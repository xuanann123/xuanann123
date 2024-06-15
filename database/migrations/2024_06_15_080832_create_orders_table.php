<?php

use App\Models\Order;
use App\Models\ProductVariant;
use App\Models\User;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            //Định danh được người đặt hàng thôi, chỉ dùng để xác định nó là thằng nào
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(ProductVariant::class)->constrained();
            //Lưu lại thông tin của người đặt hàng
            $table->string('user_name');
            $table->string('user_email');
            $table->string('user_phone');
            $table->string('user_address');
            $table->string('user_note');

            $table->boolean('is_ship_user_same_user')->default(true);
            
            //Tiếp tục đến lưu thông tin của người nhận hàng
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_phone')->nullable();
            $table->string('user_address')->nullable();
            $table->string('user_note')->nullable();
            $table->timestamps();
            //Trạng thái nào đơn hàng ra sao
            $table->string('status_order')->default(Order::STATUS_ORDER_PENDING);
            $table->string('status_payment')->default(Order::STATUS_ORDER_UNPAID);
            //Trạng thái đã thanh toán hay chưa
            $table->double('total_price', 15, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
