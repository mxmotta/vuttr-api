<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(schema="Tool", type="object")
 */
class Tool extends Model
{
    use HasFactory;

    /**
     * @OA\Property(property="title", type="string")
     * @OA\Property(property="link", type="string")
     * @OA\Property(property="description", type="string")
     * @OA\Property(property="tags", type="array", @OA\Items(type="array", @OA\Items({})))
     */
    protected $fillable = [
        'title',
        'link',
        'description'
    ];

    protected $searcheable = [
        'tags'
    ];

    /**
     * Return the tool tags
     */
    public function tags()
    {
        return $this->hasMany(ToolTag::class);
    }

    public function scopeHasTag($query, $tag)
    {
        if($tag){
            return $query->whereHas('tags', function($t) use ($tag){
                $t->where('name', $tag);
            });
        }

        return $query;
    }
}
