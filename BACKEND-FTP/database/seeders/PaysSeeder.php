<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaysSeeder extends Seeder
{
    public function run(): void
    {
        // On vide la table d'abord pour éviter les doublons si on relance
        DB::table('pays')->delete();

        $pays = [
            ['nom' => 'Cameroun', 'code' => 'CM', 'indicatif' => '237'],
            ['nom' => 'France', 'code' => 'FR', 'indicatif' => '33'],
            ['nom' => 'Belgique', 'code' => 'BE', 'indicatif' => '32'],
            ['nom' => 'Suisse', 'code' => 'CH', 'indicatif' => '41'],
            ['nom' => 'Canada', 'code' => 'CA', 'indicatif' => '1'],
            ['nom' => 'États-Unis', 'code' => 'US', 'indicatif' => '1'],
            ['nom' => 'Sénégal', 'code' => 'SN', 'indicatif' => '221'],
            ['nom' => 'Côte d\'Ivoire', 'code' => 'CI', 'indicatif' => '225'],
            ['nom' => 'Gabon', 'code' => 'GA', 'indicatif' => '241'],
            ['nom' => 'Bénin', 'code' => 'BJ', 'indicatif' => '229'],
            ['nom' => 'Togo', 'code' => 'TG', 'indicatif' => '228'],
        ];

        DB::table('pays')->insert($pays);
    }
}