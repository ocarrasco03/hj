<?php

namespace App\Traits;

use App\Models\Configs\Address;
use App\Models\Configs\Country;
use App\Models\Configs\State;
use Exception;

trait Addressable
{
    /**
     * Get the addresses that owns the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * Add an address to the model
     *
     * @param string $country
     * @param string $state
     * @param string $city
     * @param string $street
     * @param string|integer $zipCode
     * @param string $neighborhood
     * @param string|integer $extNo
     * @param string|integer $intNo Optional.
     * @param string $notes Optional.
     * @param string $type Optional. Accepts 'shipping', 'billing', 'both', null.
     */
    public function addAddress($country, $state, $city, $street, $zipCode, $neighborhood, $extNo, $intNo = null, $notes = null, $type = null)
    {
        $countryModel = Country::where('name', $country)->first();
        $stateModel = State::whereHas('country', function ($query) use ($country) {
            return $query->where('name', $country);
        })->where('name', $state)->first();

        if (!$countryModel || !$stateModel) {
            throw new Exception('Invalid Country: ' . $country . ' or State: ' . $state);
        }

        $address = new Address();
        $address->country_id = $countryModel->id;
        $address->state_id = $stateModel->id;
        $address->street = $street;
        $address->city = $city;
        $address->zip_code = $zipCode;
        $address->neighborhood = $neighborhood;
        $address->street = $street;
        $address->ext_no = $extNo;
        $address->int_no = $intNo;
        $address->notes = $notes;
        $address->type = $type;
        $this->addresses()->save($address);
    }

    /**
     * Set a new shipping address to the model
     *
     * @param int|string $id
     */
    public function setShippingAddress($id)
    {
        $this->addresses->map(function ($address) use ($id) {
            $type = 'shipping';
            if ($address->id == $id) {
                if ($address->type !== 'both') {
                    if ($address->type == 'billing') {
                        $type = 'both';
                    }
                }
                $address->update([
                    'type' => $type,
                ]);
            } else if ($address->type !== 'billing') {
                $this->removeShippingAddress($address->id);
            }
        });
    }

    /**
     * Set a new billing address to the model
     *
     * @param int|string $id
     */
    public function setBillingAddress($id)
    {
        $this->addresses->map(function ($address) use ($id) {
            $type = 'billing';
            if ($address->id == $id) {
                if ($address->type !== 'both') {
                    if ($address->type == 'shipping') {
                        $type = 'both';
                    }
                }
                $address->update([
                    'type' => $type,
                ]);
            } else if ($address->type !== 'shipping') {
                $this->removeBillingAddress($address->id);
            }

        });
    }

    /**
     * Remove a billing address from the model
     *
     * @param int|string $id
     * @return void
     */
    public function removeBillingAddress($id)
    {
        $this->addresses->map(function ($address) use ($id) {
            if ($address->id == $id) {
                if (!is_null($address->type)) {
                    $address->update([
                        'type' => $address->type == 'both' ? 'shipping' : null,
                    ]);
                }
            }
        });
    }

    /**
     * Remove a shipping address from the model
     *
     * @param int|string $id
     */
    public function removeShippingAddress($id)
    {
        $this->addresses->map(function ($address) use ($id) {
            if ($address->id == $id) {
                if (!is_null($address->type)) {
                    $address->update([
                        'type' => $address->type == 'both' ? 'billing' : null,
                    ]);
                }
            }
        });
    }
}
