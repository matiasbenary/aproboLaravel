<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Contract
 *
 * @method static \Database\Factories\ContractFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract query()
 * @mixin \Eloquent
 */
	class Contract extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Entity
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\EntityFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Entity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entity query()
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Entity extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Invoice
 *
 * @method static \Database\Factories\InvoiceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @mixin \Eloquent
 */
	class Invoice extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Media
 *
 * @method static \Database\Factories\MediaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @mixin \Eloquent
 */
	class Media extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Movie
 *
 * @property int $id
 * @property string $name
 * @property string $release_year
 * @property string $director
 * @property string $description
 * @property array $genre
 * @property string $cover
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Movie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereDirector($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereGenre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereReleaseYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Movie extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Project
 *
 * @method static \Database\Factories\ProjectFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project query()
 * @mixin \Eloquent
 */
	class Project extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Projectseur
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Projectseur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Projectseur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Projectseur query()
 * @mixin \Eloquent
 */
	class Projectseur extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Supplier
 *
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string $business_name
 * @property int $ciut_cuil
 * @property int $cbu
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\SupplierFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereBusinessName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCbu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCiutCuil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereUserId($value)
 */
	class Supplier extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @property-read \App\Models\Supplier|null $supplier
 * @property int $is_root
 * @property int $is_supplier
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Entity[] $entities
 * @property-read int|null $entities_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsRoot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsSupplier($value)
 * @method static UserBuilder|User findByEmail($email)
 * @method static UserBuilder|User onlySupplier()
 */
	class User extends \Eloquent {}
}

