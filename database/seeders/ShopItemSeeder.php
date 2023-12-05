<?php

namespace Database\Seeders;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;

class ShopItemSeeder extends Seeder
{
    const IMAGE_PATH = './shop_items/';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creates the default shop items
        $shopItems = [
            [
                'name' => 'Custom Slide (onbeperkt)',
                'description' => 'Presenteer een eigen gemaakte \'slide\' op NarrowBlast! Gebruik HTML en CSS om een webpagina te maken en upload die naar ons platform. Iedereen die langs de NarrowBlast loopt zal jouw slide zien. Jouw slide wordt eerst gecontroleerd alvorens deze wordt getoond.',
                'image_path' => 'presentation.png',
                'unique_id' => 'slide_indefinite',
                'cost_in_credits' => 0,
            ],
            [
                'name' => 'Custom Slide (14 dagen)',
                'description' => 'Presenteer 14 dagen lang een eigen gemaakte \'slide\' op NarrowBlast! Gebruik HTML en CSS om een webpagina te maken en upload die naar ons platform. Iedereen die langs de NarrowBlast loopt zal jouw slide zien. Jouw slide wordt eerst gecontroleerd alvorens deze wordt getoond.',
                'image_path' => 'presentation.png',
                'unique_id' => 'slide_14d',
                'cost_in_credits' => 115,
            ],
            [
                'name' => 'Custom Slide (7 dagen)',
                'description' => 'Presenteer 7 dagen lang een eigen gemaakte \'slide\' op NarrowBlast! Gebruik HTML en CSS om een webpagina te maken en upload die naar ons platform. Iedereen die langs de NarrowBlast loopt zal jouw slide zien. Jouw slide wordt eerst gecontroleerd alvorens deze wordt getoond.',
                'image_path' => 'presentation.png',
                'unique_id' => 'slide_7d',
                'cost_in_credits' => 75,
            ],
            [
                'name' => 'Custom Slide (1 dagen)',
                'description' => 'Presenteer 1 dag lang een eigen gemaakte \'slide\' op NarrowBlast! Gebruik HTML en CSS om een webpagina te maken en upload die naar ons platform. Iedereen die langs de NarrowBlast loopt zal jouw slide zien. Jouw slide wordt eerst gecontroleerd alvorens deze wordt getoond.',
                'image_path' => 'presentation.png',
                'unique_id' => 'slide_1d',
                'cost_in_credits' => 15,
            ],
            [
                'name' => 'Javascript Slide Power-up',
                'description' => 'Kies één slide die je hebt gemaakt en activeer er Javascript voor. Waar normaal gesproken de slides alleen HTML en CSS ondersteunen, wordt op de slide naar jouw keuze ook Javascript geactiveerd, zodat je deze interactief kunt maken. Dit werkt voor maar één slide, daarna moet je deze power-up opnieuw kopen.',
                'image_path' => 'animated.png',
                'unique_id' => 'slide_powerup_js',
                'cost_in_credits' => 50,
            ],
            [
                'name' => 'Slide Invite Systeem (incl. Javascript Power-up)',
                'description' => 'Kies één slide die je hebt gemaakt en activeer er een uitnodigingssysteem voor. Doormiddel van Javascript (inbegrepen) kun je een uitnodigingscode aanvragen en die op het scherm tonen. Spelers kunnen zich dan in jouw slide registeren na het betalen van een door jou ingestelde inzet. Hiermee kun je bijvoorbeeld een quiz maken, of weddenschap spel. Dit werkt maar voor één slide, dus zorg dat je die goed getest hebt. Je kunt dit product wel vaker kopen om het op meerdere slides te gebruiken.',
                'image_path' => 'betting.png',
                'unique_id' => 'slide_invite_system',
                'cost_in_credits' => 5000,
                'required_type' => 'teacher', // Disabled since this is a work in progress (still needs testing, and cleaning up of the UX/UI)
            ],
        ];

        foreach ($shopItems as $shopItem) {
            // Copy the image
              $shopItem['image_path'] = Storage::disk(\App\Models\ShopItem::STORAGE_DISK)
                    ->putFile(
                        \App\Models\ShopItem::FILE_DIRECTORY,
                        new File(realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . self::IMAGE_PATH . DIRECTORY_SEPARATOR . $shopItem['image_path'])
                    );

            \App\Models\ShopItem::create($shopItem);
        }
    }
}
