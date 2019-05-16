<?php

namespace Modules\Example\Transformers;

use Modules\Core\Abstracts\TransformerAbstract;

/**
 * Class ExampleTransformer
 *
 * @package Modules\Example\Transformers
 */
class ExampleTransformer extends TransformerAbstract
{
    /**
     * Transform the Example entity.
     *
     * @param \Modules\Example\Entities\Example $attribute
     *
     * @return array
     */
    public function fields($attribute)
    {
        return [
            'id' => (int) $attribute->id,

            /* place your other model properties here */

            'created_at' => $attribute->createdAt,
            'updated_at' => $attribute->updatedAt
        ];
    }
}
