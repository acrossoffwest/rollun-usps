<?php

/**
 * @copyright Copyright © 2014 Rollun LC (http://rollun.com/)
 * @license LICENSE.md New BSD License
 */
declare(strict_types=1);

namespace rollun\test\unit\Entity\Shipping\Method\Usps;

use PHPUnit\Framework\TestCase;
use rollun\Entity\Subject\Address;
use rollun\Entity\Product\Dimensions\Rectangular;
use rollun\Entity\Product\Item\Product;
use rollun\Entity\Shipping\ShippingRequest;
use rollun\Entity\Shipping\Method\FixedPrice;
use rollun\Entity\Product\Container\Box;
use rollun\Entity\Shipping\Method\ShippingMethodProvider;
use rollun\Entity\Shipping\Method\Usps\UspsProvider;

class ShippingMethodProviderTest extends TestCase
{

    public function test_getShortName()
    {
        $provider = new UspsProvider();
        $this->assertEquals(
                'Usps', $provider->getShortName()
        );
    }

    public function test_getShippingMetods()
    {
        $provider = new UspsProvider();

        $addressOrigination = new Address('', '91601');
        $addressDestination = new Address('', '91730-1234');

        $rectangular = new Rectangular(1, 10, 5);
        $product = new Product($rectangular, 0.5);
        $shippingRequest = new ShippingRequest($product, $addressOrigination, $addressDestination);

        $this->assertEquals(
                null, $provider->getShippingMetods($shippingRequest)->getArrayCopy()[3]['cost']
        );
        $this->assertEquals(
                'Usps-PM-FR-SmBox', $provider->getShippingMetods($shippingRequest)->getArrayCopy()[3]['id']
        );
        $this->assertEquals(
                null, $provider->getShippingMetods($shippingRequest)->getArrayCopy()[3]['cost']
        );
        $this->assertEquals(
                'Usps-PM-FR-LgBox', $provider->getShippingMetods($shippingRequest)->getArrayCopy()[6]['id']
        );
        $this->assertEquals(
                17.6, $provider->getShippingMetods($shippingRequest)->getArrayCopy()[6]['cost']
        );

        $this->assertEquals(
                Array(
            'id' => 'Usps-FtCls-Package',
            'cost' => 3.18
            , 'Service' => 'FIRST CLASS COMMERCIAL'
            , 'FirstClassMailType' => 'PACKAGE SERVICE'
            , 'Container' => ''
            , 'ZipOrigination' => 91601
            , 'ZipDestination' => 91730
            , 'Pounds' => 0.5
            , 'Type' => 'Rectangular'
            , 'Length' => 10
            , 'Width' => 5
            , 'Height' => 1
            , 'Girth' => 12
            , 'Volume' => 50
            , 'Click_N_Shipp' => 'First-Class Package Service'
            , 'Error' => null)
                , $provider->getShippingMetods($shippingRequest)->getBestCostResponseRec()
        );
    }
//
//    public function test_getShippingMetodsProviderInProvider()
//    {
//        $box1 = new Box(35, 6, 11);
//        $fixedPrice1 = new FixedPrice($box1, 'Md1', 10, 20);
//        $box2 = new Box(10, 10, 10);
//        $fixedPrice2 = new FixedPrice($box2, 'Md2', 20, 20);
//
//        $providerFr = new ShippingMethodProvider('Fr', [$fixedPrice1, $fixedPrice2]);
//
//        $providerUsps = new ShippingMethodProvider('Usps', [$providerFr]);
//
//        $addressOrigination = new Address('', '91601');
//        $addressDestination = new Address('', '91730-1234');
//
//        $rectangular = new Rectangular(10, 30, 5);
//        $product = new Product($rectangular, 0.5);
//        $shippingRequest = new ShippingRequest($product, $addressOrigination, $addressDestination);
//
//        $this->assertEquals(
//                ['id' => 'Usps-Fr-Md1', 'cost' => 20], $providerUsps->getShippingMetods($shippingRequest)->getArrayCopy()[0]
//        );
//
//        $this->assertEquals(
//                ['id' => 'Usps-Fr-Md2', 'cost' => null], $providerUsps->getShippingMetods($shippingRequest)->getArrayCopy()[1]
//        );
//    }
}
