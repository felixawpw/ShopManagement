<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    public function barangs()
    {
    	return $this->hasMany("App\Barang");
    }
}
