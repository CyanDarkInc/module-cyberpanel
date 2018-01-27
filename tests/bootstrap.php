<?php
/**
 * Performs all of the bootstrap operations necessary to begin execution.
 * Includes all of the core files as well as sets global constants used
 * throughout the app.
 *
 * @copyright Copyright (c) 2018, CyanDark, Inc.
 * @author CyanDark, Inc <support@cyandark.com>
 * @link http://www.cyandark.com/ CyanDark
 */
use CyanDark\UnitTest\Loader as Loader;
use CyanDark\UnitTest\Language as Language;

// Require the config file
require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

// Load the Loader class
require_once CORE_DIR . DIRECTORY_SEPARATOR . 'Loader.php';

// Load all the necessary classes in an specific order
Loader::loadClasses([CORE_DIR, CLASSES_DIR, REFLECTIONS_DIR, TESTS_DIR]);

// Initialize class aliases, that will be registered when this application is started
class_alias('CyanDark\\UnitTest\\Language', 'Language');

// Load language file
$lang = Language::getUserLang();
Language::loadLanguage($lang);

// List all the available tests
$tests = Loader::getClasses(TESTS_DIR);
$available_tests = [];

foreach ($tests as $test) {
    $file_name = explode(DIRECTORY_SEPARATOR, $test);
    $file_name = end($file_name);

    $class = trim(trim($file_name, 'php'), '.');
    $delta = explode('_', $class);
    $category = $delta[0];
    $name = $delta[1];

    $available_tests[$category][] = [
        'name' => $name,
        'class' => $class
    ];
}
