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
 *  Definition of the Lousson\Config\Builtin\BuiltinConfigTest class
 *
 *  @package    org.lousson.config
 *  @copyright  (c) 2012 - 2013, The Lousson Project
 *  @license    http://opensource.org/licenses/bsd-license.php New BSD License
 *  @author     Mathias J. Hennig <mhennig at quirkies.org>
 *  @filesource
 */
namespace Lousson\Config\Builtin;
use Lousson\Config\Error\InvalidConfigError;
use Exception;

/** Dependencies: */
use Lousson\Config\AbstractConfigTest;
use Lousson\Config\Builtin\BuiltinConfig;

/**
 *  Test case for the BuiltinConfig implementation
 *
 *  The BuiltinConfigTest is a test case for the BuiltinConfig class,
 *  implemented on top of the AbstractConfigTest.
 *
 *  @since      lousson/Lousson_Config-0.1.0
 *  @package    org.lousson.config
 */
class BuiltinConfigTest extends AbstractConfigTest
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
    public function getConfig(array $options)
    {
        $config = new BuiltinConfig($options);

        foreach ($options as $key => $value) {
            $config->setOption($key, $value);
        }

        return $config;
    }

    /**
     *  Test the setConfig() method
     *
     *  The testSetConfig() method invokes the config's setOption()
     *  method with the given $key and $value before passing the test
     *  on to testGetExpected() and testHasExpected().
     *
     *  @param  string  $key        The config key
     *  @param  string  $value      The config value
     *
     *  @dataProvider   provideTestData
     *  @test
     *
     *  @throws \PHPUnit_Framework_AssertionFailedError
     *          Raised in case testGetExpected() or testHasExpected()
     *          fail after the setConfig() method has been invoked
     */
    public function testSetConfig($key, $value)
    {
        $config = $this->getConfig(array());
        $config->setOption($key, $value);

        $this->testGetExpected($config, $key, $value);
        $this->testHasExpected($config, $key, $value);
    }
}

