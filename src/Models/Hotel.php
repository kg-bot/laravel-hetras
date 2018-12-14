<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 16.48
 */

namespace Hetras\Models;


use Hetras\Utils\Model;

class Hotel extends Model
{

    protected $entity     = '/hotel/v0/hotels';
    protected $primaryKey = 'id';
}