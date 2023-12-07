<?php

namespace App\Models;

use App\Events\SlideChanged;
use App\Events\SlideDeleted;
use App\Jobs\RemovePreviewSlide;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Slide extends Model
{
    use HasFactory;
    use Searchable;

    const STORAGE_DISK = 'local';
    const FILE_DIRECTORY = 'slides';

    const LIVE_STORAGE_DISK = 'user_content';
    const LIVE_FILE_DIRECTORY = 'slides';

    const PREVIEW_STORAGE_DISK = 'user_content';
    const PREVIEW_FILE_DIRECTORY = 'slides-preview';
    const PREVIEW_LIFETIME_IN_SECONDS = 60 * 60 * 24 * 7; // 7 days

    // Only plain HTML files are allowed
    const ACCEPTED_FILE_TYPES = [
        'text/html',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'deleted' => SlideDeleted::class,
        'updated' => SlideChanged::class,
    ];

    protected $casts = [
        'data' => AsArrayObject::class,
    ];

    protected $fillable = [
        'title',
        'path',
        'user_id',
    ];

    protected $with = [
        'user',
    ];

    protected $searchableFields = ['*'];

    /**
     *
     * Scopes
     *
     */

    /**
     * Scope a query to only include approved slides.
     */
    public function scopeOnlyApproved($query)
    {
        return $query->whereNotNull('approved_at');
    }

    /**
     *
     * Methods
     *
     */

    public function setData(string $key, mixed $value, bool $save = true)
    {
        $data = $this->data ?? new \ArrayObject();
        $data[$key] = $value;
        $this->data = $data;

        if ($save) {
            $this->save();
        }
    }

    /**
     * Extract the provided slide to a randomly generated path
     */
    public function extractToPath(string $targetPath, $disk = self::STORAGE_DISK)
    {
        // Copy the file to the disk
        $source = Storage::disk(self::STORAGE_DISK)->readStream($this->path);
        Storage::disk($disk)->writeStream($targetPath, $source);

        return $targetPath;
    }

    /**
     *
     */
    public function getKnownPath(): string
    {
        $directory = self::LIVE_FILE_DIRECTORY;

        return $directory . '/' . $this->id . '.html';
    }

    public function getKnownUrl(): string
    {
        return Storage::disk(self::LIVE_STORAGE_DISK)->url($this->getKnownPath());
    }

    /**
     * Extract the provided slide to a known path and leave it there
     */
    public function extractLiveToPublic()
    {
        return Storage::disk(self::LIVE_STORAGE_DISK)->url($this->extractToPath($this->getKnownPath(), self::LIVE_STORAGE_DISK));
    }

    /**
     * Extract the provided slide to a randomly generated public path and add a clean up job
     */
    public function extractPreviewToPublic()
    {
        $disk = self::PREVIEW_STORAGE_DISK;
        $directory = self::PREVIEW_FILE_DIRECTORY;

        do
        {
            $randomString = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 20);
            $path = $directory . '/' . $randomString . '.html';
        } while (Storage::disk($disk)->exists($path));

        $publicPath = $this->extractToPath($path, $disk);

        $cleanupJob = RemovePreviewSlide::dispatch($disk, $publicPath);

        if (self::PREVIEW_LIFETIME_IN_SECONDS > 0) {
            $cleanupJob->delay(now()->addSeconds(self::PREVIEW_LIFETIME_IN_SECONDS));
        }

        return Storage::disk($disk)->url($publicPath);
    }

    /**
     * Delete the file associated with this slide (that is not the preview file, nor the live file)
     */
    public function deleteSourceFile($originalPath = null)
    {
        $path = $originalPath ?? $this->path;

        Storage::disk(self::STORAGE_DISK)
            ->delete($path);
    }

    /**
     * Delete the live file associated with this slide
     */
    public function deleteLiveFile()
    {
        $path = $this->getKnownPath();

        Storage::disk(self::LIVE_STORAGE_DISK)
            ->delete($path);
    }

    /**
     *
     * Relationships
     *
     */

    /**
     * The user this slide belongs to
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The teacher that  this slide
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    /**
     * The screens this slide is active on
     */
    public function screens()
    {
        return $this->belongsToMany(Screen::class, 'screen_slides')
            ->using(ScreenSlide::class)
            ->withPivot([
                'activator_id',
                'slide_order',
                'slide_duration',
                'displays_from',
                'displays_until',
            ])
            ->withTimestamps();
    }

    /**
     * The active slides this slide is on
     */
    public function screenSlides()
    {
        return $this->hasMany(ScreenSlide::class);
    }
}
