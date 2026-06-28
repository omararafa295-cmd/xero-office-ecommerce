<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $navCategories = cache()->remember('nav_categories', now()->addMinutes(30), fn () => Category::orderBy('name_en')->get());

            $cartCount = 0;
            $favCount = 0;

            if (Auth::check()) {
                $user = Auth::user();
                $cart = $user->cart;

                if ($cart) {
                    $cartCount = $cart->items->sum('quantity');
                }

                $favCount = Favorite::where('user_id', $user->id)->count();
            } else {
                $sessionCart = session()->get('cart', []);
                if (is_array($sessionCart)) {
                    $cartCount = array_sum(array_column($sessionCart, 'quantity'));
                }
            }

            $view->with([
                'navCategories' => $navCategories,
                'cartCount' => $cartCount,
                'favCount' => $favCount,
            ]);
        });
    }
}
