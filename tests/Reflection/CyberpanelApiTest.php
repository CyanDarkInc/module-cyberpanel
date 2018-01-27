<?php
/**
 * Performs all initialization operations necessary to execute the tests.
 *
 * @copyright Copyright (c) 2018, CyanDark, Inc.
 * @author CyanDark, Inc <support@cyandark.com>
 * @link http://www.cyandark.com/ CyanDark
 */

namespace CyanDark\UnitTest\Reflection;

use CyanDark\UnitTest\TestClass as TestClass;

class CyberpanelApiTest extends TestClass
{
    /**
     * @var array The configuration parameters required by the class to be tested
     */
    public $config = [
        'hostname' => 'cyberpanel.cyandark.co',
        'username' => 'admin',
        'password' => '1234567'
    ];

    /**
     * Initializes the class that will be tested.
     *
     * @param  array $config An array containing the configuration parameters
     * @return mixed An instance of the class that will be tested
     */
    public function initialization($config)
    {
        try {
            $api = new \CyberpanelApi($config['hostname'], $config['username'], $config['password']);
        } catch (\Exception $e) {
            $this->failTest();
        }

        return $api;
    }
}
