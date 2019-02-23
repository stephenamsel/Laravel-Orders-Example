<?php

namespace App\Repositories;

use App\Models\order;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class orderRepository
 * @package App\Repositories
 * @version February 23, 2019, 7:18 pm UTC
 *
 * @method order findWithoutFail($id, $columns = ['*'])
 * @method order find($id, $columns = ['*'])
 * @method order first($columns = ['*'])
*/
class orderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'customer_shopify_id',
        'plan_name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return order::class;
    }
}
