<?php

namespace App\Traits;

use App\Models\Vehicles\Catalog;

trait HasApplication
{
    public function addCatalog($year, $make, $model, $engine = null, $notes = null, array $attributes = [])
    {

        Catalog::create([
            'product_id' => $this->id,
            'year_id'=> $year->id,
            'make_id'=> $make->id,
            'model_id'=> $model->id,
            'engine_id'=> $engine->id,
            'notes'=> $notes,
            'attributes'=> $attributes,
        ]);
    }

    public function catalogs()
    {
        return $this->belongsTo(Catalog::class);
    }
}
