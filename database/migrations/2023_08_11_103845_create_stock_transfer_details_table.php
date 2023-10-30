<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_transfer_details', function (Blueprint $table) {
            $table->string('TransferNo');
            $table->integer('LineNo');
            $table->string('ItemCode',10);
            $table->decimal('Quantity',10,0);
            $table->decimal('QtyPerUnit',10,3);
            $table->string('PackedUnit',10);
            $table->decimal('TotalViss',10,3);
            $table->decimal('UnitPrice',10,2);
            $table->decimal('Amount',10,2);

            $table->primary(['TransferNo', 'LineNo']);
            $table->foreign('TransferNo')->references('TransferNo')->on('stock_transfers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transfer_details');
    }
};
