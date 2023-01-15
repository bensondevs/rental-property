<?php

use App\Enums\GenderType;
use App\Models\Log;
use App\Models\User;
use App\Models\SubscriptionPackage;
use Auth\Guard;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Response;

/**
 * Generate UUID
 *
 * @return  string
 */
if (!function_exists('generate_uuid')) {
    function generate_uuid()
    {
        return Uuid::generate()->string;
    }
}

/**
 * Alias for "generate_uuid"
 *
 * @return  string
 */
if (!function_exists('generateUuid')) {
    function generateUuid()
    {
        return generate_uuid();
    }
}

/**
 * Search value in collection
 *
 * @param Illuminate\Support\Collection $collection
 * @param mixed $search
 * @return bool
 */
if (!function_exists('searchInCollection')) {
    function searchInCollection(Collection $collection, $search)
    {
        return ($collection->filter(function ($item) use ($search) {
            $attributes = array_keys($item);
            foreach ($attributes as $attribute)
                if (isset($item[$attribute]) && (!is_array($item[$attribute])))
                    if (stripos($item[$attribute], $search) !== false)
                        return true;

            return false;
        }))->toArray();
    }
}

/**
 * Convert full url to username
 *
 * @param string $url
 * @return  string
 */
if (!function_exists('urlToUsername')) {
    function urlToUsername(string $urlString)
    {
        $urlString = str_replace('http://', '', $urlString);
        $urlString = str_replace('https://', '', $urlString);
        $urlString = str_replace('www.', '', $urlString);

        $clearParams = explode('/', $urlString);

        $mainDomain = $clearParams[0];
        $breakMainDomain = explode('.', $mainDomain);
        $domainName = $breakMainDomain[0];
        $domainExtension = $breakMainDomain[1];

        return $domainName . $domainExtension;
    }
}

/**
 * Convert email name to username
 *
 * @param string $email
 * @return string
 */
if (!function_exists('emailToUsername')) {
    function emailToUsername(string $email)
    {
        $explode = explode('@', $email);
        return $explode[0];
    }
}

/**
 * Get object pure class name without namespaces
 *
 * @param mixed $class
 * @return string
 */
if (!function_exists('get_pure_class')) {
    function get_pure_class($class)
    {
        $class = get_class($class);
        $explode = explode('\\', $class);
        return $explode[count($explode) - 1];
    }
}

/**
 * Get object lower class version
 *
 * @param mixed $class
 * @return string
 */
if (!function_exists('get_lower_class')) {
    function get_lower_class($class)
    {
        $lowerClassname = get_pure_class($class);
        $lowerClassname = str_snake_case($lowerClassname);
        $lowerClassname = strtolower($lowerClassname);
        return $lowerClassname;
    }
}

/**
 * Get object plural lower case name
 *
 * This will be helpful to create variable name
 *
 * @param mixed $class
 * @return string
 */
if (!function_exists('get_plural_lower_class')) {
    function get_plural_lower_class($class)
    {
        return str_to_plural(get_lower_class($class));
    }
}

/**
 * Convert any number value to float
 *
 * @param numeric $number
 * @return float
 */
if (!function_exists('numbertofloat')) {
    function numbertofloat($number)
    {
        return sprintf('%.2f', $number);
    }
}

/**
 * Format any numeric value to currency
 *
 * @param numeric $amount
 * @param string $currencyCode
 * @param string $locale
 * @return string
 */
if (!function_exists('currency_format')) {
    function currency_format(
        $amount,
        string $currencyCode = 'EUR',
        string $locale = 'nl_NL.UTF-8'
    ) {
        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, $currencyCode);
    }
}

/**
 * Make alias for Laravel DB class
 *
 * @param string $table
 * @return DB
 */
if (!function_exists('db')) {
    function db(string $table = '')
    {
        return ($table) ? DB::table($table) : new DB;
    }
}

/**
 * Clean file name from directory special characters
 *
 * @param string $filename
 * @return string
 */
