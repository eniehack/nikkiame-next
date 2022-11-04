<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'is_draft',
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
        'scope' => 'int',
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
        return $this->belongsTo(User::class);
    }
}
