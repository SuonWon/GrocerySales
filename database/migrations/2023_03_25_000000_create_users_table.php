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
        Schema::create('users', function (Blueprint $table) {
            $table->string('Username',20)->primary();
            $table->string('Fullname',50);
            $table->string('Password',255);
          
            $table->unsignedBigInteger('SystemRole');
            $table->foreign('SystemRole')->references('RoleId')->on('system_roles');
            
            $table->boolean('IsActive')->default(1);
            $table->string('Remark',200)->nullable();
            $table->rememberToken();
            $table->string('CreatedBy',50)->nullable();
            $table->string('ModifiedBy',50)->nullable();
            $table->dateTime('CreatedDate')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('ModifiedDate')->nullable();
        });
    }
    // 2014_10_12_000000_create_users_table.php
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
