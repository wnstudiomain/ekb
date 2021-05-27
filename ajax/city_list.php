<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
    \Bitrix\Main\Loader::includeModule('aspro.next');
    $arResult['REGIONS'] = CNextRegionality::getRegions();
    $arResult['CURRENT_REGION'] = CNextRegionality::getCurrentRegion();
    $arResult['REAL_REGION'] = CNextRegionality::getRealRegionByIP();
    $arResult['REGION_SELECTED'] = isset($_COOKIE['current_region']) && $_COOKIE['current_region'];
    foreach($arResult['REGIONS'] as $id => $arRegionItem)
    {
        $arResult['JS_REGIONS'][] = array(
            'label' => $arRegionItem['NAME'],
            'ID' => $arRegionItem['ID'],
            'LOCATION' => $arRegionItem['LOCATION'],
        );
    }
    echo json_encode($arResult['JS_REGIONS']);
?>
