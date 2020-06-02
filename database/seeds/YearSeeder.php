<?php

use Illuminate\Database\Seeder;

class YearSeeder extends Seeder{

      public function run()
      {
          $faker = Faker\Factory::create();
          $date = new \DateTime();
          foreach(config('constants.YEAR') as $type){
                DB::table('sessions')->insert([
                    'name' => $type,
                    'created_at' => $faker->date('Y-m-d h:i:s', 'now'),
                    'updated_at' => $faker->date('Y-m-d h:i:s', 'now')
                ]);
          }
      }
}
