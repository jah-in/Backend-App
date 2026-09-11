<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Borrowing extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'borrowings';

    protected $fillable = [
        'book_id',
        'borrower_name',
        'borrower_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
    ];
}