<?php

namespace Tests\Unit;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class StaffControllerTest extends TestCase
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

        // Set up test payload
        $this->payload = [
            'firstName' => 'Barbara',
            'lastName' => 'McLaughlin',
            'email' => 'dddd.hopee@example.net',
            'phone' => '44452',
            'password' => '12345688',
            'status' => 0,
        ];
    }

    /** @test */
    public function it_can_create_a_staff_record()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/staffs', $this->payload);


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
            ]);

        // Assert database has the staff record
        $this->assertDatabaseHas('staffs', [
            'status' => $this->payload['status'],
        ]);

        // Assert user record is created
        $this->assertDatabaseHas('users', [
            'email' => $this->payload['email'],
        ]);
    }

    /** @test */
    public function it_can_list_staff_records()
    {
        Staff::factory()->count(5)->create();

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
                        '*' => [ // Asserts each item in the "result" array
                            'id',
                            'firstName',
                            'lastName',
                            'email',
                            'phone',
                            'role',
                            'status',
                        ],
                    ],
                ],
            ]);

    }

    /** @test */
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

    /** @test */
    public function it_can_update_a_staff_record()
    {
        $staff = Staff::factory()->create();

        $updatePayload = [
            'firstName' => 'UpdatedFirstName',
            'lastName' => 'UpdatedLastName',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson("/api/staffs/{$staff->id}", $updatePayload);

        $response->assertStatus(200)
            ->assertJsonFragment(['firstName' => 'UpdatedFirstName']);

        $this->assertDatabaseHas('staffs', [
            'id' => $staff->id,
            'firstName' => $updatePayload['firstName'],
            'lastName' => $updatePayload['lastName'],
        ]);
    }

    /** @test */
    public function it_can_delete_a_staff_record()
    {
        $staff = Staff::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->deleteJson("/api/staffs/{$staff->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Record deleted successfully']);

        $this->assertDatabaseMissing('staffs', ['id' => $staff->id]);
    }


    // test status is changing
    /** @test */
    public function it_can_change_status_of_a_staff_record()
    {
        $staff = Staff::factory()->create();

        $updatePayload = [
            'status' => 0,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson("/api/staffs/{$staff->id}", $updatePayload);

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 0]);

        $this->assertDatabaseHas('staffs', [
            'id' => $staff->id,
            'status' => 0,
        ]);
    }
}
