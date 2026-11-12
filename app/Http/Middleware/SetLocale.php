<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } elseif ($request->hasCookie('locale')) {
            $locale = $request->cookie('locale');
            if (in_array($locale, ['es', 'en', 'fr', 'de', 'it'])) {
                App::setLocale($locale);
                Session::put('locale', $locale);
            }
        }

        return $next($request);
    }
}