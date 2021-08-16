<? AddEventHandler("sale", "OnOrderNewSendEmail", "ModifyOrderSaleMails");
function ModifyOrderSaleMails($ID, &$eventName, &$arFields)
{
    if (CModule::IncludeModule("sale") && CModule::IncludeModule("iblock")) {
        //СОСТАВ ЗАКАЗА РАЗБИРАЕМ SALE_ORDER НА ЗАПЧАСТИ
        $strOrderList = "";
        $dbBasketItems = CSaleBasket::GetList(array(), array("ORDER_ID" => $ID));
        while ($arBasket = $dbBasketItems->GetNext()) {
            $mxResult = CCatalogSku::GetProductInfo($arBasket['PRODUCT_ID']);
            $prop_common = CIBlockElement::GetByID($arBasket['PRODUCT_ID']);
            $ob = $prop_common->GetNextElement();
            $prop = $ob->GetProperties();
            if (is_array($mxResult) && !empty($mxResult['ID'])) {
                $arProduct = CIBlockElement::GetByID($mxResult['ID'])->Fetch();;
            } else {
                $arProduct = CIBlockElement::GetByID($arBasket['PRODUCT_ID'])->Fetch();
            }
            //ПЕРЕМНОЖАЕМ КОЛИЧЕСТВО НА ЦЕНУ
            $summ = $arBasket['QUANTITY'] * $arBasket['PRICE'];
            //СОБИРАЕМ В СТРОКУ ТАБЛИЦЫ
            $strCustomOrderList .= $prop['MINIMAL_COUNT_GOODS']['VALUE'];
        }
        //ОБЪЯВЛЯЕМ ПЕРЕМЕННУЮ ДЛЯ ПИСЬМА
        $arFields["ORDER_TABLE_ITEMS"] = $strCustomOrderList;
    }
}

?>
