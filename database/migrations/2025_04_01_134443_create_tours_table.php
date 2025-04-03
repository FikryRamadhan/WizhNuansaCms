<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->string("description")->nullable();
            $table->text("address")->nullable();
            $table->integer("contact")->nullable();
            $table->time("opened")->nullable();
            $table->time("closed")->nullable();
            $table->text("image")->nullable();
            $table->decimal("longtitude")->nullable();
            $table->string("latitude")->nullable();
            $table->bigInteger("price")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
