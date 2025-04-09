<?php

namespace App\Http\Controllers;

use App\Mail\SubscriptionExpiryMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class MailController extends Controller
{

    public function sendWelcomeEmail()
    {

        $user = User::find(1);

        // Check if the user exists
        if (!$user) {
            Log::error('User not found for ID 1');
            return 'User not found!';
        }

        $user->name = "djfkds";
        $user->email = "aizazch057@gmail.com";

        try {

            $sendDate = Carbon::now()->addMinutes(5);


            Mail::to($user->email)->later(
                $sendDate,
                new SubscriptionExpiryMail($user)
            );

            return 'Subscription expiry email sent successfully!';
        } catch (\Exception $e) {
            Log::error('Failed to send subscription expiry email: ' . $e->getMessage());
            return 'Failed to send email!';
        }
    }
}
