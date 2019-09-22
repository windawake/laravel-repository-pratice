<?php

namespace App\Helpers;

use Illuminate\Support\Arr;
use Mail;

class SendEmail{
    public static function register($info){
        $toEmail = $info['email'];
        $title = Arr::get($info, 'title', 'Registration Successful');

        Mail::send('emails.register', $info, function($message) use($toEmail, $title){
            $message ->to($toEmail)->subject($title);
        });
        
        return count(Mail::failures()) < 1 ? true : false;
    }

    public static function changePassword($info){
        $toEmail = $info['email'];
        $title = Arr::get($info, 'title', 'Change Password');

        Mail::send('emails.changePassword', $info, function($message) use($toEmail, $title){
            $message ->to($toEmail)->subject($title);
        });
        
        return count(Mail::failures()) < 1 ? true : false;
    }

    public static function approved($info){
        $toEmail = $info['email'];
        $title = Arr::get($info, 'title', 'Approved Successful');

        Mail::send('emails.approved', $info, function($message) use($toEmail, $title){
            $message ->to($toEmail)->subject($title);
        });
        
        return count(Mail::failures()) < 1 ? true : false;
    }

    // 请求重置密码
    public static function requestResetPassword($info){
        $toEmail = $info['email'];
        $title = Arr::get($info, 'title', 'Reset Password');

        Mail::send('emails.requestResetPassword', $info, function($message) use($toEmail, $title){
            $message ->to($toEmail)->subject($title);
        });
        
        return count(Mail::failures()) < 1 ? true : false;
    }

    public static function resetPassword($info){
        $toEmail = $info['email'];
        $title = Arr::get($info, 'title', 'Reset Password');

        Mail::send('emails.resetPassword', $info, function($message) use($toEmail, $title){
            $message ->to($toEmail)->subject($title);
        });
        
        return count(Mail::failures()) < 1 ? true : false;
    }

    public static function createAffiliate($info){
        $toEmail = $info['email'];
        $title = Arr::get($info, 'title', 'Create Account Successful');

        Mail::send('emails.createAffiliate', $info, function($message) use($toEmail, $title){
            $message ->to($toEmail)->subject($title);
        });
        
        return count(Mail::failures()) < 1 ? true : false;
    }

    public static function notifyAudit($info){
        $toEmail = $info['email'];
        $title = Arr::get($info, 'title', 'Notify the audit');

        Mail::send('emails.notifyAudit', $info, function($message) use($toEmail, $title){
            $message ->to($toEmail)->subject($title);
        });
        
        return count(Mail::failures()) < 1 ? true : false;
    }

}