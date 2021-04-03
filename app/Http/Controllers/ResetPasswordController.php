<?php

namespace App\Http\Controllers;

use App\Traits\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;
}
