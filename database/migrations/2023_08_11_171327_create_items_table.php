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
        Schema::create('items', function (Blueprint $table) {
           $table->id();
           $table->string('name');
           $table->string('item_no');
            $table->integer('quantity');
            $table->integer('remain_quantity')->default(0);
            $table->decimal('price', 10, 2);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('unit_id');
            $table->timestamps();


            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('item_id')->references('id')->on('itemUnit');
            $table->foreign('department_id')->references('id')->on('departments');
           $table->foreign('category_id')
           ->references('id')
           ->on('categories')
           ->onDelete('cascade');
            
        });
      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
