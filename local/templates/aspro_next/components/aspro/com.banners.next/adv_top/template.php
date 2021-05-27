<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $this->setFrameMode(true); ?>
<? if ($arResult['ITEMS']) : ?>
	<div class="adv_list top">
		<? foreach ($arResult['ITEMS'] as $arItem) {
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			$bUrl = (isset($arItem['DISPLAY_PROPERTIES']['URL']) && $arItem['DISPLAY_PROPERTIES']['URL']['VALUE']);
			$sUrl = ($bUrl ? $arItem['DISPLAY_PROPERTIES']['URL']['VALUE'] : '');
			$background = is_array($arItem["DETAIL_PICTURE"]) ? $arItem["DETAIL_PICTURE"]["SRC"] : $this->GetFolder() . "/images/background.jpg";
			$mobileItem = CFile::GetPath($arItem["PROPERTIES"]["MOBILE_IMAGE"]["VALUE"]);
			$mobileImage = is_array($arItem["PROPERTIES"]["MOBILE_IMAGE"]) ? $mobileItem : $arItem["DETAIL_PICTURE"]["SRC"];
		?>
			<div class="item-wrapper">
				<div id="<?= $this->GetEditAreaId($arItem['ID']); ?>" class="item">
					<? if (is_array($arItem['DETAIL_PICTURE']) || is_array($arItem["PROPERTIES"]["MOBILE_IMAGE"])) : ?>
						<div class="img">
							<div class="img_inner">
								<? if ($sUrl) : ?>
									<a href="<?= $sUrl; ?>">
										<picture>
											<source media="(max-width: 650px)" srcset="<?= $mobileImage ?>" alt="<?= ($arItem['DETAIL_PICTURE']['ALT'] ? $arItem['DETAIL_PICTURE']['ALT'] : $arItem['NAME']); ?>" title="<?= ($arItem['DETAIL_PICTURE']['TITLE'] ? $arItem['DETAIL_PICTURE']['TITLE'] : $arItem['NAME']); ?>">
											<img src="<?= $background ?>">
										</picture>
									</a>
								<? else : ?>
									<picture>
										<source media="(max-width: 650px)" srcset="<?= $mobileImage ?>" alt="<?= ($arItem['DETAIL_PICTURE']['ALT'] ? $arItem['DETAIL_PICTURE']['ALT'] : $arItem['NAME']); ?>" title="<?= ($arItem['DETAIL_PICTURE']['TITLE'] ? $arItem['DETAIL_PICTURE']['TITLE'] : $arItem['NAME']); ?>">
										<img src="<?= $background ?>">
									</picture>
								<? endif; ?>
							</div>
						</div>
					<? endif; ?>
				</div>
			</div>
		<? } ?>
	</div>
<? endif; ?>