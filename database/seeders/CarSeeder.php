<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Car;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * 
     */
    public function run()
    {
        Car::create(['brand' => 'Ford', 'model' => 'Focus','plaka' => '46kp511', 'owner' => 'Ahmet Çilekçi', 'user_id' => '1' ]);
        Car::create(['brand' => 'Toyota', 'model' => 'Corolla','plaka' => '34lfe74', 'owner' => 'Dilek Uyurgezer', 'user_id' => '2' ]);
        Car::create(['brand' => 'Hyundai', 'model' => 'Accent','plaka' => '27att58', 'owner' => 'Ahsen Subaşı', 'user_id' => '3' ]);
        Car::create(['brand' => 'Fiat', 'model' => 'Egea','plaka' => '80dlc24', 'owner' => 'Süleyman Çakır', 'user_id' => '4' ]);
        Car::create(['brand' => 'Fiat', 'model' => 'Linea','plaka' => '01ap257', 'owner' => 'Polat Alemdar', 'user_id' => '5' ]);
        Car::create(['brand' => 'Citren', 'model' => 'Berlingo','plaka' => '33ay184', 'owner' => 'Burak Kılınç', 'user_id' => '6' ]);

    }
} 
