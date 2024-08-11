<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use DB;
use App\Models\User;
use App\Models\FbaShipment;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    //

    public function create()
    {
        return view('supplier.add');
    }

    public function store(Request $request)
    {     
        $encryptionKey = config('constant.encryption_key');
        $encryptedEmail = DB::raw("pgp_sym_encrypt('{$request->input('email_address')}', '$encryptionKey')");
        
        $validator = Validator::make($request->all(), [
            'supplier_name' => 'required|string',
            'company_name' => 'required|string',
            'email_address' => [
                'required',
                'email',
                // Additional validation for decrypted email uniqueness
                function ($attribute, $value, $fail) use ($encryptionKey) {
                    $decryptedEmail = DB::table('users')
                        ->selectRaw("pgp_sym_decrypt(email::bytea, ?) as decrypted_email", [$encryptionKey])
                        ->whereRaw("pgp_sym_decrypt(email::bytea, ?) = ?", [$encryptionKey, $value])
                        ->whereNull('deleted_at')
                        ->first();
    
                    if ($decryptedEmail) {
                        $fail('The email address has already been taken.');
                    }
                },
                // Additional validation for a valid domain
                function ($attribute, $value, $fail) {
                    if (strpos($value, '@') !== false && strpos($value, '.') === false) {
                        $fail('The email address must include a valid domain.');
                    }
                },
            ],
            'contact_number' => [
                'required',
                'digits:10',
                Rule::unique('users', 'contact_number')
                ->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })
                ->ignore($request->route('user')),
            ],
            'status' => 'integer',
        ], [
            'supplier_name.required' => 'Please enter the supplier name.',
            'supplier_name.string' => 'The supplier name must be a string.',
            'company_name.required' => 'Please enter the company name.',
            'company_name.string' => 'The company name must be a string.',
            'email_address.required' => 'Please enter an email address.',
            'contact_number.required' => 'Please enter a contact number',
            'contact_number.digits' => 'Please enter a valid phone number in US format.',
            'contact_number.unique' => 'The contact number has already been taken.',
            'contact_number.regex' => 'Please enter a valid phone number in US format.',
            'status.integer' => 'The status must be an integer.',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = DB::table('users')->insert([
            'name' => $request->input('supplier_name'),
            'supplier_name' => $request->input('supplier_name'),
            'company_name' => $request->input('company_name'),
            'email' => $encryptedEmail,
            'contact_number' => $request->input('contact_number'),
            'role_id' => 2,
            'status' => $request->input('status'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($user) {
            
            $supplier = DB::table('users')
            ->selectRaw("*, pgp_sym_decrypt(email::bytea, ?) as decrypted_email", [$encryptionKey])
            ->whereRaw("pgp_sym_decrypt(email::bytea, ?) = ?", [$encryptionKey, $request->input('email_address')])
            ->where('deleted_at',null)
            ->first();

            $token = Str::random(64);

            $decryptedEmail = $supplier->decrypted_email;
            
            DB::table('password_reset_tokens')->insert([
            'email' => $decryptedEmail,
            'token' => $token,
            'created_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addMinutes(Config::get('constant.RESET_TOKEN_EXPIRATION_MINUTES')),
            ]);

            $actionText = 'Set'; // or any other custom text

            $status = Mail::send('emails.reset_password_link', ['token' => $token, 'name' => $supplier->supplier_name, 'actionText' => $actionText,'email' =>$decryptedEmail], function ($message) use ($decryptedEmail) {
                $message->to($decryptedEmail);
                $message->subject('Set Password');
            });
            return response()->json(['success' => 'Supplier created successfully & Set password link sent to registered email address!','redirect' => route('suppliers.index')]);
        } else {
            return response()->json(['error' => 'Something went wrong!']);
        }        
    }

    public function showSuppliers(Request $request)
    {
        if ($request->ajax()) {
            $query = User::select(['id', 'supplier_name', 'company_name', DB::raw('pgp_sym_decrypt(email::bytea, ?) as decrypted_email'), 'contact_number', 'status'])
                ->where('role_id', 2)
                ->addBinding(config('constant.encryption_key'), 'select');

            $users = $query->get();

            $data = [];

            foreach ($users as $user) {
                $data[] = [
                    'id' => $user->id,
                    'supplier_name' => $user->supplier_name,
                    'company_name' => $user->company_name,
                    'decrypted_email' => $user->decrypted_email,
                    'contact_number' => $user->contact_number,
                    'status' => $user->status,
                    'email_icon_condition' => $this->checkEmailIconCondition($user), // Add your logic here
                ];
            }

            return DataTables::of($data)
                ->addColumn('action', function ($user) {
                    return '<button class="btn btn-primary btn-sm">Edit</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view("supplier.list");
    }


    protected function checkEmailIconCondition($user)
    {
        
        
        $expirationCheck = DB::table('password_reset_tokens')
        ->where('email', $user->decrypted_email)
        ->where('used', 0)
        ->where('expires_at', '>', now()) // Check if the link has expired or is about to expire
        ->exists();

        return $expirationCheck;
    }

    public function updateStatus(Request $request)
    {
        $userId = $request->input('supplierId');
        $newStatus = $request->input('status');

        // Perform the logic to update the status in your database
        $supplier = User::find($userId);

        if ($supplier) {

            if (
                $newStatus == 0 && $this->hasAssignedShipments($userId)) {
                    return response()->json(['error' => 'Cannot deactivate supplier. Shipments are assigned.'],401);
            }

            $supplier->update(['status' => $newStatus]);
            if (Auth::check() && Auth::user()->id == $userId && Auth::user()->role_id != 1) {
                // Log out the user if their status is set to 0
                Auth::logout();
            }
            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['error' => false, 'message' => 'Status not updated successfully']);
        }
    }

    private function hasAssignedShipments($userId)
    {
        // Check if any shipments are assigned to the supplier with the given user ID
        return FbaShipment::where('supplier_id', $userId)
            ->whereIn('shipment_status', [0,1,2,3,7,8,9,10])
            ->exists();
    }

    public function editSupplier($id)
    {
        $encryptionKey = config('constant.encryption_key');

        $supplier = DB::table('users')
        ->selectRaw("*, pgp_sym_decrypt(email::bytea, ?) as decrypted_email", [$encryptionKey])
        ->where('id', $id)
        ->first();

        return view('supplier.edit', compact('supplier'));
    }
    
    public function updateSupplier(Request $request, $id)
    {
        $encryptionKey = config('constant.encryption_key');

        $validator = Validator::make($request->all(), [
            'supplier_name' => 'required|string',
            'company_name' => 'required|string',
            'email_address' => [
                'required',
                'email',
                function ($attribute, $value, $fail) use ($id, $encryptionKey, $request) {
                    if (strpos($value, '@') !== false && strpos($value, '.') === false) {
                        $fail('The email address must include a valid domain.');
                    }
            
                    // Check if email is being updated
                    if ($request->has('email_address')) {
                        // Get existing email addresses in decrypted form
                        $existingEmails = DB::table('users')
                            ->where('id', '<>', $id)
                            ->whereNull('deleted_at')
                            ->pluck(DB::raw("pgp_sym_decrypt(email::bytea, '{$encryptionKey}') as decrypted_email"))
                            ->toArray();
            
                        // Check if the current email is already taken in decrypted form
                        if (in_array($value, $existingEmails)) {
                            $fail('The email address has already been taken.');
                        }
                    }
                },
            ],        
            'contact_number' => [
                'required',
                'digits:10',
                Rule::unique('users', 'contact_number')->ignore($id),
                
            ],
        ], [
            'supplier_name.required' => 'Please enter the supplier name.',
            'supplier_name.string' => 'The supplier name must be a string.',
            'company_name.required' => 'Please enter the company name.',
            'company_name.string' => 'The company name must be a string.',
            'email_address.required' => 'Please enter an email address.',
            'contact_number.required' => 'Please enter a contact number.',
            'contact_number.digits' => 'The contact number must be exactly 10 digits.',
            'contact_number.unique' => 'The contact number has already been taken.',
            'contact_number.regex' => 'The contact number must belong to the US country.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // If validation passes, continue with your logic for editing the supplier
        $supplier = User::find($id);
        $encryptedEmail = DB::raw("pgp_sym_encrypt('{$request->input('email_address')}', '$encryptionKey')");
        // Update supplier details
        $supplier->update([
            'supplier_name' => $request->input('supplier_name'),
            'name' => $request->input('supplier_name'),
            'company_name' => $request->input('company_name'),
            'email' => $encryptedEmail,
            'status' => $request->input('status'),
            'contact_number' => $request->input('contact_number'),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Supplier updated successfully.',
            'redirect' => route('suppliers.index'),
        ]);
    }

    public function destroy($id)
    {
        try {
            $supplier = User::findOrFail($id);

            if($this->hasAssignedShipments($id))
            {
                
                return response()->json(['success' => false, 'message' => 'Cannot delete supplier. Shipments are assigned.'], 500);
            }
            $supplier->delete(); // This will perform a soft delete

            return response()->json(['success' => true, 'message' => 'Supplier deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');;
        try {
            // Use your logic to delete suppliers with the given IDs
            foreach ($ids as $id) {
                // Check if the supplier has assigned shipments with the specified status
                if ($this->hasAssignedShipments($id)) {
                    return response()->json(['success' => false, 'message' => 'Cannot delete supplier. Shipments are assigned.'], 500);
                }
            }
            $user = User::whereIn('id', $ids)->delete();
            
            return response()->json(['message' => 'Selected suppliers deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting selected suppliers', 'message' => $e->getMessage()], 500);
        }
    }

    public function resendPasswordLink(Request $request,$id)
    {
        $encryptionKey = config('constant.encryption_key');
        $supplier = DB::table('users')
            ->selectRaw("*, pgp_sym_decrypt(email::bytea, ?) as decrypted_email", [$encryptionKey])
            ->where('id', $id)
            ->first();
            if(!$supplier)
            {
                return response()->json(['message' => 'Supplier does not exists!','redirect' => route('suppliers.index')]);
            }

            $token = Str::random(64);

            $decryptedEmail = $supplier->decrypted_email;

            DB::table('password_reset_tokens')->insert([
            'email' => $decryptedEmail,
            'token' => $token,
            'created_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addMinutes(Config::get('constant.RESET_TOKEN_EXPIRATION_MINUTES')),
            ]);

            $actionText = 'Set'; // or any other custom text

            $status = Mail::send('emails.reset_password_link', ['token' => $token, 'name' => $supplier->supplier_name, 'actionText' => $actionText], function ($message) use ($decryptedEmail) {
                $message->to($decryptedEmail);
                $message->subject('Set Password');
            });
            return response()->json(['message' => 'Supplier Set password link sent to registered email address!','redirect' => route('suppliers.index')]);    
    }
}
