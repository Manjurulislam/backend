<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function response($message, $status, $code)
    {
        return response(['message' => $message, 'status' => $status], $code);
    }
}
