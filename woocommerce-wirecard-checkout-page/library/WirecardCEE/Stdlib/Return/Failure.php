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
 * @name WirecardCEE_Stdlib_Return_Failure
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @subpackage Return
 * @version 3.0.0
 * @abstract
 */
abstract class WirecardCEE_Stdlib_Return_Failure extends WirecardCEE_Stdlib_Return_ReturnAbstract {
    /**
     *
     * @var Array
     */
    protected $_errors                             = Array();

    /**
     *
     * @var string
     */
    protected $_state                             = 'FAILURE';

    /**
     *
     * @var string
     */
    protected static $ERRORS                     = 'errors';

    /**
     *
     * @var string
     */
    protected static $ERROR                     = 'error';

    /**
     *
     * @var string
     */
    protected static $ERROR_ERROR_CODE             = 'errorCode';

    /**
     *
     * @var string
     */
    protected static $ERROR_MESSAGE             = 'message';

    /**
     *
     * @var string
     */
    protected static $ERROR_CONSUMER_MESSAGE     = 'consumerMessage';

    /**
     *
     * @var string
     */
    protected static $ERROR_PAY_SYS_MESSAGE     = 'paySysMessage';

    /**
     * return Array
     */
    abstract public function getErrors();
}