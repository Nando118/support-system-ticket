<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'title',
        'description',
        'label',
        'category',
        'priority',
        'user_id'
    ];

    protected $casts = [
        'label' => 'array',
        'category' => 'array'
    ];

    // QUERY MODEL
    // Dashboard - Count Ticket By Role & Status
    public static function getCountTicketByRoleStatus(string $role, int $user_id = null, string $status) {
        if ($role === "regular_user") {
            return Ticket::query()
                ->where("user_id", "=", $user_id)
                ->where("status", "=", $status)->count();
        }else if ($role === "engineer") {
            return Ticket::query()
                ->where("engineer_id", "=", $user_id)
                ->where("status", "=", $status)->count();
        }else{
            return Ticket::all()->where("status", "=", $status)->count();
        }
    }

    // Tickets - Get Ticket By Role
    public static function getTicketByRole(string $role, int $user_id = null) {
        if ($role === "regular_user") {
            return Ticket::query()->where("user_id", "=", $user_id)->get();
        }else if($role === "engineer"){
            return Ticket::query()->where("engineer_id", "=", $user_id)->get();
        } else{
            return Ticket::all();
        }
    }

    // RELATIONS
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function engineer(): BelongsTo {
        return $this->belongsTo(User::class, "engineer_id", "id");
    }

    public function attachments(): HasMany {
        return $this->hasMany(Attachment::class, "ticket_id", "id");
    }

    public function comments(): HasMany {
        return $this->hasMany(Comment::class, "ticket_id", "id");
    }

    public function logs(): HasMany {
        return $this->hasMany(Log::class, "ticket_id", "id");
    }

}
