<?php
/*
* Die vorliegende Software ist Eigentum von Wirecard CEE und daher vertraulich
* zu behandeln. Jegliche Weitergabe an dritte, in welcher Form auch immer, ist
* unzulaessig.
*
* Software & Service Copyright (C) by
* Wirecard Central Eastern Europe GmbH,
* FB-Nr: FN 195599 x, http://www.wirecard.at
*/

/**
 * @name WirecardCEE_Stdlib_Module_ModuleAbstract
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Module
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Module_ModuleAbstract implements WirecardCEE_Stdlib_Module_ModuleInterface {
    /**
     * Returns the user configuration details found in 'Config' directory
     * (user.config.php)
     *
     * @return Array
     * @abstract
     */
    public static function getConfig() {}

    /**
     * Returns the client configuration details found in 'Config' directory
     * (client.config.php)
     *
     * @return Array
     * @abstract
     */
    public static function getClientConfig() {}
}