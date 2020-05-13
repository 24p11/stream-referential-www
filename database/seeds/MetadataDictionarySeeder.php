<?php

use App\Model\MetadataDictionary;
use Illuminate\Database\Seeder;

class MetadataDictionarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MetadataDictionary::class, 5)->create();
    }
}
