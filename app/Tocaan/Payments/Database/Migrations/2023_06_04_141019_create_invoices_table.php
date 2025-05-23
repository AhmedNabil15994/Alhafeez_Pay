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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_id');
            $table->string('number');
            $table->decimal('amount');
            $table->decimal('vat')->default(0);
            $table->decimal('vat_amount');
            $table->decimal('discount')->default(0);
            $table->decimal('discount_amount');
            $table->decimal('total');
            $table->char('currency')->default(config('payments.currency'));
            $table->enum('status', ['paid', 'unpaid', 'canceled', 'refunded'])->default('unpaid');
            $table->timestamp('due_at');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
