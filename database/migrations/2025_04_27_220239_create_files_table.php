<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->string('id', 200)->primary();
            $table->string('type'); //Ex : png, mp4, mp3, csv
            $table->string('path'); //Ex : users/images/
            $table->string('meaning'); //Ex : license, CIN, etc.
            $table->text('description');
            $table->foreignId('user_id')
            ->constrained( table: 'users', indexName: 'files_user_id')
            ->onUpdate('cascade')
            ->onDelete('cascade'); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('files');
    }
};
