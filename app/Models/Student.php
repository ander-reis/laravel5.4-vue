<?php

namespace SON\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function classInformations()
    {
        return $this->belongsToMany(ClassInformation::class);
    }

    /**
     * Serializa os dados e incluser user na consulta do student
     * @return array
     */
    public function toArray()
    {
        $data = parent::toArray();
        //chama relation e esconde dois campos
        $this->user->makeHidden('userable_type', 'userable_id');
        $data['user'] = $this->user;
        return $data;
    }
}
