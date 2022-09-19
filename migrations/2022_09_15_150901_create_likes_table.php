<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('liker_id')->nullable(); // id user
            $table->string('liker_type')->nullable(); // App\Models\User
            $table->index(["liker_id", "liker_type"]);

            $table->unsignedBigInteger('liketable_id')->nullable(); // id comment
            $table->foreign('liketable_id')->references('id')->on('comments')->onDelete('cascade');

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
        Schema::dropIfExists('likes');
    }
}
