<?php

use App\Models\Cart;
use App\Models\Order;
use App\Models\ProductVariant;
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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            //Variant đã lưu tất cả từ sản phẩm màu sắc đến size
            $table->foreignIdFor(ProductVariant::class)->constrained();
            $table->foreignIdFor(Cart::class)->constrained();

            $table->unsignedBigInteger('quantity')->default(0);
            //Khoong lưu giá ở đây vì có thể bị thay đổi đi, sản phẩm biến thiên được
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
