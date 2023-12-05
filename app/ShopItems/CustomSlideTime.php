<?php

namespace App\ShopItems;

use App\Models\Screen;
use App\Models\ScreenSlide;
use App\Models\ShopItem;
use App\Models\ShopItemUser;
use App\Models\Slide;

#[ForShopItem('slide_1d')]
#[ForShopItem('slide_7d')]
#[ForShopItem('slide_14d')]
#[ForShopItem('slide_indefinite')]
class CustomSlideTime implements ShopItemInterface
{
    /**
     * Adds default time when a user purchases this item.
     */
    public static function onPurchase(ShopItem $shopItem, ShopItemUser $shopItemUser): void
    {
        $shopItemUser->data['time_total_in_seconds'] = match ($shopItem->unique_id) {
            'slide_1d' => 1 * 24 * 60 * 60,
            'slide_7d' => 7 * 24 * 60 * 60,
            'slide_14d' => 14 * 24 * 60 * 60,
            'slide_indefinite' => 99999999999999999999,
        };
        $shopItemUser->data['time_used_in_seconds'] = 0;
    }

    /**
     * Returns html to be displayed in the inventory showing how much time is left
     */
    public static function showUserData(ShopItem $shopItem, ShopItemUser $shopItemUser): string
    {
        $timeTotalInHours = $shopItemUser->data['time_total_in_seconds'] / 60 / 60;
        $timeUsedInHours = $shopItemUser->data['time_used_in_seconds'] / 60 / 60;
        $activeSlideId = $shopItemUser->data['active_slide'] ?? null;
        $activeSlide = $activeSlideId ? $shopItemUser->user->slides()->find($activeSlideId) : null;
        /** @var \App\Models\User */
        $user = auth()->user();
        $selectableSlides = $user->approvedSlides()->withCount('screens')->having('screens_count', '==', 0)->get();
        return view('app.shop.items.custom-slide-time', compact('timeUsedInHours', 'timeTotalInHours', 'activeSlide', 'shopItemUser', 'selectableSlides'))->render();
    }

    /**
     * Sets the start time to now when a user uses this item.
     */
    public static function onUse(ShopItem $shopItem, ShopItemUser $shopItemUser, ...$arguments): null|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        // Guard against an invalid slide being passed
        $slide = $arguments[0];
        $isActivate = $arguments[1];

        if (!$slide || !is_object($slide) || get_class($slide) !== Slide::class) {
            throw new \Exception('No slide id passed to CustomSlideTime::onUse! Please call a developer.');
        }

        if (!is_bool($isActivate)) {
            throw new \Exception('No isActivate bool passed to CustomSlideTime::onUse! Please call a developer.');
        }

        if ($isActivate) {
            $timeLeft = $shopItemUser->data['time_total_in_seconds'] - $shopItemUser->data['time_used_in_seconds'];
            if ($timeLeft <= 0) {
                return redirect()->back()->withErrors([
                    'shop_item_user_id' => __('You have no time left on this item'),
                ]);
            }

            $screenSlide = new ScreenSlide;
            $screenSlide->slide_id = $slide->id;
            $screenSlide->activator_id = auth()->id();
            $screenSlide->displays_from = now();
            $screenSlide->displays_until = now()->addSeconds($timeLeft);

            foreach (Screen::all() as $screen) {
                $screenSlide->screen()->associate($screen);
            }

            $screenSlide->save();

            $shopItemUser->data['active_slide'] = $slide->id;
            $shopItemUser->data['screen_slide_id'] = $screenSlide->id;
            $shopItemUser->data['active_slide_start_time'] = time();
        } else {
            // Check that the user is using the correct slide
            if ($shopItemUser->data['active_slide'] !== $slide->id) {
                return redirect()->back()->withErrors([
                    'shop_item_user_id' => __('You are not using this slide with this item'),
                ]);
            }

            $screenSlideId = $shopItemUser->data['screen_slide_id'];

            // Remove the active slide from the data
            $shopItemUser->data['active_slide'] = null;
            $shopItemUser->data['active_slide_start_time'] = null;
            $shopItemUser->data['screen_slide_id'] = null;

            if (isset($screenSlideId)) {
                $screenSlide = ScreenSlide::find($screenSlideId);

                if($screenSlide) {
                    $screenSlide->delete();
                }
            }
        }

        return null;
    }

    /**
     * Called periodically while the product is being used.
     *
     * We use this to check if the item has expired.
     */
    public static function onTick(ShopItem $shopItem, ShopItemUser $shopItemUser, ...$arguments): bool
    {
        // Guard against an invalid screen slide being passed
        $screenSlide = $arguments[0];

        if (!$screenSlide || !is_object($screenSlide) || get_class($screenSlide) !== ScreenSlide::class) {
            throw new \Exception('No screen slide passed to CustomSlideTime::onTick! Please call a developer.');
        }

        // Use active_slide_start_time to calculate how much time is left
        $timeUsedSinceStart = time() - $shopItemUser->data['active_slide_start_time'];
        $timeLeft = $shopItemUser->data['time_total_in_seconds'] - $shopItemUser->data['time_used_in_seconds'] - $timeUsedSinceStart;

        if ($timeLeft <= 0) {
            $shopItemUser->data['active_slide'] = null;
            $shopItemUser->data['screen_slide_id'] = null;
            $shopItemUser->data['active_slide_start_time'] = null;

            // Update the time used
            $shopItemUser->data['time_used_in_seconds'] = $shopItemUser->data['time_used_in_seconds'] + $timeUsedSinceStart;

            $screenSlide->delete();
            $shopItemUser->save();

            return false;
        }

        return true;
    }

    /**
     * Called to get custom slide column for the slides table
     */
    public static function getCustomSlideColumns(ShopItem $shopItem, ShopItemUser $shopItemUser, bool $isApproved): false|array
    {
        return false;
    }
}
