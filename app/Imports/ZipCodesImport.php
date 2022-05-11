<?php

namespace App\Imports;

use App\Models\Configs\City;
use App\Models\Configs\Country;
use App\Models\Configs\Neighborhood;
use App\Models\Configs\State;
use App\Models\Configs\ZipCode;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class ZipCodesImport implements ToCollection, WithProgressBar, WithChunkReading, WithBatchInserts, WithHeadingRow
{
    use Importable;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $country = $this->getCountry($row['d_pais'], $row['d_prefix']);
            $state = $this->getState($row['d_estado'], $country->id);
            $city = $this->getCity($row['d_mnpio'], $country->id, $state->id);
            $zipCode = $this->getZipCode($row['d_codigo'], $country->id, $state->id, $city->id);

            $this->setNeighborhood($row['d_asenta'], $row['d_tipo_asenta'], $zipCode->id);

        }
    }

    /**
     * @return integer
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * @return integer
     */
    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * Find or create country model
     *
     * @param string $name
     * @param string $prefix
     * @return \App\Models\Configs\Country
     */
    public function getCountry($name, $prefix)
    {
        $country = Country::where('name', $name)->first();

        if (!$country) {
            $country = new Country();
            $country->name = $name;
            $country->prefix = strtoupper($prefix);
            $country->save();
        }

        return $country;
    }

    /**
     * Find or create state model
     *
     * @param string $name
     * @param int $country
     * @return \App\Models\Configs\State
     */
    public function getState($name, $country)
    {
        $state = State::where('name', $name)
            ->where('country_id', $country)
            ->first();

        if (!$state) {
            $state = new State();
            $state->country_id = $country;
            $state->name = $name;
            $state->save();
        }

        return $state;
    }

    /**
     * Find or create city model
     *
     * @param string $name
     * @param int $country
     * @param int $state
     * @return \App\Models\Configs\City
     */
    public function getCity($name, $country, $state)
    {
        $city = City::where('name', $name)
            ->where('country_id', $country)
            ->where('state_id', $state)
            ->first();

        if (!$city) {
            $city = new City();
            $city->country_id = $country;
            $city->state_id = $state;
            $city->name = $name;
            $city->save();
        }

        return $city;
    }

    /**
     * Find or create zip code model
     *
     * @param string $code
     * @param int $country
     * @param int $state
     * @param int $city
     * @return \App\Models\Configs\ZipCode
     */
    public function getZipCode($code, $country, $state, $city)
    {
        $zipCode = ZipCode::where('zip_code', $code)
            ->where('country_id', $country)
            ->where('state_id', $state)
            ->where('city_id', $city)
            ->first();

        if (!$zipCode) {
            $zipCode = new ZipCode();
            $zipCode->country_id = $country;
            $zipCode->state_id = $state;
            $zipCode->city_id = $city;
            $zipCode->zip_code = $code;
            $zipCode->save();
        }

        return $zipCode;
    }

    /**
     * Create or update neighborhood
     *
     * @param string $name
     * @param string $type
     * @param int $code
     * @return \App\Models\Configs\Neighborhood
     */
    public function setNeighborhood($name, $type, $code)
    {
        $neighborhood = Neighborhood::where('name', $name)
            ->where('type', $type)
            ->where('zip_code_id', $code)
            ->first();

        if (!$neighborhood) {
            $neighborhood = new Neighborhood();
            $neighborhood->zip_code_id = $code;
            $neighborhood->name = $name;
            $neighborhood->type = $type;
            $neighborhood->save();
        } else {
            $neighborhood->zip_code_id = $code;
            $neighborhood->name = $name;
            $neighborhood->type = $type;

            if ($neighborhood->isDirty()) {
                $neighborhood->save();
            }
        }

        return $neighborhood;
    }
}
