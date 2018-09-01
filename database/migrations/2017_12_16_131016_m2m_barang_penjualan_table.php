<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class M2mBarangPenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('barang_penjualan', function (Blueprint $table) {
            $table->integer('barang_id')->unsigned()->index();
            $table->integer('penjualan_id')->unsigned()->index();
            
            $table->foreign('barang_id')->references('id')->on('barangs');
            $table->foreign('penjualan_id')->references('id')->on('penjualans');

            $table->integer('quantity');
            $table->integer('hbeli');
            $table->integer('hjual');
            $table->integer('disc');
            $table->integer('hgrosir');
            $table->integer('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('barang_penjualan');

    }
}
