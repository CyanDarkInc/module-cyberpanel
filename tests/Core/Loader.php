<?php
/**
 * Loader class for bootstrap operations.
 *
 * @copyright Copyright (c) 2018, CyanDark, Inc.
 * @author CyanDark, Inc <support@cyandark.com>
 * @link http://www.cyandark.com/ CyanDark
 */

namespace CyanDark\UnitTest;

final class Loader
{
    /**
     * Load all the classes inside of a folder.
     *
     * @param  mixed $dir The directory to scan, of an array or dirs.
     * @return array An array containing all the directory paths.
     */
    public static function loadClasses($dir)
    {
        if (is_array($dir)) {
            $files = [];

            foreach ($dir as $directory) {
                $files[] = self::getDirectoryFiles($directory, true, true);
            }

            $files = self::collapseArray($files, true);
        } else {
            $files = self::getDirectoryFiles($dir, true, true);
        }

        foreach ($files as $key => $file) {
            $file_name = explode('.', $file);
            $extension = end($file_name);

            if ($extension === 'php') {
                include_once $file;
            } else {
                unset($files[$key]);
            }
        }

        return $files;
    }

    /**
     * Returns an array with all the classes inside of a folder.
     *
     * @param  mixed $dir The directory to scan, of an array or dirs.
     * @return array An array containing all the classes.
     */
    public static function getClasses($dir)
    {
        if (is_array($dir)) {
            $files = [];

            foreach ($dir as $directory) {
                $files[] = self::getDirectoryFiles($directory, true, true);
            }

            $files = self::collapseArray($files, true);
        } else {
            $files = self::getDirectoryFiles($dir, true, true);
        }

        foreach ($files as $key => $file) {
            $file_name = explode(DIRECTORY_SEPARATOR, $file);
            $file_name = end($file_name);

            $extension = explode('.', $file_name);
            $extension = end($extension);

            if ($extension == !'php' || !is_file($file) || substr($file_name, 0, 1) == '.') {
                unset($files[$key]);
            }
        }

        return $files;
    }

    /**
     * Read the files and folders of a directory.
     *
     * @param  string $dir       The full path of the directory.
     * @param  bool   $flat      True to return a flat array, Otherwise will be returned a matrix.
     * @param  bool   $recursive True to scan de directory recursively.
     * @return array  An array containing the directory structure.
     */
    private static function getDirectoryFiles($dir, $flat = true, $recursive = false)
    {
        if (is_dir($dir)) {
            $content = array_values(array_diff(scandir($dir), ['.', '..']));

            if ($recursive || $flat) {
                foreach ($content as $key => $entry) {
                    $path = DIRECTORY_SEPARATOR . trim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $entry;

                    if (is_dir($path)) {
                        $path = $path . DIRECTORY_SEPARATOR;
                    }

                    if ($flat) {
                        $content[$key] = $path;
                    }

                    if (is_dir($path) && $recursive && !$flat) {
                        $content[$entry] = self::getDirectoryFiles($path, $flat);
                        unset($content[$key]);
                    } elseif (is_dir($path) && $recursive && $flat) {
                        $content[$path] = $path;
                        $content[$key] = self::getDirectoryFiles($path, $flat);
                    }
                }
            }

            if ($flat) {
                $content = self::collapseArray($content, true);
            }

            return $content;
        }

        return [];
    }

    /**
     * Collapse an array of arrays into a single array.
     *
     * @param  array $array       The array to collapse.
     * @param  bool  $multi_level Collapse all the levels of the matrix.
     * @return mixed The resultant array.
     */
    private static function collapseArray($array, $multi_level = false)
    {
        $result = [];

        if (is_array($array)) {
            foreach ($array as $sub_array) {
                if (is_array($sub_array)) {
                    foreach ($sub_array as $value) {
                        if (is_array($value) && $multi_level) {
                            $result = array_merge($result, self::collapseArray($value, true));
                        } else {
                            $result[] = $value;
                        }
                    }
                } else {
                    $result[] = $sub_array;
                }
            }

            return $result;
        }

        return $array;
    }
}
