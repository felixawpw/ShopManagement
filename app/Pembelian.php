<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    //
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function supplier()
    {
    	return $this->belongsTo('App\Supplier');
    }

    public function barangs()
    {
    	return $this->belongsToMany('App\Barang')->withPivot('hbeli', 'quantity', 'subtotal', 'sisa');
    }
}