if (!function_exists('clean_filename')) {
    function clean_filename(string $filename)
    {
        // Replace > with space
        $filename = str_replace('/', ' ', $filename);

        // Replace > with space
        $filename = str_replace('>', ' ', $filename);

        // Replace | with space
        $filename = str_replace('|', ' ', $filename);

        // Replace : with space
        $filename = str_replace(':', ' ', $filename);

        // Replace & with space
        $filename = str_replace('&', ' ', $filename);

        // Replace ? with space
        $filename = str_replace(' ', '_', $filename);

        // Replace spaces with _
        $filename = str_replace(' ', '_', $filename);

        return $filename;
    }
}

/**
 * Generate random hex color
 *
 * @return  string
 */
if (!function_exists('random_hex_color')) {
    function random_hex_color()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
}

/**
 * Generate random phone number
 * by specifying the length of digits
 *
 * @param int $lenth
 * @return  string
 */
if (!function_exists('random_phone')) {
    function random_phone(int $length = 12)
    {
        if ($length <= 0) return '';

        $digit = ((string)random_int(0, 9));
        return $digit . random_phone($length - 1);
    }
}

/**
 * Decode JSON string directly to array
 *
 * @param string $json
 * @return array|null
 */
if (!function_exists('json_decode_array')) {
    function json_decode_array(string $json)
    {
        return json_decode($json, true);
    }
}

/**
 * Check if a string if valid json
 *
 * @param string $string
 * @return bool
 */
if (!function_exists('is_valid_json')) {
    function is_valid_json(string $string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}

/**
 * Shorter version for laravel response json
 *
 * @param array $response
 * @return Response
 */
if (!function_exists('jsonResponse')) {
    function jsonResponse(array $response)
    {
        return response()->json($response);
    }
}

/**
 * Convery every element to uppercase in array
 *
 * @param array $array
 * @return array
 */
if (!function_exists('uppercaseArray')) {
    function uppercaseArray(array $array)
    {
        return array_map('strtoupper', $array);
    }
}

/**
 * Get current currency of the authenticated user
 *
 * @return  int
 */
if (!function_exists('current_currency')) {
    function current_currency()
    {
        if ($user = auth()->user()) {
            return $user->currency;
        }

        return \App\Enums\Currency::EUR;
    }
}

/**
 * Generate random Subnet
 *
 * @return string
 */
if (!function_exists('random_subnet')) {
    function random_subnet()
    {
        return mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '/24';
    }
}

/**
 * Generate random ip
 *
 * @return string
 */
if (!function_exists('random_ip')) {
    function random_ip()
    {
        return mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255);
    }
}

/**
 * Return laravel auth class facade
 *
 * @return \Auth
 */
if (!function_exists('auth')) {
    function auth()
    {
        return new \Auth;
    }
}

/**
 * Return laravel auth class with guard facade
 *
 * @param string $guardName
 * @return Guard
 */
if (!function_exists('authGuard')) {
    function authGuard(string $guardName = 'guest')
    {
        return \Auth::guard($guardName);
    }
}

/**
 * Check if current user is authenticated
 *
 * @return bool
 */
if (!function_exists('is_authenticated')) {
    function is_authenticated()
    {
        return auth()->check();
    }
}

/**
 * Get auth user instantly
 *
 * @return User|null
 */
if (function_exists('authUser')) {
    function authUser()
    {
        return auth()->check() ?
            auth()->user() :
            null;
    }
}

/**
 * Get auth user id instantly
 *
 * @return string|int|null
 */
if (!function_exists('authUserId')) {
    function authUserId()
    {
        if (!auth()->check()) {
            return null;
        }

        return auth()->user()->id;
    }
}

/**
 * Get Admin id instantly
 *
 * @return string|int|null
 */
if (!function_exists('authAdminUserId')) {
    function authAdminUserId()
    {
        if (!auth()->guard('admin')->check()) return null;

        return auth()->guard('admin')->user()->id;
    }
}

/**
 * Get auth user key instantly
 *
 * @return string|int
 */
if (!function_exists('authUserKey')) {
    function authUserKey()
    {
        return auth()->check() ?
            auth()->user()->user_key :
            null;
    }
}

/**
 * Get auth user type instantly
 *
 * @return string|null
 */
