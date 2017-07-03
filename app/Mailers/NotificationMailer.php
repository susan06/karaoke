<?php

namespace App\Mailers;

use App\User;
use App\Song;
use App\Reservation;
use App\Coupon;
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
        if(session('branch_office')->email_song) {
            $this->sendTo(session('branch_office')->email_song, $subject, $view, $data);
        }
    }

    public function sendReservation(Reservation $reservation, User $user)
    {
        $view = 'emails.notifications.reservation';
        $data = ['reservation' => $reservation, 'client' => $user];
        $subject = 'Solicitud de reservación - '.Settings::get('app_name').' - Sucursal: '.session('branch_office')->name;
        if(session('branch_office')->email_reservations) {
            $this->sendTo(session('branch_office')->email_reservations, $subject, $view, $data);
        }
    }

    public function sendStatusReservationAdmin(Reservation $reservation, User $user)
    {
        $view = 'emails.notifications.status_reservation';
        $data = ['reservation' => $reservation, 'client' => $user];
        $subject = 'Estado de la reservación - '.$reservation->num_reservation().' - Sucursal: '.$reservation->branchoffice->name;
        if($reservation->branchoffice->email_reservations) {
            $this->sendTo($reservation->branchoffice->email_reservations, $subject, $view, $data);
        }
    }

    public function sendStatusReservation(Reservation $reservation)
    {
        $view = 'emails.notifications.status_reservation_client';
        $data = ['reservation' => $reservation];
        $subject = 'Estatus de su reservación - '.Settings::get('app_name').' - Sucursal: '.$reservation->branchoffice->name;

        $this->sendTo($reservation->user->email, $subject, $view, $data);
    }

    public function sendGroupfieReservation(Reservation $reservation)
    {
        $view = 'emails.notifications.reservation_coupon';
        $data = ['reservation' => $reservation];
        $subject = 'Cupón por su GROUPFIE / reservación - '.Settings::get('app_name').' - Sucursal: '.$reservation->branchoffice->name;

        $this->sendTo($reservation->user->email, $subject, $view, $data);

        if($reservation->branchoffice->email_reservations) {
            $view = 'emails.notifications.reservation_groupfie';
            $data = ['reservation' => $reservation, 'client' => $reservation->user];
            $subject = 'GROUPFIE / reservación # - '.Settings::get('app_name').' - Sucursal: '.$reservation->branchoffice->name;
            $this->sendTo($reservation->branchoffice->email_reservations, $subject, $view, $data);
        }
    }

    public function sendReminderReservation(Reservation $reservation)
    {
        $view = 'emails.notifications.reminder_reservation';
        $data = ['reservation' => $reservation];
        $subject = 'Recordatorio de su reservación - '.Settings::get('app_name').' - Sucursal: '.$reservation->branchoffice->name;

        $this->sendTo($reservation->user->email, $subject, $view, $data);
    }
}