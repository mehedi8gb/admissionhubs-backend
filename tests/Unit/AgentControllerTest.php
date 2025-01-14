<?php

namespace Tests\Unit;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AgentControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private string $token;
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

    #[Test] public function it_can_create_an_agent_record()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/agents', $this->payload);

        $response->assertStatus(Response::HTTP_CREATED)
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
        $this->assertDatabaseHas('users', [
            'name' => $this->payload['agentName'],
            'email' => $this->payload['email'],
        ]);

        $this->assertDatabaseHas('agents', [
            'organization' => $this->payload['organization'],
            'contactPerson' => $this->payload['contactPerson'],
        ]);
    }

    #[Test] public function it_can_list_agent_records()
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

    #[Test] public function it_can_show_an_agent_record()
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

    #[Test] public function it_can_update_an_agent_record()
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

        $this->assertDatabaseHas('users', [
            'name' => $updatePayload['agentName'],
            'email' => $agent->user->email,
            'phone' => $agent->user->phone,
        ]);

        $this->assertDatabaseHas('agents', [
            'organization' => $updatePayload['organization'],
            'contactPerson' => $agent->contactPerson,
        ]);
    }

    #[Test] public function it_can_delete_an_agent_record()
    {
        $agent = Agent::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->deleteJson("/api/agents/{$agent->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Record deleted successfully']);

        $this->assertDatabaseMissing('agents', ['id' => $agent->id]);
    }

    #[Test] public function it_can_change_status_of_an_agent_record()
    {
        $agent = Agent::factory()->create();

        $updatePayload = [
            'status' => 0,
        ];

        $updateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson("/api/agents/{$agent->id}", $updatePayload);

        $updateResponse->assertStatus(200)
            ->assertJson([
                'data' => [
                    'status' => 0,
                ],
            ]);

        $this->assertDatabaseHas('agents', [
            'id' => $agent->id,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $agent->user->id,
            'status' => 0,
        ]);
    }

    #[Test]
    public function it_can_create_an_agent_and_login()
    {
        // Step 1: Create an agent using POST /agents
        $createPayload = [
            'agentName' => 'John Doe',
            'organization' => 'XYZ Organization',
            'contactPerson' => 'Jane Smith',
            'phone' => '+2 (4544)',
            'email' => 'ag@demo.com',
            'location' => '123 Main St, Cityville, NY 10001',
            'password' => '12345678',
            'status' => 1,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/agents', $createPayload);


        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id', 'agentName', 'email',
                ],
            ]);

        // Step 2: Extract email and login
        $loginPayload = [
            'email' => $createPayload['email'],
            'password' => $createPayload['password'],
        ];

        $loginResponse = $this->postJson('/api/auth/login', $loginPayload);

        $loginResponse->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'access_token',
                ],
            ]);
    }

    #[Test]
    public function it_fails_to_login_when_agent_status_is_false()
    {
        // Step 1: Create an agent
        $createPayload = [
            'agentName' => 'John Doe',
            'organization' => 'XYZ Organization',
            'contactPerson' => 'Jane Smith',
            'phone' => '+2 (4544)',
            'email' => 'ag@demo.com',
            'location' => '123 Main St, Cityville, NY 10001',
            'password' => '12345678',
            'status' => 1,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/agents', $createPayload);

        $response->assertStatus(Response::HTTP_CREATED);

        // Step 2: Update the agent status to false
        $agentId = $response->json('data.id');

        $updatePayload = [
            'status' => 0,
        ];

        $updateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson("/api/agents/{$agentId}", $updatePayload);

        $updateResponse->assertStatus(200)
            ->assertJson([
                'data' => [
                    'status' => 0,
                ],
            ]);

        $loginPayload = [
            'email' => $createPayload['email'],
            'password' => $createPayload['password'],
        ];

        $loginResponse = $this->postJson('/api/auth/login', $loginPayload);


        $loginResponse->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Your account is inactive',
            ]);
    }
}
