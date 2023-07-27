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
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->string('InvoiceNo',12)->primary();
            $table->date('PurchaseDate');
            $table->string('SupplierCode');
            $table->foreign('SupplierCode')->references('SupplierCode')->on('suppliers');
            $table->string('ArrivalCode');
            $table->foreign('ArrivalCode')->references('ArrivalCode')->on('item_arrivals');
            $table->char('IsComplete', 1)->default(0)->nullable();
            $table->decimal('SubTotal',10,2);
            $table->decimal('ShippingCharges',10)->nullable()->default(0);
            $table->decimal('LaborCharges',10,2)->nullable()->default(0);
            $table->decimal('DeliveryCharges',10,2)->nullable()->default(0);
            $table->decimal('WeightCharges',10,2)->nullable()->default(0);
            $table->decimal('ServiceCharges',10,2)->nullable()->default(0);
            $table->decimal('FactoryCharges',10)->nullable()->default(0);
            $table->decimal('TotalCharges',10,2);
            $table->decimal('GrandTotal',10,2);
            $table->string('Remark',200);
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
        Schema::dropIfExists('purchase_invoices');
    }
};
