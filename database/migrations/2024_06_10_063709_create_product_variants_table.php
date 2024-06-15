<?php

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->constrained();
            $table->foreignIdFor(ProductSize::class)->constrained();
            $table->foreignIdFor(ProductColor::class)->constrained();
            //Có thêm từng trường dữ liệu có mỗi bảng này
            $table->unsignedBigInteger('quantity')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
            //Không được cho trùng dữ liệu giữa các giá trị với nhau =>unique giữa các khoá ngoại với nhau
            $table->unique(['product_id', 'product_color_id', 'product_size_id'], 'product_variants_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
