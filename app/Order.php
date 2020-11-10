<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'order_number',
        'user_id',
        'ordered_on',
        'grand_total',
        'billing_name',
        'contact_no',
        'delivery_address',
    ];

    /**
     * @return HasMany
     */
    public function orderedItems()
    {
        return $this->hasMany(OrderedItem::class, 'order_id');
    }
}
