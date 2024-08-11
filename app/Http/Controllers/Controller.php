<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public int $successStatusCode = 200;

    public bool $set_web_response = false;

    public function sendResponse($message, $status_code, $data = '', $extraData = null) {
        $response = [
            'status' => true,
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data,
        ];
    
        // Add extra data to the response if provided
        if ($extraData !== null) {
            $response['has_transport'] = $extraData;
        }
    
        if (!$this->set_web_response) {
            return response()->json($response, $status_code);
        } else {
            return $response;
        }
    }

    public function sendError($error, $status_code = 500, $data = '') {
        if(!$this->set_web_response)
        {
            $response = [
                'status' => false,
                'status_code' => $status_code,
                'message' => $error,
                'data' => $data
            ];
            return response()->json($response, $status_code);
        }
        else
        {
            return $data;
        }
    }

    /**
     *
     * @param array $errors
     * @param int $error_code
     * @param array $data
     * @return JsonResponse | array
     */
    public function sendValidation(array $errors, int $error_code, array $data = []) : JsonResponse|array
    {
        if(!$this->set_web_response)
        {
            return response()->json([
                        'errors' => $errors,
                        'status_code' => $error_code,
                        'status' => false,
                        'data' => $data
                            ], $error_code);
        } else {
            return $data;
        }
    }
}
