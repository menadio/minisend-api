<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => 'failed'],
            ['name' => 'posted'],
            ['name' => 'sent']
        ];

        foreach ($statuses as $status) {
            Status::updateOrInsert(
                ['name' => $status['name']],
                ['name' => $status['name'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
