<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PostScope;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'scope',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'scope' => PostScope::class,
    ];

    protected $guarded = [
        'author',
        'id',
    ];

    protected $table = 'posts';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';
    public function user(){
        return $this->belongsTo(User::class,"author");
    }

    public function passphrase() {
        return $this->hasOne(PostPassphrase::class, "post_id");
    }
}
