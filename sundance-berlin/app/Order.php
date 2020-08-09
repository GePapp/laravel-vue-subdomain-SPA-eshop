<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** define accessor to unserialize cart column value ---> laravel Accessors **/
  public function getCartAttribute($value) {
    return unserialize($value);
   }
}
