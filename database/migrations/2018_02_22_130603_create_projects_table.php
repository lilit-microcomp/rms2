<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 250)->nullable();
            $table->string('client_id', 15)->nullable();
            $table->string('user_id', 15)->nullable();
            $table->string('descriptive_title', 250)->nullable();
            $table->string('project_url', 250)->nullable();
            $table->string('project_url_test', 250)->nullable();
            $table->string('total_budget', 45)->nullable();
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->tinyInteger('send_email_notification')->default(0);
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('projects');
    }
}
