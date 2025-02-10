<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonParentTable extends Migration
{
    public function up()
    {
        Schema::create('person_parent', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('child_id');

            // Vous pouvez ajouter des index pour optimiser les requêtes
            // $table->index('parent_id');
            // $table->index('child_id');

            // Optionnel : définir une clé primaire composite pour éviter les doublons
            // $table->primary(['parent_id', 'child_id']);

            // Si vous souhaitez assurer l'intégrité référentielle, vous pouvez ajouter des foreign keys
            // $table->foreign('parent_id')->references('id')->on('people')->onDelete('cascade');
            // $table->foreign('child_id')->references('id')->on('people')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('person_parent');
    }
}

