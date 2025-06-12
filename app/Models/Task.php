<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'due_date',
        'assigned_to',
        'todo_checklist',
        'attachment',
        'status',
    ];

    /**
     * Define the relationship to the assigned user.
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Automatically cast attributes to common data types.
     */
    protected $casts = [
        'due_date' => 'date', // Cast due_date to a Carbon instance
    ];
}
