<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_codes', function (Blueprint $table) {
            $table->id();
            $table->string("code", 50)->nullable();
            $table->string("phone_code", 10)->nullable()->default("965");
            $table->string("mobile", 50)->nullable();
            $table->nullableMorphs("user", "user_id");
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
        Schema::dropIfExists('mobile_codes');
    }
}
