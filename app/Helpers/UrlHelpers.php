<?php

use Illuminate\Support\Facades\Route;

/**
 * Check if current route name is match specified route name
 *
 * @param  string  $route
 * @return bool
 */
if (! function_exists('is_current_route')) {
	function is_current_route(string $route)
	{
		return Route::currentRouteName() === $route;
	}
}

/**
 * Alias for "is_current_route"
 *
 * @param  string
 * @return bool
 */
if (! function_exists('isCurrentRoute')) {
	function isCurrentRoute(string $route)
	{
	    return is_current_route($route);
	}
}

/**
 * Check if certain route name is starts with specified string
 *
 * @param  string  $start
 * @param  string  $routeName
 * @return bool
 */
if (! function_exists('is_route_starts_with')) {
	function is_route_starts_with(string $start, string $routeName = '')
	{
		// If route is not defined make it current route
	    $routeName = $routeName ?: Route::currentRouteName();

	    return is_str_starts_with($routeName, $start);
	}
}

/**
 * Alias for "is_route_starts_with"
 *
 * @param  string  $start
 * @param  string  $routeName
 * @return bool
 */
if (! function_exists('isRouteStartsWith')) {
	function isRouteStartsWith(string $start, string $routeName = '')
	{
	    return is_route_starts_with($start, $routeName);
	}
}

/**
 * Prepare localized route based on current locale
 *
 * @param  string  $routeName
 * @param  mixed|null  $parameters
 * @return  string
 */
if (! function_exists('localized_route')) {
    function localized_route(string $routeName, $parameters = null)
    {
        $localeParameter = [
        	'locale' => request()->route('locale') ?:
        		app()->getLocale(),
        ];

        // Check if parameters is exists
        if (! $parameters) return route($routeName, $localeParameter);

        // Prepare parameters
        if (! is_array($parameters)) $parameters = [$parameters];

        $parameters = array_merge($parameters, $localeParameter);
        return route($routeName, $parameters);
    }
}

/**
 * Alias for "localized_route"
 *
 * @param  string  $routeName
 * @param  mixed|null  $parameters
 * @return string
 */
if (! function_exists('localizedRoute')) {
	function localizedRoute(string $routeName, $parameters = null)
	{
		return localized_route($routeName, $parameters);
	}
}

/**
 * Get current link of the application
 *
 * @return  string
 */
if (! function_exists('current_link')) {
	function current_link()
	{
		return url()->current();
	}
}

/**
 * Alias for "current_link"
 *
 * @return  string
 */
if (! function_exists('currentLink')) {
	function currentLink()
	{
		return current_link();
	}
}

/**
 * Get current request method
 *
 * @return  string
 */
if (! function_exists('request_method')) {
	function request_method(): string
    {
		return request()->method();
	}
}

/**
 * Alias for "request_method"
 *
 * @return  string
 */
if (! function_exists('requestMethod')) {
	function requestMethod(): string
    {
		return request_method();
	}
}

/**
 * Get server medium image link
 *
 * @return string
 */
if (! function_exists('server_medium_img_link')) {
    function server_medium_img_link(): string
    {
        return concat_paths([
            config('globalArray.SERVER_CONTAINER_PATH'),
            config('globalArray.SERVER_215x258_IMAGE_PATH')
        ]);
    }
}

/**
 * Get server medium image link
 *
 * @return string
 */
if (! function_exists('server_low_img_link')) {
    function server_low_img_link(): string
    {
        return concat_paths([
            config('globalArray.SERVER_CONTAINER_PATH'),
            config('globalArray.SERVER_100x120_IMAGE_PATH'),
        ]);
    }
}

/**
 * Get server original image link
 *
 * @return string
 */
if (! function_exists('server_original_img_link')) {
    function server_original_img_link(): string
    {
        return concat_paths([
            config('globalArray.SERVER_CONTAINER_PATH'),
            config('globalArray.SERVER_ORIGINAL_IMAGE'),
        ]);
    }
}

/**
 * Get local original image link
 *
 * @return string
 */
if (! function_exists('local_original_img_link')) {
    function local_original_img_link()
    {
        return concat_paths([
            public_path(),
            config('globalArray.ORIGINAL_IMAGE')
        ]);
    }
}

/**
 * Get local medium image link
 * 
 * @return string
 */
if (! function_exists('local_medium_img_link')) {
	function local_medium_img_link()
	{
		return concat_paths([
			public_path(),
			config('globalArray.215x258_IMAGE_PATH')
		]);
	}
}
