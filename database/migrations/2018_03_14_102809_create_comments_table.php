<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->integer('parent_id')->nullable();
            $table->timestamps();
            $table->integer('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('type_page')->nullable();
            $table->string('type_page_row_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
