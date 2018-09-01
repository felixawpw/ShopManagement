<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class M2mBarangPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('barang_pembelian', function (Blueprint $table) {
            $table->integer('barang_id')->unsigned()->index();
            $table->integer('pembelian_id')->unsigned()->index();
            
            $table->foreign('barang_id')->references('id')->on('barangs');
            $table->foreign('pembelian_id')->references('id')->on('pembelians');

            $table->integer('quantity');
            $table->integer('hbeli');
            $table->integer('subtotal');
            $table->integer('sisa');
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
        Schema::dropIfExists('barang_pembelian');

    }
}
