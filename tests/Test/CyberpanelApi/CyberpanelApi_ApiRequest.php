<?php
/**
 * Performs all the necessary tests for an specific function
 * of the instanced class.
 *
 * @copyright Copyright (c) 2018, CyanDark, Inc.
 * @author CyanDark, Inc <support@cyandark.com>
 * @link http://www.cyandark.com/ CyanDark
 */
use CyanDark\UnitTest\Reflection\CyberpanelApiTest as CyberpanelApiTest;

class CyberpanelApi_ApiRequest extends CyberpanelApiTest
{
    /**
     * The test to run in web server environments.
     */
    public function test()
    {
        try {
            // Set the input of the function
            $this->setInput('verifyConn');

            // Call function to test
            $result = $this->instance->apiRequest('verifyConn');

            // Validate function result
            if ($this->isObject($result) && $this->isNotEmpty($result)) {
                $this->passTest();
            }

            // Set the output of the tested function
            $this->setOutput($result);
        } catch (Exception $e) {
            $result = $e;
            $this->setOutput($result);
            $this->failTest();
        }
    }

    /**
     * The test to run in CLI environments.
     */
    public function testCli()
    {
        return $this->test();
    }
}
