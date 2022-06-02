<?php

namespace App\Http\Resources\Cms\Customers;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Main\Profile\AddressResource;

class CustomerDetailResource extends JsonResource
{
    /**
     * @var array
     */
    private $months = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];

    /**
     * @var array
     */
    private $monthsNumber = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $shipping = null;
        $billing = null;

        foreach ($this->addresses as $address) {
            switch ($address->type) {
                case 'shipping':
                    $shipping = $address;
                    break;
                case 'billing':
                    $billing = $address;
                    break;
                case 'both':
                    $shipping = $address;
                    $billing = $address;
                    break;
            }
        }

        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'phone' => $this->phone,
            'avg_purchases' => is_null($this->averagePurchases()) ? 0 : $this->averagePurchases(),
            'total_purchases' => $this->totalPurchases(),
            'sum_purchases' => $this->sumPurchases(),
            'sum_canceled' => $this->sumCanceledPurchases(),
            'total_canceled' => $this->totalCanceledPurchases(),
            'addresses' => [
                'shipping' => !is_null($shipping) ? new AddressResource($shipping): null,
                'billing' => !is_null($billing) ? new AddressResource($billing) : null,
            ],
            'chart' => $this->getChart(),
            'canceledChart' => $this->getChart(true),
            'suscribed' => $this->suscribed,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ];
    }

    /**
     * Get the formatted chart data
     *
     * @return array
     */
    public function getChart($only = false)
    {
        $chart = [];

        for ($i = 0; $i < count($this->months); $i++) {
            $start = date('Y-'.$this->monthsNumber[$i].'-01');
            $end = date('Y-'.$this->monthsNumber[$i].'-t');

            $chart['labels'][$i] = $this->months[$i];
            $chart['data'][$i] = $this->orders()
                ->whereBetween('created_at', [$start, $end])
                ->when($only, function ($query) {
                    return $query->whereHas('status', function ($query) {
                        return $query->where('prefix', 'CANCELED')->orWhere('prefix', 'REFUND');
                    });
                })
                ->when(!$only, function ($query) {
                    return $query->withoutCanceled()
                        ->withoutRefunded();
                })
                ->sum('total');
        }

        return $chart;
    }
}
