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
 *  Lousson\Config\Callback\CallbackConfig class definition
 *
 *  @package    org.lousson.config
 *  @copyright  (c) 2012 - 2013, The Lousson Project
 *  @license    http://opensource.org/licenses/bsd-license.php New BSD License
 *  @author     Mathias J. Hennig <mhennig at quirkies.org>
 *  @filesource
 */
namespace Lousson\Config\Callback;

/** Dependencies: */
use Lousson\Config\Generic\GenericConfig;
use Lousson\Record\Builtin\BuiltinRecordUtil;
use Closure;

/** Exceptions: */
use Lousson\Config\Error\RuntimeConfigError;

/**
 *  A Closure-based implementation of the AnyConfig interface
 *
 *  The Lousson\Config\Callback\CallbackConfig is a flexible implementation
 *  of the AnyConfig interface, using a Closure to retrieve config values.
 *
 *  @since      lousson/Lousson_Config-0.2.0
 *  @package    org.lousson.config
 */
class CallbackConfig extends GenericConfig
{
    /**
     *  Create a config instance
     *
     *  The constructor allows to pass a Closure $getter that is used to
     *  retrieve configuration values. This callback must provide the exact
     *  same interface as the getOption() method, otherwise the behavior
     *  is undefined.
     *
     *  @param  Closure             $getter         The config callback
     */
    public function __construct(Closure $getter)
    {
        $this->getter = $getter;
    }

    /**
     *  Obtain the value of a particular option
     *
     *  The getOption() method will return the value associated with the
     *  option identified by the given $name. If there is no such option,
     *  it will either return the $fallback value - if provided -, or
     *  raise an exception.
     *
     *  @param  string              $name           The option name
     *  @param  mixed               $fallback       The fallback value
     *
     *  @return mixed
     *          The value of the option is returned on success
     *
     *  @throws \Lousson\Config\AnyConfigException
     *          Raised in case of any error
     *
     *  @link   http://php.net/manual/en/function.func-num-args.php
     *  @link   http://php.net/manual/en/language.functions.php
     */
    public function getOption($name, $fallback = null)
    {
        try {
            $getter = $this->getter;
            $result = 1 === func_num_args()
                ? $getter($name)
                : $getter($name, $fallback);

            if ($result !== $fallback) {
                $result = BuiltinRecordUtil::normalizeItem($result);
            }
        }
        catch (\Lousson\Config\AnyConfigException $error) {
            /* Nothing to do; allowed by the AnyConfig interface */
            throw $error;
        }
        catch (\Exception $error) {
            $class = get_class($error);
            $message = "Could not fetch option: Caught $class";
            $code = $error->getCode();
            throw new RuntimeConfigError($message, $code, $error);
        }

        return $result;
    }

    /**
     *  The configuration getter callback
     *
     *  @var \Closure
     */
    private $getter;
}

