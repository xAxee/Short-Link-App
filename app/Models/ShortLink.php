<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    use HasFactory;

    
    public string $full_short_link;

    // get link's user
    public function user(): BelongsTo
    {
        return $this->belondsTo(User::class);
    }
}
