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
        Schema::create('unit_measurements', function (Blueprint $table) {
            $table->string('UnitCode',10)->primary();
            $table->string('UnitDesc',50);
            $table->boolean('IsActive')->nullable()->default(1);
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
        Schema::dropIfExists('unit_measurements');
    }
};
