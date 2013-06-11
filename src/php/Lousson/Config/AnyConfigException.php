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
 *  Lousson\Config\AnyConfigException interface declaration
 *
 *  @package    org.lousson.config
 *  @copyright  (c) 2012 - 2013, The Lousson Project
 *  @license    http://opensource.org/licenses/bsd-license.php New BSD License
 *  @author     Mathias J. Hennig <mhennig at quirkies.org>
 *  @filesource
 */
namespace Lousson\Config;

/**
 *  An interface configuration exceptions
 *
 *  The AnyConfigException interface declares an interface for exceptions
 *  raised by instances of the interfaces declared in the Lousson\Config
 *  namespace.
 *
 *  @since      lousson/Lousson_Config-0.1.0
 *  @package    org.lousson.config
 */
interface AnyConfigException
{
    /**
     *  The default error code
     *
     *  @var int
     */
    const E_UNKNOWN_ERROR = 0x000;

    /**
     *  An error code to indicate arbitrary internal errors
     *
     *  @var int
     */
    const E_INTERNAL_ERROR = 0x1F4;

    /**
     *  An error code to indicate invalid options
     *
     *  @var int
     */
    const E_INVALID_OPTION = 0x190;

    /**
     *  An error code to indicate unsupported functionality
     *
     *  @var int
     */
    const E_NOT_SUPPORTED = 0x19F;

    /**
     *  An error code to indicate missing options
     *
     *  @var int
     */
    const E_NOT_FOUND = 0x194;
}

