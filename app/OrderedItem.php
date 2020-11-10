<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderedItem extends Model
{
    use SoftDeletes;

    protected $table = 'ordered_items';

    protected $fillable = [
        'order_id',
        'item_id',
        'quantity',
        'rate',
        'amount'
    ];
}
