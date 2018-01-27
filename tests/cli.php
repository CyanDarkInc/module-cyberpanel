<?php

// Initialize the bootstraping operations
require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Execute given test
if (php_sapi_name() === 'cli') {
    $results = [];
    $failed = false;
    foreach ($available_tests as $category => $classes) {
        foreach ($classes as $test) {
            try {
                $class_test = new $test['class']();
                $class_test->test();

                $status = $class_test->getStatus();
                $result = $class_test->getOutput();
                $input = $class_test->getInput();

                $results[$category][$test['name']] = ($status ? 'Passed' : 'Failed');

                if ($status === false) {
                    $failed = true;
                }
            } catch (Exception $e) {
                $results[$category][$test['name']] = [
                    'Status' => 'Failed',
                    'Exception' => $e
                ];

                $failed = true;
            }
        }
    }
}

// Print result
print_r($results);

// Exit the script
if ($failed) {
    exit(255);
}
