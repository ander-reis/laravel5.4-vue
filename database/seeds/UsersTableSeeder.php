<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\SON\Models\User::class)->create([
            'email' => 'admin@user.com',
            'enrolment' => 100000
        ])->each(function(\SON\Models\User $user){
            \SON\Models\User::assingRole($user, \SON\Models\User::ROLE_ADMIN);
            $user->save();
        });

        factory(\SON\Models\User::class, 10)->create()->each(function(\SON\Models\User $user){
            if(!$user->userable){
                \SON\Models\User::assingRole($user, \SON\Models\User::ROLE_TEACHER);
                \SON\Models\User::assignEnrolment(new \SON\Models\User(), \SON\Models\User::ROLE_TEACHER);
                $user->save();
            }
        });

        factory(\SON\Models\User::class, 10)->create()->each(function(\SON\Models\User $user){
            if(!$user->userable){
                \SON\Models\User::assingRole($user, \SON\Models\User::ROLE_STUDENT);
                \SON\Models\User::assignEnrolment(new \SON\Models\User(), \SON\Models\User::ROLE_STUDENT);
                $user->save();
            }
        });
    }
}
