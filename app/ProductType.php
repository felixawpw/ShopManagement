<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    //
    
    public function barangs()
    {
    	return $this->hasMany("App\Barang");
    }
}
