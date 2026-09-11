<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;
use OpenApi\Attributes as OA;

class BorrowingController extends Controller
{
    /**
     * Get all borrowing records.
     */
    #[OA\Get(
        path: "/api/admin/borrowings",
        summary: "Get all borrowing records",
        tags: ["Borrowing Management"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Borrowing records retrieved successfully"
            ),
            new OA\Response(
                response: 401,
                description: "Unauthorized"
            )
        ]
    )]
        public function index()
        {
            $borrowings = Borrowing::all();

            return response()->json([
                'borrowings' => $borrowings
            ]);
        }

    /**
     * Borrow a book.
     */
            #[OA\Post(
            path: "/api/admin/borrowings",
            summary: "Borrow a book",
            tags: ["Borrowing Management"],
            security: [["sanctum" => []]],
            requestBody: new OA\RequestBody(
                required: true,
                content: new OA\JsonContent(
                    required: [
                        "book_id",
                        "student_id",
                        "due_date"
                    ],
                    properties: [
                        new OA\Property(
                            property: "book_id",
                            type: "string",
                            example: "BOOK_MONGODB_ID"
                        ),
                        new OA\Property(
                            property: "student_id",
                            type: "string",
                            example: "STUDENT_MONGODB_ID"
                        ),
                        new OA\Property(
                            property: "due_date",
                            type: "string",
                            format: "date",
                            example: "2026-09-20"
                        )
                    ],
                    type: "object"
                )
            ),
            responses: [
                new OA\Response(
                    response: 201,
                    description: "Book borrowed successfully"
                ),
                new OA\Response(
                    response: 400,
                    description: "Book unavailable"
                ),
                new OA\Response(
                    response: 404,
                    description: "Book or student not found"
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
                'book_id' => 'required|string',
                'student_id' => 'required|string',
                'due_date' => 'required|date',
            ]);

            // Find the book
            $book = Book::find($validated['book_id']);

            if (! $book) {
                return response()->json([
                    'message' => 'Book not found.'
                ], 404);
            }

            // Find the student
            $student = Student::find($validated['student_id']);

            if (! $student) {
                return response()->json([
                    'message' => 'Student not found.'
                ], 404);
            }

            // Check if the book is available
            if ($book->available_quantity <= 0) {
                return response()->json([
                    'message' => 'This book is currently unavailable.'
                ], 400);
            }

            // Create borrowing record
            $borrowing = Borrowing::create([
                'book_id' => $book->id,

                // Get information automatically from Student
                'student_id' => $student->id,
                'borrower_name' => $student->name,
                'borrower_id' => $student->student_id,

                'borrow_date' => Carbon::now()->toDateString(),
                'due_date' => $validated['due_date'],
                'return_date' => null,
                'status' => 'borrowed',
            ]);

            // Reduce available quantity
            $book->decrement('available_quantity');

            return response()->json([
                'message' => 'Book borrowed successfully.',
                'borrowing' => $borrowing,
            ], 201);
        }

    /**
     * Get active borrowings.
     */
    #[OA\Get(
        path: "/api/admin/borrowings/active",
        summary: "Get active borrowings",
        tags: ["Borrowing Management"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Active borrowings retrieved successfully"
            ),
            new OA\Response(
                response: 401,
                description: "Unauthorized"
            )
        ]
    )]
        public function active()
        {
            $borrowings = Borrowing::where('status', 'borrowed')->get();

            return response()->json([
                'borrowings' => $borrowings
            ]);
        }

    /**
     * Get a single borrowing record.
     */
    #[OA\Get(
        path: "/api/admin/borrowings/{id}",
        summary: "Get a single borrowing record",
        tags: ["Borrowing Management"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Borrowing record retrieved successfully"
            ),
            new OA\Response(
                response: 404,
                description: "Borrowing record not found"
            )
        ]
    )]
    public function show(string $id)
    {
        $borrowing = Borrowing::find($id);

        if (! $borrowing) {
            return response()->json([
                'message' => 'Borrowing record not found.'
            ], 404);
        }

        return response()->json([
            'borrowing' => $borrowing
        ]);
    }

    /**
     * Return a borrowed book.
     */
    #[OA\Put(
        path: "/api/admin/borrowings/{id}/return",
        summary: "Return a borrowed book",
        tags: ["Borrowing Management"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Book returned successfully"
            ),
            new OA\Response(
                response: 400,
                description: "Book already returned"
            ),
            new OA\Response(
                response: 404,
                description: "Borrowing record not found"
            )
        ]
    )]
    public function returnBook(string $id)
    {
        $borrowing = Borrowing::find($id);

        if (! $borrowing) {
            return response()->json([
                'message' => 'Borrowing record not found.'
            ], 404);
        }

        if ($borrowing->status === 'returned') {
            return response()->json([
                'message' => 'This book has already been returned.'
            ], 400);
        }

        $book = Book::find($borrowing->book_id);

        if ($book) {
            $book->increment('available_quantity');
        }

        $borrowing->update([
            'return_date' => Carbon::now()->toDateString(),
            'status' => 'returned',
        ]);

        return response()->json([
            'message' => 'Book returned successfully.',
            'borrowing' => $borrowing
        ]);
    }
}