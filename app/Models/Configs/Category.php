<?php

namespace App\Models\Configs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'parent'
    ];

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
        ];
    }
}
