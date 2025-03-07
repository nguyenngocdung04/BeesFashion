<?php

use App\Models\Product_vote;
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
        Schema::create('product_vote_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name')->comment('Tên file');
            $table->string('file_type')->comment('Loại file (có 2 loại là ảnh và video)');
            $table->foreignIdFor(Product_vote::class)->comment('Xác định đánh giá nào');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_vote_files');
    }
};
