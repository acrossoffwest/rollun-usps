<?php

/**
 * @copyright Copyright © 2014 Rollun LC (http://rollun.com/)
 * @license LICENSE.md New BSD License
 */
declare(strict_types=1);

namespace rollun\Entity\Shipping;

class ShippingResponseSet extends \ArrayObject
{

    const KEY_SHIPPING_METHOD_NAME = 'id';
    const KEY_SHIPPING_METHOD_COST = 'cost';
    const KEY_SHIPPING_METHOD_ERROR = 'Error';
    //
    const SHIPPING_METHOD_NAME_SEPARATOR = '-';

    /**
     *
     * @param array $shippingSet [['id'  => 'RMATV-USPS-FRLG1','cost' =>17.89], ['id'  => 'RMATV-DS','cost' =>8.95]]
     */
    public function __construct($shippingSet = [])
    {
        parent::__construct($shippingSet);
    }

    /**
     *
     * @param \rollun\Entity\Shipping\ShippingResponseSet $responseSet
     * @param string $prefixName
     * @return array [['id'  => 'RMATV-USPS-FRLG1','cost' =>17.89], ['id'  => 'RMATV-DS','cost' =>8.95]]
     */
    public function mergeResponseSet(ShippingResponseSet $responseSet, string $prefixName)
    {
        foreach ($responseSet as $shippingRecord) {
            $shippingRecord[self::KEY_SHIPPING_METHOD_NAME] = $prefixName
                    . self::SHIPPING_METHOD_NAME_SEPARATOR
                    . $shippingRecord[self::KEY_SHIPPING_METHOD_NAME];
            $this->append($shippingRecord);
        }
        return $this->getArrayCopy();
    }

    public function toArray()
    {
        return $this->getArrayCopy();
    }

    public function getBestCostResponseRec()
    {
        $keyBest = null;
        $bestShippingCost = null;
        foreach ($this as $key => $shippingRecord) {
            if (!is_null($shippingRecord['cost']) &&
                    (is_null($bestShippingCost) || $shippingRecord['cost'] < $bestShippingCost)) {
                $bestShippingCost = $shippingRecord['cost'];
                $keyBest = $key;
            }
        }

        return is_null($keyBest) ? null : $this[$keyBest];
    }

    public function addFildsWithData(array $data)
    {
        foreach ($this as $key => $shippingRecord) {
            $this[$key] = array_merge($shippingRecord, $data);
        }

        return $this;
    }
}
