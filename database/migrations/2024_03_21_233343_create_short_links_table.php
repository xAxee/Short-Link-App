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
        Schema::create('users', function (Blueprint $table) {
			$table->id();
            $table->string('username');
            $table->string('email');
            $table->string('avatar')->nullable();
            $table->boolean('verified')->nullable();
            $table->string('refresh_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('short_links', function (Blueprint $table) {
            $table->id();
            $table->string("orginal_link");
            $table->string("short_link")->unique();
            $table->integer("clicks")->default(0);
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('short_links');
    }
};
