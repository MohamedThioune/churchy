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
        Schema::create('sacraments', function (Blueprint $table) {
            $table->id('id');
            $table->string('reason');
            $table->integer('amount');
            $table->foreignId('user_id')->nullable()
            ->constrained( table: 'users', indexName: 'sacraments_user_id')
            ->onUpdate('cascade')
            ->onDelete('cascade');            
            $table->timestamp('sacramented_at');
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
        Schema::drop('sacraments');
    }
};
