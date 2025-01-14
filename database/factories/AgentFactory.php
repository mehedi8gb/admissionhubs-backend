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
            'contactPerson' => $this->faker->name,
            'location' => $this->faker->address,
            'nominatedStaffId' => Staff::factory()->create()->id,
            'organization' => $this->faker->company,
        ];
    }
}
