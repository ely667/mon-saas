<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class KoshopProductsSeeder extends Seeder
{
    public function run(): void
    {
        $shop = Shop::where('slug', 'koshop')->firstOrFail();

        $products = [
            [
                'name' => 'Casque Bluetooth Pro',
                'slug' => 'casque-bluetooth-pro',
                'description' => 'Casque sans fil avec réduction de bruit active et autonomie de 40 heures.',
                'price' => 45000,
                'stock' => 12,
                'image_path' => 'products/casque.jpg',
            ],
            [
                'name' => 'Powerbank 20000mAh',
                'slug' => 'powerbank-20000mah',
                'description' => 'Batterie externe haute capacité avec charge rapide USB-C.',
                'price' => 18500,
                'stock' => 25,
                'image_path' => 'products/powerbank.jpg',
            ],
            [
                'name' => 'Enceinte portable',
                'slug' => 'enceinte-portable',
                'description' => 'Enceinte étanche IPX7, son 360° et 12 heures d\'autonomie.',
                'price' => 32000,
                'stock' => 0,
                'image_path' => 'products/enceinte.jpg',
            ],
            [
                'name' => 'Chargeur sans fil 15W',
                'slug' => 'chargeur-sans-fil-15w',
                'description' => 'Pad de charge rapide compatible Qi pour smartphone et écouteurs.',
                'price' => 8900,
                'stock' => 30,
                'image_path' => 'products/chargeur.jpg',
            ],
            [
                'name' => 'Caméra sport 4K',
                'slug' => 'camera-sport-4k',
                'description' => 'Caméra compacte étanche avec stabilisation et accessoires inclus.',
                'price' => 89000,
                'stock' => 5,
                'image_path' => 'products/camera.jpg',
            ],
            [
                'name' => 'Clavier mécanique RGB',
                'slug' => 'clavier-mecanique-rgb',
                'description' => 'Clavier gaming avec switches Blue, rétroéclairage RGB et repose-poignets.',
                'price' => 27500,
                'stock' => 0,
                'image_path' => 'products/clavier.jpg',
            ],
        ];

        foreach ($products as $data) {
            Product::updateOrCreate(
                ['shop_id' => $shop->id, 'slug' => $data['slug']],
                [...$data, 'shop_id' => $shop->id, 'is_active' => true]
            );
        }

        $this->command->info("6 produits de test ajoutés pour la boutique \"{$shop->name}\".");
    }
}
