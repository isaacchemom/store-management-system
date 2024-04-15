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
        Schema::create('issue_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
           $table->unsignedBigInteger('staff_id');
           
            $table->integer('quantity')->unsigned();
            $table->timestamps();
          
            $table->foreign('unit_id')->references('id')->on('items');
            $table->foreign('staff_id')->references('id')->on('staff');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issue_items');
    }
};
