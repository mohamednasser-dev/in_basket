<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Visitor;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Helpers\APIHelpers;
use App\Notification;
use App\UserNotification;
use App\User;

class NotificationController extends AdminController
{

    // get all notifications
    public function show()
    {
        $data['notifications'] = Notification::orderBy('id', 'desc')->get();
        return view('admin.notifications.index', ['data' => $data]);
    }

    // get notification details
    public function details(Request $request)
    {
        $data['notification'] = Notification::find($request->id);
        return view('admin.notifications.show', ['data' => $data]);
    }

    // delete notification
    public function delete(Request $request)
    {
        $notification = Notification::find($request->id);
        if ($notification) {
            $notification->delete();
        }
        return redirect('admin-panel/notifications/show');
    }

    // type : get - get send notification page
    public function getsend()
    {
        return view('admin.notifications.create');
    }

    // send notification and insert it in database
    public function send(Request $request)
    {
        $notification = new Notification();
//        if ($request->file('image')) {
//            $image_name = $request->file('image')->getRealPath();
//            Cloudder::upload($image_name, null);
//            $imagereturned = Cloudder::getResult();
//            $image_id = $imagereturned['public_id'];
//            $image_format = $imagereturned['format'];
//            $image_new_name = $image_id . '.' . $image_format;
//            $notification->image = $image_new_name;
//        } else {
//            $notification->image = null;
//        }
        $notification->title = $request->title;
        $notification->title_en = $request->title_en;
        $notification->body = $request->body;
        $notification->body_en = $request->body_en;
        $notification->save();
        if (in_array('all_users', $request->user_id)) {
            $users = User::select('id', 'fcm_token')->where('fcm_token', '!=', null)->get();
            foreach ($users as $key => $user) {
                $fcm_tokens[$key] = $user->fcm_token;
                $user_notification = new UserNotification();
                $user_notification->user_id = $user->id;
                $user_notification->notification_id = $notification->id;
                $user_notification->save();
            }
        } else {
            $users = User::select('id', 'fcm_token')->whereIn('id', $request->user_id)->where('fcm_token', '!=', null)->get();
            foreach ($users as $key => $user) {
                $fcm_tokens[$key] = $user->fcm_token;
                $user_notification = new UserNotification();
                $user_notification->user_id = $user->id;
                $user_notification->notification_id = $notification->id;
                $user_notification->save();
            }
        }
        $notificationss = APIHelpers::send_notification($notification->title, $notification->body, null, null, $fcm_tokens);
        return redirect('admin-panel/notifications/show');
    }


    // resend notifications
    public function resend(Request $request)
    {
        $notification_id = $request->id;
        $notification = Notification::find($notification_id);

        $users_tokens = Visitor::select('fcm_token')->get();
        $array_values = array_values((array)$users_tokens);
        $array_values = $array_values[0];
        APIHelpers::send_notification($notification->title, $notification->body, $notification->image, null, $array_values);
        session()->flash('success', trans('messages.sent_s'));
        return redirect()->back();
    }

}
