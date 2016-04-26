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
 * @name WirecardCEE_QPay_Response_Toolkit_GetOrderDetails
 * @category WirecardCEE
 * @package WirecardCEE_QPay
 * @subpackage Response_Toolkit
 * @version 3.0.0
 */
class WirecardCEE_QPay_Response_Toolkit_GetOrderDetails extends WirecardCEE_QPay_Response_Toolkit_ResponseAbstract {
	/**
	 * Internal order holder
	 * @var WirecardCEE_QPay_Response_Toolkit_Order
	 */
	private $_order;

	/**
	 * Order
	 * @staticvar string
	 */
	private static $ORDER 	= 'order';

	/**
	 * Payment
	 * @staticvar string
	 */
	private static $PAYMENT = 'payment';

	/**
	 * Credit
	 * @staticvar string
	 */
	private static $CREDIT 	= 'credit';

	/**
	 *
	 * @see WirecardCEE_QPay_Response_Toolkit_Abstract
	 * @param array $result
	 */
	public function __construct($result) {
		parent::__construct($result);

		$orders = $this->_getField(self::$ORDER);
		$payments = $this->_getField(self::$PAYMENT);
		$credits = $this->_getField(self::$CREDIT);

		$order = $orders[0];
		$order['paymentData'] = is_array($payments[0]) ? $payments[0] : Array();
		$order['creditData'] = is_array($credits[0]) ? $credits[0] : Array();

		$this->_order = new WirecardCEE_QPay_Response_Toolkit_Order($order);

	}

	/**
	 * getter for the returned order object
	 *
	 * @return WirecardCEE_QPay_Response_Toolkit_Order
	 */
	public function getOrder() {
		return $this->_order;
	}
}
