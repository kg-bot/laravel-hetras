<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 16.48
 */

namespace Hetras\Models;


use Hetras\Utils\Model;

class HouseAccount extends Model
{

    protected $entity     = '/finance/v0/hotels/{hotelId}/house_accounts';
    protected $primaryKey = 'id';
}