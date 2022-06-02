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
        $this->tags()->save($tag);
    }

    public function tags(){
        return $this->morphMany(Tag::class, 'taggeable');
    }
}
