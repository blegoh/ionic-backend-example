<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use JWTAuth;
use Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthenticateController extends Controller
{
    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth', ['except' => ['authenticate','register']]);
    }
    /**
     * Return the user
     *
     * @return Response
     */
    public function index()
    {
        // Retrieve all the users in the database and return them        
        $users = User::all();
        return $users;
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()){
            return response()->json(['error' => 'invalid_from_data'], 401);
        }
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
        return response()->json(['status' => 'ok'], 200);
    }

    /**
     * Return a JWT
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));
    }

    /**
     * @return Response
     */
    public function getAuthenticatedUser()
    {
        try{
            if (! $user = JWTAuth::parseToken()->authenticate()){
                return response()->json(['user_not_found'],404);
            }
        }catch (TokenExpiredException $e){
            return response()->json(['token_expired'],$e->getStatusCode());
        }catch (TokenInvalidException $e){
            return response()->json(['token_invalid'],$e->getStatusCode());
        }catch (JWTException $e){
            return response()->json(['token_absent'],$e->getStatusCode());
        }

        return response()->json(compact('user'));
    }

    public function update(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user = User::find($user->id);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->save();
        return response()->json(['status' => 'ok'], 200);
    }

}
