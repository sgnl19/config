<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 textwidth=75: *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Copyright (c) 2013, The Lousson Project                               *
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
 *  Lousson\Config\Builtin\BuiltinConfigLoader class definition
 *
 *  @package    org.lousson.config
 *  @copyright  (c) 2013, The Lousson Project
 *  @license    http://opensource.org/licenses/bsd-license.php New BSD License
 *  @author     Mathias J. Hennig <mhennig at quirkies.org>
 *  @filesource
 */
namespace Lousson\Config\Builtin;

/** Interfaces: */
use Lousson\Config\AnyConfigLoader;
use Lousson\Record\AnyRecordManager;

/** Dependencies: */
use Lousson\Config\Builtin\BuiltinConfig;
use Lousson\Record\Builtin\BuiltinRecordManager;

/** Exceptions: */
use Lousson\Config\Error\RuntimeConfigError;

/**
 *  Default implementation of the AnyConfigLoader interface
 *
 *  The Lousson\Config\Builtin\BuiltinConfigLoader class is the default
 *  implementation of the AnyConfigLoader interface.
 *
 *  @since      lousson/Lousson_Config-0.2.0
 *  @package    org.lousson.config
 */
class BuiltinConfigLoader implements AnyConfigLoader
{
    /**
     *  Create a loader instance
     *
     *  The constructor allows the caller to provide a custom record
     *  manager instance, to be used instead of the builtin one.
     *
     *  @param  AnyRecordManager    $manager        The record manager
     */
    public function __construct(AnyRecordManager $manager = null)
    {
        if (null === $manager) {
            $manager = new BuiltinRecordManager();
        }

        $this->manager = $manager;
    }

    /**
     *  Load configuration
     *
     *  The loadConfig() method is used to load the configuration at the
     *  given $location into a configuration object. The optional $type
     *  parameter can be used to specify the (internet-) media type of the
     *  resource.
     *
     *  @param  string              $location       The config location
     *  @param  string              $type           The config type
     *
     *  @return \Lousson\Config\AnyConfig
     *          A config instance is returned on success
     *
     *  @throws \Lousson\Config\AnyConfigException
     *          Raised in case loading the configuration has failed
     */
    public function loadConfig($location, $type = null)
    {
        try {
            $record = $this->manager->loadRecord($location, $type);
        }
        catch (\Lousson\Record\AnyRecordException $error) {
            $class = get_class($error);
            $message = "Could not load config: Caught $class";
            $code = $error->getCode();
            throw new RuntimeConfigError($message, $code, $error);
        }

        $config = new BuiltinConfig($record);
        return $config;
    }

    /**
     *  The loader's record manager
     *
     *  @var \Lousson\Record\AnyRecordManager
     */
    private $manager;
}

