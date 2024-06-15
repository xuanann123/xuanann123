<?php

use App\Models\Catalogue;
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
            //Dữ liệu nổi
            $table->id();
            $table->foreignIdFor(Catalogue::class)->constrained();
            //Bán sản phẩm ở đây là quần áo
            $table->string('name');
            //không được trùng
            $table->string('slug')->unique();
            // Stock Keeping Unit => mã sản phẩm
            $table->string('sku')->unique();
            //Hình ảnh sán phẩm
            $table->string('thumbnail')->nullable(); 
            $table->double('price_regular');
            $table->double('price_sale')->nullable();
            $table->string('description')->nullable();
            $table->text('content')->nullable();
            //Chất liệu material
            $table->string('material')->nullable()->comment("Chất liệu");
            $table->text('user_manual')->nullable()->comment("Hướng dẫn sử dụng");
            $table->unsignedBigInteger('views')->default(true);

            //Dữ liệu chìm
            $table->boolean('is_active')->default(true);
            $table->boolean('is_hot_deal')->default(false);
            $table->boolean('is_good_deal')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_show_home')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
