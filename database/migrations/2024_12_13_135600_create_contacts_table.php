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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->comment('Họ và tên');
            $table->string('email')->unique()->comment('Email của người dùng');
            $table->string('phone')->comment('Số điện thoại');
            $table->string('subject')->comment('Tiêu đề');
            $table->text('message')->comment('Nội dung');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
