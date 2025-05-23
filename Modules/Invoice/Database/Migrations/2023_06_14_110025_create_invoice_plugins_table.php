<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicePluginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_plugins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->string('reference_no');
            $table->enum('payment_status', ['success', 'failed', 'pending', 'expired'])->default('pending');
            $table->string('channel')->nullable();
            $table->mediumText('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_plugins');
    }
}
