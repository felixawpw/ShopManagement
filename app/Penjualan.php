<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
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
