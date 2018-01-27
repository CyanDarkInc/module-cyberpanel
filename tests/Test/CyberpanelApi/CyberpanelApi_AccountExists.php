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

class CyberpanelApi_AccountExists extends CyberpanelApiTest
{
    /**
     * The test to run in web server environments.
     */
    public function test()
    {
        try {
            // Set data for the test
            $username = 'user' . rand(0, 9999);

            // Request parameters to the user
            $this->request('username', $username);

            // Set the input of the function
            $this->setInput($this->request->username);

            // Create a test account only if is random-generated
            if ($this->isExpected($this->request->username, $username)) {
                // Set the parameters array
                $params = [
                    'username' => $this->request->username,
                    'password' => base64_encode(rand(0, 9999) . time()),
                    'email' => $this->request->username . '@' . $this->request->username . '.com',
                    'domain' => $this->request->username . '.com',
                    'package' => 'Default'
                ];

                $this->instance->createAccount($params);
            }

            // Call function to test
            $result = $this->instance->accountExists($this->request->username);

            // Validate function result
            if ($this->isBool($result)) {
                $this->passTest();
            }

            // Delete test account only if is random-generated, keep if is user-provided
            if ($this->isExpected($this->request->username, $username)) {
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
