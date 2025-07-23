<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string('api_id')->unique();
            $table->string('finnish');
            $table->string('english');
            $table->text('example');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('words');
    }
};
