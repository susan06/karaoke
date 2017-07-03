<?php

namespace App\Repositories\Coupon;

use App\Coupon;
use Carbon\Carbon;
use App\Repositories\Repository;

class EloquentCoupon extends Repository implements CouponRepository
{

    public function __construct(Coupon $coupon)
    {
        parent::__construct($coupon);
    }

}