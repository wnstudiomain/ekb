<?
$count=count($arResult["ITEMS"]);
$diff=5-$count;
if($count<5){
	for($i=1;$i<=$diff;$i++){
		$arResult["ITEMS"][]='';
	}
}

foreach ($arResult['ITEMS'] as $items) {
	$arrProductId[] = $items["PRODUCT_ID"];
}
//print_r($arrProductId);
$arFilter = Array("ID"=>$arrProductId);
$arSelect = array('PROPERTY_MINIMAL_COUNT_GOODS', 'ID');

$rsEl = CIBlockElement::GetList(Array(), $arFilter, false, array(), $arSelect);
while($arEl = $rsEl->GetNext()){
	$arrMinimalCount[$arEl["ID"]] = $arEl["PROPERTY_MINIMAL_COUNT_GOODS_VALUE"];
	//print_r($arEl);
	//print_r($arResult);
	//$arResult["MINIMAL_COUNT_GOODS"] = $arEl["PROPERTY_MINIMAL_COUNT_GOODS_VALUE"];
}

foreach ($arResult['ITEMS'] as $key => $items) {
	$arResult["ITEMS"][$key]["MINIMAL_COUNT_GOODS"] = $arrMinimalCount[$items["PRODUCT_ID"]];
}


?>
