<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Language;
use App\Models\Role;
use App\Models\Timezone;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            array(
                'name'              => 'one test',
                'email'             => 'test@test.com',
                'city'              => 'springfield',
                'birthdate'         => '1988/10/06',
                'password'          => Hash::make('password'),
            ),
        ];

        foreach ($datos as $key => $value) {

            $user = User::updateOrCreate([
                'email'     => $value['email'],
            ], $value);

            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }
        }
    }
}
