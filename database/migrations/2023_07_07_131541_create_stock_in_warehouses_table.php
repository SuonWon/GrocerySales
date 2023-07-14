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
        Schema::create('stock_in_warehouses', function (Blueprint $table) {
            $table->string('WarehouseCode',10);
            $table->string('ItemCode',10);
            $table->float('StockQty',10,2);
            $table->dateTime('LastUpdatedDate');
            
            $table->primary(['WarehouseCode', 'ItemCode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_in_warehouses');
    }
};
