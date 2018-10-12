<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembelian extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

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
    	return $this->belongsToMany('App\Barang')->withPivot('hbeli', 'quantity', 'sisa');
    }
}
