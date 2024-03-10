<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'comment'
    ];

    // RELATIONS
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function ticket(): BelongsTo {
        return $this->belongsTo(Ticket::class, "ticket_id", "id");
    }

    public function attachments(): HasMany {
        return $this->hasMany(Attachment::class, "comment_id", "id");
    }
}
