<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if (empty($arResult["CATEGORIES"])) return;?>
<div class="bx_searche scrollbar">
	<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
		<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
			<?//=$arCategory["TITLE"]?>
			<?if($category_id === "all"):?>
				<div class="bx_item_block all_result">
					<div class="maxwidth-theme">
						<div class="bx_item_element">
							<a class="all_result_title btn btn-default white bold" href="<?=$arItem["URL"]?>"><?=$arItem["NAME"]?></a>
						</div>
						<div style="clear:both;"></div>
					</div>
				</div>
			<?elseif(isset($arResult["ELEMENTS"][$arItem["ITEM_ID"]])):
				$arElement = $arResult["ELEMENTS"][$arItem["ITEM_ID"]];?>
				<a class="bx_item_block" href="<?=$arItem["URL"]?>">
					<div class="">
						<div class="bx_img_element">
							<?if(is_array($arElement["PICTURE"])):?>
								<div style="margin: 15px;width: 50px; height: 50px; background: url(<?=$arElement["PICTURE"]["src"]?>) no-repeat 50% 50%; background-size: contain;"></div>
							<?else:?>
								<img src="<?=SITE_TEMPLATE_PATH?>/images/no_photo_small.png" width="50" height="50">
							<?endif;?>
						</div>
						<div class="bx_item_element">
							<span><?=$arItem["NAME"]?></span>
							<div class="price cost prices">
								<div class="title-search-price">
									<?if($arElement["MIN_PRICE"]){?>
										<?if($arElement["MIN_PRICE"]["DISCOUNT_VALUE"] < $arElement["MIN_PRICE"]["VALUE"]):?>
											<div class="price"><?=$arElement["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"]?></div>
											<div class="price discount">
												<strike><?=$arElement["MIN_PRICE"]["PRINT_VALUE"]?></strike>
											</div>
										<?else:?>
											<div class="price"><?=$arElement["MIN_PRICE"]["PRINT_VALUE"]?></div>
										<?endif;?>
									<?}else{?>
										<?foreach($arElement["PRICES"] as $code=>$arPrice):?>
											<?if($arPrice["CAN_ACCESS"]):?>
												<?if (count($arElement["PRICES"])>1):?>
													<div class="price_name"><?=$arResult["PRICES"][$code]["TITLE"];?></div>
												<?endif;?>
												<?if ($arElement['PROPERTY_WEIGHTED_GOODS_VALUE']):?>
													<?$new_price = $arElement['PROPERTY_MINIMAL_COUNT_GOODS_VALUE'] * $arPrice["DISCOUNT_VALUE"];?>
													<?$old_price = $arElement['PROPERTY_MINIMAL_COUNT_GOODS_VALUE'] * $arPrice["VALUE"];?>
													<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
													<div class="price"><?=$new_price?> руб./<span><?=$arElement['PROPERTY_MINIMAL_COUNT_GOODS_VALUE']?> гр.</span></div>
													<div class="price discount">
														<strike><?=$old_price?> руб./<span><?=$arElement['PROPERTY_MINIMAL_COUNT_GOODS_VALUE']?> гр.</strike>
													</div>
													<?else:?>
													<div class="price"><?=$new_price?> руб./<span><?=$arElement['PROPERTY_MINIMAL_COUNT_GOODS_VALUE']?> гр.</div>
													<?endif;?>
												<?elseif($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
													<div class="price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></div>
													<div class="price discount">
														<strike><?=$arPrice["PRINT_VALUE"]?></strike>
													</div>
												<?else:?>
													<div class="price"><?=$arPrice["PRINT_VALUE"]?></div>
												<?endif;?>
											<?endif;?>
										<?endforeach;?>
									<?}?>
								</div>
							</div>
						</div>
						<div style="clear:both;"></div>
					</div>
				</a>
			<?else:?>
				<?if($arItem["MODULE_ID"]):?>
					<a class="bx_item_block others_result" href="<?=$arItem["URL"]?>">
						<div class="maxwidth-theme">
							<div class="bx_item_element">
								<span><?=$arItem["NAME"]?></span>
							</div>
							<div style="clear:both;"></div>
						</div>
					</a>
				<?endif;?>
			<?endif;?>
		<?endforeach;?>
	<?endforeach;?>
</div>
