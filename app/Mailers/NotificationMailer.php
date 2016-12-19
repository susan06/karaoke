<?php

namespace App\Mailers;

use App\User;
use App\Song;
use App\Reservation;
use Settings;

class NotificationMailer extends AbstractMailer
{
    public function newUserRegistration(User $recipient, User $newUser)
    {
        $view = 'emails.notifications.new-registration';
        $data = ['user' => $recipient, 'newUser' => $newUser];
        $subject = 'New User Registration';

        $this->sendTo($recipient->email, $subject, $view, $data);
    }

    public function sendApplySong(Song $song, User $user)
    {
        $view = 'emails.notifications.apply_song';
        $data = ['song' => $song, 'client' => $user];
        $subject = 'Solicitud de canción - '.Settings::get('app_name').' - Sucursal: '.session('branch_office')->name;

        $this->sendTo(session('branch_office')->email_song, $subject, $view, $data);
    }

    public function sendReservation(Reservation $reservation, User $user)
    {
        $view = 'emails.notifications.reservation';
        $data = ['reservation' => $reservation, 'client' => $user];
        $subject = 'Solicitud de reservación - '.Settings::get('app_name').' - Sucursal: '.session('branch_office')->name;

        $this->sendTo(session('branch_office')->email_reservations, $subject, $view, $data);
    }
}