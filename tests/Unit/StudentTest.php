<?php

namespace Tests\Unit;

use App\Models\Student;
use App\Models\User;
use App\Services\NestedRelationService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class StudentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $user;
    private string $token;
    private array $payload;


// Set up the test environment.
    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
        Artisan::call('db:seed', ['--class' => 'UsersSeeder']);
        Artisan::call('db:seed', ['--class' => 'AgentSeeder']);
        Artisan::call('db:seed', ['--class' => 'InstituteSeeder']);
        Artisan::call('db:seed', ['--class' => 'AcademicYearSeeder']);
        Artisan::call('db:seed', ['--class' => 'TermSeeder']);

        $this->user = User::factory()->create();
        $this->user->assignRole('admin');
        $this->token = JWTAuth::fromUser($this->user);

        $this->payload = [
            'title' => 'Mr.',
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'dd@example.com',
            'phone' => '1234567890',
            'dob' => '01-01-1990',
            'maritualStatus' => 'Single',
            'gender' => 'Male',
            'nationality' => 'Bangladeshi',
            'countryResidence' => 'Bangladesh',
            'countryBirth' => 'Bangladesh',
            'nativeLanguage' => 'Bengali',
            'addressLine1' => 'dd',
            'addressLine2' => 'dd',
            'townCity' => 'Dhaka',
            'state' => 'Dhaka',
            'postCode' => '1205',
            'country' => 'Bangladesh',
            'disabilities' => 'None',
            'ethnicity' => 'Asian',
            'genderIdentity' => 'Male',
            'sexualOrientation' => 'Heterosexual',
            'religion' => 'Islam',
        ];
    }

    /**
     * Test for storing a student.
     *
     * @return void
     */
    public function testStoreStudent()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/students', $this->payload);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'success' => true,
            'message' => 'Student created successfully',
        ]);

        $this->assertDatabaseHas('students', [
            'id' => $response['data']['id'],
            'name' => 'John Doe',
            'email' => $this->payload['email'],
            'phone' => $this->payload['phone'],
        ]);
    }

    /**
     * Test for updating a student.
     *
     * @return void
     */
    public function testUpdateStudent()
    {
        $student = Student::factory()->create();
        $updatedData = [
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => 'jane.doe@example.com',
            'phone' => '0987654321',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson("/api/students/{$student->id}", $updatedData);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'success' => true,
            'message' => 'Student updated successfully',
        ]);

        $student->refresh();
        $this->assertEquals('Jane', $student->name);
        $this->assertEquals('jane.doe@example.com', $student->email);
    }

    /**
     * Test for creating student with nested array data.
     *
     * @return void
     */
    public function testCreateStudentWithNestedData()
    {
        $student = Student::factory()->create();
        $updatedData = [
            'applications' => [
                "institution" => "DDD PLC",
                "course" => "esse",
                "term" => "Spring",
                "type" => "Full-time",
                "amount" => "37243.86",
                "status" => "Submitted"
            ],
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson("/api/students/{$student->id}", $updatedData);

        dd($response->getContent());
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'success' => true,
            'message' => 'application was created successfully',
        ]);
    }

    /**
     * Test for retrieving a student's details.
     *
     * @return void
     */
    public function testShowStudent()
    {
        $student = Student::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson("/api/students/{$student->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'success' => true,
            'message' => 'Student details retrieved successfully',
        ]);
    }

    /**
     * Test for deleting a student.
     *
     * @return void
     */
    public function testDeleteStudent()
    {
        $student = Student::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->deleteJson("/api/students/{$student->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'success' => true,
            'message' => 'Student deleted successfully',
        ]);

        $this->assertNull(Student::find($student->id));
    }

    /**
     * Test for deleting student relations (nested data).
     *
     * @return void
     */
    public function testDeleteStudentRelations()
    {
        $student = Student::factory()->create();
        $application = $student->applications()->create([
            'status' => 'Pending',
            'student_id' => $student->id,
        ]);

        $this->payload = [
            'applications' => [
                ['id' => $application->id],
            ],
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->deleteJson("/api/students/{$student->id}", $this->payload);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'success' => true,
            'message' => 'Applications was deleted successfully',
        ]);

        $this->assertNull($application->fresh());
    }

    /**
     * Test for an empty students list.
     *
     * @return void
     */
    public function testNoStudentsFound()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/students');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson([
            'success' => false,
            'message' => 'No students found',
        ]);
    }

    /**
     * Test for handling student data validation failure.
     *
     * @return void
     */
    public function testStoreStudentValidationFailure()
    {
        $this->payload = [
            'firstName' => '',
            'lastName' => '',
            'email' => 'invalidemail',
            'phone' => '123',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/students', $this->payload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['firstName', 'lastName', 'email', 'phone']);
    }
}
