<?php

namespace App\Logic\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Logic\Enums\FacebookInsightType;

class FacebookInsight extends Model
{
    use HasFactory;

    public $table = 'facebook_insights';

    protected $fillable = [
        'account_id',
        'type',
        'value',
        'date',
    ];

    protected $casts = [
        'type' => FacebookInsightType::class,
        'date' => 'date'
    ];

    public function scopeAccount($query, int $accountId)
    {
        $query->where('account_id', $accountId);
    }
}
