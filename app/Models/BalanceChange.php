<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceChange extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the balance change.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
