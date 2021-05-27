

<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$this->setFrameMode(true);



use \Bitrix\Main\Localization\Loc;?>
<?if(!$arResult['POPUP']):?>
	<?if($arResult['CURRENT_REGION']):?>
		<?global $arTheme;?>
		<div class="region_wrapper">
			<div class="city_title"><?=Loc::getMessage('CITY_TITLE');?></div>
			<div class="js_city_chooser colored" data-event="jqm" data-name="city_chooser" data-param-url="<?=urlencode($APPLICATION->GetCurUri());?>" data-param-form_id="city_chooser">
				<span><?=$arResult['CURRENT_REGION']['NAME'];?></span><span class="arrow"><i></i></span>
			</div>
			<?if($arResult['SHOW_REGION_CONFIRM']):?>
				<div class="confirm_region">
					<?
					$href = 'data-href="'.$arResult['REGIONS'][$arResult['REAL_REGION']['ID']]['URL'].'"';
					if($arTheme['USE_REGIONALITY']['DEPENDENT_PARAMS']['REGIONALITY_TYPE']['VALUE'] == 'SUBDOMAIN' && ($arResult['HOST'].$_SERVER['HTTP_HOST'].$arResult['URI'] == $arResult['REGIONS'][$arResult['REAL_REGION']['ID']]['URL']))
					$href = '';?>
					<div class="title"><?=Loc::getMessage('CITY_TITLE');?> <?=$arResult['REAL_REGION']['NAME'];?> ?</div>
					<div class="buttons">
						<span class="btn btn-default aprove" data-location="<?=$arResult['REAL_REGION']['LOCATION'];?>" data-id="<?=$arResult['REAL_REGION']['ID'];?>" <?=$href;?>><?=Loc::getMessage('CITY_YES');?></span>
						<span class="btn btn-default white js_city_change"><?=Loc::getMessage('CITY_CHANGE');?></span>
					</div>
				</div>
			<?endif;?>
		</div>
	<?endif;?>
