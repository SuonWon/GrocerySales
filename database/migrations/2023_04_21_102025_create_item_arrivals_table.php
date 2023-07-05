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
        Schema::create('item_arrivals', function (Blueprint $table) {
            $table->string('ArrivalCode',12)->primary();
            $table->date('ArrivalDate');
            $table->string('PlateNo',20)->nullable();
            $table->decimal('ChargesPerBag',10,2);
            $table->float('TotalBags',10,2);
            $table->decimal('OtherCharges',10,2);
            $table->decimal('TotalCharges',10,2);
            $table->char('Status',1)->default('N');
            $table->string('Remark',200)->nullable();
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
        Schema::dropIfExists('item_arrivals');
    }
};
