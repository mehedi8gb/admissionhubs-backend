<?php

namespace Tests\Unit;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class StaffControllerTest extends TestCase
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

        // Test payload for creating a staff member
        $this->payload = [
            'firstName' => 'Barbara',
            'lastName' => 'McLaughlin',
            'email' => 'dddd.hopee@example.net',
            'phone' => '44452',
            'password' => '12345688',
        ];
    }

    #[Test]
    public function it_can_create_a_staff_record()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/staffs', $this->payload);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'firstName',
                    'lastName',
                    'email',
                    'phone',
                    'status',
                ],
            ]);

        // Assert database has the staff record
        $this->assertDatabaseHas('users', [
            'email' => $this->payload['email'],
            'phone' => $this->payload['phone'],
            'status' => 1,
        ]);

        $this->assertDatabaseHas('staffs', [
            'firstName' => $this->payload['firstName'],
            'lastName' => $this->payload['lastName'],
        ]);
    }

    #[Test]
    public function it_can_list_staff_records()
    {
        Staff::factory()->count(10)->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/staffs');

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
                            'firstName',
                            'lastName',
                            'email',
                            'phone',
                            'status',
                        ],
                    ],
                ],
            ]);
    }

    #[Test]
    public function it_can_show_a_staff_record()
    {
        $staff = Staff::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson("/api/staffs/{$staff->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'firstName',
                    'lastName',
                    'email',
                    'phone',
                    'status',
                ],
            ])
            ->assertJsonFragment(['id' => $staff->id]);
    }

    #[Test]
    public function it_can_update_a_staff_record()
    {
        $staff = Staff::factory()->create();

        $updatePayload = [
            'firstName' => 'Updated FirstName',
            'lastName' => 'Updated LastName',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson("/api/staffs/{$staff->id}", $updatePayload);

        $response->assertStatus(200)
            ->assertJsonFragment(['firstName' => 'Updated FirstName']);

        $this->assertDatabaseHas('users', [
            'email' => $staff->user->email,
            'phone' => $staff->user->phone,
        ]);

        $this->assertDatabaseHas('staffs', [
            'firstName' => $updatePayload['firstName'],
            'lastName' => $updatePayload['lastName'],
        ]);
    }

    #[Test]
    public function it_can_delete_a_staff_record()
    {
        $staff = Staff::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->deleteJson("/api/staffs/{$staff->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Record deleted successfully']);

        $this->assertDatabaseMissing('staffs', ['id' => $staff->id]);
    }

    #[Test]
    public function it_can_change_status_of_a_staff_record()
    {
        $staff = Staff::factory()->create();

        $updatePayload = [
            'status' => 0,
        ];

        $updateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson("/api/staffs/{$staff->id}", $updatePayload);

        $updateResponse->assertStatus(200)
            ->assertJson([
                'data' => [
                    'status' => 0,
                ],
            ]);

        $this->assertDatabaseHas('staffs', [
            'id' => $staff->id,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $staff->user->id,
            'status' => 0,
        ]);
    }

    #[Test]
    public function it_can_create_a_staff_and_login()
    {
        // Step 1: Create a staff member using POST /staff
        $createPayload = [
            'firstName' => 'Barbara',
            'lastName' => 'McLaughlin',
            'email' => 'dddd.hopee@example.net',
            'phone' => '44452',
            'password' => '12345688',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/staffs', $createPayload);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id', 'firstName', 'lastName', 'email',
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
    public function it_fails_to_login_when_staff_status_is_false()
    {
        // Step 1: Create a staff member
        $createPayload = [
            'firstName' => 'Barbara',
            'lastName' => 'McLaughlin',
            'email' => 'dddd.hopee@example.net',
            'phone' => '44452',
            'password' => '12345688',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/staffs', $createPayload);

        $response->assertStatus(Response::HTTP_CREATED);

        // Step 2: Update the staff status to false
        $staffId = $response->json('data.id');

        $updatePayload = [
            'status' => 0,
        ];

        $updateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson("/api/staffs/{$staffId}", $updatePayload);

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

    #[Test]
    public function it_fails_to_create_a_staff_record_with_invalid_data()
    {
        $payload = [
            'firstName' => 'Barbara',
            'lastName' => 'McLaughlin',
            'email' => '',
            'phone' => '44452',
            'password' => '12345688',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/staffs', $payload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
