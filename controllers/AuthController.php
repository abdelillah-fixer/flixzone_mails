<?php

namespace App\Http\Controllers;
use App\Notifications\SignInMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    private static $myStaticVariable;


    public function register(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'firstName' => 'required',
            'lastName'  => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8',
        ]);
        
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }
        
        $credentials = $validator->validated();
        
        return User::create([
            "first_name" => $credentials['firstName'],
            "last_name" => $credentials['lastName'],
            "email" => $credentials['email'],
            "password" => Hash::make($credentials['password']),
        ]);
    }


    public function login(Request $req)
    {

        if (!Auth::attempt($req->only('email', 'password'))) {
            return response()->json([
                "message" => "please register"
            ], 404);
        } else {
            
                $validator = Validator::make($req->all(), [
                    'email' => 'required|email',
                    'password' => 'required',
                ]);
            
                if ($validator->fails()) {
                    return response()->json(["message" => $validator->errors()], Response::HTTP_BAD_REQUEST);
                }
            
                $credentials = $validator->validated();
            
                if (!Auth::attempt($credentials)) {
                    return response()->json([
                        "message" => "Invalid credentials"
                    ], 401);
                }
           

                // Save verification code to database
                
                $user =  Auth::user();
                $verificationCode = random_int(100000, 999999); // Generates a 6-digit random code
                self::$myStaticVariable = $verificationCode;
                VerificationCode::create([
                    'user_id' => $user->id,
                    'code' => $verificationCode,
                ]);
                $token = $user->createToken('token')->plainTextToken;
                $user->notify(new SignInMail($verificationCode));
                return response()->json(["message" => "Success", "data" => $token]);
            
            
        }
    }
    public function verify(Request $request)
    {
        $receivedCode = $request->input('Code');
        $storedCode = VerificationCode::latest() // Retrieve the latest record
        ->value('code');
        
    
        if ($storedCode==$receivedCode) {
            return response()->json(["message" => "Success"], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Incorrect code"], Response::HTTP_OK);
        }
    }

    
}
