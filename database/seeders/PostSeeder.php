<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'type' => 'lost',
                'category' => 'Wallet',
                'city' => 'Casablanca',
                'location_text' => 'Near Central Market',
                'description' => 'Black leather wallet with student card inside.',
                'whatsapp' => '+212600111222',
                'phone' => '0522001122',
                'status' => 'active',
            ],
            [
                'type' => 'lost',
                'category' => 'Phone',
                'city' => 'Rabat',
                'location_text' => 'Tramway Station Agdal',
                'description' => 'Blue Samsung phone lost on the platform.',
                'whatsapp' => '+212600333444',
                'phone' => null,
                'status' => 'active',
            ],
            [
                'type' => 'lost',
                'category' => 'Document',
                'city' => 'Marrakesh',
                'location_text' => 'Jemaa el-Fnaa entrance',
                'description' => 'Green folder with business papers and receipts.',
                'whatsapp' => '+212600555666',
                'phone' => '0531009988',
                'status' => 'active',
            ],
            [
                'type' => 'found',
                'category' => 'CIN',
                'city' => 'Agadir',
                'location_text' => 'Near beach promenade',
                'description' => 'National ID card found near the benches.',
                'whatsapp' => '+212601000111',
                'phone' => null,
                'status' => 'active',
            ],
            [
                'type' => 'found',
                'category' => 'Phone',
                'city' => 'Tangier',
                'location_text' => 'Bus station',
                'description' => 'iPhone with a cracked screen, picked up at the gate.',
                'whatsapp' => '+212601222333',
                'phone' => '0529001122',
                'status' => 'active',
            ],
            [
                'type' => 'found',
                'category' => 'Other',
                'city' => 'Fes',
                'location_text' => 'Old Medina parking',
                'description' => 'Set of keys with a red keychain.',
                'whatsapp' => '+212601444555',
                'phone' => null,
                'status' => 'active',
            ],
        ];

        Post::insert($posts);
    }
}
