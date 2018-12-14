<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 15.37
 */

namespace Hetras\Builders;


use Hetras\Models\Hotel;

class HotelBuilder extends Builder
{
    protected $entity = 'hotel/v0/hotels';
    protected $model  = Hotel::class;
}