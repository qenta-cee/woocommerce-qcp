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
 * @name WirecardCEE_Stdlib_Module
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Module
 * @version 3.0.0
 */
class WirecardCEE_Stdlib_Module extends WirecardCEE_Stdlib_Module_ModuleAbstract implements WirecardCEE_Stdlib_Module_ModuleInterface {
    /**
     * Returns the client configuration details found in 'Config' directory
     * (client.config.php)
     *
     * @return Array
     */
    public static final function getClientConfig() {
        return include dirname(__FILE__) . '/Config/client.config.php';
    }
}