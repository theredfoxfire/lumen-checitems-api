<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use App\Models\Users;

class UsersController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api');
    }

    public function authenticate(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required|max:100',
            'password' => 'required|max:20'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'data' => [
                    'message' => $validate->errors()->first()
                ]
            ]);
        }

        $user = Users::where('username', $request->input('username'))->first();

        if ((new BcryptHasher())->check($request->input('password'), $user->password)) {
            $apiKey = base64_encode(str_random(40));
            Users::where('username', $request->input('username'))->update(['api_key' => $apiKey]);

            return response()->json([
                'success' => true,
                'data' => [
                    'user_id' => $user->id,
                    'api_key' => $apiKey,
                ]
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'data' => [
                    'message' => 'incorrect username or password',
                ]
            ], 401);
        }
    }

    /**
     * User add method
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required|unique:users|max:100',
            'password' => 'required|max:20'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'data' => [
                    'message' => $validate->errors()->first()
                ]
            ]);
        }

        $user = new Users();
        $user->username = $request->input('username');
        $user->password = (new BcryptHasher())->make($request->input('password'));

        if ($user->save()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'message' => 'New user has been successfully saved'
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => [
                    'message' => 'Unable to save new user, please try again'
                ]
            ]);
        }
    }
}