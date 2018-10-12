<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function barangs()
    {
        return $this->belongsToMany('App\Barang')->withPivot('hbeli', 'quantity', 'hjual');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function customer()
    {
    	return $this->belongsTo('App\Customer');
    }
}
