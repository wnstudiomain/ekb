<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $this->setFrameMode(true); ?>
<? if ($arResult['ITEMS']) : ?>
	<div class="wrapper_inner promo-page">
		<div class="row">
			<? foreach ($arResult['ITEMS'] as $arItem) {
				if ($arItem["PROPERTIES"]["PROMO_PAGE"]["VALUE_XML_ID"] == 'Y') {
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					$isUrl = (strlen($arItem["PROPERTIES"]["URL_STRING"]["VALUE"]) ? true : false);
					$isUrl2 = (strlen($arItem["PROPERTIES"]["URL_STRING2"]["VALUE"]) ? true : false);
					$isUrlmore = (strlen($arItem["PROPERTIES"]["URL_MORE"]["VALUE"]["TEXT"]) ? true : false);
					$isTitle = (strlen($arItem["PROPERTIES"]["HTML_TEXT"]["VALUE"]["TEXT"]) ? true : false);
			?>

					<? if ($isTitle) : ?>
						<? $arItem["FORMAT_NAME"] = strip_tags($arItem["PROPERTIES"]["HTML_TEXT"]["~VALUE"]["TEXT"]); ?>
					<? else : ?>
						<? $arItem["FORMAT_NAME"] = strip_tags($arItem["~NAME"]); ?>
					<? endif; ?>
					<div class="promo-item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
						<? if ($arItem["DETAIL_PICTURE"]["SRC"] || $arItem["PREVIEW_PICTURE"]["SRC"]) : ?>
							<div class="<?= ($arItem["PROPERTIES"]["BANNER_SIZE"]["VALUE_XML_ID"] ? $arItem["PROPERTIES"]["BANNER_SIZE"]["VALUE_XML_ID"] : "normal"); ?> promo-image" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
								<? if ($isUrl) { ?>
									<a href="<?= $arItem["PROPERTIES"]["URL_STRING"]["VALUE"] ?>" title="<?= $arItem["FORMAT_NAME"]; ?>" <?= ($arItem["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"] ? "target='" . $arItem["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"] . "'" : ""); ?>>
										<img src="<?= ($arItem["DETAIL_PICTURE"]["SRC"] ? $arItem["DETAIL_PICTURE"]["SRC"] : $arItem["PREVIEW_PICTURE"]["SRC"]) ?>" /></a>
								<? } else { ?>
									<div class="img_block"><img src="<?= ($arItem["DETAIL_PICTURE"]["SRC"] ? $arItem["DETAIL_PICTURE"]["SRC"] : $arItem["PREVIEW_PICTURE"]["SRC"]) ?>" /></div>
								<? } ?>
							</div>
						<? endif; ?>
						<div class="info">
							<? if ($arItem['ACTIVE_FROM'] && $arItem['ACTIVE_TO']) : ?>
								<?
								$date = substr($arItem['ACTIVE_TO'], 0, 2);
								$newDate = DateTime::createFromFormat('d.m.Y', $arItem['ACTIVE_TO']);
								$day = $newDate->format('j');
								$intlFormatter = new IntlDateFormatter('ru_RU', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
								$intlFormatter->setPattern('MMMM');
								$month = $intlFormatter->format($newDate);
								?>
								<div class="active-date">
									<?= 'до ' . $day . ' ' . $month; ?>
								</div>
							<? endif; ?>
							<? if ($isTitle) : ?>
								<h2><?= htmlspecialcharsBack($arItem["PROPERTIES"]["HTML_TEXT"]["VALUE"]["TEXT"]); ?></h2>
							<? else : ?>
								<h2><?= $arItem['NAME']; ?></h2>
							<? endif; ?>
							<? if ($arItem['DETAIL_TEXT']) : ?>
								<div class="desc"><?= $arItem['DETAIL_TEXT']; ?></div>
							<? endif; ?>
							<div class="button-group">
								<? if ($isUrlmore) : ?>
									<a class="promo-link promo-link-more" href="<?= $arItem["PROPERTIES"]["URL_MORE"]["VALUE"] ?>" title="Полные условия акции" <?= ($arItem["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"] ? "target='" . $arItem["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"] . "'" : ""); ?>>
										Полные условия акции
									</a>
								<? endif; ?>
								<? if ($isUrl) : ?>
									<a class="promo-link promo-link-url1" href="<?= $arItem["PROPERTIES"]["URL_STRING"]["VALUE"] ?>" title="<?= $arItem["PROPERTIES"]["URL_STRIN1TEXT"]["VALUE"] ?>" <?= ($arItem["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"] ? "target='" . $arItem["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"] . "'" : ""); ?>>
										<?= $arItem["PROPERTIES"]["URL_STRIN1TEXT"]["VALUE"] ?>
									</a>
								<? endif; ?>
								<? if ($isUrl2) : ?>
									<a class="promo-link promo-link-url2" href="<?= $arItem["PROPERTIES"]["URL_STRING2"]["VALUE"] ?>" title="<?= $arItem["PROPERTIES"]["URL_STRIN2TEXT"]["VALUE"] ?>" <?= ($arItem["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"] ? "target='" . $arItem["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"] . "'" : ""); ?>>
										<?= $arItem["PROPERTIES"]["URL_STRIN2TEXT"]["VALUE"] ?>
									</a>
								<? endif; ?>
							</div>
						</div>
					</div>
				<? } ?>

			<? } ?>
		</div>
	</div>
<? endif; ?>