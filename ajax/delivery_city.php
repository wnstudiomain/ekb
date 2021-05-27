<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
if (isset($_POST["val"]) && isset($_POST["productId"]))
{
    $location = $_POST["val"];
    $id = $_POST["productId"];
}
$bxCRequest = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
//$city= $bxCRequest->getCookieRaw('current_region');
//$location= $bxCRequest->getCookieRaw('current_location'); ?>
            <?

        function getDeliveryPriceForProduct($bitrixProductId, $siteId, $userId, $personTypeId, $deliveryId, $userCityId, $deliveryType)
        {
            $result = null;

            \Bitrix\Main\Loader::includeModule('catalog');
            \Bitrix\Main\Loader::includeModule('sale');

            $products = array(
                array(
                    'PRODUCT_ID' => $bitrixProductId,
                    'QUANTITY'   => 1,
                    // 'NAME'       => 'Товар 1',
                    // 'PRICE' => 500,
                    // 'CURRENCY' => 'RUB',
                ),
            );
            /** @var \Bitrix\Sale\Basket $basket */
            $basket = \Bitrix\Sale\Basket::create($siteId);
            foreach ($products as $product) {
                $item = $basket->createItem("catalog", $product["PRODUCT_ID"]);
                unset($product["PRODUCT_ID"]);
                $item->setFields($product);
            }

            /** @var \Bitrix\Sale\Order $order */
            $order = \Bitrix\Sale\Order::create($siteId, $userId);
            $order->setPersonTypeId($personTypeId);
            $order->setBasket($basket);

            /** @var \Bitrix\Sale\PropertyValueCollection $orderProperties */
            $orderProperties = $order->getPropertyCollection();
            /** @var \Bitrix\Sale\PropertyValue $orderDeliveryLocation */
            $orderDeliveryLocation = $orderProperties->getDeliveryLocation();
            $orderDeliveryLocation->setValue($userCityId); // В какой город "доставляем" (куда доставлять).


            /** @var \Bitrix\Sale\ShipmentCollection $shipmentCollection */
            $shipmentCollection = $order->getShipmentCollection();

            $delivery = \Bitrix\Sale\Delivery\Services\Manager::getObjectById($deliveryId);
            /** @var \Bitrix\Sale\Shipment $shipment */
            $shipment = $shipmentCollection->createItem($delivery);

            /** @var \Bitrix\Sale\ShipmentItemCollection $shipmentItemCollection */
            $shipmentItemCollection = $shipment->getShipmentItemCollection();
            /** @var \Bitrix\Sale\BasketItem $basketItem */
            foreach ($basket as $basketItem) {
                $item = $shipmentItemCollection->createItem($basketItem);
                $item->setQuantity($basketItem->getQuantity());
            }

            // $result = $order->save(); // НЕ сохраняем заказ в битриксе - нам нужны только применённые "скидки" и "правила корзины" на заказ.
            // if (!$result->isSuccess()) {
            //     //$result->getErrors();
            // }

            $deliveryPrice = Bitrix\Sale\PriceMaths::roundPrecision($order->getDeliveryPrice());
            $arDelivery = \Bitrix\Sale\Delivery\Services\Manager::calculateDeliveryPrice($shipment, $deliveryId, array());
            $arPeriod = $arDelivery -> getPeriodDescription();
            $arDeliveryParams = \Bitrix\Sale\Delivery\Services\Manager::getById($deliveryId);

            if ($deliveryPrice === '') {
                $deliveryPrice = null;
            }
            $result = $deliveryPrice;

            $html = '<div><p style="font-weight: 600">' . $deliveryType . '</p><p>' . $deliveryPrice . ', ' . $arPeriod . '</p></div>';

            $array = [
                "TITLE" => $deliveryType,
                "PRICE" => $deliveryPrice,
                "PERIOD" => $arPeriod,
            ];

            return $array;

            //echo '1:<pre>';print_R( $deliveryPrice);echo '</pre>';
            //echo '2:<pre>';print_R( $arPeriod);echo '</pre>';
            //echo '3:<pre>';print_R( $arDeliveryParams);echo '</pre>';


        }
        $deliveryPriceForProduct = getDeliveryPriceForProduct(
            $id,
            SITE_ID,
            $USER->GetID(),
            1, // Юридическое лицо  /bitrix/admin/sale_person_type.php?lang=ru
            36, // Доставка курьером до дома (в случае наличия "профиля" - указываем его id)  /bitrix/admin/sale_delivery_service_edit.php?lang=ru
            $location, // Город пользователя
            'Пункты выдачи' // Тип доставки
        );
        $deliveryPriceForProductCourier = getDeliveryPriceForProduct(
            $id,
            SITE_ID,
            $USER->GetID(),
            1, // Юридическое лицо  /bitrix/admin/sale_person_type.php?lang=ru
            35, // Доставка курьером до дома (в случае наличия "профиля" - указываем его id)  /bitrix/admin/sale_delivery_service_edit.php?lang=ru
            $location, // Город пользователяs
            'Доставка Курьером' // Тип доставки
        );
        $deliveryPriceForProductPickup = getDeliveryPriceForProduct(
            $id,
            SITE_ID,
            $USER->GetID(),
            1, // Юридическое лицо  /bitrix/admin/sale_person_type.php?lang=ru
            2, // Доставка курьером до дома (в случае наличия "профиля" - указываем его id)  /bitrix/admin/sale_delivery_service_edit.php?lang=ru
            $location, // Город пользователя
            'Самовывоз со склада' // Тип доставки
        );
        $deliveryArr = array (
            'pickpoint' => $deliveryPriceForProduct,
            'courier' => $deliveryPriceForProductCourier,
            'pickup' => $deliveryPriceForProductPickup
        );
        echo json_encode($deliveryArr);
    ?>
