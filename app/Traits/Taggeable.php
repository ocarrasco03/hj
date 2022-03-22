<?php

namespace App\Traits;

use App\Models\Configs\Tag;

trait Taggeable
{
    /**
     * This model has many tags
     *
     * @param string $name
     * @return Tag
     */
    public function tag($name)
    {
        $tag = new Tag();
        $tag->tag = $name;
        $this->products()->save($tag);
    }

    public function products(){
        return $this->morphMany(\App\Models\Catalogs\Product::class, 'taggeable');
    }
}
