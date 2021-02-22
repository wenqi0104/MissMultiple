<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;


class EmailController extends Controller
{
    public function sendEmail(Request $request){

        $user_email = $request->input('user_email');
        $data = array(
            'name' => $request->name,
            'message' => $request->message,
        );
        
        Mail::to($user_email)->send(new SendMail($data));

        return back()->with('success','You have send this email to this user');
    }
}
