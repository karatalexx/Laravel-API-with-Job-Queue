<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $message
 * @property Carbon $created_at
 */
class Message extends Model
{
    use HasFactory;

    protected $table = 'submissions';

    public $timestamps = false;

    public static function boot(): void
    {
        parent::boot();

        static::creating(static function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    protected $fillable = [
        'name',
        'email',
        'message',
    ];
}
