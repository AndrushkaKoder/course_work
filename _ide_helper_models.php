<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $mark
 * @property string $model
 * @property string|null $class
 * @property string $vin_code
 * @property int $year
 * @property int $price
 * @property string $color
 * @property CarType $type
 * @property int $count
 * @property string|null $state_number
 * @property string|null $preview
 * @property string|null $images
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereStateNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereVinCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereYear($value)
 * @mixin Eloquent
 * @property int|null $mileage
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereMileage($value)
 */
	class Car extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sail> $sails
 * @property-read int|null $sails_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Client extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $client_id
 * @property int|null $user_id
 * @property int|null $car_id
 * @property int|null $price
 * @property SailStatus $status
 * @property SailType $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Car|null $car
 * @property-read Client|null $client
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereCarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereUserId($value)
 * @mixin Eloquent
 * @property array<array-key, mixed>|null $files
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sail whereFiles($value)
 */
	class Sail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sail> $sails
 * @property-read int|null $sails_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

