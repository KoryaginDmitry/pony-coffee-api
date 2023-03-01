<?php

namespace Database\Seeders;

use App\Models\Feedback;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        Feedback::factory()->create(
            [
                'grade' => '4',
                'user_id' => 3,
                'coffee_pot_id' => 2
            ]
        );
    }
}
