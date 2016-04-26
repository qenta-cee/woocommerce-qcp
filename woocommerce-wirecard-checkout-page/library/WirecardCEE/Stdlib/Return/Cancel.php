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
 * @name WirecardCEE_Stdlib_Return_Cancel
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Return
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Return_Cancel extends WirecardCEE_Stdlib_Return_ReturnAbstract {
    /**
     * State
     * @var string
     */
    protected $_state = 'CANCEL';
}
