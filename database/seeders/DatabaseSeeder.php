<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Campaign;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Bikin Akun ADMIN
        User::create([
            'name' => 'Admin Laviade',
            'email' => 'admin@laviade.com',
            'password' => Hash::make('password'), // Passwordnya: password
            'role' => 'admin',
        ]);

        // 2. Bikin Akun USER Biasa
        User::create([
            'name' => 'Joseph User',
            'email' => 'user@laviade.com',
            'password' => Hash::make('password'), // Passwordnya: password
            'role' => 'user',
        ]);

        // 3. Bikin Kategori
        $catTops = Category::create(['name' => 'Tops']);
        $catBottoms = Category::create(['name' => 'Bottoms']);
        $catOuter = Category::create(['name' => 'Outerwear']);

        // 4. Bikin Produk Dummy
        // Produk 1 (Tops)
        Product::create([
            'name' => 'Laviade Signature T-Shirt',
            'category_id' => $catTops->id,
            'price' => 150000,
            'stock' => 50,
            'description' => 'Kaos katun bambu premium dengan logo Laviade minimalis.',
            'image' => 'products/tshirt_black.jpg', // Nanti siapin gambar dummy
        ]);

        // Produk 2 (Tops)
        Product::create([
            'name' => 'Oversized Graphic Tee',
            'category_id' => $catTops->id,
            'price' => 185000,
            'stock' => 30,
            'description' => 'Kaos oversized dengan sablon grafis artistik di punggung.',
            'image' => 'products/tshirt_graphic.jpg',
        ]);

        // Produk 3 (Bottoms)
        Product::create([
            'name' => 'Cargo Pants Utility',
            'category_id' => $catBottoms->id,
            'price' => 350000,
            'stock' => 20,
            'description' => 'Celana kargo dengan banyak saku fungsional, bahan ripstop.',
            'image' => 'products/cargo_pants.jpg',
        ]);

        // Produk 4 (Bottoms)
        Product::create([
            'name' => 'Slim Fit Chino',
            'category_id' => $catBottoms->id,
            'price' => 299000,
            'stock' => 45,
            'description' => 'Celana chino potongan slim fit yang nyaman untuk daily wear.',
            'image' => 'products/chino_cream.jpg',
        ]);

        // Produk 5 (Outer)
        Product::create([
            'name' => 'Varsity Jacket Laviade',
            'category_id' => $catOuter->id,
            'price' => 550000,
            'stock' => 10,
            'description' => 'Jaket varsity klasik dengan bordir towel Laviade di dada.',
            'image' => 'products/varsity.jpg',
        ]);

        // Produk 6 (Outer)
        Product::create([
            'name' => 'Denim Trucker Jacket',
            'category_id' => $catOuter->id,
            'price' => 450000,
            'stock' => 15,
            'description' => 'Jaket denim 14oz dengan washing vintage blue.',
            'image' => 'products/denim_jacket.jpg',
        ]);

        // 5. Bikin Campaign Dummy
        Campaign::create([
            'title' => 'Opening Sale',
            'banner_path' => 'banners/opening_sale.jpg',
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'redirect_url' => '/products',
        ]);
    }
}