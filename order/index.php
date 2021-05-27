<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оформление заказа");
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.ajax", 
	"new", 
	array(
		"PAY_FROM_ACCOUNT" => "N",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"COUNT_DELIVERY_TAX" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"ALLOW_AUTO_REGISTER" => "Y",
		"SEND_NEW_USER_NOTIFY" => "Y",
		"DELIVERY_NO_AJAX" => "H",
		"DELIVERY_NO_SESSION" => "N",
		"TEMPLATE_LOCATION" => "popup",
		"DELIVERY_TO_PAYSYSTEM" => "d2p",
		"USE_PREPAYMENT" => "N",
		"PROP_1" => "",
		"PROP_3" => "",
		"PROP_2" => "",
		"PROP_4" => "",
		"SHOW_STORES_IMAGES" => "Y",
		"PATH_TO_BASKET" => SITE_DIR."basket/",
		"PATH_TO_PERSONAL" => SITE_DIR."personal/",
		"PATH_TO_PAYMENT" => SITE_DIR."order/payment/",
		"PATH_TO_AUTH" => SITE_DIR."auth/",
		"SET_TITLE" => "Y",
		"PRODUCT_COLUMNS" => "",
		"DISABLE_BASKET_REDIRECT" => "N",
		"DISPLAY_IMG_WIDTH" => "90",
		"DISPLAY_IMG_HEIGHT" => "90",
		"COMPONENT_TEMPLATE" => "new",
		"ALLOW_NEW_PROFILE" => "N",
		"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
		"COMPATIBLE_MODE" => "N",
		"BASKET_IMAGES_SCALING" => "adaptive",
		"ALLOW_USER_PROFILES" => "N",
		"TEMPLATE_THEME" => "blue",
		"SHOW_TOTAL_ORDER_BUTTON" => "Y",
		"SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",
		"SHOW_PAY_SYSTEM_INFO_NAME" => "Y",
		"SHOW_DELIVERY_LIST_NAMES" => "Y",
		"SHOW_DELIVERY_INFO_NAME" => "Y",
		"SHOW_DELIVERY_PARENT_NAMES" => "N",
		"BASKET_POSITION" => "after",
		"SHOW_BASKET_HEADERS" => "Y",
		"DELIVERY_FADE_EXTRA_SERVICES" => "N",
		"SHOW_COUPONS_BASKET" => "N",
		"SHOW_COUPONS_DELIVERY" => "N",
		"SHOW_COUPONS_PAY_SYSTEM" => "N",
		"SHOW_NEAREST_PICKUP" => "Y",
		"DELIVERIES_PER_PAGE" => "8",
		"PAY_SYSTEMS_PER_PAGE" => "8",
		"PICKUPS_PER_PAGE" => "5",
		"SHOW_MAP_IN_PROPS" => "Y",
		"SHOW_MAP_FOR_DELIVERIES" => array(
			0 => "1",
			1 => "2",
		),
		"PROPS_FADE_LIST_1" => array(
			0 => "1",
			1 => "2",
			2 => "3",
			3 => "4",
			4 => "7",
		),
		"PROPS_FADE_LIST_2" => "",
		"PRODUCT_COLUMNS_VISIBLE" => array(
			0 => "PREVIEW_PICTURE",
			1 => "PROPS",
			2 => "NOTES",
			3 => "DISCOUNT_PRICE_PERCENT_FORMATED",
		),
		"ADDITIONAL_PICT_PROP_13" => "-",
		"ADDITIONAL_PICT_PROP_14" => "-",
		"PRODUCT_COLUMNS_HIDDEN" => array(
			0 => "PREVIEW_PICTURE",
			1 => "DETAIL_PICTURE",
			2 => "PREVIEW_TEXT",
			3 => "PROPS",
			4 => "NOTES",
			5 => "DISCOUNT_PRICE_PERCENT_FORMATED",
			6 => "PRICE_FORMATED",
			7 => "WEIGHT_FORMATED",
			8 => "PROPERTY_MINIMUM_PRICE",
			9 => "PROPERTY_MAXIMUM_PRICE",
			10 => "PROPERTY_BRAND",
			11 => "PROPERTY_HIT",
			12 => "PROPERTY_PROP_2033",
			13 => "PROPERTY_IN_STOCK",
		),
		"USE_YM_GOALS" => "N",
		"USE_CUSTOM_MAIN_MESSAGES" => "N",
		"USE_CUSTOM_ADDITIONAL_MESSAGES" => "Y",
		"USE_CUSTOM_ERROR_MESSAGES" => "N",
		"SHOW_ORDER_BUTTON" => "final_step",
		"SKIP_USELESS_BLOCK" => "Y",
		"SERVICES_IMAGES_SCALING" => "standard",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"ALLOW_APPEND_ORDER" => "Y",
		"SHOW_NOT_CALCULATED_DELIVERIES" => "L",
		"SPOT_LOCATION_BY_GEOIP" => "Y",
		"SHOW_VAT_PRICE" => "N",
		"USE_PRELOAD" => "N",
		"SHOW_PICKUP_MAP" => "Y",
		"PICKUP_MAP_TYPE" => "yandex",
		"USER_CONSENT" => "Y",
		"USER_CONSENT_ID" => "1",
		"USER_CONSENT_IS_CHECKED" => "Y",
		"USER_CONSENT_IS_LOADED" => "N",
		"ACTION_VARIABLE" => "soa-action",
		"USE_PHONE_NORMALIZATION" => "Y",
		"ADDITIONAL_PICT_PROP_17" => "-",
		"ADDITIONAL_PICT_PROP_20" => "-",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"SHOW_COUPONS" => "Y",
		"EMPTY_BASKET_HINT_PATH" => "/",
		"HIDE_ORDER_DESCRIPTION" => "Y",
		"MESS_PRICE_FREE" => "бесплатно",
		"MESS_ECONOMY" => "Экономия",
		"MESS_REGISTRATION_REFERENCE" => "Если вы впервые на сайте, и хотите, чтобы мы вас помнили и все ваши заказы сохранялись, заполните регистрационную форму.",
		"MESS_AUTH_REFERENCE_1" => "Символом \"звездочка\" (*) отмечены обязательные для заполнения поля.",
		"MESS_AUTH_REFERENCE_2" => "После регистрации вы получите информационное письмо.",
		"MESS_AUTH_REFERENCE_3" => "Личные сведения, полученные в распоряжение интернет-магазина при регистрации или каким-либо иным образом, не будут без разрешения пользователей передаваться третьим организациям и лицам за исключением ситуаций, когда этого требует закон или судебное решение.",
		"MESS_ADDITIONAL_PROPS" => "Дополнительные свойства",
		"MESS_USE_COUPON" => "Применить купон",
		"MESS_COUPON" => "Купон",
		"MESS_PERSON_TYPE" => "Тип плательщика",
		"MESS_SELECT_PROFILE" => "Выберите профиль",
		"MESS_REGION_REFERENCE" => "Выберите свой город в списке",
		"MESS_PICKUP_LIST" => "Пункты самовывоза:",
		"MESS_NEAREST_PICKUP_LIST" => "Ближайшие пункты:",
		"MESS_SELECT_PICKUP" => "Выбрать",
		"MESS_INNER_PS_BALANCE" => "На вашем пользовательском счете:",
		"MESS_ORDER_DESC" => "Комментарии к заказу:"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>