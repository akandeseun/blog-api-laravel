<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'tag_id', 'category_id'];

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
