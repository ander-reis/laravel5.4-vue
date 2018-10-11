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
            $profile = factory(\SON\Models\UserProfile::class)->make();
            $user->profile()->create($profile->toArray());
            \SON\Models\User::assingRole($user, \SON\Models\User::ROLE_ADMIN);
            $user->save();
        });

        factory(\SON\Models\User::class)->create([
            'email' => 'student@user.com',
            'enrolment' => 700000
        ])->each(function(\SON\Models\User $user){
            if(!$user->userable) {
                $profile = factory(\SON\Models\UserProfile::class)->make();
                $user->profile()->create($profile->toArray());
                \SON\Models\User::assingRole($user, \SON\Models\User::ROLE_STUDENT);
                $user->save();
            }
        });

        factory(\SON\Models\User::class)->create([
            'email' => 'teacher@user.com',
            'enrolment' => 400000
        ])->each(function(\SON\Models\User $user){
            if(!$user->userable) {
                $profile = factory(\SON\Models\UserProfile::class)->make();
                $user->profile()->create($profile->toArray());
                \SON\Models\User::assingRole($user, \SON\Models\User::ROLE_TEACHER);
                $user->save();
            }
        });

        factory(\SON\Models\User::class, 100)->create()->each(function(\SON\Models\User $user){
            if(!$user->userable){
                $profile = factory(\SON\Models\UserProfile::class)->make();
                $user->profile()->create($profile->toArray());
                \SON\Models\User::assingRole($user, \SON\Models\User::ROLE_TEACHER);
                \SON\Models\User::assignEnrolment(new \SON\Models\User(), \SON\Models\User::ROLE_TEACHER);
                $user->save();
            }
        });

        factory(\SON\Models\User::class, 100)->create()->each(function(\SON\Models\User $user){
            if(!$user->userable){
                $profile = factory(\SON\Models\UserProfile::class)->make();
                $user->profile()->create($profile->toArray());
                \SON\Models\User::assingRole($user, \SON\Models\User::ROLE_STUDENT);
                \SON\Models\User::assignEnrolment(new \SON\Models\User(), \SON\Models\User::ROLE_STUDENT);
                $user->save();
            }
        });
    }
}
