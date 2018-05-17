<?php
// app/database/seeds/UserTableSeeder.php
use Illuminate\Database\Seeder;
use App\Http\Model\User;

class UserTableSeeder extends Seeder
{

public function run()
{
    DB::table('users')->delete();
    User::create(array(
        'name'     => 'Chris Sevilleja',
        'email'    => 'chris@yopmail.com',
        'password' => Hash::make('awesome'),
    ));
}

}