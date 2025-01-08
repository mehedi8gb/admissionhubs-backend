<?php

namespace Database\Factories;

use App\Models\Agent;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AgentFactory extends Factory
{
    protected $model = Agent::class;

    public function definition(): array
    {
        $user = User::factory()->create();
        $user->assignRole('agent');

        return [
            'user_id' => $user->id,
            'agent_name' => $this->faker->name,
            'contact_person' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'location' => $this->faker->address,
            'nominated_staff' => Staff::factory()->create()->id,
            'organization' => $this->faker->company,
            'phone' => $this->faker->unique()->phoneNumber,
            'password' => Hash::make('password'), // Default password
            'status' => $this->faker->boolean(),
        ];
    }
}
