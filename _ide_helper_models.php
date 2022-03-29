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
 * App\Models\Catalogs\File
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string $fileable_type
 * @property int $fileable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $fileable
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogs\Product[] $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\Catalogs\FileFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File query()
 * @method static \Illuminate\Database\Eloquent\Builder|File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUpdatedAt($value)
 */
	class File extends \Eloquent {}
}

namespace App\Models\Catalogs{
/**
 * App\Models\Catalogs\Product
 *
 * @property int $id
 * @property int $brand_id
 * @property int|null $supplier_id
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
 * @property array|null $notes
 * @property string $condition
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Catalogs\Brand $brand
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Configs\Categorizable[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogs\File[] $files
 * @property-read int|null $files_count
 * @property-read mixed $average_rating
 * @property-read mixed $sum_rating
 * @property-read mixed $user_average_rating
 * @property-read mixed $user_sum_rating
 * @property-read \Illuminate\Database\Eloquent\Collection|\willvincent\Rateable\Rating[] $ratings
 * @property-read int|null $ratings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $related
 * @property-read int|null $related_count
 * @property-read \App\Models\Catalogs\Supplier|null $supplier
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Configs\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Database\Factories\Catalogs\ProductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
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
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 */
	class Product extends \Eloquent implements \App\Packages\Shoppingcart\Contracts\Buyable {}
}

namespace App\Models\Catalogs{
/**
 * App\Models\Catalogs\Supplier
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogs\Product[] $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\Catalogs\SupplierFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newQuery()
 * @method static \Illuminate\Database\Query\Builder|Supplier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Supplier withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Supplier withoutTrashed()
 */
	class Supplier extends \Eloquent {}
}

namespace App\Models\Configs{
/**
 * App\Models\Configs\Categorizable
 *
 * @property int $category_id
 * @property string $categorizable_type
 * @property int $categorizable_id
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $categorizable
 * @property-read \App\Models\Configs\Category $category
 * @property-read \App\Models\Catalogs\Product|null $products
 * @method static \Illuminate\Database\Eloquent\Builder|Categorizable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categorizable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categorizable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Categorizable whereCategorizableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categorizable whereCategorizableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categorizable whereCategoryId($value)
 */
	class Categorizable extends \Eloquent {}
}

namespace App\Models\Configs{
/**
 * App\Models\Configs\Category
 *
 * @property int $id
 * @property string $name
 * @property int $parent
 * @method static \Database\Factories\Configs\CategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParent($value)
 */
	class Category extends \Eloquent {}
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

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $acepted_terms_conditions
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAceptedTermsConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
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
 * @property-read \App\Models\Vehicles\Manufacturer $makes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicles\Year[] $years
 * @property-read int|null $years_count
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
 * @method static \Database\Factories\Vehicles\YearFactory factory(...$parameters)
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

