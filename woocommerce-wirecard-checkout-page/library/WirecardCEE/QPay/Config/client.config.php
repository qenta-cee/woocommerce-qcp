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
return Array(
        'FRONTEND_URL' => 'https://checkout.wirecard.com/page/init-server.php',
        'TOOLKIT_URL' => 'https://checkout.wirecard.com/page/toolkit.php',
        'MODULE_NAME' => 'WirecardCEE_Checkout_Page',
        'MODULE_VERSION' => '3.0.0',
        'DEPENDENCIES' => Array(
                'FRAMEWORK_NAME' => 'Zend_Framework',
                'FRAMEWORK_VERSION' => Array(
                        'MINIMUM' => '1.11.10',
                        'CURRENT' => Zend_Version::VERSION
                ),
        ),
        'USE_DEBUG' => FALSE
);
