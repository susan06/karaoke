<?php

namespace App\Mailers;

use App\User;

class UserMailer extends AbstractMailer
{
    public function sendConfirmationEmail($user, $token)
    {
        $view = 'emails.registration.confirmation';
        $data = ['token' => $token];
        $subject = 'Confirmación de registro';

        $this->sendTo($user->email, $subject, $view, $data);
    }

    public function sendPasswordReminder(User $user, $token, $pin = 0)
    {
        $view = 'emails.password.remind';
        $data = ['user' => $user, 'token' => $token, 'pin' => $pin];
        $subject = 'Password Reset Required';

        $this->sendTo($user->email, $subject, $view, $data);
    }
}