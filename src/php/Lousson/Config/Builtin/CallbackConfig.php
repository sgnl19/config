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
 *  Definition of the Lousson\Config\Builtin\CallbackConfig class
 *
 *  @package    org.lousson.config
 *  @copyright  (c) 2012 The Lousson Project
 *  @license    http://opensource.org/licenses/bsd-license.php New BSD License
 *  @author     Mathias J. Hennig <mhennig at quirkies.org>
 *  @filesource
 */
/** Dependencies: */
use Lousson\Config\AnyConfig;
use Lousson\Config\AnyConfigException;
use Lousson\Config\Builtin\ConfigException;

/**
 *  A Closure-based implementation of the AnyConfig interface
 *
 *  The Lousson\Config\Builtin\CallbackConfig class is a flexible
 *  implementation of the Lousson\Config\AnyConfig interface that
 *  uses a user-defined Closure to retrieve configuration values.
 *
 *  @since      lousson/config-0.2.0
 *  @package    org.lousson.config
 */
class CallbackConfig implements AnyConfig
{
    // The tag below is necessary due to a bug in PHP_CodeCoverage that
    // causes Closures to confuse the whole processing logic. Nevertheless,
    // the Lousson\Config\Builtin\CallbackConfigTest class does in fact
    // use the constructor - otherwise, all the tests would fail anyway.
    // @codeCoverageIgnoreStart

    /**
     *  Constructor
     *
     *  The constructor allows to pass a Closure $getter that is used to
     *  retrieve configuration values. This callback must provide the exact
     *  same interface as AnyConfig::getOption().
     *
     *  @param  Closure $getter
     */
    public function __construct(\Closure $getter)
    {
        $this->_getter = $getter;
    }

    // @codeCoverageIgnoreEnd

    /**
     *  Get the value of a particular option
     *
     *  The getOption() method will return the value associated with the
     *  option identified by the given $name. If there is no such option,
     *  it will return the value of the given $fallback - but only in case
     *  a fallback has been provided.
     *  If neither is available, the getOption() method will raise a
     *  Lousson\Config\AnyConfigException class.
     *
     *  @param  string  $name
     *  @param  mixed   $fallback
     *
     *  @return mixed
     *
     *  @throws Lousson\Config\AnyConfigException
     *          Raised in case of any error
     *
     *  @link http://php.net/manual/en/function.func-num-args.php
     *  @link http://php.net/manual/en/language.functions.php
     */
    public function getOption($name, $fallback = null)
    {
        $getter = $this->_getter;
        $result = 1 === func_num_args()
            ? $getter($name)
            : $getter($name, $fallback);

        return $result;
    }

    /**
     *  Check whether a particular option is set
     *
     *  The hasOption() method will return TRUE in case a subsequent call
     *  to getOption() would succeed, when the same $name but no $fallback
     *  is provided. FALSE will be returned otherwise.
     *
     *  @param  string  $name
     *
     *  @return boolean
     */
    public function hasOption($name)
    {
        try {
            $this->getOption($name);
            return true;
        }
        catch (AnyConfigException $error) {
            return false;
        }
    }

    /**
     *  The configuration getter callback
     *
     *  @var array
     */
    private $_getter = array();
}

