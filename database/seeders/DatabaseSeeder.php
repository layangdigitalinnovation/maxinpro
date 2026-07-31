<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Area;
use App\Models\Article;
use App\Models\Developer;
use App\Models\Listing;
use App\Models\PartnerBank;
use App\Models\Project;
use App\Models\PropertyType;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * NOTE: all data below is EXAMPLE / PLACEHOLDER content for local development
 * and demoing purposes. Replace with real listings, agents, and photography
 * before going to production.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin MaxinPro',
            'email' => 'admin@maxinpro.com',
            'password' => bcrypt('ChangeThisPassword123!'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        $types = collect(['Rumah', 'Apartemen', 'Ruko / Rukan', 'Tanah'])
            ->map(fn ($name) => PropertyType::create(['name' => $name, 'slug' => Str::slug($name)]));

        $areas = collect([
            ['name' => 'BSD City', 'city' => 'Tangerang Selatan', 'count' => 4200, 'popular' => true],
            ['name' => 'Bintaro', 'city' => 'Tangerang Selatan', 'count' => 3100, 'popular' => true],
            ['name' => 'Alam Sutera', 'city' => 'Tangerang', 'count' => 2600, 'popular' => true],
            ['name' => 'Gading Serpong', 'city' => 'Tangerang', 'count' => 2100, 'popular' => true],
            ['name' => 'Jakarta Selatan', 'city' => 'Jakarta', 'count' => 5400, 'popular' => true],
            ['name' => 'Kelapa Gading', 'city' => 'Jakarta Utara', 'count' => 1800, 'popular' => true],
        ])->map(fn ($a) => Area::create([
            'name' => $a['name'],
            'slug' => Str::slug($a['name']),
            'city' => $a['city'],
            'property_count' => $a['count'],
            'is_popular' => $a['popular'],
            'image_path' => 'areas/' . Str::slug($a['name']) . '.png',
        ]));

        $agents = collect([
            ['name' => 'Dedi Kurniawan', 'email' => 'dedi.agent@maxinpro.com'],
            ['name' => 'Sari Wulandari', 'email' => 'sari.agent@maxinpro.com'],
            ['name' => 'Budi Santoso', 'email' => 'budi.agent@maxinpro.com'],
        ])->map(function ($a) {
            $user = User::create([
                'name' => $a['name'],
                'email' => $a['email'],
                'password' => 'ChangeThisPassword123!',
                'email_verified_at' => now(),
            ]);
            $user->assignRole('agent');

            return Agent::create([
                'user_id' => $user->id,
                'name' => $a['name'],
                'email' => $a['email'],
                'whatsapp' => '6281112345678',
                'is_active' => true,
            ]);
        });

        $developers = collect(['Sinarmas Land', 'Alam Sutera Realty', 'Paramount Land'])
            ->map(fn ($name) => Developer::create(['name' => $name]));

        PartnerBank::insert(
            collect(['BCA', 'Mandiri', 'BRI', 'BNI', 'BTN', 'BSI', 'CIMB Niaga', 'Danamon', 'Maybank', 'OCBC NISP'])
                ->map(fn ($name, $i) => ['name' => $name, 'sort_order' => $i, 'created_at' => now(), 'updated_at' => now()])
                ->toArray()
        );

        $listingsData = [
            ['Rumah Modern Minimalis', 'Terpopuler', 2_100_000_000, 4, 3, 3, 120, 150],
            ['Rumah Siap Huni', 'Baru', 1_800_000_000, 3, 3, 2, 84, 100],
            ['Rumah Mewah 2 Lantai', 'Premium', 3_200_000_000, 5, 4, 4, 200, 240],
            ['Rumah Hook Strategis', 'Terpopuler', 2_400_000_000, 4, 3, 3, 135, 160],
            ['Rumah Nyaman Siap Huni', 'Baru', 1_300_000_000, 3, 3, 2, 72, 90],
            ['Rumah Klasik Dua Lantai', 'Premium', 4_500_000_000, 4, 4, 3, 180, 220],
            ['Rumah Cluster Asri', 'Terpopuler', 1_900_000_000, 3, 3, 2, 96, 110],
            ['Rumah Split Level', 'Baru', 2_900_000_000, 4, 4, 3, 150, 180],
            ['Rumah Taman Pribadi', 'Premium', 5_100_000_000, 5, 5, 4, 240, 280],
        ];

        foreach ($listingsData as $i => $row) {
            [$title, $badge, $price, $car, $bed, $bath, $land, $building] = $row;
            Listing::create([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . ($i + 1),
                'description' => "Contoh deskripsi untuk {$title}. Properti dengan lokasi strategis, akses mudah ke tol dan pusat perbelanjaan.",
                'property_type_id' => $types->first()->id,
                'area_id' => $areas->random()->id,
                'agent_id' => $agents->random()->id,
                'address' => 'Jl. Contoh Alamat No. ' . ($i + 1),
                'price' => $price,
                'land_area' => $land,
                'building_area' => $building,
                'bedrooms' => $bed,
                'bathrooms' => $bath,
                'car_ports' => $car,
                'badge' => $badge,
                'status' => 'active',
                'is_featured' => $i < 6,
                'published_at' => now()->subDays($i),
            ]);
        }

        $projectsData = [
            ['Grand Serpong Residence', 'Launching', 1_500_000_000, 'Sisa 24 unit'],
            ['Alam Sutera Signature Tower', 'Premium', 2_800_000_000, 'Sisa 12 unit'],
            ['Paramount Cluster Aria', 'New Cluster', 1_200_000_000, 'Sisa 40 unit'],
        ];

        foreach ($projectsData as $i => $row) {
            [$name, $status, $priceFrom, $units] = $row;
            Project::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'developer_id' => $developers->random()->id,
                'area_id' => $areas->random()->id,
                'property_type_id' => $types->first()->id,
                'description' => "Contoh deskripsi untuk project {$name}. Dikembangkan oleh developer terpercaya dengan fasilitas lengkap.",
                'status' => $status,
                'price_from' => $priceFrom,
                'units_available' => $units,
                'is_featured' => true,
                'published_at' => now()->subDays($i),
                // Sequential by default — reorder anytime from /admin/projects-order.
                'priority_order' => $i,
            ]);
        }

        Testimonial::insert([
            ['name' => 'Andi Prasetyo', 'city' => 'Tangerang Selatan', 'rating' => 5, 'quote' => 'Proses jual rumah saya di MaxinPro sangat cepat dan transparan.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rina Kartika', 'city' => 'Jakarta Selatan', 'rating' => 5, 'quote' => 'Agennya sangat responsif dan membantu dari awal sampai akad.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fajar Nugroho', 'city' => 'Bintaro', 'rating' => 4, 'quote' => 'Simulasi KPR di website ini memudahkan saya menentukan budget.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        Article::insert([
            [
                'title' => 'Tips Memilih Rumah Pertama di Tangerang',
                'slug' => 'tips-memilih-rumah-pertama-di-tangerang',
                'category' => 'Tips',
                'excerpt' => 'Panduan singkat sebelum membeli rumah pertama Anda.',
                'body' => "Ini adalah contoh isi artikel. Ganti dengan konten asli sebelum production.\n\nPertimbangkan lokasi, akses transportasi, dan legalitas dokumen.",
                'published_at' => now()->subDays(2),
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'title' => 'Simulasi KPR: Yang Perlu Diperhatikan',
                'slug' => 'simulasi-kpr-yang-perlu-diperhatikan',
                'category' => 'KPR',
                'excerpt' => 'Memahami suku bunga dan tenor sebelum mengajukan KPR.',
                'body' => 'Ini adalah contoh isi artikel. Ganti dengan konten asli sebelum production.',
                'published_at' => now()->subDays(5),
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}
