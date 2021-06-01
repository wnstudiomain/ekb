<?
namespace Aspro\Functions;

use Bitrix\Main\Application;
use Bitrix\Main\Web\DOM\Document;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Web\DOM\CssParser;
use Bitrix\Main\Text\HtmlFilter;
use Bitrix\Main\IO\File;
use Bitrix\Main\IO\Directory;
use	\Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);
\Bitrix\Main\Loader::includeModule('sale');
\Bitrix\Main\Loader::includeModule('catalog');

//user custom functions

if(!class_exists("CAsproNextCustom"))
{
	class CAsproNextCustom{
		const partnerName	= 'aspro';
		const solutionName	= 'next';
		const moduleID		= ASPRO_NEXT_MODULE_ID;
		const wizardID		= 'aspro:next';
		const devMode 		= false;
		public static function GetAddToBasketArray(&$arItem, $totalCount = 0, $defaultCount = 1, $basketUrl = '', $bDetail = false, $arItemIDs = array(), $class_btn = "small", $arParams=array(),$minimalCountGoods){
			static $arAddToBasketOptions, $bUserAuthorized;
			if($arAddToBasketOptions === NULL){
				$arAddToBasketOptions = array(
					"SHOW_BASKET_ONADDTOCART" => Option::get(self::moduleID, "SHOW_BASKET_ONADDTOCART", "Y", SITE_ID) == "Y",
					"USE_PRODUCT_QUANTITY_LIST" => Option::get(self::moduleID, "USE_PRODUCT_QUANTITY_LIST", "Y", SITE_ID) == "Y",
					"USE_PRODUCT_QUANTITY_DETAIL" => Option::get(self::moduleID, "USE_PRODUCT_QUANTITY_DETAIL", "Y", SITE_ID) == "Y",
					"BUYNOPRICEGGOODS" => Option::get(self::moduleID, "BUYNOPRICEGGOODS", "NOTHING", SITE_ID),
					"BUYMISSINGGOODS" => Option::get(self::moduleID, "BUYMISSINGGOODS", "ADD", SITE_ID),
					"EXPRESSION_ORDER_BUTTON" => Option::get(self::moduleID, "EXPRESSION_ORDER_BUTTON", GetMessage("EXPRESSION_ORDER_BUTTON_DEFAULT"), SITE_ID),
					"EXPRESSION_ORDER_TEXT" => Option::get(self::moduleID, "EXPRESSION_ORDER_TEXT", GetMessage("EXPRESSION_ORDER_TEXT_DEFAULT"), SITE_ID),
					"EXPRESSION_SUBSCRIBE_BUTTON" => Option::get(self::moduleID, "EXPRESSION_SUBSCRIBE_BUTTON", GetMessage("EXPRESSION_SUBSCRIBE_BUTTON_DEFAULT"), SITE_ID),
					"EXPRESSION_SUBSCRIBED_BUTTON" => Option::get(self::moduleID, "EXPRESSION_SUBSCRIBED_BUTTON", GetMessage("EXPRESSION_SUBSCRIBED_BUTTON_DEFAULT"), SITE_ID),
					"EXPRESSION_ADDTOBASKET_BUTTON_DEFAULT" => Option::get(self::moduleID, "EXPRESSION_ADDTOBASKET_BUTTON_DEFAULT", GetMessage("EXPRESSION_ADDTOBASKET_BUTTON_DEFAULT"), SITE_ID),
					"EXPRESSION_ADDEDTOBASKET_BUTTON_DEFAULT" => Option::get(self::moduleID, "EXPRESSION_ADDEDTOBASKET_BUTTON_DEFAULT", GetMessage("EXPRESSION_ADDEDTOBASKET_BUTTON_DEFAULT"), SITE_ID),
					"EXPRESSION_READ_MORE_OFFERS_DEFAULT" => Option::get(self::moduleID, "EXPRESSION_READ_MORE_OFFERS_DEFAULT", GetMessage("EXPRESSION_READ_MORE_OFFERS_DEFAULT"), SITE_ID),
				);

				global $USER;
				$bUserAuthorized = $USER->IsAuthorized();
			}



			$buttonText = $buttonHTML = $buttonACTION = '';
			$quantity=$ratio=1;
			$max_quantity=0;
			$float_ratio=is_double($arItem["CATALOG_MEASURE_RATIO"]);


			if($arItem["CATALOG_MEASURE_RATIO"]){
				$quantity=$arItem["CATALOG_MEASURE_RATIO"];
				$ratio=$arItem["CATALOG_MEASURE_RATIO"];
			}else{
				$quantity=$defaultCount;
			}
			if($arItem["CATALOG_QUANTITY_TRACE"]=="Y"){
				if($totalCount < $quantity){
					$quantity=($totalCount>$arItem["CATALOG_MEASURE_RATIO"] ? $totalCount : $arItem["CATALOG_MEASURE_RATIO"] );
				}
				$max_quantity=$totalCount;
			}

			$canBuy = $arItem["CAN_BUY"];
			if($arParams['USE_REGION'] == 'Y' && $arParams['STORES'])
				$canBuy = ($totalCount || ((!$totalCount && $arItem["CATALOG_QUANTITY_TRACE"] == "N") || (!$totalCount && $arItem["CATALOG_QUANTITY_TRACE"] == "Y" && $arItem["CATALOG_CAN_BUY_ZERO"] == "Y")));
			$arItem["CAN_BUY"] = $canBuy;

			$arItemProps = (($arParams['PRODUCT_PROPERTIES']) ? implode(';', $arParams['PRODUCT_PROPERTIES']) : "");
			$partProp=($arParams["PARTIAL_PRODUCT_PROPERTIES"] ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : "" );
			$addProp=($arParams["ADD_PROPERTIES_TO_BASKET"] ? $arParams["ADD_PROPERTIES_TO_BASKET"] : "" );
			$emptyProp=$arItem["EMPTY_PROPS_JS"];
			global $arTheme;
			if($arItem["OFFERS"]){
				$type_sku = (isset($arTheme["TYPE_SKU"]["VALUE"]) ? $arTheme["TYPE_SKU"]["VALUE"] : $arTheme["TYPE_SKU"]);
				if(!$bDetail && $arItem["OFFERS_MORE"] != "Y" && (is_array($arTheme) && $type_sku != "TYPE_2")){
					$buttonACTION = 'ADD';
					$buttonText = array($arAddToBasketOptions['EXPRESSION_ADDTOBASKET_BUTTON_DEFAULT'], $arAddToBasketOptions['EXPRESSION_ADDEDTOBASKET_BUTTON_DEFAULT']);
					$buttonHTML = '<span class="btn btn-default transition_bg '.$class_btn.' read_more1 to-cart animate-load" id="'.$arItemIDs['BUY_LINK'].'" data-offers="N" data-iblockID="'.$arItem["IBLOCK_ID"].'" data-item="'.$arItem["ID"].'"><i></i><span>'.$buttonText[0].'</span></span><a rel="nofollow" href="'.$basketUrl.'" id="'.$arItemIDs['BASKET_LINK'].'" class="'.$class_btn.' in-cart btn btn-default transition_bg" data-item="'.$arItem["ID"].'"  style="display:none;"><i></i><span>'.$buttonText[1].'</span></a>';
				}
				elseif(($bDetail && $arItem["FRONT_CATALOG"] == "Y") || $arItem["OFFERS_MORE"]=="Y" || (is_array($arTheme) && $type_sku == "TYPE_2")){
					$buttonACTION = 'MORE';
					$buttonText = array($arAddToBasketOptions['EXPRESSION_READ_MORE_OFFERS_DEFAULT']);
					$buttonHTML = '<a class="btn btn-default basket read_more" rel="nofollow" href="'.$arItem["DETAIL_PAGE_URL"].'" data-item="'.$arItem["ID"].'">'.$buttonText[0].'</a>';
				}
			}
			else{
				if($bPriceExists = isset($arItem["MIN_PRICE"]) && $arItem["MIN_PRICE"]["VALUE"] > 0){
					// price exists
					if($totalCount > 0){
						// rest exists
						if((isset($arItem["CAN_BUY"]) && $arItem["CAN_BUY"]) || (isset($arItem["MIN_PRICE"]) && $arItem["MIN_PRICE"]["CAN_BUY"] == "Y")){
							if($bDetail && $arItem["FRONT_CATALOG"] == "Y"){
								$buttonACTION = 'MORE';
								$buttonText = array($arAddToBasketOptions['EXPRESSION_READ_MORE_OFFERS_DEFAULT']);
								$rid=($arItem["RID"] ? "?RID=".$arItem["RID"] : "");
								$buttonHTML = '<a class="btn btn-default transition_bg basket read_more" rel="nofollow" href="'.$arItem["DETAIL_PAGE_URL"].$rid.'" data-item="'.$arItem["ID"].'">'.$buttonText[0].'</a>';
							}
							else{

								$arItem["CAN_BUY"] = 1;
								$buttonACTION = 'ADD';
								$buttonText = array($arAddToBasketOptions['EXPRESSION_ADDTOBASKET_BUTTON_DEFAULT'], $arAddToBasketOptions['EXPRESSION_ADDEDTOBASKET_BUTTON_DEFAULT']);
								$buttonHTML = '<span data-value="'.$arItem["MIN_PRICE"]["DISCOUNT_VALUE"].'" data-currency="'.$arItem["MIN_PRICE"]["CURRENCY"].'" class="'.$class_btn.' to-cart btn btn-default transition_bg animate-load" data-item="'.$arItem["ID"].'" data-float_ratio="'.$float_ratio.'" data-ratio="'.$ratio.'" data-mini_count = "'. $minimalCountGoods.'" data-bakset_div="bx_basket_div_'.$arItem["ID"].'" data-props="'.$arItemProps.'" data-part_props="'.$partProp.'" data-add_props="'.$addProp.'"  data-empty_props="'.$emptyProp.'" data-offers="'.$arItem["IS_OFFER"].'" data-iblockID="'.$arItem["IBLOCK_ID"].'"  data-quantity="'.$minimalCountGoods.'"><i></i><span>'.$buttonText[0].'</span></span><a rel="nofollow" href="'.$basketUrl.'" class="'.$class_btn.' in-cart btn btn-default transition_bg" data-item="'.$arItem["ID"].'"  style="display:none;"><i></i><span>'.$buttonText[1].'</span></a>';
							}
						}
						elseif($arItem["CATALOG_SUBSCRIBE"] == "Y"){
							$buttonACTION = 'SUBSCRIBE';
							$buttonText = array($arAddToBasketOptions['EXPRESSION_SUBSCRIBE_BUTTON'], $arAddToBasketOptions['EXPRESSION_SUBSCRIBED_BUTTON']);
							$buttonHTML = '<span class="'.$class_btn.' ss to-subscribe'.(!$bUserAuthorized ? ' auth' : '').(self::checkVersionModule('16.5.3', 'catalog') ? ' nsubsc' : '').' btn btn-default transition_bg" rel="nofollow" data-param-form_id="subscribe" data-name="subscribe" data-param-id="'.$arItem["ID"].'" data-item="'.$arItem["ID"].'"><i></i><span>'.$buttonText[0].'</span></span><span class="'.$class_btn.' ss in-subscribe btn btn-default transition_bg" rel="nofollow" style="display:none;" data-item="'.$arItem["ID"].'"><i></i><span>'.$buttonText[1].'</span></span>';
						}
					}
					else{
						if(!strlen($arAddToBasketOptions['EXPRESSION_ORDER_BUTTON'])){
							$arAddToBasketOptions['EXPRESSION_ORDER_BUTTON']=GetMessage("EXPRESSION_ORDER_BUTTON_DEFAULT");
						}
						// no rest
						if($bDetail && $arItem["FRONT_CATALOG"] == "Y"){
							$buttonACTION = 'MORE';
							$buttonText = array($arAddToBasketOptions['EXPRESSION_READ_MORE_OFFERS_DEFAULT']);
							$rid=($arItem["RID"] ? "?RID=".$arItem["RID"] : "");
							$buttonHTML = '<a class="btn btn-default basket read_more" rel="nofollow" href="'.$arItem["DETAIL_PAGE_URL"].$rid.'" data-item="'.$arItem["ID"].'">'.$buttonText[0].'</a>';
						}
						else{
							$buttonACTION = $arAddToBasketOptions["BUYMISSINGGOODS"];
							if($arAddToBasketOptions["BUYMISSINGGOODS"] == "ADD" /*|| $arItem["CAN_BUY"]*/){
								if($arItem["CAN_BUY"]){
									$buttonText = array($arAddToBasketOptions['EXPRESSION_ADDTOBASKET_BUTTON_DEFAULT'], $arAddToBasketOptions['EXPRESSION_ADDEDTOBASKET_BUTTON_DEFAULT']);
									$buttonHTML = '<span data-value="'.$arItem["MIN_PRICE"]["DISCOUNT_VALUE"].'" data-currency="'.$arItem["MIN_PRICE"]["CURRENCY"].'" class="'.$class_btn.' to-cart btn btn-default transition_bg animate-load" data-item="'.$arItem["ID"].'" data-float_ratio="'.$float_ratio.'" data-mini_count = "'. $minimalCountGoods.'" data-ratio="'.$ratio.'" data-bakset_div="bx_basket_div_'.$arItem["ID"].'" data-props="'.$arItemProps.'" data-part_props="'.$partProp.'" data-add_props="'.$addProp.'"  data-empty_props="'.$emptyProp.'" data-offers="'.$arItem["IS_OFFER"].'" data-iblockID="'.$arItem["IBLOCK_ID"].'" data-quantity="'.$quantity.'"><i></i><span>'.$buttonText[0].'</span></span><a rel="nofollow" href="'.$basketUrl.'" class="'.$class_btn.' in-cart btn btn-default transition_bg" data-item="'.$arItem["ID"].'"  style="display:none;"><i></i><span>'.$buttonText[1].'</span></a>';
								}else{
									if($arAddToBasketOptions["BUYMISSINGGOODS"] == "SUBSCRIBE" && $arItem["CATALOG_SUBSCRIBE"] == "Y"){
										$buttonText = array($arAddToBasketOptions['EXPRESSION_SUBSCRIBE_BUTTON'], $arAddToBasketOptions['EXPRESSION_SUBSCRIBED_BUTTON']);
										$buttonHTML = '<span class="'.$class_btn.' ss to-subscribe'.(!$bUserAuthorized ? ' auth' : '').(self::checkVersionModule('16.5.3', 'catalog') ? ' nsubsc' : '').' btn btn-default transition_bg" rel="nofollow" data-name="subscribe" data-param-form_id="subscribe" data-param-id="'.$arItem["ID"].'"  data-item="'.$arItem["ID"].'"><i></i><span>'.$buttonText[0].'</span></span><span class="'.$class_btn.' ss in-subscribe btn btn-default transition_bg" rel="nofollow" style="display:none;" data-item="'.$arItem["ID"].'"><i></i><span>'.$buttonText[1].'</span></span>';
									}else{
										$buttonText = array($arAddToBasketOptions['EXPRESSION_ORDER_BUTTON']);
										$buttonHTML = '<span class="'.$class_btn.' to-order btn btn-default white grey transition_bg transparent animate-load" data-event="jqm" data-param-form_id="TOORDER" data-name="toorder" data-autoload-product_name="'.\CNext::formatJsName($arItem["NAME"]).'" data-autoload-product_id="'.$arItem["ID"].'"><i></i><span>'.$buttonText[0].'</span></span>';
										if($arAddToBasketOptions['EXPRESSION_ORDER_TEXT']){
											$buttonHTML .='<div class="more_text">'.$arAddToBasketOptions['EXPRESSION_ORDER_TEXT'].'</div>';
										}
									}
								}

							}
							elseif($arAddToBasketOptions["BUYMISSINGGOODS"] == "SUBSCRIBE" && $arItem["CATALOG_SUBSCRIBE"] == "Y"){
								$buttonText = array($arAddToBasketOptions['EXPRESSION_SUBSCRIBE_BUTTON'], $arAddToBasketOptions['EXPRESSION_SUBSCRIBED_BUTTON']);
								$buttonHTML = '<span class="'.$class_btn.' ss to-subscribe'.(!$bUserAuthorized ? ' auth' : '').(self::checkVersionModule('16.5.3', 'catalog') ? ' nsubsc' : '').' btn btn-default transition_bg" data-name="subscribe" data-param-form_id="subscribe" data-param-id="'.$arItem["ID"].'"  rel="nofollow" data-item="'.$arItem["ID"].'"><i></i><span>'.$buttonText[0].'</span></span><span class="'.$class_btn.' ss in-subscribe btn btn-default transition_bg" rel="nofollow" style="display:none;" data-item="'.$arItem["ID"].'"><i></i><span>'.$buttonText[1].'</span></span>';
							}
							elseif($arAddToBasketOptions["BUYMISSINGGOODS"] == "ORDER"){
								$buttonText = array($arAddToBasketOptions['EXPRESSION_ORDER_BUTTON']);
								$buttonHTML = '<span class="'.$class_btn.' to-order btn btn-default white grey transition_bg transparent animate-load" data-event="jqm" data-param-form_id="TOORDER" data-name="toorder" data-autoload-product_name="'.\CNext::formatJsName($arItem["NAME"]).'" data-autoload-product_id="'.$arItem["ID"].'"><i></i><span>'.$buttonText[0].'</span></span>';
								if($arAddToBasketOptions['EXPRESSION_ORDER_TEXT']){
									$buttonHTML .='<div class="more_text">'.$arAddToBasketOptions['EXPRESSION_ORDER_TEXT'].'</div>';
								}
							}
						}
					}
				}
				else{
					// no price or price <= 0
					if($bDetail && $arItem["FRONT_CATALOG"] == "Y"){
						$buttonACTION = 'MORE';
						$buttonText = array($arAddToBasketOptions['EXPRESSION_READ_MORE_OFFERS_DEFAULT']);
						$buttonHTML = '<a class="btn btn-default transition_bg basket read_more" rel="nofollow" href="'.$arItem["DETAIL_PAGE_URL"].'" data-item="'.$arItem["ID"].'">'.$buttonText[0].'</a>';
					}
					else{
						$buttonACTION = $arAddToBasketOptions["BUYNOPRICEGGOODS"];
						if($arAddToBasketOptions["BUYNOPRICEGGOODS"] == "ORDER"){
							$buttonText = array($arAddToBasketOptions['EXPRESSION_ORDER_BUTTON']);
							$buttonHTML = '<span class="'.$class_btn.' to-order btn btn-default white grey transition_bg transparent animate-load" data-event="jqm" data-param-form_id="TOORDER" data-name="toorder" data-autoload-product_name="'.self::formatJsName($arItem["NAME"]).'" data-autoload-product_id="'.$arItem["ID"].'"><i></i><span>'.$buttonText[0].'</span></span>';
							if($arAddToBasketOptions['EXPRESSION_ORDER_TEXT']){
								$buttonHTML .='<div class="more_text">'.$arAddToBasketOptions['EXPRESSION_ORDER_TEXT'].'</div>';
							}
						}
					}
				}
			}
			$arOptions = array("OPTIONS" => $arAddToBasketOptions, "TEXT" => $buttonText, "HTML" => $buttonHTML, "ACTION" => $buttonACTION, "RATIO_ITEM" => $ratio, "MIN_QUANTITY_BUY" => $minimalCountGoods, "MAX_QUANTITY_BUY" => $max_quantity, "CAN_BUY" => $canBuy);

			foreach(GetModuleEvents(ASPRO_NEXT_MODULE_ID, 'OnAsproGetBuyBlockElement', true) as $arEvent) // event for manipulation with buy block element
				ExecuteModuleEventEx($arEvent, array($arItem, $totalCount, $arParams, &$arOptions));

			return $arOptions;

		}
		public static function getCurrentPrice($price_field, $arPrice, $price){
			$val = '';
			$format_value = \CCurrencyLang::CurrencyFormat($arPrice[$price_field], $arPrice['CURRENCY'], false);
			if(strpos($arPrice["PRINT_".$price_field], $format_value) !== false):
				$val = str_replace($format_value, '<span class="price_value">'.$price.'</span><span class="price_currency">', $arPrice["PRINT_".$price_field].'</span>');
			else:
				$val = $arPrice["PRINT_".$price_field];
			endif;

			return $val;


		}
		public static function showPriceMatrix($arItem = array(), $arParams, $strMeasure = '', $arAddToBasketData = array(), $minimalCountGoods){
			$html = '';
			if(isset($arItem['PRICE_MATRIX']) && $arItem['PRICE_MATRIX'])
			{
				ob_start();?>
					<div class="price_matrix_block">
						<?
						$sDiscountPrices = \Bitrix\Main\Config\Option::get(ASPRO_NEXT_MODULE_ID, 'DISCOUNT_PRICE');
						$arDiscountPrices = array();
						if($sDiscountPrices)
							$arDiscountPrices = array_flip(explode(',', $sDiscountPrices));

						\Bitrix\Main\Type\Collection::sortByColumn($arItem['PRICE_MATRIX']['COLS'], array('SORT' => SORT_ASC));

						$arTmpPrice = (isset($arItem['ITEM_PRICES']) ? current($arItem['ITEM_PRICES']) : array());

						$iCountPriceGroup = count($arItem['PRICE_MATRIX']['COLS']);
						$bPriceRows = (count($arItem['PRICE_MATRIX']['ROWS']) > 1);?>
						<?foreach($arItem['PRICE_MATRIX']['COLS'] as $arPriceGroup):?>
							<?if($iCountPriceGroup > 1):?>
								<?
								$class = '';
								if($arTmpPrice)
								{
									if($arItem['PRICE_MATRIX']['MATRIX'][$arPriceGroup['ID']][$arTmpPrice['QUANTITY_HASH']]['ID'] == $arTmpPrice['ID'])
										$class = 'min';
								}?>
								<div class="price_group <?=$class;?>  <?=$arPriceGroup['XML_ID']?>"><div class="price_name"><?=$arPriceGroup["NAME_LANG"];?></div>
							<?endif;?>
							<div class="price_matrix_wrapper <?=($arDiscountPrices ? (isset($arDiscountPrices[$arPriceGroup['ID']]) ? 'strike_block' : '') : '');?>">
							<?$iCountPriceInterval = count($arItem['PRICE_MATRIX']['MATRIX'][$arPriceGroup['ID']]);?>
							<?foreach($arItem['PRICE_MATRIX']['MATRIX'][$arPriceGroup['ID']] as $key => $arPrice):?>
								<?if($iCountPriceInterval > 1):?>
									<div class="price_wrapper_block">
										<div class="price_interval">
											<?
											$quantity_from = $arItem['PRICE_MATRIX']['ROWS'][$key]['QUANTITY_FROM'];
											$quantity_to = $arItem['PRICE_MATRIX']['ROWS'][$key]['QUANTITY_TO'];
											$text = ($quantity_to ? ($quantity_from ? $quantity_from.'-'.$quantity_to : '<'.$quantity_to ) : '>'.$quantity_from );
											?>
											<?=$text?><?if(($arParams["SHOW_MEASURE"]=="Y") && $strMeasure):?> <?=$strMeasure?><?endif;?>
										</div>
									<?endif;?>
									<?if($arPrice["PRICE"] > $arPrice["DISCOUNT_PRICE"]){?>
										<div class="price" data-currency="<?=$arPrice["CURRENCY"];?>" data-value="<?=$arPrice["DISCOUNT_PRICE"];?>">
											<?if(strlen($arPrice["DISCOUNT_PRICE"])):?>
												<span class="values_wrapper"><?=\Aspro\Functions\CAsproNextCustom::getCurrentPrice("DISCOUNT_PRICE", $arPrice, $price);?></span><?if(($arParams["SHOW_MEASURE"]=="Y") && $strMeasure && $arPrice["DISCOUNT_PRICE"]):?><span class="price_measure1">/<?=$strMeasure?></span><?endif;?>
											<?endif;?>
										</div>
										<?if($arParams["SHOW_OLD_PRICE"]=="Y"):?>
											<div class="price discount" data-currency="<?=$arPrice["CURRENCY"];?>" data-value="<?=$arPrice["PRICE"];?>">
												<span class="values_wrapper"><?=\Aspro\Functions\CAsproNextCustom::getCurrentPrice("PRICE", $arPrice, $price);?></span>
											</div>
										<?endif;?>
									<?}else{?>
										<?$price = $arPrice["PRICE"] * $minimalCountGoods;?>
										<div class="price" data-currency="<?=$arPrice["CURRENCY"];?>" data-value="<?=$arPrice["DISCOUNT_PRICE"];?>">
											<span>
												<span class="values_wrapper">
													<?=\Aspro\Functions\CAsproNextCustom::getCurrentPrice("PRICE", $arPrice, $price);?>
											</span>
												<?if(($arParams["SHOW_MEASURE"]=="Y") && $strMeasure && $arPrice["PRICE"]):?>
													<span class="price_measure">/<?=$strMeasure?></span>
												<?endif;?></span>
										</div>
									<?}?>
								<?if($iCountPriceInterval > 1):?>
									</div>
								<?else:
									if($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y' && $arPrice["PRICE"] > $arPrice["DISCOUNT_PRICE"]):?>
										<?$ratio = (!$bPriceRows ? $arAddToBasketData["MIN_QUANTITY_BUY"] : 1);?>
										<div class="sale_block">
											<span class="title"><?=GetMessage("CATALOG_ECONOMY");?></span> <div class="text"><span class="values_wrapper" data-currency="<?=$arPrice["CURRENCY"];?>" data-value="<?=(($arPrice["PRICE"] - $arPrice["DISCOUNT_PRICE"])*$ratio);?>"><?=CAllCurrencyLang::CurrencyFormat(($arPrice["PRICE"] - $arPrice["DISCOUNT_PRICE"]), $arPrice['CURRENCY'])?></span></div>
										</div>
									<?endif;?>
								<?endif;?>
							<?endforeach;?>
							</div>
							<?if($iCountPriceGroup > 1):?>
								</div>
							<?endif;?>
						<?endforeach;?>
					</div>
				<?$html = ob_get_contents();
				ob_end_clean();

				foreach(GetModuleEvents(ASPRO_NEXT_MODULE_ID, 'OnAsproShowPriceMatrix', true) as $arEvent) // event for manipulation price matrix
					ExecuteModuleEventEx($arEvent, array($arItem, $arParams, $strMeasure, $arAddToBasketData, &$html));
			}
			return $html;
		}
	}
}?>
