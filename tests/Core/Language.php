<?php
/**
 * Language class for localization and app translation.
 *
 * @copyright Copyright (c) 2018, CyanDark, Inc.
 * @author CyanDark, Inc <support@cyandark.com>
 * @link http://www.cyandark.com/ CyanDark
 */

namespace CyanDark\UnitTest;

class Language
{
    /**
     * @var array The language definitions.
     */
    private static $lang = [];

    /**
     * Load an specific language file.
     *
     * @param string $lang_file The language file name.
     */
    public static function loadLanguage($lang_file)
    {
        $lang = [];

        if (file_exists(LANGUAGES_DIR . DIRECTORY_SEPARATOR . $lang_file . '.php')) {
            require_once LANGUAGES_DIR . DIRECTORY_SEPARATOR . $lang_file . '.php';
        } else {
            $languages = Loader::getClasses(LANGUAGES_DIR);
            require_once $languages[0];
        }

        self::$lang = $lang;
    }

    /**
     * Get the current language of the user.
     *
     * @return string The ISO language code.
     */
    public static function getUserLang()
    {
        $localization = str_replace('_', '-', strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']));
        $lang = explode('-', $localization, 2);
        $lang = $lang[0];

        return $lang;
    }

    /**
     * Returns a language definition.
     *
     * @param  string $text_key The key of the language definition.
     * @return string The language definition.
     */
    public static function lang($text_key)
    {
        $args = func_get_args();
        $text = isset(self::$lang[$text_key]) ? self::$lang[$text_key] : $text_key;

        if (count($args) > 1) {
            $args[0] = $text;
            $text = call_user_func_array('sprintf', $args);
        }

        return $text;
    }
}
