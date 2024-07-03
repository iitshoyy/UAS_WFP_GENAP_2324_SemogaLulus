<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Hotel;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Reservasi;
use App\Models\Transaction;
use App\Models\Type;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'pelanggan'
        ]);
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'role' => 'pelanggan'
            ]);
        }

        Type::create(['name' => 'Luxury']);
        Type::create(['name' => 'Budget']);
        Type::create(['name' => 'Business']);

        Hotel::create([
            'name' => 'Grand Hotel',
            'address' => '123 Main Street',
            'phone' => '123-456-7890',
            'email' => 'info@grandhotel.com',
            'rating' => 5,
            'type_id' => 1,
        ]);
        Hotel::create([
            'name' => 'Budget Inn',
            'address' => '456 Side Street',
            'phone' => '987-654-3210',
            'email' => 'info@budgetinn.com',
            'rating' => 3,
            'type_id' => 2,
        ]);

        ProductType::create(['name' => 'Room']);
        ProductType::create(['name' => 'Suite']);
        ProductType::create(['name' => 'Facility']);

        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'name' => 'Room Test ' . $i,
                'price' => (mt_rand(100,500)*1000).'',
                'nama_fasilitas' => 'Free WiFi',
                'deskripsi_fasilitas' => 'High-speed internet access',
                'hotel_id' => 1,
                'product_type_id' => 1,
            ]);
        }
        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'name' => 'Suite Test ' . $i,
                'price' => (mt_rand(100,500)*1000).'',
                'nama_fasilitas' => 'Free WiFi',
                'deskripsi_fasilitas' => 'High-speed internet access',
                'hotel_id' => 2,
                'product_type_id' => 2,
            ]);
        }

        for ($i = 0; $i < 8; $i++) {
            Transaction::create([
                'price' => '150',
                'invoice' => 'INV-12345',
                'total_price' => (mt_rand(100,500)*1000).'',
            ]);
        }

        for ($i = 0; $i < 20; $i++) {
            Reservasi::create([
                'user_id' => rand(1, 10),
                'product_id' => rand(1, 20),
                'transaction_id' => rand(1, 8),
                'keterangan' => 'This is a test reservation'.$i,
                'tanggal_jam' => now(),
            ]);
        }
    }
}
