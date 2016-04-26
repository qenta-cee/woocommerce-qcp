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
 * @name WirecardCEE_Stdlib_SerialApi
 * @category WirecardCEE
 * @package WirecardCEE_Stdlib
 * @version 3.0.0
 */
class WirecardCEE_Stdlib_SerialApi {
    /**
     * Encode the mixed[] $valueToEncode into the SerialAPI format
     *
     * NOTE: only Strings can be handled. So for every object the __toString
     * will be called.
     *
     * @throws WirecardCEE_Stdlib_Exception_InvalidTypeException if valueToEncode is not an array.
     * @param mixed[] $aValueToEncode
     * @return string SerialAPI encoded Array
     */
    public static function encode($aValueToEncode) {
        if (is_array($aValueToEncode)) {
            $serializedString = '';
            foreach($aValueToEncode as $key => $value) {
                $serializedString = self::_addEntryEncode($key, $value, $serializedString);
            }
            return $serializedString;
        }
        else {
            throw new WirecardCEE_Stdlib_Exception_InvalidTypeException(sprintf('Invalid type for %s. Array must be given.', __METHOD__));
        }
    }

    /**
     * Adds an key/value pair to the serializedString
     *
     * @param string key representing the entry
     * @param mixed|mixed[] value for key entry
     * @param string serialized String
     */
    protected static function _addEntryEncode($key, $value, $serializedString = '') {
        if (is_array($value)) {
            $entryValue = Array();
            $entryKey = '';
            $nextEntryKey = '';
            $nextEntryValue = '';
            foreach($value as $subKey => $subValue) {
                if (is_int($subKey)) {
                    $subKey++;
                    if (!is_array($subValue)) {
                        if ($entryKey == '') {

                            if (is_numeric(substr(strrchr($key, '.'), 1))) {
                                $entryKey = $key . '.' . $subKey;
                            }
                            else {
                                $entryKey = $key;
                            }
                        }
                        $entryValue[] = $subValue;
                        // next loop
                        continue;
                    }
                    else {
                        if (!empty($entryValue)) {
                            $serializedString = self::_addLastEntryArrayEncode($entryKey, $entryValue, $serializedString);
                            $entryValue = '';
                            $entryKey = '';
                        }
                    }
                }
                if (empty($entryValue)) {
                    $serializedString = self::_addEntryEncode($key . '.' . $subKey, $subValue, $serializedString);
                }
                else {
                    $nextEntryKey = $key . '.' . $subKey;
                    $nextEntryValue = $subValue;
                }
            }
            if (!empty($entryValue)) {
                $serializedString = self::_addLastEntryArrayEncode($entryKey, $entryValue, $serializedString);
                $entryValue = '';
                $entryKey = '';
                if ($nextEntryKey != '' && $nextEntryValue != '') {
                    $serializedString = self::_addEntryEncode($nextEntryKey, $nextEntryValue, $serializedString);
                    $nextEntryKey = '';
                    $nextEntryValue = '';
                }
            }
        }
        else {
            if ($serializedString != '') {
                $serializedString .= '&';
            }
            if (is_int($key)) {
                $key++;
            }
            $serializedString .= urlencode((string) $key) . '=' . urlencode((string) $value);
        }
        return $serializedString;
    }

    /**
     *
     * @param string $sKey
     * @param array $aValues
     * @param string $serializedString
     * @return string
     */
    protected static function _addLastEntryArrayEncode($sKey, Array $aValues, $serializedString) {
        $valueString = '';
        foreach($aValues as $value) {
            if ($valueString == '') {
                $valueString = urlencode((string) $value);
            }
            else {
                $valueString .= ',' . urlencode((string) $value);
            }
        }
        if ($serializedString == '') {
            $serializedString = urlencode((string) $sKey) . '=' . $valueString;
        }
        else {
            $serializedString .= '&' . urlencode((string) $sKey) . '=' . $valueString;
        }
        return $serializedString;
    }

    public static function decode($encodedValue) {
        $decodedValue = Array();
        $keyValueStrings = explode('&', $encodedValue);
        foreach($keyValueStrings as $entry) {
            $decodedValue = self::_addEntryDecode($entry, $decodedValue);
        }
        return $decodedValue;
    }

    /**
     *
     * @param string $sEntry
     * @param array $aDecodedValue
     * @throws WirecardCEE_Stdlib_Exception_InvalidFormatException
     * @return Array
     */
    protected static function _addEntryDecode($sEntry, $aDecodedValue) {
        $aEntry = explode('=', $sEntry);
        if (!is_array($aEntry) || count($aEntry) < 2) {
            // ignore keys only
            return $aDecodedValue;
        }
        else
            if (count($aEntry) == 2) {
                $keyArray = explode('.', $aEntry[0]);
                if (is_array($keyArray) && count($keyArray) > 1) {
                    $position = & $aDecodedValue;
                    foreach($keyArray as $keyName) {
                        if ($keyName == intval($keyName)) {
                            $keyName--;
                        }
                        if (!isset($position[$keyName])) {
                            $position[$keyName] = Array();
                        }
                        $position = & $position[$keyName];
                    }
                    $position = self::_decodeValueArray($aEntry[1]);
                }
                else {
                    if ($aEntry[0] == intval($aEntry[0])) {
                        $aEntry[0]--;
                    }
                    $aDecodedValue[urldecode($aEntry[0])] = self::_decodeValueArray($aEntry[1]);
                }
                return $aDecodedValue;
            }
            else {
                throw new WirecardCEE_Stdlib_Exception_InvalidFormatException('Invalid format for WirecardCEE_Stdlib_SerialApi::decode. Expecting key=value pairs');
            }
    }

    /**
     *
     * @param string $sValue
     * @return multitype: string | string
     */
    protected static function _decodeValueArray($sValue) {
        $aValues = explode(',', $sValue);
        if (is_array($aValues) && count($aValues) > 1) {
            $aEntries = Array();
            foreach($aValues as $sEntry) {
                $aEntries[] = urldecode($sEntry);
            }
            return $aEntries;
        }
        else {
            return urldecode($sValue);
        }
    }
}