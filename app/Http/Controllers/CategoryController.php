<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use DataTables;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::with('parent')->get();
            return DataTables::of($categories)
                ->addColumn('action', function ($user) {
                    return '<button class="btn btn-primary btn-sm">Edit</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('category.list');
    }

    public function create()
    {
        return view('category.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'slug' => 'required',
        ]);

        Category::create($request->all());

        //return the response in JSON format
        return response()->json(['success' => 'Category added successfully.', 'redirect' => route('category.index')]);
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required',
            'slug' => 'required',
        ]);

        $category = Category::find($id);
        $category->update($request->all());

        return response()->json(['success' => 'Category updated successfully.', 'redirect' => route('category.index')]);
    }

    public function destroy($id)
    {
        Category::find($id)->delete();

        return redirect()->route('category.index')
            ->with('success', 'Category deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        Category::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => 'Categories deleted successfully.']);
    }
}
