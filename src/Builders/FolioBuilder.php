<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 15.37
 */

namespace Hetras\Builders;


use Hetras\Models\Folio;

class FolioBuilder extends Builder
{
    protected $entity = 'finance/v0/hotels/{hotelId}/folios';
    protected $model  = Folio::class;
}