<?php

namespace Tests\Unit;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class StudentTest extends TestCase
{
    use RefreshDatabase;
    private User $user;
    private $token;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the student role and user only once
        Role::create(['name' => 'student', 'guard_name' => 'web']);
        $this->user = User::factory()->create();
        $this->user->assignRole('student');
        $this->token = JWTAuth::fromUser($this->user);
    }

    private function studentData($overrides = []): array
    {
        $defaultData = [
            'title' => 'Mr.',
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
            'dob' => '01-01-1990',
            'maritualStatus' => 'Single',
            'gender' => 'Male',
            'nationality' => 'Bangladeshi',
            'countryResidence' => 'Bangladesh',
            'countryBirth' => 'Bangladesh',
            'nativeLanguage' => 'Bengali',
            'passportName' => 'John Doe',
            'passportIssueLocation' => 'Dhaka',
            'passportNumber' => 'A12345678',
            'passportIssueDate' => '01-01-2015',
            'passportExpiryDate' => '01-01-2025',
            'addressLine1' => '123 Main Street',
            'addressLine2' => 'Apt 4B',
            'townCity' => 'Dhaka',
            'state' => 'Dhaka',
            'postCode' => '1205',
            'country' => 'Bangladesh',
            'disabilities' => 'None',
            'ethnicity' => 'Asian',
            'genderidentity' => 'Male',
            'sexualOrientation' => 'Heterosexual',
            'religion' => 'Islam',
            'emergencyContact' => [
                [
                    'name' => 'Jane Doe',
                    'phone' => '9876543210',
                    'email' => 'jane.doe@example.com',
                    'address' => '456 Elm Street, Dhaka',
                    'relationship' => 'Spouse',
                    'status' => 'Active',
                ],
            ],
            'travelHistory' => [
                [
                    'purpose' => 'Study',
                    'arrival' => '01-01-2020',
                    'departure' => '01-01-2021',
                    'visaStart' => '01-01-2020',
                    'visaExpiry' => '01-01-2021',
                    'visaType' => 'Student Visa',
                ],
            ],
            'visaNeed' => true,
            'refuseHistory' => [
                [
                    'refusaltype' => 'Visa Refusal',
                    'refusalDate' => '01-01-2018',
                    'details' => 'Insufficient funds',
                    'country' => 'USA',
                    'visaType' => 'Tourist Visa',
                    'status' => 'Resolved',
                ],
            ],
            'academicHistory' => [
                [
                    'institution' => 'Dhaka University',
                    'course' => 'Computer Science',
                    'studylevel' => 'Undergraduate',
                    'resultScore' => 3.8,
                    'outof' => 4.0,
                    'startDate' => '01-01-2010',
                    'endDate' => '01-01-2014',
                    'status' => 'Completed',
                ],
            ],
            'workDetails' => [
                [
                    'jobtitle' => 'Software Engineer',
                    'organization' => 'ABC Ltd.',
                    'address' => '789 Maple Street, Dhaka',
                    'phone' => '1122334455',
                    'fromDate' => '01-01-2015',
                    'toDate' => '01-01-2020',
                    'active' => true,
                    'currentlyWorking' => false,
                ],
            ],
            'documents' => [
                'passport' => 'document-passport.pdf',
                'bankstatement' => 'document-bankstatement.pdf',
                'qualification' => 'document-qualification.pdf',
                'workExperience' => 'document-workexperience.pdf',
                'cv' => 'document-cv.pdf',
            ],
            'application' => [
                [
                    'institution' => 'Dhaka University',
                    'course' => 'Computer Science',
                    'term' => 'Fall 2024',
                    'type' => 'Full-time',
                    'amount' => 50000,
                    'status' => 'Submitted',
                ],
            ],
            'assignStaff' => [
                [
                    'staffid' => 1,
                    'type' => 'Counselor',
                ],
            ],
        ];

        return array_merge($defaultData, $overrides);
    }

    public function test_can_store_student_with_valid_data()
    {
        // Send request to store student with valid data
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/students', $this->studentData());

        $response->assertStatus(200);
        $response->assertJsonFragment(['firstName' => 'John', 'email' => 'john.doe@example.com']);

        $student = Student::latest()->first();
        $this->assertEquals('John', $student->student_data['firstName']);
    }

    public function test_can_update_student_with_partial_data()
    {
        // Step 2: Create a student with initial data using the provided structure
        $student = Student::factory()->create([
            'created_by' => User::factory()->create()->id,
            'student_data' => $this->studentData()
        ]);

        // Step 3: Define the update payload
        $updateData = [
            'firstName' => 'Updated John', // Updated field
            'addressLine1' => '456 New Main Street', // Updated field
            'emergencyContact' => [
                [
                    'name' => 'Updated Jane Doe', // Updated emergency contact
                    'phone' => '9999999999', // Updated phone number
                ]
            ],
            'visaNeed' => false, // Updated field
            'academicHistory' => [
                [
                    'institution' => 'Dhaka Polytechnic', // Updated academic history
                    'course' => 'Information Technology',
                    'studylevel' => 'Diploma',
                    'startDate' => '01-01-2015',
                    'endDate' => '01-01-2017',
                    'status' => 'Completed'
                ]
            ],
            // Other fields like 'genderidentity', 'religion' will remain unchanged
        ];

        // Step 4: Send PUT request with JWT authorization
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson("/api/students/{$student->id}", $updateData);

        // Step 5: Assertions for response status
        $response->assertStatus(200);

        // Step 6: Reload the student data from the database
        $updatedStudent = Student::find($student->id);

        // Step 7: Assertions for updated fields
        $this->assertEquals('Updated John', $updatedStudent->student_data['firstName']); // Updated
        $this->assertEquals('456 New Main Street', $updatedStudent->student_data['addressLine1']); // Updated
        $this->assertEquals('Updated Jane Doe', $updatedStudent->student_data['emergencyContact'][0]['name']); // Updated
        $this->assertEquals('9999999999', $updatedStudent->student_data['emergencyContact'][0]['phone']); // Updated
        $this->assertFalse($updatedStudent->student_data['visaNeed']); // Updated
        $this->assertEquals('Dhaka Polytechnic', $updatedStudent->student_data['academicHistory'][0]['institution']); // Updated
        $this->assertEquals('Information Technology', $updatedStudent->student_data['academicHistory'][0]['course']); // Updated

        // Step 8: Assertions for unchanged fields
        $this->assertEquals('Single', $updatedStudent->student_data['maritualStatus']); // Unchanged
        $this->assertEquals('Male', $updatedStudent->student_data['gender']); // Unchanged
        $this->assertEquals('Bangladeshi', $updatedStudent->student_data['nationality']); // Unchanged
    }

    public function test_can_delete_student()
    {
        // Create a student record to delete
        $student = Student::factory()->create([
            'student_data' => $this->studentData()
        ]);

        // Send DELETE request to remove the student
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->deleteJson("/api/students/{$student->id}");

        // Assert response status is 200
        $response->assertStatus(200);

        // Assert the student is deleted from the database
        $this->assertNull(Student::find($student->id));
    }

    public function test_can_show_student_details()
    {
        // Create a student record
        $student = Student::factory()->create([
            'student_data' => $this->studentData()
        ]);

        // Send GET request to fetch student details
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson("/api/students/{$student->id}");

        // Assert response status is 200
        $response->assertStatus(200);

        // Assert the correct student data is returned
        $response->assertJsonFragment(['firstName' => 'John', 'email' => 'john.doe@example.com']);
    }

    public function test_can_list_all_students()
    {
        // Create multiple student records
        Student::factory()->create([
            'student_data' => $this->studentData(['firstName' => 'John', 'email' => 'john.doe@example.com'])
        ]);
        Student::factory()->create([
            'student_data' => $this->studentData(['firstName' => 'Jane', 'email' => 'jane@example.com'])
        ]);

        // Send GET request to fetch all students
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/students');

        // Assert response status is 200
        $response->assertStatus(200);

        // Assert the correct students are returned
        $response->assertJsonFragment(['firstName' => 'John', 'email' => 'john.doe@example.com']);
        $response->assertJsonFragment(['firstName' => 'Jane', 'email' => 'jane.doe@example.com']);
    }

    public function test_can_store_student_with_valid_data_and_auto_generated_ref_id()
    {
        $data = $this->studentData(); // No need to pass 'ref_id' since it's auto-generated
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/students', $data);

        $response->assertStatus(200);

        // Assert that the response contains the auto-generated ref_id
        $response->assertJsonFragment(['refId' => 'STD00001']);

        // Retrieve the most recently created student from the database
        $student = Student::latest()->first();

        // Check if the auto-generated ref_id matches the format and is correct
        $this->assertMatchesRegularExpression('/^STD\d{5}$/', $student->ref_id);

        // Optionally, assert that the student's ref_id is correctly generated
        $this->assertEquals(sprintf('STD%05d', $student->id), $student->ref_id);
    }


    public function test_cannot_store_student_without_required_fields()
    {
        $data = $this->studentData(['email' => null]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/students', $data);

        $response->assertStatus(422);
        // Assert the JSON structure contains success: false and the appropriate message
        $response->assertJson([
            'success' => false,
            'message' => 'The email field is required.',
        ]);
    }


    public function test_can_update_student_status_without_changing_other_data()
    {
        // Create a student with valid data
        $student = Student::factory()->create([
            'status' => true, // Initially, the status is set to true
        ]);

        // Prepare the updated data, only changing the 'status' field
        $updatedData = ['status' => false]; // Changing the status to false

        // Perform the update request with the 'status' field
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson('/api/students/' . $student->id, $updatedData);

        // Assert that the status code is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains the updated 'status' field
        $response->assertJsonFragment(['status' => 0]);

        // Retrieve the student again from the database
        $updatedStudent = Student::find($student->id);

        // Assert that the 'status' has been updated correctly
        $this->assertNotEquals($student->status, $updatedStudent->status);

        // Assert that other fields (e.g., ref_id) remain unchanged
        $this->assertEquals($student->ref_id, $updatedStudent->ref_id);
        $this->assertEquals($student->email, $updatedStudent->email);
    }


}
