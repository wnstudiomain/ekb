<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?foreach($_POST['arr'] as $id){
  $arSelect = Array("ID", "PRODUCT_ID");
  $arFilter = Array("ID"=>$id);
  $dbRes = CSaleBasket::GetList(array(), $arFilter, false, false, $arSelect);
  while($arRes = $dbRes->Fetch()){
  	$arrIdProduct[$arRes["ID"]] = $arRes["PRODUCT_ID"];
  }


  $arResult = $arrIdProduct;
  $arResultFlipped = array_flip($arrIdProduct);

  $arSelect = Array("ID", "PROPERTY_MINIMAL_COUNT_GOODS", "PROPERTY_WEIGHTED_GOODS");
  $arFilter = Array("ID"=>$arrIdProduct);
  $res = CIBlockElement::GetList(array(), $arFilter, false, array(), $arSelect);
  while($ob = $res->GetNextElement())
  {
   $arFields = $ob->GetFields();
   if($arFields["PROPERTY_MINIMAL_COUNT_GOODS_VALUE"] && $arFields["PROPERTY_WEIGHTED_GOODS_VALUE"]){
     $arResult[$arResultFlipped[$arFields['ID']]] = $arFields["PROPERTY_MINIMAL_COUNT_GOODS_VALUE"];
   }else{
     $arResult[$arResultFlipped[$arFields['ID']]] = "";
   }
  }
}

print_r(\Bitrix\Main\Web\Json::encode($arResult));
?>
