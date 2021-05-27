 <? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Акции");
$APPLICATION->SetPageProperty("keywords", "Акции");
$APPLICATION->SetPageProperty("title", "Акции");
$APPLICATION->SetTitle("Акции"); ?>
	<? $APPLICATION->IncludeComponent(
        "aspro:com.banners.next",
        "actions",
        array(
            "IBLOCK_TYPE" => "aspro_next_adv",
            "IBLOCK_ID" => "3",
            "TYPE_BANNERS_IBLOCK_ID" => "1",
            "SET_BANNER_TYPE_FROM_THEME" => "N",
            "NEWS_COUNT" => "10",
            "SORT_BY1" => "SORT",
            "SORT_ORDER1" => "ASC",
            "SORT_BY2" => "ID",
            "SORT_ORDER2" => "DESC",
            "PROPERTY_CODE" => array(
                0 => "URL",
                1 => "",
            ),
            "CHECK_DATES" => "Y",
            "CACHE_GROUPS" => "N",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "BANNER_TYPE_THEME" => "FLOAT"
        ),
        false
    ); ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>