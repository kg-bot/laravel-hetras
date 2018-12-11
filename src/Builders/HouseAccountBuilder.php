<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 15.37
 */

namespace Hetras\Builders;


use Hetras\Models\HouseAccount;

class HouseAccountBuilder extends Builder
{
    protected $entity = 'finance/v0/hotels/{hotelId}/house_accounts';
    protected $model  = HouseAccount::class;
}