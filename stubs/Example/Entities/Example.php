<?php

namespace Modules\Example\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\CamelMutatorTrait;

class Example extends Model
{
    use CamelMutatorTrait;

    protected $fillable = [];
}
