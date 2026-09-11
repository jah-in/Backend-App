<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class BookController extends Controller
{
    #[OA\Get(
        path: "/api/admin/books",
        summary: "Get all books",
        tags: ["Book Management"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Books retrieved successfully"
            ),
            new OA\Response(
                response: 401,
                description: "Unauthorized"
            )
        ]
    )]
    public function index()
    {
        $books = Book::all();

        return response()->json([
            'books' => $books
        ]);
    }

    #[OA\Post(
        path: "/api/admin/books",
        summary: "Add a new book",
        tags: ["Book Management"],
        security: [["sanctum" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: [
                    "title",
                    "author",
                    "isbn",
                    "category",
                    "quantity"
                ],
                properties: [
                    new OA\Property(
                        property: "title",
                        type: "string",
                        example: "Introduction to Networking"
                    ),
                    new OA\Property(
                        property: "author",
                        type: "string",
                        example: "Jain Alawi"
                    ),
                    new OA\Property(
                        property: "isbn",
                        type: "string",
                        example: "978-1234567890"
                    ),
                    new OA\Property(
                        property: "category",
                        type: "string",
                        example: "Networking"
                    ),
                    new OA\Property(
                        property: "quantity",
                        type: "integer",
                        example: 5
                    ),
                    new OA\Property(
                        property: "description",
                        type: "string",
                        example: "A basic introduction to computer networking."
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Book added successfully"
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
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $validated['available_quantity'] = $validated['quantity'];

        $book = Book::create($validated);

        return response()->json([
            'message' => 'Book added successfully.',
            'book' => $book
        ], 201);
    }

    #[OA\Get(
        path: "/api/admin/books/{id}",
        summary: "Get a single book",
        tags: ["Book Management"],
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
                description: "Book retrieved successfully"
            ),
            new OA\Response(
                response: 404,
                description: "Book not found"
            )
        ]
    )]
    public function show(string $id)
    {
        $book = Book::find($id);

        if (! $book) {
            return response()->json([
                'message' => 'Book not found.'
            ], 404);
        }

        return response()->json([
            'book' => $book
        ]);
    }

    #[OA\Put(
        path: "/api/admin/books/{id}",
        summary: "Update a book",
        tags: ["Book Management"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "title", type: "string"),
                    new OA\Property(property: "author", type: "string"),
                    new OA\Property(property: "isbn", type: "string"),
                    new OA\Property(property: "category", type: "string"),
                    new OA\Property(property: "quantity", type: "integer"),
                    new OA\Property(property: "description", type: "string")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Book updated successfully"
            ),
            new OA\Response(
                response: 404,
                description: "Book not found"
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]
    public function update(Request $request, string $id)
    {
        $book = Book::find($id);

        if (! $book) {
            return response()->json([
                'message' => 'Book not found.'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'isbn' => 'sometimes|required|string|unique:books,isbn,' . $id,
            'category' => 'sometimes|required|string|max:255',
            'quantity' => 'sometimes|required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        if (isset($validated['quantity'])) {
            $difference = $validated['quantity'] - $book->quantity;

            $validated['available_quantity'] =
                max(0, $book->available_quantity + $difference);
        }

        $book->update($validated);

        return response()->json([
            'message' => 'Book updated successfully.',
            'book' => $book
        ]);
    }

    #[OA\Delete(
        path: "/api/admin/books/{id}",
        summary: "Delete a book",
        tags: ["Book Management"],
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
                description: "Book deleted successfully"
            ),
            new OA\Response(
                response: 404,
                description: "Book not found"
            )
        ]
    )]
    public function destroy(string $id)
    {
        $book = Book::find($id);

        if (! $book) {
            return response()->json([
                'message' => 'Book not found.'
            ], 404);
        }

        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully.'
        ]);
    }
}