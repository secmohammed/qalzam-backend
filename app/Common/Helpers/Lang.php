<?php

if (!function_exists('__')) {
    /**
     * Translate the given message.
     *
     * @param string|null $key
     * @param array $replace
     * @param string|null $locale
     * @return string|array|null
     */
    function __($key = null, $replace = [], $locale = null)
    {
        if (is_null($key)) {
            return $key;
        }
        return trans($key, $replace, $locale ?? session('lang') ?? config('app.locale'));
    }
}


/**
 * Get The Common Languages.
 *
 * @return array
 */
function AppLanguages(): array
{
    return ['ar', 'en'];
}

/**
 * Get The Common Locale.
 *
 * @return string
 */
function GetLanguage() : string
{
    return session('lang') == null ? GetDefaultLang() : app()->getLocale();
}

/**
 * Get's The Site Direction.
 *
 * @return string
 */
function GetDirection() : string
{
    return GetLanguage() == 'ar' ? 'rtl' : 'ltr';
}

/**
 * Get's The Default Language.
 *
 * @return string
 */
function GetDefaultLang() : string
{
    return config('app.locale');
}

/**
 * if design isRtl.
 *
 * @return bool.addRtl().
 */
function isRtl() : bool
{
    return GetLanguage() == 'ar' ? true : false;
}

/**
 * @param $language
 * @param $key
 * @return string
 */
function GetLanguageValues($language, $key) : string
{
    return config('languages.language.'.$language)[$key];
}

function addRtl(): string
{
    return GetDirection() == 'rtl' ? '.rtl' : '';
}
