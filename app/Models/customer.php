<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class customer
 * @package App\Models
 * @version February 23, 2019, 7:14 pm UTC
 *
 * @property string name
 * @property string email
 * @property string shopify_id
 * @property string stripe_id
 * @property string dna_file_path
 * @property integer has_dna
 */
class customer extends Model
{
    use SoftDeletes;
    public $table = 'customers';
    protected $dates = ['deleted_at'];
    public $fillable = [
        'name',
        'email',
        'shopify_id',
        'stripe_id',
        'dna_file_path',
        'has_dna'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'shopify_id' => 'string',
        'stripe_id' => 'string',
        'dna_file_path' => 'string',
        'has_dna' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'email'
    ];
	
	  
}
