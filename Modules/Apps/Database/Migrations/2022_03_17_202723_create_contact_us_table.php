<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->uuid('id');
            $table->string("username");
            $table->string("mobile");
            $table->string("email");
            $table->text("message")->nullable();
            $table->timestamp("seen_at")->nullable();
            $table->foreignId("user_id")
                    ->nullable()
                    ->constrained("users")
                    ->cascadeOnUpdate()
                    ->nullOnDelete();
            $table->primary(["id"]);
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
        Schema::dropIfExists('contact_us');
    }
}
