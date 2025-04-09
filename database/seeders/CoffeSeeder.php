<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CoffeSeeder extends Seeder
{
    public function run()
    {
        $coffes = [
            [
                'name' => 'Qinthara Coffee & Resto',
                'description' => 'Tempat nongkrong cozy dengan nuansa kekinian.',
                'category' => 'Modern',
                'address' => 'Jl. RE Martadinata No.28, Ciporang, Kec. Kuningan, Jawa Barat 45514',
                'contact' => '08122332451',
                'opened' => '11:00:00',
                'closed' => '23:00:00',
                'image' => 'qinthara_coffee.jpg',
                'longtitude' => 108.4725,
                'latitude' => '-6.9756',
                'menus' => 'Espresso,Latte,Cappuccino,Nasi Goreng,Sandwich',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Otaku Coffee & Roastery',
                'description' => 'Mengusung konsep ala Jepang dengan suasana tenang dan nyaman.',
                'category' => 'Thematic',
                'address' => 'Jl. Ciporang, Kuningan, Jawa Barat',
                'contact' => '',
                'opened' => '10:00:00',
                'closed' => '22:00:00',
                'image' => 'otaku_coffee.jpg',
                'longtitude' => 108.4850,
                'latitude' => '-6.9800',
                'menus' => 'Matcha Latte,Japanese Cheesecake,Cold Brew',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Joglo Arunika',
                'description' => 'Terletak di perbukitan dengan panorama alam yang asri.',
                'category' => 'Traditional',
                'address' => 'Kuningan, Jawa Barat',
                'contact' => '',
                'opened' => '09:00:00',
                'closed' => '21:00:00',
                'image' => 'joglo_arunika.jpg',
                'longtitude' => 108.5000,
                'latitude' => '-6.9900',
                'menus' => 'Kopi Tubruk,Pisang Goreng,Teh Jahe',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hulday Coffee Eatery',
                'description' => 'Kafe outdoor di tengah hutan pinus dengan spot foto.',
                'category' => 'Outdoor',
                'address' => 'Bumi Perkemahan Trijaya, Mandirancan, Kuningan',
                'contact' => '',
                'opened' => '08:00:00',
                'closed' => '20:00:00',
                'image' => 'hulday_coffee.jpg',
                'longtitude' => 108.5600,
                'latitude' => '-7.0000',
                'menus' => 'Manual Brew,Croissant,Herbal Tea',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Waja Kopi',
                'description' => 'Menyajikan kopi warisan Nusantara dengan cita rasa khas.',
                'category' => 'Vintage',
                'address' => 'Kuningan, Jawa Barat',
                'contact' => '',
                'opened' => '10:00:00',
                'closed' => '22:00:00',
                'image' => 'waja_kopi.jpg',
                'longtitude' => 108.4900,
                'latitude' => '-6.9850',
                'menus' => 'Kopi Luwak,Kopi Tubruk,Kue Tradisional',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kedai Kopi Ruang Tunggu',
                'description' => 'Tempat nyaman untuk menunggu sambil ngopi.',
                'category' => 'Minimalist',
                'address' => 'Kuningan, Jawa Barat',
                'contact' => '',
                'opened' => '09:00:00',
                'closed' => '22:00:00',
                'image' => 'ruang_tunggu.jpg',
                'longtitude' => 108.4950,
                'latitude' => '-6.9875',
                'menus' => 'Americano,Cappuccino,Muffin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('coffes')->insert($coffes);
    }
}
