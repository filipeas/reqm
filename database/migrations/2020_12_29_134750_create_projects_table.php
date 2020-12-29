<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedBigInteger('user');
            $table->string('initials', 30);
            $table->string('scope', 255);
            $table->string('diagram_context')->nullable();
            $table->text('product_limits');
            $table->string('developer_institution', 100);
            $table->string('client_institution', 100);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->text('acronym_definitions');
            $table->timestamps();

            $table->foreign('user')->references('id')->on('users')->onDelete('CASCADE');
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
