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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->json('tags')->nullable(true);
            $table->decimal('price', 8, 2);
            $table->timestamps();
            $table->text('backstory');

            // Ref id for artisan who is user
            $table->foreignId('artisan_id')->references('id')->on('users');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->integer('quantity');
            $table->decimal('price', 8, 2);

            $table->foreignId('buyer_id')->references('id')->on('users');
            $table->foreignId('product_id')->references('id')->on('products');
            $table->foreignId('order_id')->references('id')->on('orders');


            $table->string('size');
            $table->string('color');
            $table->timestamps();
        });

        // Adding a field `role` to the users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
