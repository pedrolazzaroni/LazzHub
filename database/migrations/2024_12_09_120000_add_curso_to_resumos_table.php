<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCursoToResumosTable extends Migration
{
    public function up()
    {
        Schema::table('resumos', function (Blueprint $table) {
            $table->string('curso', 50)->after('materia');
        });
    }

    public function down()
    {
        Schema::table('resumos', function (Blueprint $table) {
            $table->dropColumn('curso');
        });
    }
}
