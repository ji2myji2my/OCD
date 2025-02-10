<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('relationships', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('parent_id')->unsigned();
            $table->bigInteger('child_id')->unsigned();
            $table->timestamps();

            $table->primary('id');
            $table->index('created_by');
            $table->index('parent_id');
            $table->index('child_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relationships');
    }
};
