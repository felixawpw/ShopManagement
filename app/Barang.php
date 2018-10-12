<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    //
    public function pembelians()
    {
    	return $this->belongsToMany('App\Pembelian')
    				->withPivot('quantity', 'hbeli', 'sisa');
    }

    public function penjualans()
    {
    	return $this->belongsToMany('App\Penjualan')
    				->withPivot('quantity', 'hbeli', 'hjual');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    public function product_type()
    {
        return $this->belongsTo('App\ProductType');
    }
}
