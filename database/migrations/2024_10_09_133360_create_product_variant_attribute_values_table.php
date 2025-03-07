<?php

use App\Models\Attribute_value;
use App\Models\Product_variant;
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
        Schema::create('product_variant_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product_variant::class)->comment('Khóa ngoại, thuộc về biến thể nào')->constrained();
            $table->foreignIdFor(Attribute_value::class)->comment('Xác định biến thể này có những thuộc tính nào')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variant_attribute_values');
    }
};
