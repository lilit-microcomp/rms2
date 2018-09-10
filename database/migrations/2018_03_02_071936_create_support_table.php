<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->string('project_url')->nullable();
            $table->date('due_date')->nullable();
            $table->string('duration')->nullable();
            $table->text('description')->nullable();
            $table->text('access_data')->nullable();
            $table->tinyInteger('send_email_notification')->default(0);
            $table->integer('status')->default(0);
            $table->text('files')->nullable();
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
        Schema::dropIfExists('support');
    }
}