if (!function_exists('authUserType')) {
    function authUserType()
    {
        return auth()->user()->type;
    }
}

/**
 * Get auth user profile instantly
 *
 * @return \App\Models\UserProfile|null
 */
if (!function_exists('authProfile')) {
    function authProfile()
    {
        return auth()->user()->userProfile;
    }
}

/**
 * Get user's profile image stored in session
 *
 * @return string
 */
if (!function_exists('session_profile_image')) {
    function session_profile_image()
    {
        return session('pro_img', null);
    }
}

/**
 * Get path of image placeholder from config value
 *
 * @return string
 */
if (!function_exists('image_placeholder')) {
    function image_placeholder()
    {
        return config('globalArray.IMAGE_PLACEHOLDER');
    }
}

/**
 * Destructure object class into array
 *
 * @param Object $class
 * @param array $attributes
 * @return array
 */
if (!function_exists('dest_obj_to_arr')) {
    function dest_obj_to_arr($class, array $attributes)
    {
        $result = [];

        foreach ($attributes as $attribute) {
            $result[$attribute] = $class->{$attribute};
        }

        return $result;
    }
}

/**
 * Get laravel current page
 *
 * @return int
 */
if (!function_exists('current_page')) {
    function current_page()
    {
        return request()->input(
            'page',
            request()->input('current_page', 1)
        );
    }
}

/**
 * Get laravel current page
 *
 * @return int
 */
if (!function_exists('pagination_size')) {
    function pagination_size()
    {
        return request()->input(
            'per_page',
            request()->input(
                'page_size',
                request()->input('pagination_size', 10)
            )
        );
    }
}

/**
 * Create log of the application
 *
 * @param array $parameters
 * @return Log
 */
if (!function_exists('create_log')) {
    function create_log(array $parameters)
    {
        return Log::create($parameters);
    }
}

/**
 * Record log using log service.
 *
 * @param string $type
 * @param array $resources
 * @param string $message
 * @return bool
 */
if (!function_exists('record_log')) {
    function record_log(
        string $type,
        string $message = '',
        array $resources = []
    ): bool {
        $service = app(\App\Services\Utility\LogService::class);

        return $service->write($type, $message, $resources);
    }
}

/**
 * Send SMS to a certain phone number
 *
 * @param string $phoneNumber
 * @param string $content
 * @return void
 */
if (!function_exists('send_sms')) {
    function send_sms(string $phoneNumber, string $content = 'Blank')
    {
        $twilio = new \App\Services\TwilioService();
        return $twilio->sendSms($phoneNumber, $content);
    }
}

/**
 * Get one-all social login headers for Guzzle
 *
 * @return array
 */
if (!function_exists('oneall_headers')) {
    function oneal_headers()
    {
        //
    }
}

/**
 * Send email to target mail
 *
 * @param string $recipient
 * @param string $subject
 * @param string $content
 * @return void
 */
if (!function_exists('send_mail')) {
    function send_mail(
        string $recipient,
        string $subject,
        string $content
    ): void {
        $service = new \App\Services\EmailService;
        $service->send($recipient, $subject, $content);
    }
}

/**
 * Return requester's IP address
 *
 * @return string
 */
if (!function_exists('request_ip')) {
    function request_ip()
    {
        if (request()->ip() == '127.0.0.1') {
            return env('IP_ADDRESS', '116.68.101.232');
        }

        return request()->ip();
    }
}

if (!function_exists('request_ip_detail')) {
    /**
     * Get requester information details using IP
     *
     * @param string $ipAddress
     * @return array
     * @throws Exception
     * @see \Tests\Unit\Helpers\HelpersTest::test_request_ip_detail()
     *      To the helper method unit tester method.
     */
    function request_ip_detail(string $ipAddress = ''): array
    {
        // Prepare IP address as subject of the operation
        $ipAddress = $ipAddress ?: request_ip();
        $ipAddress = ($ipAddress == '127.0.0.1') ?
            '111.92.73.81' : $ipAddress;

        $ipApiService = new \App\Services\IpApiLocationService();
        $ipApiService->setIp($ipAddress);

        return (array)$ipApiService->findLocation(true);
    }
}

