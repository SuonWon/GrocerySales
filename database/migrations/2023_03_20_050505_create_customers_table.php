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
        Schema::create('customers', function (Blueprint $table) {
            
            $table->string('CustomerCode',10)->primary();
            $table->string('CustomerName',100);
            $table->string('NRCNo',30)->nullable();
            $table->string('CompanyName',100)->nullable();
            $table->string('Street',200)->nullable();
            $table->string('City',200)->nullable();
            $table->string('Region',200)->nullable();
            $table->string('ContactNo',50)->nullable();
            $table->string('OfficeNo',50)->nullable();
            $table->string('FaxNo',50)->nullable();
            $table->string('Email',50)->nullable()->unique();
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
        Schema::dropIfExists('customers');
    }
};
