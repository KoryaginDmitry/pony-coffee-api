<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        Message::factory()->create(
            [
                'text' => 'Все супер',
                'user_id' => 3,
                'feedback_id' => 1
            ]
        );
    }
}
