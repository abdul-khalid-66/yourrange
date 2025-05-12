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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->string('name');
            $table->string('tax_number')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('phone', 20);
            $table->string('email');
            $table->text('address');
            $table->string('logo_path', 2048)->nullable();
            $table->string('receipt_header', 2048)->nullable();
            $table->string('receipt_footer', 2048)->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
