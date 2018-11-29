<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use App\User;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class UserController extends Controller
{

    public function authenticate(Request $request){
        $credentials=$request->only('email','password');
        try{
            if($token=JWTAuth::attempt($credentials)){
                return response()->json(compact('token'), 200);
            }
        }
        catch(JWTException $exception){
            return response()->json(['error'=>'could not create token'],500);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }
    public function register(Request $request)
    {

        // Here the request is validated. The validator method is located
        // inside the RegisterController, and makes sure the name, email
        // password and password_confirmation fields are required.

        $validation = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validation->fails()){
            return response()->json($validation->errors()->toJson(),400);
        }

        // code that needs to be run as soon as the user is created.
        $user = $this->create($request->all());
        $token = JWTAuth::fromUser($user);
        $user->api_token=$token;

        return response()->json(compact('user','token'),201);
        // After the user is created, he's logged in.
//        $this->guard()->login($user);

    }
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    public static function parseToken($method = 'bearer', $header = 'authorization', $query = 'token')
    {
        return JWTAuth::parseToken($method, $header, $query);
    }
    public function getAuthenticatedUser()
    {
        try {

            if (! $user =JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }
    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json(['data' => 'User logged out.'], 200);
    }
    //
}
