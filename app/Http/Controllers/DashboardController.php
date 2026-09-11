<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Student;
use Carbon\Carbon;
use OpenApi\Attributes as OA;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics.
     */
    #[OA\Get(
        path: "/api/admin/dashboard",
        summary: "Get dashboard statistics",
        tags: ["Dashboard"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Dashboard statistics retrieved successfully"
            ),
            new OA\Response(
                response: 401,
                description: "Unauthorized"
            )
        ]
    )]
    public function index()
    {
        $totalBooks = Book::count();

        $availableBooks = Book::sum('available_quantity');

        $totalStudents = Student::count();

        $activeBorrowings = Borrowing::where(
            'status',
            'borrowed'
        )->count();

        $returnedBooks = Borrowing::where(
            'status',
            'returned'
        )->count();

        $overdueBooks = Borrowing::where(
            'status',
            'borrowed'
        )
        ->where(
            'due_date',
            '<',
            Carbon::today()->toDateString()
        )
        ->count();

        return response()->json([
            'message' => 'Dashboard statistics retrieved successfully.',
            'statistics' => [
                'total_books' => $totalBooks,
                'available_books' => $availableBooks,
                'borrowed_books' => $activeBorrowings,
                'total_students' => $totalStudents,
                'active_borrowings' => $activeBorrowings,
                'returned_books' => $returnedBooks,
                'overdue_books' => $overdueBooks,
            ]
        ]);
    }
}