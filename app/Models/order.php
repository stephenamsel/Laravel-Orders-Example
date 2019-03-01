<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class order
 * @package App\Models
 * @version February 23, 2019, 7:18 pm UTC
 *
 * @property string customer_shopify_id
 * @property string plan_name
 */
class order extends Model
{
    use SoftDeletes;

    public $table = 'orders';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'customer_shopify_id',
        'plan_name',
        'amount_paid'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'customer_shopify_id' => 'string',
        'plan_name' => 'string',
        'amount_paid' => 'float',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'plan_name' => 'text if'
    ];

    
}
