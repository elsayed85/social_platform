<?php

namespace App\Logic\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportedPost extends Model
{
    use HasFactory;

    public $table = 'imported_posts';

    protected $fillable = [
        'account_id',
        'provider_post_id',
        'content',
        'metrics',
        'created_at'
    ];

    protected $casts = [
        'content' => 'array',
        'metrics' => 'array',
        'created_at' => 'date' // TODO: change type of this column from `date` to `datetime`
    ];

    public $timestamps = false;
}
