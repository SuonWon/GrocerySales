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
        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->string('AdjustmentNo')->primary();
            $table->dateTime('AdjustmentDate');
            $table->string('Warehouse',10);
            $table->string('Remark',200)->nullable();
            $table->char('Status');
            $table->string('CreatedBy',50)->nullable();
            $table->string('ModifiedBy',50)->nullable();
            $table->string('DeletedBy',50)->nullable();
            $table->dateTime('CreatedDate')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('ModifiedDate')->nullable();
            $table->dateTime('DeletedDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_adjustments');
    }
};
