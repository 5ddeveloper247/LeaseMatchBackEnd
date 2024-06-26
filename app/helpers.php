<?php

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Menu;
use App\Models\MenuControl;
use App\Models\UserSubscription;
use App\Models\ApiSettings;
use App\Models\RequiredDocuments;

if (!function_exists('saveMultipleImages')) {

    function saveMultipleImages($files, $path)
    {

        $savedFilePaths = [];

        if (!File::isDirectory(public_path($path))) {
            File::makeDirectory(public_path($path), 0777, true);
        }

        foreach ($files as $file) {
            $filename = $file->getClientOriginalExtension();
            $date_append = Str::random(32);
            $file->move(public_path($path), $date_append . '.' . $filename);

            $savedFilePaths[] = $path . '/' . $date_append . '.' . $filename;
        }

        return $savedFilePaths;
    }
}

if (!function_exists('saveSingleImage')) {

    function saveSingleImage($file, $path)
    {

        if (!File::isDirectory(public_path($path))) {
            File::makeDirectory(public_path($path), 0777, true);
        }

        $filename = $file->getClientOriginalExtension();
        $date_append = Str::random(32);
        $file->move(public_path($path), $date_append . '.' . $filename);

        $savedFilePaths = $path . '/' . $date_append . '.' . $filename;

        return $savedFilePaths;
    }
}

if (!function_exists('deleteImage')) {
    function deleteImage($imagePath)
    {
        $imagePath = public_path($imagePath);

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        } else {
            // Image not found
        }
        try {
            // Check if the file exists before attempting to delete it
            if (File::exists($imagePath)) {
                // Delete the file
                File::delete($imagePath);
                return 'Image deleted successfully';
            } else {
                return 'Image not found';
            }
        } catch (\Exception $e) {
            return 'Error deleting image: ' . $e->getMessage();
        }
    }
}

if (!function_exists('sendMail')) {
    function sendMail($send_to_name, $send_to_email, $email_from_name, $subject, $body)
    {
        try {
            $mail_val = [
                'send_to_name' => $send_to_name,
                'send_to' => $send_to_email,
                'email_from' => 'noreply@leasematch.com',
                'email_from_name' => $email_from_name,
                'subject' => $subject,
            ];

            Mail::send('emails.mail', ['body' => $body], function ($send) use ($mail_val) {
                $send->from($mail_val['email_from'], $mail_val['email_from_name']);
                $send->replyto($mail_val['email_from'], $mail_val['email_from_name']);
                $send->to($mail_val['send_to'], $mail_val['send_to_name'])->subject($mail_val['subject']);
            });
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            echo "An error occurred while sending the email: " . $e->getMessage();
            return false;
        }
    }
}

if (!function_exists('getLeftMenu')) {

    function getLeftMenu()
    {
        if(Auth::user()->type == 1){
            $menu = Menu::orderBy('seq_no', 'asc')->where('enable', '1')->get();
        }else{
            // $menuControl = Menu::get();
            $menu = Menu::join('menu_control', 'menu.id', '=', 'menu_control.menu_id')
            ->where('menu_control.user_id', Auth::user()->id)
            ->where('menu.enable', '1')
            ->select('menu.id', 'menu.seq_no', 'menu.name', 'menu.route', 'menu.image', 'menu.created_at', 'menu.updated_at')
            ->get();
        }

        return $menu;
    }
}

if (!function_exists('getAllMenu')) {

    function getAllMenu()
    {
        $menu = Menu::where('enable', '1')->get();
        return $menu;
    }
}

if (!function_exists('checkUserSubscription')) {

    function checkUserSubscription()
    {
        $currentPlan = UserSubscription::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
        
        if($currentPlan != null){
            
            if(Carbon::now()->format('Y-m-d') > $currentPlan->end_date){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }
}

if (!function_exists('getStripePk')) {

    function getStripePk()
    {
        $apiSettings = ApiSettings::where('status', '1')->first();
        
        if(isset($apiSettings->publishable_key)){
            return $apiSettings->publishable_key;
        }else{
            return false;
        }
    }
}
if (!function_exists('getStripeSk')) {

    function getStripeSk()
    {
        $apiSettings = ApiSettings::where('status', '1')->first();
        
        if(isset($apiSettings->secret_key)){
            return $apiSettings->secret_key;
        }else{
            return false;
        }
    }
}
if (!function_exists('trimText')) {

    function trimText($string, $limit = 200, $end = '...')
    {
        if (mb_strlen($string) > $limit) {
            return mb_substr($string, 0, $limit) . $end;
        } else {
            return $string;
        }
    }
}

if (!function_exists('getReqDocs')) {

    function getReqDocs()
    {
        $reqDocs = RequiredDocuments::orderBy('created_at', 'desc')->where('status', '1')->get();
        
        return $reqDocs;
    }
}

