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
        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->string('InvoiceNo',12)->primary();
            $table->date('SalesDate');
            $table->string('CustomerCode',10);
            $table->foreign('CustomerCode')->references('CustomerCode')->on('customers');
            $table->string('PlateNo',20)->nullable();
            $table->decimal('SubTotal',10,2);
            $table->decimal('ShippingCharges',10)->nullable();
            $table->decimal('LaborCharges',10,2)->nullable();
            $table->decimal('DeliveryCharges',10,2)->nullable();
            $table->decimal('WeightCharges',10,2)->nullable();
            $table->decimal('ServiceCharges',10,2)->nullable();
            $table->decimal('TotalCharges',10,2);
            $table->decimal('GrandTotal',10,2);
            $table->string('Remark',200)->nullable();
            $table->boolean('IsPaid');
            $table->date('PaidDate')->nullable();
            $table->char('Status',1)->default('O');
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
        Schema::dropIfExists('sale_invoices');
    }
};
