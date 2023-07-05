<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->string('ItemCode',10)->primary();
            $table->string('ItemName',50);
            $table->string('ItemCategoryCode',10);
            $table->foreign('ItemCategoryCode')->references('ItemCategoryCode')->on('item_categories');
            $table->string('BaseUnit',20);
            $table->foreign('BaseUnit')->references('UnitCode')->on('unit_measurements');
            $table->decimal('UnitPrice',10,2);
            $table->float('WeightByPrice')->default(1);
            $table->string('DefSalesUnit',20);
            $table->foreign('DefSalesUnit')->references('UnitCode')->on('unit_measurements');
            $table->string('DefPurUnit',20);
            $table->foreign('DefPurUnit')->references('UnitCode')->on('unit_measurements');
            $table->decimal('LastPurPrice',10,2);
            $table->boolean('Discontinued');
            $table->string('Remark',200)->nullable();
            $table->string('CreatedBy',50)->nullable();
            $table->string('ModifiedBy',50)->nullable();
            $table->dateTime('CreatedDate')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('ModifiedDate')->nullable();
 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
