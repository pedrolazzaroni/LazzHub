<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResumosTable extends Migration
{
    public function up()
    {
        Schema::create('resumos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->string('materia');
            $table->string('nivel');
            $table->string('conteudo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resumos');
    }
}