if (!function_exists('request_ip_timezone')) {
    /**
     * Get current requester timezone based on the IP address.
     *
     * @return string
     * @throws Exception
     */
    function request_ip_timezone(): string
    {
        $ipDetail = request_ip_detail();

        return $ipDetail['timezone'] ??
            config('app.timezone');
    }
}

/**
 * Convert stdClass instance to array
 *
 * @param stdClass $object
 * @return array
 */
if (!function_exists('stdclass_to_array')) {
    function stdclass_to_array(stdClass $object)
    {
        return json_decode(json_encode($object), true);
    }
}

/**
 * Get certain env variable with condition.
 * If true then get value from second parameter as env attribute.
 * If false do for the third parameter
 *
 * @param bool $condition
 * @param string $firstEnvAttr
 * @param string $secondEnvAttr
 * @param mixed $defaultValue
 * @return mixed
 */
if (!function_exists('which_env')) {
    function which_env(
        bool $condition,
        string $firstEnvAttr,
        string $secondEnvAttr,
        $defaultValue = null
    ) {
        $attr = $condition ? $firstEnvAttr : $secondEnvAttr;

        return env($attr, $defaultValue);
    }
}

/**
 * Get current pagination information including
 * `page` and `per_page`.
 *
 * @return array
 */
if (!function_exists('pagination_info')) {
    function pagination_info()
    {
        return request()->only([
            'page',
            'per_page'
        ]);
    }
}

/**
 * Apply resource class for pagination collection
 *
 * @param string $resourceClass
 * @param LengthAwarePaginator $pagination
 * @return LengthAwarePaginator
 */
if (!function_exists('pagination_apply_resource')) {
    function pagination_apply_resource(string $resourceClass, $pagination)
    {
        $collection = $resourceClass::collection($pagination);

        $pagination->setCollection($collection);

        return $pagination;
    }
}

/**
 * Get time interval of friend request
 *
 * @return int
 */
if (!function_exists('request_interval')) {
    function request_interval()
    {
        return App\Models\RequestVariable::first()->time_interval;
    }
}

/**
 * Get random element in an array
 *
 * @param array $haystack
 * @return mixed
 */
if (!function_exists('array_random_element')) {
    function array_random_element(array $haystack)
    {
        return array_rand($haystack, 1)[0];
    }
}

/**
 * Get max phone view count
 *
 * @return int
 */
if (!function_exists('max_phone_view')) {
    function max_phone_view()
    {
        if (!$maxPhoneView = cache()->get('max_phone_view', 0)) {
            $variable = \App\Models\ViewPhonenumberVariable::first() ?:
                \App\Models\ViewPhonenumberVariable::create([
                    'max_phone_view' => 50,
                    'error_msg' => 'Failed to get set amount of max phone view',
                ]);

            $maxPhoneView = $variable->max_phone_view;
            cache()->put('max_phone_view', $maxPhoneView);
        }

        return $maxPhoneView;
    }
}

/**
 * Patch for upgrade of `factory()` method in older laravel version.
 *
 * @return Factory
 */
if (!function_exists('factory')) {
    function factory(
        string $model,
        int $quantity = 1
    ): Illuminate\Database\Eloquent\Factories\Factory {
        return $quantity > 1 ?
            (new $model)->factory($quantity) : (new $model)->factory();
    }
}

if (!function_exists('fake_safe_email')) {
    /**
     * Create safe email using factory and add it with timestamp.
     *
     * @return string
     */
    function fake_safe_email(): string
    {
        $faker = Faker\Factory::create();

        $safeEmail = $faker->safeEmail;

        $explode = explode('@', $safeEmail);
        $explode[0] = $explode[0] . strtolower(random_string(10));
        $explode[1] = 'gmail.com';

        return implode('@', $explode);
    }
}

/**
 * Get array collection of CORS headers.
 *
 * @return array
 */
if (!function_exists('cors_headers')) {
    function cors_headers(): array
    {
        return [
            'X-Container-Meta-Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => '*',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Expose-Headers' => 'Origin, X-Requested-With, Content-Type, Accept, Authorization',
            'Access-Control-Request-Headers' => 'Origin, X-Requested-With, Content-Type, Accept, Authorization'
        ];
    }
}

