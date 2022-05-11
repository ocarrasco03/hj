<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Catalogs{
/**
 * App\Models\Catalogs\Brand
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogs\Product[] $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\Catalogs\BrandFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newQuery()
 * @method static \Illuminate\Database\Query\Builder|Brand onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Brand withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Brand withoutTrashed()
 */
	class Brand extends \Eloquent {}
}

namespace App\Models\Catalogs{
/**
 * App\Models\Catalogs\Product
 *
 * @property int $id
 * @property int $brand_id
 * @property int $status_id
 * @property string $sku
 * @property string $name
 * @property string|null $description
 * @property string $slug
 * @property float $cost
 * @property float $price_wo_tax
 * @property float $price
 * @property string $unit
 * @property float $stock
 * @property float $weight
 * @property string|null $notes
 * @property array|null $attributes
 * @property string $condition
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Configs\Tag[] $tags
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Catalogs\Brand $brand
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicles\Catalog[] $catalogs
 * @property-read int|null $catalogs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Configs\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read mixed $average_rating
 * @property-read mixed $sum_rating
 * @property-read mixed $user_average_rating
 * @property-read mixed $user_sum_rating
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sales\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\willvincent\Rateable\Rating[] $ratings
 * @property-read int|null $ratings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $related
 * @property-read int|null $related_count
 * @property-read \App\Models\Configs\Status $status
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product applicationSearch($year = null, $make = null, $model = null, $engine = null, $category = null, $subcategory = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product crawler($term)
 * @method static \Database\Factories\Catalogs\ProductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePriceWoTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 */
	class Product extends \Eloquent implements \App\Packages\Shoppingcart\Contracts\Buyable, \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models\Cms{
/**
 * App\Models\Cms\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\Cms\AdminFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Query\Builder|Admin onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|Admin withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Admin withoutTrashed()
 */
	class Admin extends \Eloquent {}
}

namespace App\Models\Configs{
/**
 * App\Models\Configs\Category
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent_id
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $children
 * @property-read int|null $children_count
 * @property-read Category|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|Category allParents()
 * @method static \Database\Factories\Configs\CategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models\Configs{
/**
 * App\Models\Configs\City
 *
 * @property int $id
 * @property int $country_id
 * @property int $state_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Configs\Country $country
 * @property-read \App\Models\Configs\State $state
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Configs\ZipCode[] $zipCodes
 * @property-read int|null $zip_codes_count
 * @method static \Database\Factories\Configs\CityFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Query\Builder|City onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|City withTrashed()
 * @method static \Illuminate\Database\Query\Builder|City withoutTrashed()
 */
	class City extends \Eloquent {}
}

namespace App\Models\Configs{
/**
 * App\Models\Configs\Country
 *
 * @property int $id
 * @property string $name
 * @property string $prefix
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User\Address[] $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Configs\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Configs\State[] $states
 * @property-read int|null $states_count
 * @method static \Database\Factories\Configs\CountryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Query\Builder|Country onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Country withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Country withoutTrashed()
 */
	class Country extends \Eloquent {}
}

namespace App\Models\Configs{
/**
 * App\Models\Configs\Currency
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Configs\CurrencyFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereUpdatedAt($value)
 */
	class Currency extends \Eloquent {}
}

namespace App\Models\Configs{
/**
 * App\Models\Configs\Neighborhood
 *
 * @property int $id
 * @property int $zip_code_id
 * @property string $name
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Configs\ZipCode $zipCode
 * @method static \Database\Factories\Configs\NeighborhoodFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Neighborhood newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Neighborhood newQuery()
 * @method static \Illuminate\Database\Query\Builder|Neighborhood onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Neighborhood query()
 * @method static \Illuminate\Database\Eloquent\Builder|Neighborhood whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Neighborhood whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Neighborhood whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Neighborhood whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Neighborhood whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Neighborhood whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Neighborhood whereZipCodeId($value)
 * @method static \Illuminate\Database\Query\Builder|Neighborhood withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Neighborhood withoutTrashed()
 */
	class Neighborhood extends \Eloquent {}
}

namespace App\Models\Configs{
/**
 * App\Models\Configs\Slider
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Configs\SliderFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUpdatedAt($value)
 */
	class Slider extends \Eloquent {}
}

namespace App\Models\Configs{
/**
 * App\Models\Configs\State
 *
 * @property int $id
 * @property int $country_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Configs\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \App\Models\Configs\Country $country
 * @method static \Database\Factories\Configs\StateFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|State newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|State newQuery()
 * @method static \Illuminate\Database\Query\Builder|State onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|State query()
 * @method static \Illuminate\Database\Eloquent\Builder|State whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|State withTrashed()
 * @method static \Illuminate\Database\Query\Builder|State withoutTrashed()
 */
	class State extends \Eloquent {}
}

namespace App\Models\Configs{
/**
 * App\Models\Configs\Status
 *
 * @property int $id
 * @property string $name
 * @property string $prefix
 * @property int $level
 * @property string|null $module_name
 * @property int $logable
 * @property int $send_email
 * @property int $shipped
 * @property int $delivered
 * @property int $paid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sales\Order[] $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|Status canceled()
 * @method static \Database\Factories\Configs\StatusFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Status newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Status newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Status query()
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereDelivered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereLogable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereModuleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereSendEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereShipped($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereUpdatedAt($value)
 */
	class Status extends \Eloquent {}
}

namespace App\Models\Configs{
/**
 * App\Models\Configs\Store
 *
 * @property int $id
 * @property string $name
 * @property string $rfc
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Configs\StoreFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Store newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store query()
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereRfc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereUpdatedAt($value)
 */
	class Store extends \Eloquent {}
}

namespace App\Models\Configs{
/**
 * App\Models\Configs\Tag
 *
 * @property int $id
 * @property string $tag
 * @property string $taggeable_type
 * @property int $taggeable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Catalogs\Product|null $products
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $taggeable
 * @method static \Database\Factories\Configs\TagFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereTaggeableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereTaggeableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models\Configs{
/**
 * App\Models\Configs\ZipCode
 *
 * @property int $id
 * @property int $country_id
 * @property int $state_id
 * @property int $city_id
 * @property string $zip_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Configs\City $city
 * @property-read \App\Models\Configs\Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Configs\Neighborhood[] $neighborhoods
 * @property-read int|null $neighborhoods_count
 * @property-read \App\Models\Configs\State $state
 * @method static \Database\Factories\Configs\ZipCodeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ZipCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ZipCode newQuery()
 * @method static \Illuminate\Database\Query\Builder|ZipCode onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ZipCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|ZipCode whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZipCode whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZipCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZipCode whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZipCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZipCode whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZipCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZipCode whereZipCode($value)
 * @method static \Illuminate\Database\Query\Builder|ZipCode withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ZipCode withoutTrashed()
 */
	class ZipCode extends \Eloquent {}
}

namespace App\Models\Sales{
/**
 * App\Models\Sales\Order
 *
 * @property string $id
 * @property int $user_id
 * @property int $status_id
 * @property float $subtotal
 * @property float $discount
 * @property float $tax
 * @property float $total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Configs\Status|null $canceledOrders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogs\Product[] $products
 * @property-read int|null $products_count
 * @property-read \App\Models\Configs\Status $status
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\Sales\OrderFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Query\Builder|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order search($term)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Order withoutTrashed()
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $acepted_terms_conditions
 * @property int $suscribed
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sales\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAceptedTermsConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSuscribed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

namespace App\Models\User{
/**
 * App\Models\User\Address
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $line_1
 * @property string|null $line_2
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $zip_code
 * @property string $references
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\User\AddressFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereReferences($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereZipCode($value)
 */
	class Address extends \Eloquent {}
}

namespace App\Models\Vehicles{
/**
 * App\Models\Vehicles\Catalog
 *
 * @property int $id
 * @property int $product_id
 * @property int $year_id
 * @property int $make_id
 * @property int $model_id
 * @property int|null $engine_id
 * @property string|null $notes
 * @property mixed|null $attributes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Vehicles\Engine|null $engine
 * @property-read \App\Models\Vehicles\Manufacturer $make
 * @property-read \App\Models\Vehicles\Model $model
 * @property-read \App\Models\Catalogs\Product $product
 * @property-read \App\Models\Vehicles\Year $year
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog query()
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereEngineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereMakeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereYearId($value)
 */
	class Catalog extends \Eloquent {}
}

namespace App\Models\Vehicles{
/**
 * App\Models\Vehicles\Engine
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Database\Factories\Vehicles\EngineFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Engine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Engine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Engine query()
 * @method static \Illuminate\Database\Eloquent\Builder|Engine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Engine whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Engine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Engine whereUpdatedAt($value)
 */
	class Engine extends \Eloquent {}
}

namespace App\Models\Vehicles{
/**
 * App\Models\Vehicles\Manufacturer
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicles\Model[] $models
 * @property-read int|null $models_count
 * @method static \Database\Factories\Vehicles\ManufacturerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Manufacturer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Manufacturer newQuery()
 * @method static \Illuminate\Database\Query\Builder|Manufacturer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Manufacturer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Manufacturer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manufacturer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manufacturer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manufacturer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manufacturer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Manufacturer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Manufacturer withoutTrashed()
 */
	class Manufacturer extends \Eloquent {}
}

namespace App\Models\Vehicles{
/**
 * App\Models\Vehicles\Model
 *
 * @property int $id
 * @property int $make_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicles\Engine[] $engines
 * @property-read int|null $engines_count
 * @property-read \App\Models\Vehicles\Manufacturer $make
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicles\Year[] $year
 * @property-read int|null $year_count
 * @method static \Database\Factories\Vehicles\ModelFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model newQuery()
 * @method static \Illuminate\Database\Query\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereMakeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Model withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Model withoutTrashed()
 */
	class Model extends \Eloquent {}
}

namespace App\Models\Vehicles{
/**
 * App\Models\Vehicles\Year
 *
 * @property int $id
 * @property string $year
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicles\Catalog[] $catalogs
 * @property-read int|null $catalogs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicles\Model[] $models
 * @property-read int|null $models_count
 * @method static \Database\Factories\Vehicles\YearFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Year findByYear($year)
 * @method static \Illuminate\Database\Eloquent\Builder|Year newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Year newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Year query()
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereYear($value)
 */
	class Year extends \Eloquent {}
}

