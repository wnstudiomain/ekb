<?$APPLICATION->IncludeComponent(
	"bitrix:search.title", 
	"corp", 
	array(
		"NUM_CATEGORIES" => "0",
		"TOP_COUNT" => "5",
		"ORDER" => "date",
		"USE_LANGUAGE_GUESS" => "N",
		"CHECK_DATES" => "N",
		"SHOW_OTHERS" => "N",
		"PAGE" => CNext::GetFrontParametrValue("CATALOG_PAGE_URL"),
		"CATEGORY_0_TITLE" => "ALL",
		"CATEGORY_OTHERS_TITLE" => "OTHER",
		"CATEGORY_0_iblock_aspro_next_catalog" => array(
			0 => "17",
		),
		"CATEGORY_0_iblock_aspro_next_content" => array(
			0 => "all",
		),
		"SHOW_INPUT" => "Y",
		"INPUT_ID" => "title-search-input_fixed",
		"CONTAINER_ID" => "title-search_fixed",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"SHOW_ANOUNCE" => "N",
		"PREVIEW_TRUNCATE_LEN" => "50",
		"SHOW_PREVIEW" => "Y",
		"PREVIEW_WIDTH" => "20",
		"PREVIEW_HEIGHT" => "20",
		"CONVERT_CURRENCY" => "N",
		"SHOW_INPUT_FIXED" => "Y",
		"COMPONENT_TEMPLATE" => "corp",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"CATEGORY_0" => array(
			0 => "iblock_aspro_next_catalog",
		)
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);?>
