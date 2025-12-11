<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ProductImportSeeder extends Seeder
{
    public function run()
    {
        // 1. Siapkan Kategori Dulu (Biar ID-nya ada)
        $categories = ['Pria', 'Wanita', 'Anak', 'Aksesoris', 'Uncategorized'];
        $catMap = [];
        
        foreach ($categories as $name) {
            $cat = Category::firstOrCreate(['name' => $name]);
            $catMap[$name] = $cat->id;
        }

        // 2. Data Mentah dari cloth.sql (Sudah dikonversi)
        $products = [
            // Data ID 1-20 (Kategori NULL di source, kita masukkan ke Uncategorized)
            ['name' => 'Knitwear', 'desc' => 'knit', 'price' => 259000, 'stock' => 8, 'image' => '1764223618_SWEATER KNIT1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Denim Jacket', 'desc' => 'denim keren', 'price' => 399000, 'stock' => 10, 'image' => '1764223620_DENIM1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Hoodie Oversize', 'desc' => 'hoodie tebal', 'price' => 289000, 'stock' => 12, 'image' => '1764223622_HOODIE1.png', 'cat' => 'Uncategorized'],
            ['name' => 'T-Shirt Basic', 'desc' => 'kaos polos', 'price' => 99000, 'stock' => 20, 'image' => '1764223624_TSHIRT1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Cargo Pants', 'desc' => 'celana cargo', 'price' => 199000, 'stock' => 15, 'image' => '1764223626_CARGO1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Flannel Shirt', 'desc' => 'kemeja flannel', 'price' => 159000, 'stock' => 10, 'image' => '1764223628_FLANNEL1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Sweatpants', 'desc' => 'celana santai', 'price' => 149000, 'stock' => 12, 'image' => '1764223630_SWEATPANTS1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Bomber Jacket', 'desc' => 'jaket bomber', 'price' => 349000, 'stock' => 8, 'image' => '1764223632_BOMBER1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Long Sleeve Tee', 'desc' => 'kaos lengan panjang', 'price' => 119000, 'stock' => 16, 'image' => '1764223634_LONGSLEEVE1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Polo Shirt', 'desc' => 'kaos polo', 'price' => 129000, 'stock' => 14, 'image' => '1764223636_POLO1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Cardigan', 'desc' => 'cardigan rajut', 'price' => 179000, 'stock' => 9, 'image' => '1764223638_CARDIGAN1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Short Pants', 'desc' => 'celana pendek', 'price' => 99000, 'stock' => 18, 'image' => '1764223640_SHORTS1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Varsity Jacket', 'desc' => 'jaket varsity', 'price' => 399000, 'stock' => 7, 'image' => '1764223642_VARSITY1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Dress Casual', 'desc' => 'dress santai', 'price' => 219000, 'stock' => 11, 'image' => '1764223644_DRESS1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Blazer', 'desc' => 'blazer formal', 'price' => 299000, 'stock' => 6, 'image' => '1764223646_BLAZER1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Tanktop', 'desc' => 'tanktop wanita', 'price' => 79000, 'stock' => 13, 'image' => '1764223648_TANKTOP1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Jeans Slimfit', 'desc' => 'jeans slimfit', 'price' => 219000, 'stock' => 10, 'image' => '1764223650_JEANS1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Outer Kimono', 'desc' => 'outer kimono', 'price' => 159000, 'stock' => 8, 'image' => '1764223652_KIMONO1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Sweater Crop', 'desc' => 'sweater crop', 'price' => 139000, 'stock' => 12, 'image' => '1764223654_CROP1.png', 'cat' => 'Uncategorized'],
            ['name' => 'Jumpsuit', 'desc' => 'jumpsuit wanita', 'price' => 249000, 'stock' => 7, 'image' => '1764223656_JUMPSUIT1.png', 'cat' => 'Uncategorized'],

            // Data ID 21-35 (Kategori ada)
            ['name' => 'Kaos Polos Premium', 'desc' => 'Produk fashion berkualitas tinggi dengan bahan premium...', 'price' => 150000, 'stock' => 170, 'image' => 'default.jpg', 'cat' => 'Pria'],
            ['name' => 'Kemeja Formal Slim Fit', 'desc' => 'Produk fashion berkualitas tinggi...', 'price' => 250000, 'stock' => 75, 'image' => 'default.jpg', 'cat' => 'Pria'],
            ['name' => 'Celana Jeans Denim', 'desc' => 'Produk fashion berkualitas tinggi...', 'price' => 300000, 'stock' => 167, 'image' => 'default.jpg', 'cat' => 'Pria'],
            ['name' => 'Jaket Bomber', 'desc' => 'Produk fashion berkualitas tinggi...', 'price' => 400000, 'stock' => 120, 'image' => 'default.jpg', 'cat' => 'Pria'],
            ['name' => 'Dress Casual', 'desc' => 'Produk fashion berkualitas tinggi...', 'price' => 200000, 'stock' => 141, 'image' => 'default.jpg', 'cat' => 'Wanita'],
            ['name' => 'Blouse Elegant', 'desc' => 'Produk fashion berkualitas tinggi...', 'price' => 180000, 'stock' => 168, 'image' => 'default.jpg', 'cat' => 'Wanita'],
            ['name' => 'Rok Mini', 'desc' => 'Produk fashion berkualitas tinggi...', 'price' => 120000, 'stock' => 59, 'image' => 'default.jpg', 'cat' => 'Wanita'],
            ['name' => 'Cardigan Rajut', 'desc' => 'Produk fashion berkualitas tinggi...', 'price' => 220000, 'stock' => 95, 'image' => 'default.jpg', 'cat' => 'Wanita'],
            ['name' => 'Kaos Anak Karakter', 'desc' => 'Produk fashion berkualitas tinggi...', 'price' => 80000, 'stock' => 108, 'image' => 'default.jpg', 'cat' => 'Anak'],
            ['name' => 'Celana Pendek Anak', 'desc' => 'Produk fashion berkualitas tinggi...', 'price' => 60000, 'stock' => 172, 'image' => 'default.jpg', 'cat' => 'Anak'],
            ['name' => 'Topi Baseball', 'desc' => 'Produk fashion berkualitas tinggi...', 'price' => 50000, 'stock' => 153, 'image' => 'default.jpg', 'cat' => 'Aksesoris'],
            ['name' => 'Tas Ransel', 'desc' => 'Produk fashion berkualitas tinggi...', 'price' => 350000, 'stock' => 176, 'image' => 'default.jpg', 'cat' => 'Aksesoris'],
            ['name' => 'Kaos Polo Shirt', 'desc' => 'Produk fashion berkualitas tinggi...', 'price' => 175000, 'stock' => 68, 'image' => 'default.jpg', 'cat' => 'Pria'],
            ['name' => 'Sweater Hoodie', 'desc' => 'Produk fashion berkualitas tinggi...', 'price' => 280000, 'stock' => 193, 'image' => 'default.jpg', 'cat' => 'Pria'],
            ['name' => 'Jumpsuit Wanita', 'desc' => 'Produk fashion berkualitas tinggi...', 'price' => 320000, 'stock' => 150, 'image' => 'default.jpg', 'cat' => 'Wanita'],
        ];

        // 3. Loop Insert ke Database Baru
        foreach ($products as $item) {
            Product::create([
                'name' => $item['name'],
                'category_id' => $catMap[$item['cat']], // Ambil ID dari map
                'price' => $item['price'],
                'stock' => $item['stock'],
                'description' => $item['desc'],
                'image' => 'products/' . $item['image'], // Tambah prefix folder biar rapi
            ]);
        }
    }
}