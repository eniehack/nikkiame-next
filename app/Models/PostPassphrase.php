<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PostPassphrase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [];
    protected $guarded = ["post_id", "passphrase"];

    protected $casts = [
        "created_at" => "datetime",
        "updated_at" => "datetime",
    ];

    protected $table = "posts_passphrases";

    protected $primaryKey = "post_id";
    public $incrementing = false;
    protected $keyType = "string";
}
