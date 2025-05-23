<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HandleUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId("nationality_id")
                  ->nullable()
                  ->constrained("countries")
                  ->nullOnDelete()
                  ->cascadeOnDelete();

            $table->string("age")->nullable();
            $table->string("id_number")->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
           $table->dropForeign(["nationality_id"]);
           $table->dropColumn(["nationality_id", "age", "id_number"]);
        });
    }
}
