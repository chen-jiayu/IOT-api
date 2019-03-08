<?php

use Illuminate\Database\Seeder;

class usersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        user::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            user::create([
                'user_name' => $faker->user_name,
                'mobile' => $faker->mobile,
                'email' => $faker->email,
                'password' => $faker->password,
                'remeber_token' => $faker->remeber_toke,
                'id_token' => $faker->id_token,
                'is_deleted' => $faker->numberBetween($min = 0, $max = 1),
                
            ]);
    }
    }
}
