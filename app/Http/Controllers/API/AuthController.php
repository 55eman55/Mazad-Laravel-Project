<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\user as userResource;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Traits\GeneralTrait;

class AuthController extends BaseController
{
    use GeneralTrait;

    const HTTP_OK = Response::HTTP_OK;
    const HTTP_CREATED = Response::HTTP_CREATED;
    const HTTP_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;

    public function login(Request $request)
    {

        $credentials = [

            'email' => $request->email,
            'password' => $request->password

        ];

        if (auth()->attempt($credentials)) {

            $user = Auth::user();
            $success['id'] = $user->id;
            $success['name'] = $user->name;
            $success['email'] = $user->email;
            $success['phone'] = $user->phone;
            $success['age'] = $user->age;
            $success['bank_account'] = $user->bank_account;
            $success['vodafone_account'] = $user->vodafone_account;
            $success['token'] = $this->get_user_token($user, "TestToken");

            $response = self::HTTP_OK;

            return $this->sendResponse("You Are Logging Sucessfuly ", $success, $response);
        } else {



            $message = "You Are Failed To login .  Please Check your email or password";



            $response = self::HTTP_OK;

            return $this->sendError("error", $message, $response);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'email' => 'required|email|unique:users,email,except,id',
            'phone' => 'required',
            'password' => 'required',
            'age' => 'required',
            'bank_account' => 'required',
            'vodafone_account' => 'required',


        ]);




        if ($validator->fails()) {


            return response()->json(['error' => $validator->errors()]);
        }


        $data = $request->all();

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $success['token'] = $this->get_user_token($user, "TestToken");

        $success['name'] =  $user->name;

        $response =  self::HTTP_CREATED;

        return $this->sendResponse("success", $success, $response);
    }
    public function searchuser(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'name' => 'required',

        ]);

        $user = User::where('name', 'like', '%' . $request->name . '%')->get(['name', 'profile_picture']);

        return $this->sendResponse('', $user, 'user found successfully');

        if (is_null($user)) {
            return $this->sendError('user not found ');
        }
    }

    public function get_user_details_info()
    {
        $user = Auth::user();

        $response =  self::HTTP_OK;

        return $user ? $this->sendResponse("success", $user, $response)
            : $this->sendResponse("Unauthenticated user", $user, $response);
    }

    public function logout(Request $request)
    {
        // get token value
        $token = $request->user()->token();

        // revoke this token value
        $token->revoke();

        return response()->json([
            "status" => true,
            "message" => "User logged out successfully"
        ]);
    }


    public function update(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'age' => 'required',
            'bank_account' => 'required',
            'vodafone_account' => 'required',

        ]);

        $user = Auth::user();
        if ($request->hasFile('profile_picture')) {
            $request->validate([
                'profile_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);
            $path = $request->file('profile_picture')->store('public\profile_picture');
            $user->profile_picture = $path;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->age = $request->age;
        $user->bank_account = $request->bank_account;
        $user->vodafone_account = $request->vodafone_account;
        $user->save();
        return response()->json(['status' => 'true', 'message' => 'update_profile', 'data' => $user]);
    }
    public function show(Request $request)
    {
        $user = Auth::user();

        if (is_null($user)) {
            return $this->sendError('user not found ');
        }
        return $this->sendResponse(new userResource($user), 'user found successfully');
    }

    public function updateprofileInfo(Request $request)
    {

        if ($request->has('name')) {
            $rules = [
                'name' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {


                return response()->json(['error' => $validator->errors()]);
            }
        }

        if ($request->has('phone')) {
            $rules = [
                'phone' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {


                return response()->json(['error' => $validator->errors()]);
            }
        }

        if ($request->has('email')) {
            $rules = [
                'email' => 'required|email'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {


                return response()->json(['error' => $validator->errors()]);
            }
        }
        if ($request->has('age')) {
            $rules = [
                'age' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {


                return response()->json(['error' => $validator->errors()]);
            }
        }
        if ($request->has('bank_account')) {
            $rules = [
                'bank_account' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {


                return response()->json(['error' => $validator->errors()]);
            }
        }
        if ($request->has('vodafone_account')) {
            $rules = [
                'vodafone_account' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {


                return response()->json(['error' => $validator->errors()]);
            }
        }

        $user = Auth::user();
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $path = $this->saveImage($request->profile_picture, 'profile_picture');
        $user->profile_picture = $path;




        $user->update([


            'phone' => $request->phone ?? $user->phone,
            'email' => $request->email ?? $user->email,
            'name' => $request->name ?? $user->name,
            'age' => $request->age ?? $user->age,
            'bank_account' => $request->bank_account ?? $user->bank_account,
            'vodafone_account' => $request->vodafone_account ?? $user->vodafone_account,


        ]);
        return response()->json(['status' => 'true', 'message' => 'update_profile', 'data' => $user]);
    }



    public function changePassword(Request $request)
    {
        $user = $request->id;

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|same:confirm_password|min:6',
            'confirm_password' => 'required',
        ]);

        if (!Hash::check($request->current_password, $request->password)) {

            return response()->json(['status' => 'fale', 'message' => 'password not match']);
        }

        $user->password = Hash::make($request->password);

        $user->save();


        return response()->json(['status' => 'true', 'message' => 'success', 'data' =>'password successfully updated']);
    }
}
