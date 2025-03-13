<?php

namespace App\Http\Controllers\Token;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function create()
    {
        $user = User::where('email', request('email'))->first();
        return [
            'token' => $user->createToken('token')->plainTextToken
        ];
    }
}
