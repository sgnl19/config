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
 *  Lousson\Config\Generic\GenericConfigTest class definition
 *
 *  @package    org.lousson.config
 *  @copyright  (c) 2012 - 2013, The Lousson Project
 *  @license    http://opensource.org/licenses/bsd-license.php New BSD License
 *  @author     Mathias J. Hennig <mhennig at quirkies.org>
 *  @filesource
 */
namespace Lousson\Config\Generic;

/** Dependencies: */
use Lousson\Config\AbstractConfigTest;
use Lousson\Config\Generic\GenericConfig;
use Lousson\Config\Error\InvalidConfigError;
use Exception;

/**
 *  Test case for the GenericConfig implementation
 *
 *  The GenericConfigTest is a test case for the GenericConfig class,
 *  implemented on top of the AbstractConfigTest.
 *
 *  @since      lousson/Lousson_Config-0.2.0
 *  @package    org.lousson.config
 */
class GenericConfigTest extends AbstractConfigTest
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
        $callback = function($name, $fallback = null) use($options)
        {
            if (isset($options[$name]) ||
                    array_key_exists($name, $options)) {
                return $options[$name];
            }

            if (1 < func_num_args()) {
                return $fallback;
            }

            $message = "Missing configuration directive: $name";
            throw new InvalidConfigError($message);
        };

        $config = new GenericConfig($callback);
        return $config;
    }

    /**
     *  Test error handling of hasOption()
     *
     *  The testGetOptionError() method verifies that the hasOption()
     *  method does not violate the AnyConfig interface even in case the
     *  getOption() method raises an unrecognized exception.
     *
     *  @expectedException  PHPUnit_Framework_Error_Warning
     *  @test
     *
     *  @throws \PHPUnit_Framework_Error_Warning
     *          Raised in case the test is successful
     */
    public function testHasOptionError()
    {
        $class = "Lousson\\Config\\AbstractConfig";
        $mock = $this->getMockForAbstractClass($class);

        $mock->expects($this->any())
            ->method("getOption")
            ->will($this->throwException(new Exception));

        $mock->hasOption("foobar");
    }

    /**
     *  Test error handling of getOption()
     *
     *  The testGetOptionError() method verifies that the getOption()
     *  method does not violate the AnyConfig interface even in case the
     *  callback raises an unrecognized exception.
     *
     *  @expectedException  Lousson\Config\AnyConfigException
     *  @test
     *
     *  @throws \Lousson\Config\AnyConfigException
     *          Raised in case the test is successful
     */
    public function testGetOptionError()
    {
        $callback = function($name) {
            throw new Exception("TEST!");
        };

        $config = new GenericConfig($callback);
        $config->getOption("foobar");
    }
}

