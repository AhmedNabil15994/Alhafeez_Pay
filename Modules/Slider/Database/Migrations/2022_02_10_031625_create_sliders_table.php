<?php

use Modules\Slider\Enum\SliderType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json("title")->nullable();
            $table->json("description")->nullable();
            $table->string("type", 20)->index()->default(SliderType::NORMAL);
            $table->string("value")->nullable();
            $table->string("image")->default("/uploads/default.png");
            $table->date("start_at");
            $table->date("end_at");
            $table->boolean("status")->index()->default(true);
            $table->softDeletes();
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
        Schema::dropIfExists('sliders');
    }
}
