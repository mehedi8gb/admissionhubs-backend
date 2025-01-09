<?php

namespace Tests\Unit;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AgentControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private $token;
    private array $payload;

    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);

        $this->user = User::factory()->create();
        $this->user->assignRole('admin');
        $this->token = JWTAuth::fromUser($this->user);

        // Test payload for creating an agent
        $this->payload = [
            'agentName' => 'John Doe',
            'organization' => 'XYZ Organization',
            'contactPerson' => 'Jane Smith',
            'phone' => '+2 (555)',
            'email' => 'hhjjkk@example.com',
            'location' => '123 Main St, Cityville, NY 10001',
            'password' => '12345678',
            'status' => true,
        ];
    }

    /** @test */
    public function it_can_create_an_agent_record()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/agents', $this->payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'agentName',
                    'contactPerson',
                    'email',
                    'location',
                    'organization',
                    'phone',
                    'nominatedStaff',
                    'status',
                ],
            ]);

        // Assert database has the agent record
        $this->assertDatabaseHas('agents', [
            'agentName' => $this->payload['agentName'],
            'organization' => $this->payload['organization'],
            'email' => $this->payload['email'],
        ]);
    }

    /** @test */
    public function it_can_list_agent_records()
    {
        Agent::factory()->count(10)->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/agents');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'meta' => [
                        'page',
                        'limit',
                        'total',
                        'totalPage',
                    ],
                    'result' => [
                        '*' => [
                            'id',
                            'agentName',
                            'contactPerson',
                            'email',
                            'location',
                            'organization',
                            'phone',
                            'nominatedStaff',
                            'status',
                        ],
                    ],
                ],
            ]);
    }

    /** @test */
    public function it_can_show_an_agent_record()
    {
        $agent = Agent::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson("/api/agents/{$agent->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'agentName',
                    'contactPerson',
                    'email',
                    'location',
                    'organization',
                    'phone',
                    'nominatedStaff',
                    'status',
                ],
            ])
            ->assertJsonFragment(['id' => $agent->id]);
    }

    /** @test */
    public function it_can_update_an_agent_record()
    {
        $agent = Agent::factory()->create();

        $updatePayload = [
            'agentName' => 'Updated Agent Name',
            'organization' => 'Updated Organization',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson("/api/agents/{$agent->id}", $updatePayload);

        $response->assertStatus(200)
            ->assertJsonFragment(['agentName' => 'Updated Agent Name']);

        $this->assertDatabaseHas('agents', [
            'id' => $agent->id,
            'agentName' => $updatePayload['agentName'],
            'organization' => $updatePayload['organization'],
        ]);
    }

    /** @test */
    public function it_can_delete_an_agent_record()
    {
        $agent = Agent::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->deleteJson("/api/agents/{$agent->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Record deleted successfully']);

        $this->assertDatabaseMissing('agents', ['id' => $agent->id]);
    }

    /** @test */
    public function it_can_change_status_of_an_agent_record()
    {
        $agent = Agent::factory()->create(['status' => true]);

        $updatePayload = ['status' => false];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson("/api/agents/{$agent->id}", $updatePayload);

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 0]);

        $this->assertDatabaseHas('agents', [
            'id' => $agent->id,
            'status' => 0,
        ]);
    }
}
