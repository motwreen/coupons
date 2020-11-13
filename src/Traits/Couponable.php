<?php
namespace Motwreen\Coupons\Traits;

use Motwreen\Coupons\Models\Coupon;

trait Couponable
{
    public function coupons()
    {
        return $this->morphToMany(Coupon::class, 'couponable');
    }
}
