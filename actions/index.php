<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Акции месяца");
$APPLICATION->SetPageProperty("keywords", "Акции месяца");
$APPLICATION->SetPageProperty("title", "Акции месяца");
$APPLICATION->SetTitle("Акции месяца"); ?>
<? $APPLICATION->IncludeComponent(
	"aspro:com.banners.next",
	"actions",
	array(
		"BANNER_TYPE_THEME" => "FLOAT",
		"BANNER_TYPE_THEME_CHILD" => "20",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"FILTER_NAME" => "",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "aspro_next_adv",
		"NEWS_COUNT" => "10",
		"NEWS_COUNT2" => "20",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "URL",
			2 => "",
		),
		"SET_BANNER_TYPE_FROM_THEME" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "DESC",
		"TYPE_BANNERS_IBLOCK_ID" => "1",
		"COMPONENT_TEMPLATE" => "FLOAT"
	),
	false
);
$APPLICATION->IncludeComponent(
	"aspro:com.banners.next",
	"insta",
	array(
		"BANNER_TYPE_THEME" => "INSTA",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"FILTER_NAME" => "",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "aspro_next_adv",
		"NEWS_COUNT" => "10",
		"NEWS_COUNT2" => "20",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "URL",
			2 => "",
		),
		"SET_BANNER_TYPE_FROM_THEME" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"TYPE_BANNERS_IBLOCK_ID" => "1",
		"COMPONENT_TEMPLATE" => "INSTA"
	),
	false
); ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
