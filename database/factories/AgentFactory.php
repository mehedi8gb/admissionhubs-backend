<?php

namespace Database\Factories;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgentFactory extends Factory
{
    protected $model = Agent::class;

    public function definition(): array
    {
        $user = User::factory()->create();
        $user->assignRole('agent');

        return [
            'user_id' => $user->id,
            'organization' => $this->faker->company(),
            'contact_person' => $this->faker->name(),
            'location' => $this->faker->address(),
            'status' => $this->faker->boolean(),
        ];
    }
}
