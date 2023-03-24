<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User as users;
use Illuminate\Support\Facades\Hash;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user=new users();
        $user->name='steveyout';
        $user->email='youtsteve1@gmail.com';
        $user->password=Hash::make('test123@');
        $user->phone_no='254719567930';
        $user->id_no='0719567930';
        $user->save();
    }
}
