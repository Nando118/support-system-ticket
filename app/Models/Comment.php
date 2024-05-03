<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    // GET NOTIFICATION COMMENT
    public static function getNotification (string $ticket_id) {
        $ticket = Ticket::query()->where("id", "=", $ticket_id)->first();
        $lastCommentUserId = Comment::query()->where("ticket_id", "=", $ticket_id)->latest()->first();

        if ($lastCommentUserId === null) {
            if ($ticket->user_id !== Auth::user()->id && $ticket->status !== "closed") {
                return true;
            }

            return false;
        }

        if ($lastCommentUserId->user_id !== Auth::user()->id && $ticket->status !== "closed") {
            return true;
        }

        return false;
    }
}
