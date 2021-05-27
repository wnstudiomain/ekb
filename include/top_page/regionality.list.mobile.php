<?global $arTheme;?>

<?$frame = new \Bitrix\Main\Page\FrameHelper('header-regionality-block');?>
<?$frame->begin();?>
<?
$template = strtolower($arTheme["USE_REGIONALITY"]["DEPENDENT_PARAMS"]["REGIONALITY_VIEW"]["VALUE"]);
if($arTheme["USE_REGIONALITY"]["DEPENDENT_PARAMS"]["REGIONALITY_SEARCH_ROW"]["VALUE"] == "Y" && $template == "select")
	$template = "popup_regions";
?>
<?$APPLICATION->IncludeComponent(
	"aspro:regionality.list.mobile.next",
	"popup_regions",
	array(
		"COMPONENT_TEMPLATE" => "popup_regions",
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y",
	)
);?>

<?$frame->end();?>
