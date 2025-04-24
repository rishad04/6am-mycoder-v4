<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

trait ReturnFormatTrait
{

    protected function responseWithSuccess($message = '', $data = [])
    {
        $data['status']         = true;
        $data['status_text']    = $data['status_text'] ?? $message;
        $data['message']        = $data['message'] ?? $message;

        return [
            'status'    => true,
            'message'   => $message,
            'data'      => $data,
        ];
    }

    protected function responseWithError($message = '', $data = [])
    {
        $data['status']         = false;
        $data['status_text']    = $data['status_text'] ?? $message;
        $data['message']        = $data['message'] ?? $message;

        return [
            'status'    => false,
            'message'   => $message,
            'data'      => $data,
        ];
    }
}
