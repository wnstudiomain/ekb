<? AddEventHandler("sale", "OnOrderNewSendEmail", "ModifyOrderSaleMails");
	function ModifyOrderSaleMails($orderID, &$eventName, &$arFields)
	{
	   if(CModule::IncludeModule("sale") && CModule::IncludeModule("iblock"))
	   {
	 //СОСТАВ ЗАКАЗА РАЗБИРАЕМ SALE_ORDER НА ЗАПЧАСТИ
	      $strOrderList = "";
	      $dbBasketItems = CSaleBasket::GetList(
	                 array("NAME" => "ASC"),
	                 array("ORDER_ID" => $orderID),
	                 false,
	                 false,
	                 array("PRODUCT_ID", "ID", "NAME", "QUANTITY", "PRICE", "CURRENCY")
	               );
	 while ($arProps = $dbBasketItems->Fetch())
	  {
  //ПЕРЕМНОЖАЕМ КОЛИЧЕСТВО НА ЦЕНУ
      $summ = $arProps['QUANTITY'] * $arProps['PRICE'];
	  //СОБИРАЕМ В СТРОКУ ТАБЛИЦЫ
	       $strCustomOrderList .= "<tr><td>".$arProps['NAME']."</td><td>".$arProps['QUANTITY']."</td><td>".$arProps['PRICE']."</td><td>".$arProps['CURRENCY']."</td><td>".$summ."</td><tr>";
	  }
	  //ОБЪЯВЛЯЕМ ПЕРЕМЕННУЮ ДЛЯ ПИСЬМА
	  $arFields["ORDER_TABLE_ITEMS"] = $strCustomOrderList;
}
}
?>
