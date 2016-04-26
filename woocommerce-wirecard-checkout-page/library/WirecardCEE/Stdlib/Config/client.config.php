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
        'MODULE_NAME' => 'WirecardCEE_Stdlib',
        'MODULE_VERSION' => '3.0.0',
        'DEPENDENCIES' => array(
                'FRAMEWORK_NAME' => 'Zend_Framework',
                'FRAMEWORK_VERSION' => Array(
                        'MINIMUM' => '1.11.10',
                        'CURRENT' => Zend_Version::VERSION
                ),
                'SCRIPTING_LANG' => 'PHP',
                'SCRIPTING_LANG_VERSION' => '5.2'
        ),
        'USE_DEBUG' => FALSE
);