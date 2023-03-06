<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;


class AuthController extends Controller
{
    public function sign_up(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'phone' => 'required|regex:/(01)[0125][0-9]{8}/|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'fcm_token' => 'required',

        ]);
        //Request is valid, create new user
        if ($validator->fails()) {
            return msgdata($request, failed(), $validator->messages()->first(), (object)[]);
        }
        //Request is valid, create new user
        $six_digit_random_number = six_digit_random_number();
        $data['code'] = $six_digit_random_number;
        $data['password'] = $request->password;
        $data['verified'] = 0;
        $data['active'] = 1;
        $data['jwt'] = Str::random(120);
        $user = User::create($data);
        $data = new UserResource($user);

        return msgdata($request, success(), trans('lang.register_done'), $data);

    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|exists:users,email',
            'password' => 'required',
            'fcm_token' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return msgdata($request, failed(), $validator->messages()->first(), (object)[]);
        }
        $credentials = $request->only(['email', 'password']);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (!Hash::check($request->password, $user->password)) {
                return msgdata($request, failed(), trans('lang.not_authorized'), (object)[]);
            }
        } else {
            return msgdata($request, failed(), trans('lang.not_authorized'), (object)[]);

        }


        if ($request->fcm_token) {
            User::whereId($user->id)->update(['fcm_token' => $request->fcm_token]);
        }
        $user_data = User::where('id', $user->id)->first();
        $user_data->jwt = Str::random(120);
        $user_data->save();
        $data = new UserResource($user_data);
        return msgdata($request, success(), trans('lang.login_s'), $data);
    }

    public function forget_password(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);
        if (!$validator->fails()) {
            //make token of 4 degits random...
            $six_digit_random_number = six_digit_random_number();
            $target_user = User::where('email', $request->email)->first();
            if ($target_user) {
                $target_user->code = $six_digit_random_number;
                $target_user->save();
//                Mail::raw('رمز استعاده كلمه المرور الخاصة بك: ' . $six_digit_random_number, function ($message) use ($target_user) {
//                    $message->subject('Reset Password');
//                    $message->from('taheelpost@gmail.com', 'taheelpost');
//                    $message->to($target_user->email);
//                });
                return sendResponse(200, trans('lang.email_send_code'), (object)[]);
            } else {
                return msgdata($request, failed(), trans('lang.not_authorized'), (object)[]);
            }
        } else {
            return msgdata($request, failed(), $validator->messages()->first(), (object)[]);
        }
    }

    public function verify_code(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'code' => 'required',
        ]);
        if (!$validator->fails()) {

            $target_user = User::where('code', $request->code)
                ->where('email', $request->email)->first();

            // dd($pass_reset);
            if ($target_user != null) {
                $data['status'] = true;
                $target_user->verified = 1;
                $target_user->code = null;
                $target_user->save();
                return sendResponse(200, trans('lang.code_checked_s'), $data);
            } else {

                $data['status'] = false;
                return msgdata($request, failed(), trans('lang.make_sure_code'), $data);
            }
        } else {
            $data['status'] = false;
            return msgdata($request, failed(), $validator->messages()->first(), $data);
        }
    }

    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed',
        ]);
        if (!$validator->fails()) {
            $target_user = User::where('email', $request->email)->first();
            if ($target_user != null) {
                $target_user->password = $request->password;
                $target_user->jwt = Str::random(120);
                $target_user->code = null;
                $target_user->save();
                $data = new UserResource($target_user);
                return sendResponse(200, trans('lang.password_changed_s'), $data);
            } else {
                return msgdata($request, failed(), trans('lang.not_found'), (object)[]);
            }
        } else {
            return msgdata($request, failed(), $validator->messages()->first(), (object)[]);
        }
    }

    public function socialLogin(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'social_type' => 'required|in:facebook,google,apple',
            'social_id' => 'required',
            'fcm_token' => 'required',
            'email' => 'required',
            'phone' => 'required|regex:/(01)[0125][0-9]{8}/|unique:users,phone',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }

        // 1- check social id exists

        $userFound = User::where('social_id', $request->social_id)
            ->where('social_type', $request->social_type)
            ->first();
        if ($userFound) {
//            $userFound->email = $request->email;
            $userFound->fcm_token = $request->fcm_token;
            $userFound->jwt = Str::random(120);
            $userFound->save();

            $data = (new UserResource($userFound));
            return response()->json(msgdata($request, success(), trans('lang.success'), $data));
        }

        // 2- if not login with social before
        try {


            $user = User::create([
                'social_id' => $request->social_id,
                'fcm_token' => $request->fcm_token,
                'name' => $request->email,
                'phone' => $request->phone,
                'email' => $request->email,
                'email_verified_at' => Carbon::now(),
                'active' => 1,
                'password' => "123456",
                'social_type' => $request->social_type,
                'jwt' => Str::random(120)
            ]);


        } catch (\Exception $e) {

            return response()->json(msg($request, failed(), trans('lang.EmailExists')));
        }


        $data = (new UserResource($user));
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }


}
