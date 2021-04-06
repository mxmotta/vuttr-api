<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tool_id',
        'name'
    ];

    /**
     * Return the tool
     */
    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}