if (!function_exists('test_path')) {
    /**
     * Get the test folder relative path.
     *
     * @param string $path
     * @return string
     */
    function test_path(string $path = ''): string
    {
        return concat_paths(
            [base_path(), 'tests', $path],
            true,
            true
        );
    }
}

if (!function_exists('table_exists')) {
    /**
     * Check whether specified table is existing.
     *
     * @param string $table
     * @return bool
     */
    function table_exists(string $table): bool
    {
        return \Illuminate\Support\Facades\Schema::hasTable($table);
    }
}

if (!function_exists('column_exists')) {
    /**
     * Check whether specified column in certain table exists.
     *
     * @param string $table
     * @param string $column
     * @return bool
     */
    function column_exists(string $table, string $column): bool
    {
        return \Illuminate\Support\Facades\Schema::hasColumn($table, $column);
    }
}

if (!function_exists('not')) {
    /**
     * Turn the statement
     *
     * @param string|bool $statement
     * @return bool
     */
    function not(string|bool $statement): bool
    {
        return !strtobool($statement);
    }
}

if (!function_exists('is_not_null')) {
    /**
     * Check whether specified statement is null or not.
     *
     * @param mixed $statement
     * @return bool
     */
    function is_not_null(mixed $statement): bool
    {
        return (!is_null($statement));
    }
}

if (!function_exists('application_stripe_product_name')) {
    /**
     * Get application name based on current environment.
     *
     * @return string
     */
    function application_stripe_product_name(): string
    {
        $environment = config('app.env');

        return match (true) {
            in_array($environment, ['local', 'testing', 'development']) =>
            config('globalArray.TEST_PRODUCT_NAME'),
            in_array($environment, ['production', 'preproduction', 'live']) =>
            config('globalArray.PRODUCT_NAME'),

            default => 'Rent-A-Friend',
        };
    }
}

if (!function_exists('getEndDate')) {
    /**
     * Find End Date of subscription
     * @param SubscriptionPackage $package
     *
     * @return   Carbon
     */
    function getEndDate(SubscriptionPackage $package)
    {
        if ($package->duration_in_days == 365) {

            $endDate = carbon()->addYear();
        } elseif ($package->duration_in_days == 30) {

            $endDate = carbon()->addMonth();
        } else {
            $endDate = now()->addDays($package->duration_in_days);
        }
        return $endDate;
    }
}

if (!function_exists('friends_with_info')) {
    /**
     * Get Friend interest
     *
     * @param Collection $userGender
     * @param int $male_count
     * @param int $female_count
     * @return array
     */
    function friends_with_info(Collection $userGender, int $male_count, int $female_count): array
    {
        $info = array();
        $interested_in = array();
        $interested_in_male = 0;
        $interested_in_female = 0;
        $all_gender_count = $male_count + $female_count;
        foreach ($userGender as $genderInfo) {
            array_push($interested_in, ucwords($genderInfo->gender_type));
            if ($genderInfo->type == GenderType::Male) {
                $interested_in_male++;
            }
            if ($genderInfo->type == GenderType::Female) {
                $interested_in_female++;
            }
        }
        $interested_in_total = $interested_in_male + $interested_in_female;
        if ($interested_in_total == $all_gender_count) {
            array_push($info, 'Everyone');
            return $info;
        } else if ($interested_in_male == $male_count && $interested_in_female == 0) {
            array_push($info, 'Only Men');
            return $info;
        } else if ($interested_in_female == $female_count && $interested_in_male == 0) {
            array_push($info, 'Only Women');
            return $info;
        } else {
            return $interested_in;
        }
    }
}

if (!function_exists('mailgun_list_name')) {
    /**
     * Get Mailgun list name
     *
     * @param string $list_name
     * @return string
     */
    function mailgun_list_name(string $list_name): string
    {
        if (!strpos($list_name, '@')) {
            $list_name = $list_name . '@' . config('mailgun.domain');
        }

        return $list_name;
    }
}
