<?php

namespace App\Http\Controllers;

use App\Models\Student;
use OpenApi\Attributes as OA;
use Illuminate\Http\Request;


class StudentController extends Controller
{
    /**
     * Get all students.
     */
    #[OA\Get(
        path: "/api/admin/students",
        summary: "Get all students",
        tags: ["Students"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Students retrieved successfully"
            ),
            new OA\Response(
                response: 401,
                description: "Unauthorized"
            )
        ]
    )]
    public function index()
    {
        $students = Student::all();

        return response()->json([
            'students' => $students
        ]);
    }

    /**
     * Add a new student.
     */
    #[OA\Post(
        path: "/api/admin/students",
        summary: "Add a new student",
        tags: ["Students"],
        security: [["sanctum" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: [
                    "student_id",
                    "name",
                    "email",
                    "course",
                    "year_level"
                ],
                properties: [
                    new OA\Property(
                        property: "student_id",
                        type: "string",
                        example: "2023-00123"
                    ),
                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "Juan Dela Cruz"
                    ),
                    new OA\Property(
                        property: "email",
                        type: "string",
                        format: "email",
                        example: "juan@example.com"
                    ),
                    new OA\Property(
                        property: "course",
                        type: "string",
                        example: "BSIT"
                    ),
                    new OA\Property(
                        property: "year_level",
                        type: "integer",
                        example: 3
                    )
                ],
                type: "object"
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Student added successfully"
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            ),
            new OA\Response(
                response: 401,
                description: "Unauthorized"
            )
        ]
    )]
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string|unique:students,student_id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'course' => 'required|string|max:255',
            'year_level' => 'required|integer|min:1|max:10',
        ]);

        $student = Student::create($validated);

        return response()->json([
            'message' => 'Student added successfully.',
            'student' => $student
        ], 201);
    }

    /**
     * Get a single student.
     */
    #[OA\Get(
        path: "/api/admin/students/{id}",
        summary: "Get a student",
        tags: ["Students"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Student ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Student retrieved successfully"
            ),
            new OA\Response(
                response: 404,
                description: "Student not found"
            )
        ]
    )]
    public function show(string $id)
    {
        $student = Student::find($id);

        if (! $student) {
            return response()->json([
                'message' => 'Student not found.'
            ], 404);
        }

        return response()->json([
            'student' => $student
        ]);
    }

    /**
     * Update a student.
     */
    #[OA\Put(
        path: "/api/admin/students/{id}",
        summary: "Update a student",
        tags: ["Students"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Student ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: "student_id",
                        type: "string",
                        example: "2023-00123"
                    ),
                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "Juan Dela Cruz"
                    ),
                    new OA\Property(
                        property: "email",
                        type: "string",
                        format: "email",
                        example: "juan@example.com"
                    ),
                    new OA\Property(
                        property: "course",
                        type: "string",
                        example: "BSIT"
                    ),
                    new OA\Property(
                        property: "year_level",
                        type: "integer",
                        example: 4
                    )
                ],
                type: "object"
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Student updated successfully"
            ),
            new OA\Response(
                response: 404,
                description: "Student not found"
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);

        if (! $student) {
            return response()->json([
                'message' => 'Student not found.'
            ], 404);
        }

        $validated = $request->validate([
            'student_id' => 'sometimes|required|string',
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email',
            'course' => 'sometimes|required|string|max:255',
            'year_level' => 'sometimes|required|integer|min:1|max:10',
        ]);

        $student->update($validated);

        return response()->json([
            'message' => 'Student updated successfully.',
            'student' => $student
        ]);
    }

    /**
     * Delete a student.
     */
    #[OA\Delete(
        path: "/api/admin/students/{id}",
        summary: "Delete a student",
        tags: ["Students"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Student ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Student deleted successfully"
            ),
            new OA\Response(
                response: 404,
                description: "Student not found"
            )
        ]
    )]
    public function destroy(string $id)
    {
        $student = Student::find($id);

        if (! $student) {
            return response()->json([
                'message' => 'Student not found.'
            ], 404);
        }

        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully.'
        ]);
    }
}