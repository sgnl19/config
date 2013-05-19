<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 textwidth=75: *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Copyright (c) 2012 - 2013, The Lousson Project                        *
 *                                                                       *
 * All rights reserved.                                                  *
 *                                                                       *
 * Redistribution and use in source and binary forms, with or without    *
 * modification, are permitted provided that the following conditions    *
 * are met:                                                              *
 *                                                                       *
 * 1) Redistributions of source code must retain the above copyright     *
 *    notice, this list of conditions and the following disclaimer.      *
 * 2) Redistributions in binary form must reproduce the above copyright  *
 *    notice, this list of conditions and the following disclaimer in    *
 *    the documentation and/or other materials provided with the         *
 *    distribution.                                                      *
 *                                                                       *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   *
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     *
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS     *
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE        *
 * COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,            *
 * INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES    *
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR    *
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)    *
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,   *
 * STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)         *
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED   *
 * OF THE POSSIBILITY OF SUCH DAMAGE.                                    *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/**
 *  Lousson\Config\AbstractConfigTest class definition
 *
 *  @package    org.lousson.config
 *  @copyright  (c) 2012 - 2013, The Lousson Project
 *  @license    http://opensource.org/licenses/bsd-license.php New BSD License
 *  @author     Attila Levai <alevai at quirkies.org>
 *  @author     Mathias J. Hennig <mhennig at quirkies.org>
 *  @filesource
 */
namespace Lousson\Config;

/** Dependencies: */
use Lousson\Config\AnyConfig;
use PHPUnit_Framework_TestCase;

/**
 *  Abstract test case for AnyConfig implementation
 *
 *  The AbstractConfigTest class is a basement for testing implementations
 *  of the AnyConfig interface.
 *
 *  @since      lousson/config-0.1.0
 *  @package    org.lousson.config
 */
abstract class AbstractConfigTest extends PHPUnit_Framework_TestCase
{
    /**
     *  Obtain the config to test
     *
     *  The getConfig() method returns the instance of the AnyConfig
     *  interface that is to be tested. It will be pre-set with the given
     *  $options.
     *
     *  @param  array   $options    The options to apply
     *
     *  @return \Lousson\Config\AnyConfig
     *          A config instance is returned on success
     */
    abstract function getConfig(array $options);

    /**
     *  Obtain key/value pairs for testing
     *
     *  The getTestData() method returns an associative array of key/value
     *  pairs of different types. This is used e.g. within data providers,
     *  to pre-set configuration options to test.
     *
     *  @return array
     *          An array of scalar key/value pairs is returned on success
     */
    public function getTestData()
    {
        return array(
            "" => "#EMPTY#", "null" => null, true => "TRUE",
            "alpha" => "ALPHA", "beta" => "BETA", "123" => 123,
            "float" => -12.3, "a/b/c" => "A/B/C", "x.y.z" => "X/Y/Z",
        );
    }

    /**
     *  Provide configuration objects to test
     *
     *  The provideTestConfig() method is a data-provider that will return
     *  an array of zero or more items, each of whose is an array itself.
     *  The "inner" arrays' first item is an instance of the configuration
     *  class to test, whilst the latter item is an associative array of
     *  key/value pairs representing the configuration directives stored
     *  in the object.
     *
     *  @return array
     *          An array of test parameters is returned on success
     */
    public function provideTestConfig()
    {
        $data = $this->getTestData();
        $config = $this->getConfig($data);

        return array(array($config, $data));
    }

    /**
     *  Provide configuration data to test
     *
     *  The provideTestData() method is a data-provider that will
     *  return an array of zero or more items, each of whose will be an
     *  array itself.
     *  The "inner" arrays' first item is meant as a key or configuration
     *  directive, whilst the latter is meant as the associated value.
     *  This is used to e.g. test setters of configuration implementations,
     *  if any.
     *
     *  @return array
     *          An array of test parameters is returned on success
     */
    public function provideTestData()
    {
        $data = $this->getTestData();
        $testData = array();

        foreach ($data as $key => $value) {
            $testData[] = array($key, $value);
        }

        return $testData;
    }

    /**
     *  Provide configuration parameter to test
     *
     *  The provideTestParameter() method is a data-provider that will
     *  return an array of zero or more items, each of whose will be an
     *  array itself.
     *  The "inner" arrays' first item is the configuration object to be
     *  tested, the second is a key and the third a value. Those key/value
     *  pairs are assumed to exist as directive within the configuration
     *  instance.
     *
     *  @return array
     *          An array of test parameters is returned on success
     */
    public function provideTestParameter()
    {
        $configList = $this->provideTestConfig();
        $testData = array();

        foreach ($configList as $configPair) {

            assert('$configPair[0] instanceof Lousson\\Config\\AnyConfig');
            assert('is_array($configPair[1])');

            foreach ($configPair[1] as $key => $value) {
                $testData[] = array($configPair[0], $key, $value);
            }
        }

        return $testData;
    }

    /**
     *  Test getOption() with expected key/value pairs
     *
     *  The testGetExpected() method tests whether the $config's
     *  getOption() method returns the expected $value when invoked
     *  for the given $key.
     *
     *  @param  \Lousson\Config\AnyConfig   $config The config instance
     *  @param  string                      $key    The config key
     *  @param  mixed                       $value  The config value
     *
     *  @dataProvider       provideTestParameter
     *  @test
     *
     *  @throws \PHPUnit_Framework_AssertionFailedError
     *          Raised in case getOption() does not return $value
     */
    public function testGetExpected(AnyConfig $config, $key, $value)
    {
        $type = is_object($value)? get_class($value): gettype($value);
        $message = sprintf(
            "%s::getOption(%s) is expected to return %s",
            get_class($config), var_export($key, true), $type
        );

        $this->assertEquals($value, $config->getOption($key), $message);
    }

