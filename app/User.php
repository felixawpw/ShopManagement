<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'username','email', 'password', 'hak_akses',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function pembelians()
    {
        return $this->hasMany('App\Pembelian');
    }

    public function penjualans()
    {
        return $this->hasMany('App\Penjualan');
    }

    public function pegawai()
    {
        return $this->hasOne('App\Pegawai');
    }
}
