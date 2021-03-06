<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $this->setFrameMode(true); ?>
<? if ($arResult['ITEMS']) : ?>
	<div class="wrapper_inner insta-block">
		<h2>Акции в нашем Instagram</h2>
		<p class="insta-info">Подпишитесь на наш <a href="https://www.instagram.com/restoranica.ru/">Instagram</a> и участвуйте в розыгрышах подарков, получайте дополнительные скидки и бонусы за активность, бесплатное сервисное обслуживание, кэшбэк за покупку и многое другое!</p>
		<!-- <a href="https://www.instagram.com/restoranica.ru/">Перейти в аккаунт</a> -->
		<div class="row swiper-container insta-block-wrapper">
			<div class="swiper-wrapper">
				<? foreach ($arResult['ITEMS'] as $arItem) {
					if ($arItem["PROPERTIES"]["PROMO_PAGE"]["VALUE_XML_ID"] == 'Y') {
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
						$isUrl = (strlen($arItem["PROPERTIES"]["URL_STRING"]["VALUE"]) ? true : false);
						$background = is_array($arItem["DETAIL_PICTURE"]) ? $arItem["DETAIL_PICTURE"]["SRC"] : $arItem["PREVIEW_PICTURE"]["SRC"];
						$mobileItem = CFile::GetPath($arItem["PROPERTIES"]["MOBILE_IMAGE"]["VALUE"]);
						$mobileImage = (is_array($arItem["PROPERTIES"]["MOBILE_IMAGE"]) && strlen($mobileItem) !== 0)  ? $mobileItem : $background;
				?>
						<? if ($isTitle) : ?>
							<? $arItem["FORMAT_NAME"] = strip_tags($arItem["PROPERTIES"]["HTML_TEXT"]["~VALUE"]["TEXT"]); ?>
						<? else : ?>
							<? $arItem["FORMAT_NAME"] = strip_tags($arItem["~NAME"]); ?>
						<? endif; ?>
						<? if ($arItem["DETAIL_PICTURE"]["SRC"] || $arItem["PREVIEW_PICTURE"]["SRC"]) : ?>
							<div class="swiper-slide sm_<?= $k; ?> <?= ($isUrl ? "hover" : ""); ?> <?= ($arItem["PROPERTIES"]["BANNER_SIZE"]["VALUE_XML_ID"] ? $arItem["PROPERTIES"]["BANNER_SIZE"]["VALUE_XML_ID"] : "normal"); ?>" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
								<? $arItem["FORMAT_NAME"] = strip_tags($arItem["~NAME"]); ?>
								<? if ($isUrl) { ?>
									<a href="<?= $arItem["PROPERTIES"]["URL_STRING"]["VALUE"] ?>" class="img_block" title="<?= $arItem["FORMAT_NAME"]; ?>" <?= ($arItem["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"] ? "target='" . $arItem["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"] . "'" : ""); ?>>
										<picture>
											<source class="swiper-lazy" media="(max-width: 650px)" srcset="/images/back-inst.png" data-srcset="<?= $mobileImage ?>">
											<img src="<?= $background ?>">
										</picture>
									</a>
								<? } else { ?>
									<div class="scale_block_animate img_block">
										<picture>
											<source class="swiper-lazy" media="(max-width: 650px)" srcset="/images/back-inst.png"" data-srcset="<?= $mobileImage ?>">
											<img src="<?= $background ?>">
										</picture>
									</div>
								<? } ?>
							</div>
							<? $k++; ?>
						<? endif; ?>
					<? } ?>

				<? } ?>
			</div>
			<ul class="flex-direction-nav">
				<li class="flex-nav-prev">
					<a class="flex-prev" href="#">Previous</a>
				</li>
				<li class="flex-nav-next">
					<a class="flex-next" href="#">Next</a>
				</li>
			</ul>
		</div>

	</div>
<? endif; ?>