<?else:?>
	<div class="popup_regions">
		<div class="h-search autocomplete-block" id="title-search-city">
			<div class="wrapper">
				<input id="search" class="autocomplete text" type="text" placeholder="<?=Loc::getMessage('CITY_PLACEHOLDER');?>">
				<div class="search_btn"></div>
			</div>
			<?if($arResult['FAVORITS']):?>
				<div class="favorits">
					<span class="title"><?=GetMessage('EXAMPLE_CITY');?></span>
					<div class="cities">
						<?foreach($arResult['FAVORITS'] as $arItem):?>
							<div class="item">
								<a href="<?=$arItem['URL'];?>" data-location="<?=$arItem['LOCATION'];?>" data-id="<?=$arItem['ID'];?>" class="name"><?=$arItem['NAME'];?></a>
							</div>
						<?endforeach;?>
					</div>
				</div>
			<?endif;?>
		</div>
		<?if(\Bitrix\Main\Config\Option::get('aspro.next', 'REGIONALITY_SEARCH_ROW', 'N') != 'Y'):?>
			<div class="items ext_view">
				<?if($arResult['SECTION_LEVEL1']):?>
					<div class="block regions">
						<div class="title"><?=($arResult['SECTION_LEVEL2'] ? Loc::getMessage('OKRUG') : Loc::getMessage('REGION'));?></div>
						<div class="items_block">
							<?foreach($arResult['SECTION_LEVEL1'] as $key => $arSection):?>
								<div class="item dark_link" data-id="<?=$key;?>"><span><?=$arSection['NAME'];?></span></div>
							<?endforeach;?>
						</div>
					</div>
				<?endif;?>
				<?if($arResult['SECTION_LEVEL2']):?>
					<div class="block regions">
						<div class="title"><?=Loc::getMessage('REGION');?></div>
						<div class="items_block">
							<?foreach($arResult['SECTION_LEVEL2'] as $key => $arSections):?>
								<div class="parent_block" data-id="<?=$key;?>">
									<?foreach($arSections as $key2 => $arSection):?>
										<div class="item dark_link" data-id="<?=$key2;?>"><span><?=$arSection['NAME'];?></span></div>
									<?endforeach;?>
								</div>
							<?endforeach;?>
						</div>
					</div>
				<?endif;?>
				<?if($arResult['REGIONS']):?>
					<div class="block cities">
						<div class="title"><?=Loc::getMessage('CITY');?></div>
						<div class="filter-list" id="filter-list">
							<a class="filter active">А</a>
							<a class="filter">Б</a>
							<a class="filter">В</a>
							<a class="filter">Г</a>
							<a class="filter">Д</a>
							<a class="filter">Е</a>
							<a class="filter">Ж</a>
							<a class="filter">З</a>
							<a class="filter">И</a>
							<a class="filter">К</a>
							<a class="filter">Л</a>
							<a class="filter">М</a>
							<a class="filter">Н</a>
							<a class="filter">О</a>
							<a class="filter">П</a>
							<a class="filter">Р</a>
							<a class="filter">С</a>
							<a class="filter">Т</a>
							<a class="filter">У</a>
							<a class="filter">Ф</a>
							<a class="filter">Х</a>
							<a class="filter">Ц</a>
							<a class="filter">Ч</a>
							<a class="filter">Ш</a>
							<a class="filter">Щ</a>
							<a class="filter">Э</a>
							<a class="filter">Ю</a>
							<a class="filter">Я</a>
						</div>
						<div class="items_block">
							<?foreach($arResult['REGIONS'] as $key => $arItem):?>
								<?$bCurrent = ($arResult['CURRENT_REGION']['ID'] == $arItem['ID']);?>
								<div class="item <?=($bCurrent ? 'current shown' : '');?> <?=((!$arResult['SECTION_LEVEL1'] && !$arResult['SECTION_LEVEL2']) ? 'shown' : '');?>" data-id="<?=((isset($arItem['IBLOCK_SECTION_ID']) && $arItem['IBLOCK_SECTION_ID']) ? $arItem['IBLOCK_SECTION_ID'] : 0);?>">
									<?if($bCurrent):?>
										<a href="<?=$arItem['URL'];?>" data-location="<?=$arItem['LOCATION'];?>" data-id="<?=$arItem['ID'];?>"><span class="name <?=(($arItem['PROPERTY_REGION_TAG_TEST2_VALUE'] == 'Y') ? 'main_city' : '');?>"><?=$arItem['NAME'];?></span></a>
									<?else:?>
										<a href="<?=$arItem['URL'];?>" data-location="<?=$arItem['LOCATION'];?>" data-id="<?=$arItem['ID'];?>" class="name <?=(($arItem['PROPERTY_REGION_TAG_TEST2_VALUE'] == 'Y') ? 'main_city' : '');?>"><?=$arItem['NAME'];?></a>
									<?endif;?>
								</div>
							<?endforeach;?>
						</div>

					</div>
				<?endif;?>
			</div>
			<script>
				var arRegions = <?=CUtil::PhpToJsObject($arResult['JS_REGIONS']);?>
			</script>
		<?else:?>
			<script>
				var arRegions = [];
			</script>
		<?endif;?>
	</div>
<?endif;?>
<script>
	$(document).ready(function(){

  $(".items_block div").hide();
		  let letter = 'А';
		  $(".items_block div").each(function () {
                if ($.trim($(this).text())[0] == letter) {
                    $(this).show();
                }
        });

      $("#filter-list a").on("click", function () {
        //clear text from space and save first letter
		var letter = $.trim($(this).text())[0];

        //hide all words on click
        $(".items_block div").hide();
        //remove and add active class
        $("#filter-list a").removeClass("active");
        $(this).addClass("active");
        //compare first letters and show only concided words
        $(".items_block div").each(function () {
                if ($.trim($(this).text())[0] == letter) {
                    $(this).show();
                }
        });
      return false;
  });
	})
</script>
