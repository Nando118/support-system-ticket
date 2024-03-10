<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'comment_id',
        'file_name',
        'file_path'
    ];

    public function ticket(): BelongsTo {
        return $this->belongsTo(Ticket::class, "ticket_id", "id");
    }

    public function comment(): BelongsTo {
        return $this->belongsTo(Comment::class, "comment_id", "id");
    }

}
