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

class CyberpanelApi_UpdateAccountPackage extends CyberpanelApiTest
{
    /**
     * The test to run in web server environments.
     */
    public function test()
    {
        try {
            // Set data for the test
            $domain = 'user' . rand(0, 9999) . '.com';
            $new_package = 'Default';

            // Request parameters to the user
            $this->request('domain', $domain);
            $this->request('new_package', $new_package);

            // Set the input of the function
            $this->setInput($this->request->domain, $this->request->new_package);

            // Create a test account only if is random-generated
            if ($this->isExpected($this->request->domain, $domain)) {
                // Set the parameters array
                $params = [
                    'username' => 'user' . rand(0, 9999),
                    'password' => base64_encode(rand(0, 9999) . time()),
                    'email' => 'user' . rand(0, 9999) . '@' . $this->request->domain,
                    'domain' => $this->request->domain,
                    'package' => 'Default'
                ];

                $this->instance->createAccount($params);
            }

            // Call function to test
            $result = $this->instance->updateAccountPackage($this->request->domain, $this->request->new_package);

            // Validate function result
            if ($this->isObject($result) && $this->isNotEmpty($result->changePackage)) {
                $this->passTest();
            }

            // Delete test account only if is random-generated, keep if is user-provided
            if ($this->isExpected($this->request->domain, $domain)) {
                $this->instance->deleteAccount($this->request->domain);
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
