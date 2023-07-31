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
        Schema::create('sale_invoice_details', function (Blueprint $table) {
            $table->string('InvoiceNo',12);
            $table->string('ReferenceNo',50)->primary();
            $table->foreign('InvoiceNo')->references('InvoiceNo')->on('sale_invoices');
            $table->string('WarehouseNo',10);
            $table->string('ItemCode',10);
            $table->foreign('ItemCode')->references('ItemCode')->on('items');
            $table->decimal('Quantity',10,2);
            $table->string('PackedUnit',10);
            $table->foreign('PackedUnit')->references('UnitCode')->on('unit_measurements');
            $table->decimal('QtyPerUnit', 10,3)->default(0);
            $table->decimal('TotalViss',10,3);
            $table->decimal('UnitPrice',10,2);
            $table->decimal('Amount',10,2);
            $table->decimal('LineDisPer',10,2);
            $table->decimal('LineDisAmt',10,2);
            $table->decimal('LineTotalAmt',10,2);
            $table->boolean('IsFOC')->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_invoice_details');
    }
};
