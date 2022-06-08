<?php

namespace App\Traits;

use App\Models\Vehicles\Manufacturer;
use App\Models\Vehicles\Model;
use App\Models\Vehicles\Vehicle;
use App\Models\Vehicles\Year;
use Illuminate\Support\Facades\DB;

trait HasApplication
{
    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class)->withPivot('notes', 'attributes');
    }

    /**
     * Attach a new vehicle to a product
     *
     * @param \App\Models\Vehicles\Year $year
     * @param \App\Models\Vehicles\Manufacturer $make
     * @param \App\Models\Vehicles\Model $model
     * @param \App\Models\Vehicles\Engine $engine
     * @param string $notes
     * @param array $attributes
     * @return void
     */
    public function attachVehicle($year, $make, $model, $engine = null, $notes = null, array $attributes = null)
    {
        $vehicle = Vehicle::where('year_id', $year->id)->where('make_id', $make->id)->where('model_id', $model->id)->where('engine_id', !is_null($engine) ? $engine->id : null)->first();

        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles()
                ->attach($vehicle, [
                    'notes' => $notes,
                    'attributes' => !is_null($attributes) ? json_encode($attributes) : null,
                ]);
        }
    }

    /**
     * Sync all attached vehicles to a product
     * 
     *
     * @param [type] $application
     * @return void
     */
    public function syncApplication($application)
    {
        $this->vehicles()->detach();
        $application = collect($application);
        $application->map(function ($vehicle) {
            $this->attachVehicle(
                Year::where('year', $vehicle['year'])->first(),
                Manufacturer::where('name', $vehicle['make'])->first(),
                Model::where('name', $vehicle['model'])->first(),
                null
            );
        });
    }
}
