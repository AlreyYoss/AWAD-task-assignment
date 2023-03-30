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
        'status',
        'upload',
        'assigner_id',
        'receiver_id',
        'due_date',
        'assigner_file_name'
    ];
}
