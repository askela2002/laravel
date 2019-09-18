<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserVacancyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_vacancy', function (Blueprint $table) {

            $table->integer('user_id')->unsigned();
            $table->integer('vacancy_id')->unsigned();
//            $table->foreign('user_id')->references('id')->on('users')
//                ->onDelete('cascade');
//            $table->foreign('vacancy_id')->references('id')->on('vacancies')
//                ->onDelete('cascade');
            $table->softDeletes();
            $table->unique(['user_id', 'vacancy_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_vacancy', function (Blueprint $table) {
            $table->dropIfExists('user_vacancy');
        });
    }
}
