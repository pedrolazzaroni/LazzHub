<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTituloToResumosTable extends Migration
{
    public function up()
    {
        Schema::table('resumos', function (Blueprint $table) {
            $table->string('titulo')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('resumos', function (Blueprint $table) {
            $table->dropColumn('titulo');
        });
    }
}
