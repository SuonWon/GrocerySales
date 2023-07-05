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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->string('SupplierCode',10)->primary();
            $table->string('SupplierName',100);
            $table->string('ContactName',100);
            $table->decimal('Profit',10,1)->nullable()->default(1);
            $table->string('ContactNo',50)->nullable();
            $table->string('OfficeNo',50)->nullable();
            $table->string('Street',100)->nullable();
            $table->string('Township',100)->nullable();
            $table->string('City',100)->nullable();
            $table->boolean('IsActive')->default(1);
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
        Schema::dropIfExists('suppliers');
    }
};
