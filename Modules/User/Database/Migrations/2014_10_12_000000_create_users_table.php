<?php

use Modules\User\Enum\UserType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('image')->default("/uploads/default.png")->nullable();
            $table->string("phone_code")->nullable()->default("965");
            $table->string('mobile')->unique();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes();
            $table->string("type", 20)->default(UserType::USER)->index();
            $table->string("id_image")->nullable()->default("/uploads/default.png");
            $table->boolean("admin_approved")->default(false)->index();
            $table->boolean("is_verified")->default(false)->index();
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
        Schema::dropIfExists('users');
    }
}
