<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AuthController extends Controller
{
    //

public function indexShow(Request $request){
    $perPage = $request->input('paginate', 20);  // You can change the default value to your needs

    // Fetch paginated news items using DB::table
    $users = DB::table('users')
        ->orderBy('created_at', 'desc')  // Ordering by created_at as an example
        ->paginate($perPage);    
    // Return the view with the paginated news data
    return view('users.index', compact('users'));
}
public function signupOrLogin(Request $request)
{
    
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
        'type' => 'required|in:new,old',
    ]);

    // If validation fails, return errors
    if ($validator->fails()) {
        return response()->json([
            'error' => true,
            'message' => $validator->errors()->first(),
            'code' => 422
        ], 422);
    }

    $type = $request->type;
    $otp = rand(100000, 999999);

    if($type == 'new'){

        $user = DB::table('users')
        ->where('email',$request->email)
        ->first();

        if(!$user){
            $user = DB::table('users')->insert([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'otp' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(10)->format('H:i:s'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }else{

            return response()->json(['error'=>true,'message' => 'Emial Id alerady Exist','code'=>401]);
        }

        return response()->json(['message' => 'OTP sent to your email','otp'=>$otp]);
    }else if($type == 'old'){

        $user = DB::table('users')
        ->select('_id', 'email', 'created_at', 'updated_at','otp','password')
        ->where('email', $request->email)
        ->first();
        
        if($user)
        {
            if (!Hash::check($request['password'], $user['password'])) {
                return response()->json(['error'=>true,'message' => 'Invalid password','code'=>401], 401);
            }

            if($user['otp']){
                $user = DB::table('users')
                ->where('email', $request->email) // Find user by email
                ->update([
                    'otp' => "",
                    'updated_at' => Carbon::now(),
                ]);
            }

            $data = [
                'id' => (string) $user['_id'],
                'email' => $user['email'] ?? null,
            ];
            return response()->json(['error'=>false,'message' => 'Success','data'=>$data,'code'=>200]);
         }else{
            return response()->json(['error'=>true,'message' => 'Email id not Exist !','code'=>401], 401);
         }
    }
    return response()->json(['error'=>true,'message' => 'Please valid type !','code'=>401], 401);



    // Mail::to($request->email)->send(new SendOtpMail($otp));

    // return response()->json(['message' => 'OTP sent to your email','otp'=>$otp]);
}



public function verifyOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'otp' => 'required|numeric'
    ]);

    $user = DB::table('users')
    ->where('email',$request->email)
    ->first();

    if (!$user || $user['otp'] != $request->otp || now()->gt($user['otp_expires_at'])) {
        return response()->json(['error'=>true,'message' => 'Invalid or expired OTP','code'=>401], 401);
    }

    // Clear OTP after verification
    $user = DB::table('users')
    ->where('email', $request->email) // Find user by email
    ->update([
        'otp' => "",
        'updated_at' => Carbon::now(),
    ]);
    return response()->json(['error'=>false,'message' => 'Success','code'=>200]);
}


public function forgotPassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
    ]);

    // If validation fails, return errors
    if ($validator->fails()) {
        return response()->json([
            'error' => true,
            'message' => $validator->errors()->first(),
            'code' => 422
        ], 422);
    }

    $user = DB::collection('users')->where('email', $request->email)->first();
    if (!$user) {
        return response()->json(['error' => true, 'message' => 'Email not found'], 404);
    }

    $otp = rand(100000, 999999);
    $expiresAt = now()->addMinutes(10);

    DB::collection('users')->where('email', $request->email)->update([
        'otp' => (string)$otp,
        'otp_expires_at' => Carbon::now()->addMinutes(10)->format('H:i:s'),
    ]);

    // You can use Mail::to() to send email; for now, just return it
    return response()->json(['error' => false, 'message' => 'OTP sent', 'otp' => $otp]);
}


public function resetPassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // If validation fails, return errors
    if ($validator->fails()) {
        return response()->json([
            'error' => true,
            'message' => $validator->errors()->first(),
            'code' => 422
        ], 422);
    }


    $user = DB::collection('users')->where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['error' => true, 'message' => 'OTP not verified'], 400);
    }

    DB::collection('users')->where('email', $request->email)->update([
        'password' => Hash::make($request->password),
        'otp' => null,
        'otp_verified' => null,
        'otp_expires_at' => null
    ]);

    return response()->json(['error' => false, 'message' => 'Password reset successfully']);
}
}
