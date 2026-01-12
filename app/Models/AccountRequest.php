<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountRequest extends Model
{
    use HasFactory;
      protected $fillable = [
        'name',
        'email',
        'phone',
        'status',          // pending / approved / rejected
        'role_requested',  // ADMIN / TECH_MANAGER / USER / INVITE
    ];
}