    /**
     *  Test hasOption() with expected key/value pairs
     *
     *  The testHasExpected() method tests whether the $config's
     *  hasOption() method returns TRUE for the given $key and,
     *  furthermore, whether a subsequent call to getOption() really
     *  returns the expected $value.
     *
     *  @param  \Lousson\Config\AnyConfig   $config The config instance
     *  @param  string                      $key    The config key
     *  @param  mixed                       $value  The config value
     *
     *  @throws PHPUnit_Framework_AssertionFailedError
     *          Raised in case hasOption() does not return TRUE or
     *          a subsequent run of getOption() does not return $value
     *
     *  @dataProvider       provideTestParameter
     *  @test
     */
    public function testHasExpected(AnyConfig $config, $key, $value)
    {
        $message = sprintf(
            "%s::hasOption(%s) is expected to return TRUE",
            get_class($config), var_export($key, true)
        );

        $this->assertTrue($config->hasOption($key), $message);
        $this->testGetExpected($config, $key, $value);
    }

    /**
     *  Test getOption() with unexpected keys
     *
     *  The testGetUnexpected() method tests whether the $config's
     *  getOption() method raises a Lousson\Config\AnyConfigException for
     *  the given $token.
     *
     *  Note that in case $token is NULL, a radom one will get created.
     *  It is ensured that this token will not be a valid key for any of
     *  the given $values.
     *
     *  @param  \Lousson\Config\AnyConfig   $config The config instance
     *  @param  array                       $values The config values
     *  @param  string                      $token  The test token
     *
     *  @dataProvider       provideTestConfig
     *  @expectedException  Lousson\Config\AnyConfigException
     *  @test
     *
     *  @throws \Lousson\Config\AnyConfigException
     *          Raised in case of success (this is a test!)
     *
     *  @throws \PHPUnit_Framework_AssertionFailedError
     *          Raised in case the $token is is a key within the $values
     */
    public function testGetUnexpected(
        AnyConfig $config, $values = array(), $token = null)
    {
        if (null === $token) {
            $token = $this->getRandomKey($config, $values);
        }

        $this->assertThat(
            $values, $this->logicalNot($this->contains($token)),
            "THE \$token SHALL NOT BE CONTAINED IN THE LIST OF \$keys"
        );

        $config->getOption($token);
    }

    /**
     *  Test hasOption() with unexpected keys
     *
     *  The testHasUnexpected() method tests whether the $config's
     *  hasOption() method returns FALSE for the given $token.
     *  Additionally, the testGetUnexpected() method is invoked afterwards,
     *  in order to check whether hasOption() is consistent with the
     *  getOption() method.
     *
     *  Note that in case $token is NULL, a radom one will get created.
     *  It is ensured that this token will not be a valid key for any of
     *  the given $values.
     *
     *  @param  \Lousson\Config\AnyConfig   $config The config instance
     *  @param  array                       $values The config values
     *  @param  string                      $token  The test token
     *
     *  @dataProvider       provideTestConfig
     *  @expectedException  Lousson\Config\AnyConfigException
     *  @test
     *
     *  @throws \Lousson\Config\AnyConfigException
     *          Raised in case of success (this is a test!)
     *
     *  @throws \PHPUnit_Framework_AssertionFailedError
     *          Raised in case hasOption() does not return FALSE or the
     *          $token is is a key within the $values
     */
    public function testHasUnexpected(
        AnyConfig $config, $values = array(), $token = null)
    {
        if (null === $token) {
            $token = $this->getRandomKey($config, $values);
        }

        $message = sprintf(
            "%s::hasOption(%s) is expected to return FALSE",
            get_class($config), var_export($token, true)
        );

        $this->assertFalse($config->hasOption($token), $message);
        $this->testGetUnexpected($config, $values, $token);
    }

    /**
     *  Test getOption() with fallback values
     *
     *  The testFallback() method tests whether the given $config's
     *  getOption() method returns a generic fallback value when neither
     *  of the given $values is used.
     *
     *  @param  \Lousson\Config\AnyConfig   $config The config instance
     *  @param  array                       $values The config values
     *  @param  string                      $token  The test token
     *
     *  @dataProvider       provideTestConfig
     *  @test
     *
     *  @throws \PHPUnit_Framework_AssertionFailedError
     *          Raised in case getOption() does not return the generic
     *          fallback value
     */
    public function testFallback(
        AnyConfig $config, $values = array(), $token = null)
    {
        if (null === $token) {
            $token = $this->getRandomKey($config, $values);
        }

        $option = $config->getOption($token, $token);
        $message = sprintf(
            "%1\$s::getOption(%2\$s, %2\$s) is expected to return ".
            "the provided fallback value",
            get_class($config), var_export($token, true)
        );

        $this->assertEquals($token, $option, $message);
    }

    /**
     *  Obtain a pseudo-random token
     *
     *  The getRandomKey() method is used internally to generate a
     *  character sequence that is not a key within the given list of
     *  $values and assumed to be no valid $config option.
     *
     *  @param  \Lousson\Config\AnyConfig   $config The config instance
     *  @param  array                       $values Known config values
     *
     *  @return string
     *          A nonexistent configuration key is returned on success
     */
    private function getRandomKey(AnyConfig $config, $values = array())
    {
        $token = sha1("this-key-should-not-exist");

        while (array_key_exists($token, $values)) {
            $token = sha1($token . microtime());
        }

        return $token;
    }
}

