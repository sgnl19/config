<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 textwidth=75: *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Copyright (c) 2012, The Lousson Project                               *
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
namespace Lousson\Config\Builtin;

/**
 *  Definition of the Lousson\Config\Builtin\CallbackConfigTest class
 *
 *  @package    org.lousson.config
 *  @copyright  (c) 2012 The Lousson Project
 *  @license    http://opensource.org/licenses/bsd-license.php New BSD License
 *  @author     Mathias J. Hennig <mhennig at quirkies.org>
 *  @filesource
 */
/** Dependencies: */
use Lousson\Config\AbstractConfigTest;
use Lousson\Config\Builtin\CallbackConfig;
use Lousson\Config\Builtin\ConfigException;

/**
 *  Test case for the CallbackConfig implementation
 *
 *  The Lousson\Config\Builtin\CallbackConfigTest is a test case for
 *  the Lousson\Config\Builtin\CallbackConfig class.
 *
 *  @since      lousson/config-0.2.0
 *  @package    org.lousson.config
 */
class CallbackConfigTest extends AbstractConfigTest
{
    /**
     *  Obtain the config to test
     *
     *  The getConfig() method will return the instance of the
     *  Lousson\Config\Builtin\CallbackConfig class.
     *  This instance will be pre-set with the options specified
     *  by the associative $options array.
     *
     *  @param  array   $options
     *
     *  @return Lousson\Config\Builtin\CallbackConfig
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

            throw new ConfigException(sprintf(
                "Missing configuration directive: %s", $name
            ));
        };

        $config = new CallbackConfig($callback);
        return $config;
    }
}

