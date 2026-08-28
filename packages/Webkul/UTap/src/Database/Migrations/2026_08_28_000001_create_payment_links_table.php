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
        Schema::create('payment_links', function (Blueprint $table) {
            $table->id();
            $table->string('link_code', 32)->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 50)->nullable();
            $table->decimal('amount', 12, 4);
            $table->string('currency', 10)->default('AED');
            $table->text('reason');
            $table->string('type', 30)->default('admin_created');
            $table->string('status', 30)->default('pending');
            $table->string('utap_invoice_id')->nullable();
            $table->string('utap_txn_id')->nullable();
            $table->string('utap_ipg_id')->nullable();
            $table->text('utap_payment_link')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_links');
    }
};
