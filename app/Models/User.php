<?php

namespace SON\Models;

use Bootstrapper\Interfaces\TableInterface;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SON\Notifications\UserCreated;

class User extends Authenticatable implements TableInterface
{
    use Notifiable;

    const ROLE_ADMIN = 1;
    const ROLE_TEACHER = 2;
    const ROLE_STUDENT = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'enrolment'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userable()
    {
        return $this->morphTo();
    }

    public static function createFully($data)
    {
        //cria password
        $password = str_random(6);
        $data['password'] = $password;
        /** @var User $user */
        $user = parent::create($data + ['enrolment' => str_random(6)]);

        //cria matricula
        self::assignEnrolment($user, self::ROLE_ADMIN);

        $user->save();

        //envia email de notificação de conta criada
        if(isset($data['send_mail'])){

            //gera token para recuperar password
            $token = \Password::broker()->createToken($user);

            $user->notify(new UserCreated($token));
        }

        return compact('user', 'password');
    }

    public static function assignEnrolment(User $user, $type)
    {
        $types = [
            self::ROLE_ADMIN => 100000,
            self::ROLE_TEACHER => 400000,
            self::ROLE_STUDENT => 700000
        ];

        $user->enrolment = $types[$type] + $user->id;
        return $user->enrolment;
    }

    /**
     * A list of headers to be used when a table is displayed
     *
     * @return array
     */
    public function getTableHeaders()
    {
        return ['ID', 'Nome', 'Email'];
    }

    /**
     * Get the value for a given header. Note that this will be the value
     * passed to any callback functions that are being used.
     *
     * @param string $header
     * @return mixed
     */
    public function getValueForHeader($header)
    {
        switch($header){
            case 'ID':
                return $this->id;
            case 'Nome':
                return $this->name;
            case 'Email':
                return $this->email;
        }
    }
}