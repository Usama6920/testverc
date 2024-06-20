<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use App\Models\UserChats;
use App\Models\email_verify_token;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\forgetpasswordtokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Mail;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
  public function googlecreds(Request $request)
  {
    $email = $request['metamask_id'];
    $user = User::where('email', '=', $email)->first();
    if ($user == null) {
      $user = User::create(['name' => $request['name'], 'DOB' => '2023-03-03', 'pronouns' => 'They/Them', 'email' => $request['metamask_id'], 'google_id' =>  $request['google_id'], 'password' => Hash::make($request['google_id'])]);
      $token = $user->createToken('SimulateAi');
      $expires_at = $token->token->expires_at;
      $expires_at_string = $expires_at->format('Y-m-d H:i:s');
      $data = [
        'status' => "200",
      ];
      return response()->json(['data' => $data, 'user' => $user, 'token' => $token->accessToken, "expiry" => $expires_at_string]);
    } else {
      $user->google_id = $request['google_id'];
      $user->save();
      $token = $user->createToken('SimulateAi');
      $access_token = $token->accessToken;
      $expires_at = $token->token->expires_at;
      $expires_at_string = $expires_at->format('Y-m-d H:i:s');
      $data = [
        'status' => "200",
      ];
      return response()->json(['data' => $data, 'user' => $user, 'token' => $token->accessToken, "expiry" => $expires_at_string]);
    }
  }





  public function UserSignUp(Request $request)
  {
    //dd($request);
    //signups up the user
    $user = $request['name'];
    $email = $request['metamask_id'];

    $user=User::where('email', $request['metamask_id'])->first();
    if ($user != null) {
      //return to signup
      $data = [
        'status' => "500",
        'logs' => "Duplicate User"

      ];
      return response()->json(['data' => $data]);
    } else {

      $user = User::create(['name' => $request['name'], 'DOB' => $request['dob'], 'pronouns' => $request['pronouns'], 'email' => $request['metamask_id'], 'google_id' =>  $request['google_id'], 'password' => Hash::make($request['password'])]);
        $user->metamask_id=$email;
        $token = $user->createToken('SimulateAi');
        $access_token = $token->accessToken;
        $expires_at = $token->token->expires_at;
        $expires_at_string = $expires_at->format('Y-m-d H:i:s');
        $data = [
          'status' => "200",
        ];
        return response()->json(['data' => $data, 'user' => $user, 'token' => $token->accessToken, "expiry" => $expires_at_string]);
      $data = [
        'status' => '202',
        'logs' => "Kindly Verify your email to continue"
      ];
      return response()->json(['data' => $data]);
    }
  }


  public function UserLogIn(Request $request)
  {
    $user = User::where('email', "=", $request['metamask_id'])->first();
    if ($user === null) {
      $data = [
        'logs' => "User Doesn't exist",
        'status' => "500",

      ];
      return response()->json(['data' => $data]);
    } else {
      // if ($user->email_verified === 0) {
      //   $data = [
      //     'logs' => "Kindly Verify Your Email",
      //     'status' => "500",

      //   ];
      //   return response()->json(['data' => $data]);
      // }

        //logs in the user
        Auth::guard()->login($user);
        //generate token for the user to be used
        $token = $user->createToken('SimulateAi');
        $access_token = $token->accessToken;
        $expires_at = $token->token->expires_at;
        $expires_at_string = $expires_at->format('Y-m-d H:i:s');
        $data = [
          'status' => "200",
        ];
        return response()->json(['data' => $data, 'user' => $user, 'token' => $token->accessToken, "expiry" => $expires_at_string]);

    }
    $data = [
      'logs' => "Incorrect Password",
      'status' => "500",

    ];
    return response()->json(['data' => $data]);
  }

  public function test()
  {
    $data = [
      'logs' => "Valid Token",
      'status' => "202",

    ];
    return response()->json(['data' => $data]);
  }

  public function failed()
  {
    $data = [
      'logs' => "Unauthorized Access",
      'status' => "401",
    ];
    return response()->json(['data' => $data]);
  }

  public function savemessage(Request $request)
  {
    $user = Auth::user();
    UserChats::create(['user_id' => $user->id, 'bot_id' => $request['bot_id'], 'message' => $request['message'], 'sentbyuser' => $request['sentbyuser'], 'time' => carbon::now()]);
    $data = [
      'status' => "202",
      'logs' => "Message Saved"

    ];
    return response()->json(['data' => $data]);
  }

  public function getconversation(Request $request)
  {
    $user = Auth::user();
    $chats = UserChats::where('user_id', $user->id)
      ->where('bot_id', $request['bot_id'])
      ->orderBy('time', 'asc')
      ->get();
    $data = [
      'status' => "202",
    ];
    return response()->json(['data' => $data, 'conversation' => $chats]);
  }

  public function deleteconversation(Request $request)
  {
    $user = Auth::user();
    UserChats::where('user_id', $user->id)
      ->where('bot_id', $request['bot_id'])
      ->delete();
    $data = [
      'status' => "202",
    ];
    return response()->json(['data' => $data]);
  }

  public function changepronouns(Request $request)
  {
    $user = Auth::user();
    $user->pronouns = $request['pronouns'];
    $user->save();
    $data = [
      'logs' => "Updated",
      'status' => "202",
    ];
    return response()->json(['data' => $data]);
  }
  public function changename(Request $request)
  {
    $user = Auth::user();
    $user->name = $request['name'];
    $user->save();
    $data = [
      'logs' => "Updated",
      'status' => "202",
    ];
    return response()->json(['data' => $data]);
  }
  public function changeemail(Request $request)
  {
    $user = Auth::user();
    $email = $request['metamask_id'];
    $validator = Validator::make(
      array(
        'username' => $user,
        'email' => $email
      ),
      array(

        'email' => 'email|unique:users,email,' . $user->id
      )
    );
    if ($validator->fails()) {

      $data = [
        'logs' => "Error",
        'status' => "500",
      ];
      return response()->json(['data' => $data, 'Cause' => $validator]);
    } else {

      $user = Auth::user();
      $user->email = $request->email;
      $user->save();
    }
    $data = [
      'logs' => "Updated",
      'status' => "202",
    ];
    return response()->json(['data' => $data]);
  }
  public function changedob(Request $request)
  {
    $user = Auth::user();
    $user->dob = $request['dob'];
    $user->save();
    $data = [
      'logs' => "Updated",
      'status' => "202",
    ];
    return response()->json(['data' => $data]);
  }

  public function changepassword(Request $request)
  {
    $user =  Auth::user();
    $hashedPassword = $user->password;
    $oldPassword = $request['oldpassword'];
    if ((Hash::check($oldPassword, $hashedPassword))) {
      $user->password = Hash::make($request['password']);
      $user->save();
      $data = [
        'logs' => "Updated",
        'status' => "202",
      ];
      return response()->json(['data' => $data]);
    }
    $data = [
      'logs' => "Incorrect old password",
      'status' => "500",
    ];
    return response()->json(['data' => $data]);
  }




  public function reqforgetpassword(Request $request)
  {


    $user = User::where('email', "=", $request['metamask_id'])->first();
    if ($user === null) {
      $data = [
        'error' => "Email Doesn't Exist",

      ];
      return response()->json(['data' => $data]);
    } else {
      $email = $request['metamask_id'];
      $response['message'] = "email sent";
      $token = Str::random(20);
      $exist = forgetpasswordtokens::where('email', $email)->first();
      if ($exist) {
        $exist->delete();
      }

      $verify = forgetpasswordtokens::create(['email' => $email, 'token' => $token]);

      $data = ['token' => $token];
      Mail::send('Emails.Forget-password', $data, function ($m) use ($email) {
        $m->from('testemail@testmail.com', 'SimulateAi');
        $m->to($email, 'App User')->subject('Forget password');
      });


      return response()->json($response);
    }
  }





  function verifyemail(Request $request)
  {

    $token = $request['token'];
    $email = email_verify_token::select('email')->where('token', $token)->get(['email']);

    if (count($email) == 1) {
      $email = $email[0]->email;

      $usrdata = User::where('email', $email)->get();

      if ($usrdata) {
        User::where('email', $email)->update(['email_verified' => true]);

        return view('Admin.confirmation', ['content' => 'Your email has been verified', 'heading' => 'Successfuly']);
      }
    }
    $response['message'] = "failed";
    return response()->json($response);
  }
  function ForgetPassword(Request $request)
  {

    $token = $request['token'];

    $usrdata =  forgetpasswordtokens::where('token', "=", $token)->first();

    if ($usrdata) {

      $pageConfigs = ['myLayout' => 'blank'];
      return view('Admin.resetpass', ['reset_token' => $token, 'emailid' => $usrdata->email, 'pageConfigs' => $pageConfigs]);
    }
    return 'Invalid token';
  }
  function ForgetPasswordsubmit(Request $request)
  {

    $token = $request['resettoken'];


    $usrdata =  forgetpasswordtokens::where('token', "=", $token)->first();

    if ($usrdata) {
      DB::table('users')->where('email', $usrdata->email)->update([

        'password' => Hash::make($request['password']),

      ]);
      $usrdata =  forgetpasswordtokens::where('token', "=", $token)->first();
      return view('Admin.confirmation', ['content' => 'Your Password has been changed', 'heading' => 'Successfuly']);
    }
    return "unable to reset password";
  }
  public function resendverify(Request $request)
  {

    $tokenver = Str::random(30);
    $verify = email_verify_token::where('email', $request['metamask_id'])->first();

    if ($verify) {
      $verify->token = $tokenver;
      $verify->save();
      $email = $request['metamask_id'];
      $username = "User";
      $data = ['token' => $tokenver];

      Mail::send('Emails.verify-email', $data, function ($m) use ($email, $username) {
        $m->from('testemail@testmail.com', 'SimulateAi');
        $m->to($email, $username)->subject('SimulateAi Email Verification');
      });

      $response['message'] = "email_sent";
      return response()->json($response);
    }

    $response['message'] = "error";
    return response()->json($response);
  }




}
