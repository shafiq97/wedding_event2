<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use App\Models\Traits\HasLocation;
use App\Models\Traits\HasSlugForRouting;
use App\Models\Traits\HasWebsite;
use App\Options\Visibility;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @property-read int $id
 * @property string $name
 * @property int $user_id
 * @property string $slug
 * @property string $image
 * @property ?string $description
 * @property Visibility $visibility
 * @property ?Carbon $started_at
 * @property ?Carbon $finished_at
 *
 * @property-read Collection|BookingOption[] $bookingOptions {@see Venue::bookingOptions()}
 * @property-read ?ServiceSeries $eventSeries {@see Venue::eventSeries()}
 * @property-read Collection|Organization[] $organizations {@see Venue::organizations()}
 * @property-read ?Venue $parentEvent {@see Venue::parentEvent()}
 * @property-read Collection|Venue[] $subEvents {@see Venue::subEvents()}
 */
class Venue extends Model
{
    use Filterable;
    use HasFactory;
    use HasLocation;
    use HasSlugForRouting;
    use HasWebsite;

    protected $table = 'venues';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'visibility',
        'started_at',
        'finished_at',
        'website_url',
        'image',
        'user_id',
        'service_rating'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'visibility' => Visibility::class,
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    protected $perPage = 12;

    public function bookingOptions(): HasMany
    {
        return $this->hasMany(BookingOption::class, 'event_id');
    }

    public function eventSeries(): BelongsTo
    {
        return $this->belongsTo(ServiceSeries::class, 'event_series_id');
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class)
            ->orderBy('name')
            ->withTimestamps();
    }

    public function parentEvent(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'parent_event_id');
    }

    public function subEvents(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_event_id')
            ->orderBy('started_at')
            ->orderBy('finished_at');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function fillAndSave(array $validatedData): bool
    {
        $this->fill($validatedData);
        $this->location()->associate($validatedData['location_id'] ?? null);
        $this->eventSeries()->associate($validatedData['event_series_id'] ?? null);
        $this->parentEvent()->associate($validatedData['parent_event_id'] ?? null);

        if (isset($validatedData['image'])) {
            // dd('huhu');
            $image       = $validatedData['image'];
            $filename    = $image->storePublicly('landscape', 'public');
            $this->image = $filename;
        } else {
            // dd('hehe');
        }


        return $this->save()
            && $this->organizations()->sync($validatedData['organization_id'] ?? []);
    }

    public static function allowedFilters(): array
    {
        return [
            AllowedFilter::partial('name'),
            AllowedFilter::exact('location_id'),
            AllowedFilter::exact('organization_id', 'organizations.id'),
        ];
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Venue.php model

    public function reviews2()
    {
        return $this->hasMany(Review::class)->with('user:id,first_name');
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'wishlist_venues', 'service_id', 'user_id')->withTimestamps();
    }

}