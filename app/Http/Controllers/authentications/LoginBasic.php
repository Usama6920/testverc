<?php

namespace App\Http\Controllers\authentications;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Csv\Writer;
use Illuminate\Support\Facades\DB;

use League\Csv\Statement;

class LoginBasic extends Controller
{
  public function index()
  {
       try {
        DB::connection()->getPdo();
        return response()->json(['status' => 'success', 'message' => 'Database is online'], 200);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Database is offline', 'error' => $e->getMessage()], 500);
    }
  }

  public function downloadcsv( Request $request )
  {

    if( $request->email =='admin@chatcoach.com') {
      if($request->password=='CCki@4k;lja@!#'){
        $users = User::select('name', 'email', 'DOB', 'pronouns', 'email_verified', 'stripe_id', 'created_at', 'updated_at')->get();

        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(['Name', 'Email', 'Date of Birth', 'Pronouns', 'Email Verified','Created At', 'Updated At']);

        foreach ($users as $user) {
            $csv->insertOne([
                $user->name,
                $user->email,
                $user->DOB,
                $user->pronouns,
                $user->email_verified,
                $user->created_at,
                $user->updated_at,
            ]);
        }

        $csv->output('users.csv');
      }
      else{
        $pageConfigs = ['myLayout' => 'blank'];
        return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
      }

    }
    else{
      $pageConfigs = ['myLayout' => 'blank'];
      return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
    }


  }
}
