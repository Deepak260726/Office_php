<?php

namespace App\Http\Middleware;

use Illuminate\Support\Str;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class XssSanitizer
{
    /**
     * Disallowed Strings in the input parameters
     *
     * @var array
     */
    protected $disallowed_strings = [
        '<script>',
        '</script>',
        '&lt;script&gt;',
        '&lt;/script&gt;',
        'alert(',
        'iframe',
        'onclick',
        'onmouseover',
        '!',
        '[',
        ']',
    ];


    /**
     * Allowed HTML Tags
     *
     * @var array
     */
    protected $allowd_html_tags = [
        '<p>',
        '<strong>',
        '<em>',
        '<u>',
        '<s>',
        '<br>',
    ];


    /**
     * Allowed Input Fields with special characters
     *
     * @var array
     */
    protected $allowd_fields = [
        'sql',
        'password',
    ];

    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $input = $request->all();

        array_walk_recursive($input, function (&$input, $key) {

            if(!is_array($input) && !is_object($input) && $input != '' && $input != null && !in_array($key,$this->allowd_fields)) {
                if(Str::contains(\html_entity_decode(strtolower($input)), $this->disallowed_strings) === true) {
                    Log::error('Xss Filter - Disallowed content found for ' . $key . ' / value: ' .$input);
                    abort(403);
                }

                $input = strip_tags($input, $this->allowd_html_tags);
            }
            
        });

        $request->merge($input);

        return $next($request);
    }
}
