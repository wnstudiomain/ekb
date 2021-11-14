<?php /*
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<? global $arTheme;	?>
<header class="header-v4 <?=strtolower($arTheme["ORDER_BASKET_VIEW"]["VALUE"])?> <?=($arTheme["CABINET"]["VALUE"]=='Y'?'cabinet':'')?>">
	<b><?=__FILE__?></b>
</header>
    */ ?>


<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
global $arTheme, $arRegion;
$arRegions = CNextRegionality::getRegions();
if($arRegion)
    $bPhone = ($arRegion['PHONES'] ? true : false);
else
    $bPhone = ((int)$arTheme['HEADER_PHONES'] ? true : false);
$logoClass = ($arTheme['COLORED_LOGO']['VALUE'] !== 'Y' ? '' : ' colored');
?>


<div class="top-block top-block-v1">
    <div class="maxwidth-theme">

        <div class="row">
            <div class="col-md-9">
                <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
                array(
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => SITE_DIR."include/menu/menu.topest.php",
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "include_area.php"
                ),
                false
            );?>
            </div>
            <div class="top-block-item pull-right show-fixed top-ctrl">
                <div class="personal_wrap">
                    <div class="personal top login twosmallfont">
                        <?=CNext::ShowCabinetLink(true, true);?>
                    </div>
                </div>
            </div>
            <?if($arTheme['ORDER_BASKET_VIEW']['VALUE'] == 'NORMAL'&&0):?>
            <div class="top-block-item pull-right">
                <div class="phone-block">
                    <?if($bPhone):?>
                    <div class="inline-block">
                        <?CNext::ShowHeaderPhones();?>
                    </div>
                    <?endif?>
                    <?if($arTheme['SHOW_CALLBACK']['VALUE'] == 'Y'):?>
                    <div class="inline-block">
                        <span class="callback-block animate-load twosmallfont colored" data-event="jqm" data-param-form_id="CALLBACK" data-name="callback"><?=GetMessage("CALLBACK")?></span>
                    </div>
                    <?endif;?>
                </div>
            </div>
            <?endif;?>
            <div class="top-block-item pull-right  top-ctrl">
                <div class="personal_wrap">
                    <div class="personal top login twosmallfont" style="max-width: 100%;">
                        <?

                        global $arRegion;
                        ?>
                        <?if($arRegion):?>
                        <?$frame_em = new \Bitrix\Main\Page\FrameHelper('email-block'."-header-email-block");?>
                        <?$frame_em->begin();?>
                        <?endif;?>

                        <?if($arRegion):?>
                        <?if($arRegion['PROPERTY_EMAIL_VALUE']):?>

                            <?foreach($arRegion['PROPERTY_EMAIL_VALUE'] as $value):?>
                                <a class="personal-link dark-color animate-load" href="mailto:<?=$value;?>">
                                    <i class="svg inline  svg-inline-cabinet" aria-hidden="true" >
                                        <svg xmlns="http://www.w3.org/2000/svg" id="Email_black.svg" width="16" height="15" viewBox="0 0 16 15">
                                            <defs>
                                                <style>
                                                    .loccls-1 {
                                                        fill: #222;
                                                        fill-rule: evenodd;
                                                    }
                                                </style>
                                            </defs>
                                            <path id="Rounded_Rectangle_114_copy_8" data-name="Rounded Rectangle 114 copy 8" class="loccls-1" d="M338,981H326a2,2,0,0,1-2-2v-8l8-5,8,5v8A2,2,0,0,1,338,981Zm0-2v-6.75L332,976l-6-3.75V979h12Zm-10.387-8h0L332,973.719,336.387,971h0L332,968.281Z" transform="translate(-324 -966)"/>
                                        </svg>
                                    </i>
                                    <span class="wrap"><span class="name">Написать нам</span></span></a>
                                <?break;?>
                                <?endforeach;?>

                            <?endif;?>
                        <?else:?>

                        <?$APPLICATION->IncludeFile(SITE_DIR."include/header/site-email.php", array(), array(
                                "MODE" => "html",
                                "NAME" => "AddressHeader",
                                "TEMPLATE" => "include_area.php",
                            )
                        );?>

                        <?endif;?>



                        <?if($arRegion):?>
                        <?$frame_em->end();?>
                        <?endif;?>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="header-v3 header-wrapper">
    <div class="logo_and_menu-row">
        <div class="logo-row">
            <div class="maxwidth-theme">
                <div class="row">
                    <div class="logo-block col-md-2 col-sm-3">
                        <div class="logo<?=$logoClass?>">
                            <?=CNext::ShowLogo();?>
                        </div>


                    </div>
                    <?if($arRegions):?>
                    <div class="inline-block pull-left">
                        <div class="top-description">
                            <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
                            array(
                                "COMPONENT_TEMPLATE" => ".default",
                                "PATH" => SITE_DIR."include/top_page/regionality.list.php",
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "",
                                "AREA_FILE_RECURSIVE" => "Y",
                                "EDIT_TEMPLATE" => "include_area.php"
                            ),
                            false
                        );?>
                        </div>
                    </div>
                    <?endif;?>
                    <div class="qqqc pull-left search_wrap wide_search">

                        <div class="inner-table-block baskets big-padding">

                            <div class="inner-table-block header-phone-block">
                                <?/*<!--'start_frame_cache_header-allphones-block1'-->*/?>
                                <!-- noindex -->
                                <div class="phone">
                                    <i class="svg svg-phone"></i>
                                             <a rel="nofollow" href="tel:88002004492">8 (343) 302-01-72</a>
                                   <?/*CNext::ShowHeaderPhones();*/?>
                                </div>
                                <!-- /noindex -->
                                 <?/*<!--'end_frame_cache_header-allphones-block1'-->*/?>
                                <div class="inline-block">
                                    <span class="callback-block animate-load twosmallfont colored" data-event="jqm" data-param-form_id="CALLBACK" data-name="callback">Заказать звонок</span>
                                </div>
                            </div>
                            <div class="inner-table-block header-phone-block">
                                 <?/*<!--'start_frame_cache_header-allphones-block11'-->*/?>
                                <!-- noindex -->
                                <div class="phone">
                                    <i class="svg svg-phone"></i>
                                    <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
                                    array(
                                        "COMPONENT_TEMPLATE" => ".default",
                                        "PATH" => SITE_DIR."include/header/header_phone_static.php",
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "",
                                        "AREA_FILE_RECURSIVE" => "Y",
                                        "EDIT_TEMPLATE" => "include_area.php"
                                    ),
                                    false, array("HIDE_ICONS" => "N")
                                );?>

                                </div>
                                <!-- /noindex -->
                                 <?/*<!--'end_frame_cache_header-allphones-block11'-->*/?>
                                <div class="inline-block">
                                    <span class="callback-block twosmallfont">Горячая линия</span>
                                </div>
                            </div>

                            <style>

                            </style>


                        </div>


                        <div class="search-block inner-table-block" style="width:300px;">


                            <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => SITE_DIR."include/top_page/search.title.catalog.php",
                                "EDIT_TEMPLATE" => "include_area.php"
                            )
                        );?>


                        </div>
                    </div>
                    <?if($arTheme['ORDER_BASKET_VIEW']['VALUE'] !== 'NORMAL'):?>
                    <div class="pull-right block-link">

                        <div class="phone-block with_btn">
                            <?if($bPhone):?>
                            <div class="inner-table-block">
                                <?CNext::ShowHeaderPhones();?>
                                <div class="schedule">
                                    <?$APPLICATION->IncludeFile(SITE_DIR."include/header-schedule.php", array(), array("MODE" => "html","NAME" => GetMessage('HEADER_SCHEDULE'),"TEMPLATE" => "include_area.php"));?>
                                </div>
                            </div>
                            <?endif?>
                            <?if($arTheme['SHOW_CALLBACK']['VALUE'] == 'Y'):?>
                            <div class="inner-table-block">
                                <span class="callback-block animate-load twosmallfont colored  white btn-default btn" data-event="jqm" data-param-form_id="CALLBACK" data-name="callback"><?=GetMessage("CALLBACK")?></span>
                            </div>
                            <?endif;?>
                        </div>
                    </div>
                    <?endif;?>
                    <div class="pull-right block-link">

                        <?=CNext::ShowBasketWithCompareLink('with_price', 'big', true, 'wrap_icon inner-table-block baskets big-padding');?>
                    </div>
                </div>
            </div>
        </div><?// class=logo-row?>
    </div>
    <div class="menu-row middle-block bg<?=strtolower($arTheme["MENU_COLOR"]["VALUE"]);?>">
        <div class="maxwidth-theme">
            <div class="row">
                <div class="col-md-12">
                    <div class="menu-only">
                        <nav class="mega-menu sliced">
                        <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
						array(
							"COMPONENT_TEMPLATE" => ".default",
							"PATH" => SITE_DIR."include/menu/menu.top.php",
							"AREA_FILE_SHOW" => "file",
							"AREA_FILE_SUFFIX" => "",
							"AREA_FILE_RECURSIVE" => "Y",
							"EDIT_TEMPLATE" => "include_area.php"
						),
						false, array("HIDE_ICONS" => "Y")
					);?>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="line-row visible-xs"></div>
</div>
