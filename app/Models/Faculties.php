<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculties extends Model
{
    use HasFactory;

    protected $table = 'faculties';
    protected $guarded = [];

    public function students()
    {
        return $this->hasMany('App\Models\Students', 'id_fakultas');
    }
}
