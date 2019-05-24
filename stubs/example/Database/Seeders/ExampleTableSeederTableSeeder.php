<?php

namespace Modules\Example\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Example\Entities\Example;

class ExampleTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Example::truncate();
        Example::create([
            'name'  => 'demo',
            'value' => 'hello world',
        ]);
    }
}
