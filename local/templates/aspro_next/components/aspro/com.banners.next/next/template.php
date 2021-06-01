<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $this->setFrameMode(true); ?>
<? if ($arResult["ITEMS"]) { ?>
	<h2>Лучшие товары в категориях</h2>
	<div class="start_promo <?= ($arResult["OTHER_BANNERS_VIEW"] == "Y" ? "other" : "normal_view"); ?> row margin0">
		<? $i = 1;
		$k = 1;
		$isUrl = (strlen($arResult["ITEMS"][0]["PROPERTIES"]["URL_STRING"]["VALUE"]) ? true : false); ?>
		<div class="start_promo_wraper_big">
			<div class="s_<?= $i; ?> <?= ($isUrl ? "hover" : ""); ?> <?= ($arResult["ITEMS"][0]["PROPERTIES"]["BANNER_SIZE"]["VALUE_XML_ID"] ? $arResult["ITEMS"][0]["PROPERTIES"]["BANNER_SIZE"]["VALUE_XML_ID"] : "normal"); ?>" id="<?= $this->GetEditAreaId($arResult["ITEMS"][0]['ID']); ?>">
				<? $arResult["ITEMS"][0]["FORMAT_NAME"] = strip_tags($arResult["ITEMS"][0]["~NAME"]); ?>
				<? if ($isUrl) { ?>
					<a href="<?= $arResult["ITEMS"][0]["PROPERTIES"]["URL_STRING"]["VALUE"] ?>" class="opacity_block1 dark_block_animate" title="<?= $arResult["ITEMS"][0]["FORMAT_NAME"]; ?>" <?= ($arResult["ITEMS"][0]["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"] ? "target='" . $arResult["ITEMS"][0]["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"] . "'" : ""); ?>>
						<picture>
							<source media="(max-width: 650px)" srcset="about:blank">
							<img src="<?= ($arResult["ITEMS"][0]["DETAIL_PICTURE"]["SRC"] ? $arResult["ITEMS"][0]["DETAIL_PICTURE"]["SRC"] : $arResult["ITEMS"][0]["PREVIEW_PICTURE"]["SRC"]) ?>">
						</picture>
					</a>
				<? } else { ?>
					<div class="scale_block_animate img_block">
						<picture>
							<source media="(max-width: 650px)" srcset="about:blank">
							<img src="<?= ($arResult["ITEMS"][0]["DETAIL_PICTURE"]["SRC"] ? $arResult["ITEMS"][0]["DETAIL_PICTURE"]["SRC"] : $arResult["ITEMS"][0]["PREVIEW_PICTURE"]["SRC"]) ?>" />
					</div>
				<? } ?>
			</div>
		</div>

		<div class="start_promo_wraper_small">
			<? foreach ($arResult["ITEMS"] as $key => $arItem) : ?>
				<? if ($key == 0)
					continue ?>
				<?
				if ($arItem["PROPERTIES"]["MAIN_PAGE"]["VALUE_XML_ID"] == 'Y') {
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					$isUrl = (strlen($arItem["PROPERTIES"]["URL_STRING"]["VALUE"]) ? true : false);
				?>
					<? if ($arItem["DETAIL_PICTURE"]["SRC"] || $arItem["PREVIEW_PICTURE"]["SRC"]) : ?>
						<div class="s_<?= $i; ?> <?= ($isUrl ? "hover" : ""); ?> <?= ($arItem["PROPERTIES"]["BANNER_SIZE"]["VALUE_XML_ID"] ? $arItem["PROPERTIES"]["BANNER_SIZE"]["VALUE_XML_ID"] : "normal"); ?>" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
							<? $arItem["FORMAT_NAME"] = strip_tags($arItem["~NAME"]); ?>
							<? if ($isUrl) { ?>
								<a href="<?= $arItem["PROPERTIES"]["URL_STRING"]["VALUE"] ?>" class="opacity_block1 dark_block_animate" title="<?= $arItem["FORMAT_NAME"]; ?>" <?= ($arItem["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"] ? "target='" . $arItem["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"] . "'" : ""); ?>>
									<img src="<?= ($arItem["DETAIL_PICTURE"]["SRC"] ? $arItem["DETAIL_PICTURE"]["SRC"] : $arItem["PREVIEW_PICTURE"]["SRC"]) ?>" /></a>
							<? } else { ?>
								<div class="scale_block_animate img_block"><img src="<?= ($arItem["DETAIL_PICTURE"]["SRC"] ? $arItem["DETAIL_PICTURE"]["SRC"] : $arItem["PREVIEW_PICTURE"]["SRC"]) ?>" /></div>
							<? } ?>
						</div>
						<? $i++; ?>
					<? endif; ?>
				<? } ?>
			<? endforeach; ?>
		</div>
		<div class="adv-slider-mobile swiper-container">
			<div class="swiper-wrapper">
				<? foreach ($arResult["ITEMS"] as $key => $arItem) : ?>
					<?
					$background = is_array($arItem["DETAIL_PICTURE"]) ? $arItem["DETAIL_PICTURE"]["SRC"] : $arItem["PREVIEW_PICTURE"]["SRC"];
					$mobileItem = CFile::GetPath($arItem["PROPERTIES"]["MOBILE_IMAGE"]["VALUE"]);
					$mobileImage = (is_array($arItem["PROPERTIES"]["MOBILE_IMAGE"]) && strlen($mobileItem) !== 0)  ? $mobileItem : $background;
					$isUrl = (strlen($arItem["PROPERTIES"]["URL_STRING"]["VALUE"]) ? true : false);

					?>
					<? if ($arItem["DETAIL_PICTURE"]["SRC"] || $arItem["PREVIEW_PICTURE"]["SRC"]) : ?>
						<div class="swiper-slide sm_<?= $k; ?> <?= ($isUrl ? "hover" : ""); ?> <?= ($arItem["PROPERTIES"]["BANNER_SIZE"]["VALUE_XML_ID"] ? $arItem["PROPERTIES"]["BANNER_SIZE"]["VALUE_XML_ID"] : "normal"); ?>" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
							<? $arItem["FORMAT_NAME"] = strip_tags($arItem["~NAME"]); ?>
							<? if ($isUrl) { ?>
								<a href="<?= $arItem["PROPERTIES"]["URL_STRING"]["VALUE"] ?>" class="img_block" title="<?= $arItem["FORMAT_NAME"]; ?>" <?= ($arItem["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"] ? "target='" . $arItem["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"] . "'" : ""); ?>>
									<picture>
										<source class="swiper-lazy" media="(max-width: 650px)" srcset="/images/back.png" data-srcset="<?= $mobileImage ?>">
										<img src="<?= $background ?>">
									</picture>
								</a>
							<? } else { ?>
								<div class="scale_block_animate img_block">
									<picture>
										<source class="swiper-lazy" media="(max-width: 650px)" srcset="/images/back.png" data-srcset="<?= $mobileImage ?>">
										<img src="<?= $background ?>">
									</picture>
								</div>
							<? } ?>
						</div>
						<? $k++; ?>
					<? endif; ?>
				<? endforeach; ?>
			</div>
		</div>
	</div>
<? } ?>
