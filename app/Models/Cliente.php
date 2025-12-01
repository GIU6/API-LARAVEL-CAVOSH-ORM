<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cliente extends Authenticatable
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'codigo_verificacion',
        'esta_verificado',
    ];

    protected $hidden = [
        'password',
        'codigo_verificacion',
    ];
}