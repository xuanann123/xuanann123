<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductGallery;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Mỗi lần seeder sẽ tạo thêm dữ liệu => mỗi lần thêm vào thì xoá toàn bộ cái cũ đi
        
        Schema::disableForeignKeyConstraints();
        
        ProductVariant::query()->truncate();
        ProductGallery::query()->truncate();
        DB::table('product_tag')->truncate();
        Product::query()->truncate();
        ProductColor::query()->truncate();
        ProductSize::query()->truncate();
        



        //Bảng tag
        Tag::factory(15)->create();

        //Bảng size S M L XL XXL
        $dataSize = ['S', 'M', 'L', 'XL', 'XXL'];
        $dataColor = ['#000000', '#FFFF00', '#808000', '#FF0000', '#0000FF'];
        //Bảng kích cỡ
        foreach ($dataSize as $item) {
            ProductSize::query()->create([
                'name' => $item
            ]);
        }
        //Bảng màu sắc
        foreach ($dataColor as $item) {
            ProductColor::query()->create([
                'name' => $item
            ]);
        }
        //Bảng product đến
        for ($i = 0; $i < 1000; $i++) {
            $name = fake()->text(100);
            //Tương đương tạo ra một 1k sản phẩm
            Product::query()->create([
                'catalogue_id' => rand(1, 6),
                'name' => $name,
                'slug' => Str::slug($name) . '-' . Str::random(8),
                'sku' => Str::random(8) . $i,
                'thumbnail' => "https://canifa.com/img/1000/1500/resize/8/t/8ts23s008-se297-1.webp",
                'price_regular' => 600000,
                'price_sale' => 499000,
            ]);
        }
        //Bảng ProductGallerty
        for ($i = 1; $i < 1001; $i++) {
            //Tương đương tạo ra một 1k sản phẩm
            ProductGallery::query()->create([
                'product_id' => $i,
                'image' => "https://canifa.com/img/1000/1500/resize/8/t/8ts23s008-se297-1.webp",
            ]);
        }
        //Bảng Product_Tag
        for ($i = 1; $i < 1001; $i++) {
            //Tương đương tạo ra một 1k sản phẩm
            DB::table('product_tag')->insert([
                [
                   'product_id' => $i, 
                   'tag_id' => rand(1, 7)
                ],
                [
                    'product_id' => $i,
                    'tag_id' => rand(9, 15)
                ],
                
            ]);
        }

        //Bảng product Varient
        for ($productID = 1; $productID < 1001; $productID++) {
            $data = [];
            //Tương đương tạo ra một 1k sản phẩm
            for ($sizeID = 1; $sizeID < 6; $sizeID++) {
                for ($colorID = 1; $colorID < 6; $colorID++) {
                    $data[] = [
                        'product_id' => $productID,
                        'product_color_id' => $sizeID,
                        'product_size_id' => $colorID,
                        'quantity' => 100,
                        'image' => "https://canifa.com/img/1000/1500/resize/8/t/8ts22w023-sb346-1.webp",

                    ];
                }
            }
        }
        DB::table('product_variants')->insert($data);
    }
}
