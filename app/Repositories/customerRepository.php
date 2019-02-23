<?php

namespace App\Repositories;

use App\Models\customer;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class customerRepository
 * @package App\Repositories
 * @version February 23, 2019, 7:14 pm UTC
 *
 * @method customer findWithoutFail($id, $columns = ['*'])
 * @method customer find($id, $columns = ['*'])
 * @method customer first($columns = ['*'])
*/
class customerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'shopify_id',
        'stripe_id',
        'dna_file_path',
        'has_dna'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return customer::class;
    }
}
