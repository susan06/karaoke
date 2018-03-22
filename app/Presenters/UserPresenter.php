<?php

namespace App\Presenters;

use App\Support\Enum\UserStatus;
use Illuminate\Support\Str;
use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
    public function name()
    {
        return sprintf("%s %s", $this->entity->first_name, $this->entity->last_name);
    }

    public function nameOrEmail()
    {
        $name =  $this->entity->first_name.' '.$this->entity->last_name;
        if($this->entity->first_name) {
            return $name;
        } 
        return $this->entity->email;
    }

    public function avatar()
    {
        if (! $this->entity->avatar) {
            return url('assets/img/profile.png');
        }

        return Str::contains($this->entity->avatar, ['http', 'gravatar'])
            ? $this->entity->avatar
            : url("upload/users/{$this->entity->avatar}");
    }

    public function lastLogin()
    {
        return $this->entity->last_login
            ? $this->entity->last_login->diffForHumans()
            : '-';
    }

    /**
     * Determine css class used for status labels
     * inside the users table by checking user status.
     *
     * @return string
     */
    public function labelClass()
    {
        switch($this->entity->status) {
            case UserStatus::ACTIVE:
                $class = 'success';
                break;

            case UserStatus::BANNED:
                $class = 'danger';
                break;

            default:
                $class = 'warning';
        }

        return $class;
    }
}