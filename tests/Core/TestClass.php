<?php
/**
 * Abstract class that all the reflection or tests classes must extend.
 *
 * @copyright Copyright (c) 2018, CyanDark, Inc.
 * @author CyanDark, Inc <support@cyandark.com>
 * @link http://www.cyandark.com/ CyanDark
 */

namespace CyanDark\UnitTest;

abstract class TestClass
{
    /**
     * @var array The configuration parameters required by the class to be tested.
     */
    public $config = [];

    /**
     * @var mixed The instance of the class to test.
     */
    public $instance;

    /**
     * @var stdClass An object containing the requested parameters.
     */
    public $request;

    /**
     * @var mixed The output of the test function.
     */
    private $output;

    /**
     * @var mixed The input of the test function.
     */
    private $input;

    /**
     * @var mixed The status of the test.
     */
    private $status = false;

    /**
     * Execute initialization.
     */
    public function __construct()
    {
        $this->instance = $this->initialization($this->config);
    }

    /**
     * Initializes the class that will be tested.
     *
     * @param  array $config An array containing the configuration parameters.
     * @return mixed An instance of the class that will be tested.
     */
    public function initialization($config)
    {
    }

    /**
     * Set the output of the test function.
     *
     * @param mized $result The result of the test funcion.
     */
    public function setOutput($result = null)
    {
        $this->output = $result;
    }

    /**
     * Get the previous saved output of the test function.
     *
     * @return mixed The saved output.
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Set the input parameters of the test function.
     */
    public function setInput()
    {
        $this->input = func_get_args();

        if (empty($this->input)) {
            $this->input = null;
        }
    }

    /**
     * Get the previous saved input parameters of the test function.
     *
     * @return mixed The saved parameters.
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Mark the test as successfully passed.
     */
    public function passTest()
    {
        $this->status = true;
    }

    /**
     * Mark the test as failed.
     */
    public function failTest()
    {
        $this->status = false;
    }

    /**
     * Get the status of the test.
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Request a parameter to the user.
     *
     * @param string $name The name of the field.
     * @param string $value The default value of the field.
     */
    public function request($name, $value)
    {
        if (empty($this->request)) {
            $this->request = new \stdClass();
        }

        if (isset($_POST[$name])) {
            $this->request->{$name} = $_POST[$name];
        } else {
            $this->request->{$name} = $value;
        }
    }

    /**
     * Execute the test.
     */
    public function test()
    {
    }

    /**
     * Execute the CLI test.
     */
    public function testCli()
    {
    }

    /**
     * Check if a given input is a string.
     *
     * @param  mixed   $result The input to validate.
     * @return bool True if is a string, false otherwise.
     */
    public function isString(&$result)
    {
        return is_string($result);
    }

    /**
     * Check if a given input is a integer.
     *
     * @param  mixed   $result The input to validate.
     * @return bool True if is a integer, false otherwise.
     */
    public function isInteger(&$result)
    {
        return is_int($result);
    }

    /**
     * Check if a given input is a float.
     *
     * @param  mixed   $result The input to validate.
     * @return bool True if is a float, false otherwise.
     */
    public function isFloat(&$result)
    {
        return is_float($result);
    }

    /**
     * Check if a given input is an array.
     *
     * @param  mixed   $result The input to validate.
     * @return bool True if is an array, false otherwise.
     */
    public function isArray(&$result)
    {
        return is_array($result);
    }

    /**
     * Check if a given input is boolean.
     *
     * @param  mixed   $result The input to validate.
     * @return bool True if is an array, false otherwise.
     */
    public function isBool(&$result)
    {
        return is_bool($result) || (int) $result == 0;
    }

    /**
     * Check if a given input is an object.
     *
     * @param  mixed   $result The input to validate
     * @return bool True if is an object, false otherwise
     */
    public function isObject(&$result)
    {
        return is_object($result);
    }

    /**
     * Check if a given input is callable.
     *
     * @param  mixed   $result The input to validate.
     * @return bool True if is callable, false otherwise.
     */
    public function isCallable(&$result)
    {
        return is_callable($result);
    }

    /**
     * Check if a given input is a equal to another.
     *
     * @param  mixed   $result   The input to validate.
     * @param  mixed   $expected The input to compare.
     * @return bool True if both input are equal, false otherwise.
     */
    public function isExpected(&$result, &$expected)
    {
        return $result === $expected;
    }

    /**
     * Check if a given input is different to another.
     *
     * @param  mixed   $result   The input to validate.
     * @param  mixed   $expected The input to compare.
     * @return bool True if both input are different, false otherwise.
     */
    public function isDifferent(&$result, &$expected)
    {
        return $result == !$expected;
    }

    /**
     * Check if a given input is empty.
     *
     * @param  mixed   $result The input to validate.
     * @return bool True if the input is empty, false otherwise.
     */
    public function isEmpty(&$result)
    {
        return empty($result);
    }

    /**
     * Check if a given input is not empty.
     *
     * @param  mixed   $result The input to validate.
     * @return bool True if the input is not empty, false otherwise.
     */
    public function isNotEmpty(&$result)
    {
        return !empty($result);
    }

    /**
     * Check if a given input is an instance of another.
     *
     * @param  mixed   $instance The instance to validate.
     * @param  mixed   $expected The expected instance.
     * @return bool True if the instance is equal to the expected one, false otherwise.
     */
    public function isInstanceOf(&$instance, $expected)
    {
        return $instance instanceof $expected;
    }
}
