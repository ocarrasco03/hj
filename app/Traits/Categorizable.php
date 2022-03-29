<?php

namespace App\Traits;

use App\Models\Configs\Category;


trait Categorizable
{
    /**
     * This model has many categories.
     *
     * @param mixed $id
     * @return Category
     */
    public function category($id)
    {
        if (is_array($id)) {
            return array_map(function ($item) {
                return $this->category($item);
            }, $id);
        }

        $ids = [$id];

        if (count($this->categories()->whereIn('category_id', $ids)->pluck('category_id')) <= 0) {
            $this->categories()->attach($id);
        }
    }

    public function categoryRemove($id)
    {
        if (is_array($id)) {
            return array_map(function ($item) {
                return $this->categoryRemove($item);
            }, $id);
        }

        $this->categories()->where('category_id', $id)->delete();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'products_categories');
    }
}
