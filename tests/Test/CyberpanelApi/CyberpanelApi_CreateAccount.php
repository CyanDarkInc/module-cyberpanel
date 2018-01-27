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

class CyberpanelApi_CreateAccount extends CyberpanelApiTest
{
    /**
     * The test to run in web server environments.
     */
    public function test()
    {
        try {
            // Set data for the test
            $username = 'user' . rand(0, 9999);
            $password = base64_encode(rand(0, 9999) . time());
            $domain = $username . '.com';
            $email = $username . '@' . $domain;
            $package = 'Default';

            // Request parameters to the user
            $this->request('username', $username);
            $this->request('password', $password);
            $this->request('domain', $domain);
            $this->request('email', $email);
            $this->request('package', $package);

            // Set the parameters array
            $params = [
                'username' => $this->request->username,
                'password' => $this->request->password,
                'email' => $this->request->email,
                'domain' => $this->request->domain,
                'package' => $this->request->package
            ];

            // Set the input of the function
            $this->setInput($params);

            // Call function to test
            $result = $this->instance->createAccount($params);

            // Validate function result
            if ($this->isObject($result) && $this->isNotEmpty($result->createWebSiteStatus)) {
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
