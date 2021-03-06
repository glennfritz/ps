<?php

use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder{

      public function run()
      {
          $faker = Faker\Factory::create();
          $i = 1;
          foreach(config('constants.CLASS') as $type){
               if($i < 4){
                   DB::table('classes')->insert([
                       'name' => $type,
                       'section_id'=> 1,
                       'created_at' => $faker->date('Y-m-d h:i:s', 'now'),
                       'updated_at' => $faker->date('Y-m-d h:i:s', 'now'),
                       'abbreviations' => "N".$i,
                   ]);
               }else{
                   DB::table('classes')->insert([
                       'name' => $type,
                       'section_id'=> 2,
                       'created_at' => $faker->date('Y-m-d h:i:s', 'now'),
                       'updated_at' => $faker->date('Y-m-d h:i:s', 'now'),
                       'abbreviations' => "P".$i,
                   ]);
               }
              $i++;
          }
      }
}
