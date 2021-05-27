<?$arDisplays = array("block_custom", "list_custom", "table_custom");
if(array_key_exists("display", $_REQUEST) || (array_key_exists("display", $_SESSION)) || $arParams["DEFAULT_list_custom_TEMPLATE"]){
	if($_REQUEST["display"] && (in_array(trim($_REQUEST["display"]), $arDisplays))){
		$display = trim($_REQUEST["display"]);
		$_SESSION["display"]=trim($_REQUEST["display"]);
	}
	elseif($_SESSION["display"] && (in_array(trim($_SESSION["display"]), $arDisplays))){
		$display = $_SESSION["display"];
	}
	elseif($arSection["DISPLAY"]){
		$display = $arSection["DISPLAY"];
	}
	else{
		$display = $arParams["DEFAULT_list_custom_TEMPLATE"];
	}
}
else{
	$display = "block_custom";
}
$template = "catalog_".$display;
?>

<div class="sort_header view_<?=$display?>">
	<!--noindex-->
	<div class="sort_filter">
		<?

			$arAvailableSort = array();
			$arSorts = $arParams["SORT_BUTTONS"];
			if(in_array("POPULARITY", $arSorts)){
				$arAvailableSort["SHOWS"] = array("SHOWS", "desc", "По популярности");
			}
			if(in_array("NAME", $arSorts)){
				$arAvailableSort["NAME"] = array("NAME", "asc",);
			}
			if(in_array("PRICE", $arSorts)){
				$arSortPrices = $arParams["SORT_PRICES"];
				if($arSortPrices == "MINIMUM_PRICE" || $arSortPrices == "MAXIMUM_PRICE"){
					$arAvailableSort["PRICE"] = array("PROPERTY_".$arSortPrices, "desc", "Сначала дорогие");
				}
				else{
					if($arSortPrices == "REGION_PRICE")
					{
						global $arRegion;
						if($arRegion)
						{
							if(!$arRegion["PROPERTY_SORT_REGION_PRICE_VALUE"] || $arRegion["PROPERTY_SORT_REGION_PRICE_VALUE"] == "component")
							{
								$price = CCatalogGroup::Getlist(array(), array("NAME" => $arParams["SORT_REGION_PRICE"]), false, false, array("ID", "NAME"))->GetNext();
								$arAvailableSort["PRICE"] = array("CATALOG_PRICE_".$price["ID"], "desc");
							}
							else
							{
								$arAvailableSort["PRICE"] = array("CATALOG_PRICE_".$arRegion["PROPERTY_SORT_REGION_PRICE_VALUE"], "desc");
							}
						}
						else
						{
							$price_name = ($arParams["SORT_REGION_PRICE"] ? $arParams["SORT_REGION_PRICE"] : "BASE");
							$price = CCatalogGroup::Getlist(array(), array("NAME" => $price_name), false, false, array("ID", "NAME"))->GetNext();
							$arAvailableSort["PRICE"] = array("CATALOG_PRICE_".$price["ID"], "desc");
						}
					}
					else
					{
						$price = CCatalogGroup::Getlist(array(), array("NAME" => $arParams["SORT_PRICES"]), false, false, array("ID", "NAME"))->GetNext();
						$arAvailableSort["PRICE"] = array("CATALOG_PRICE_".$price["ID"], "desc");
					}
				}
			}
			if(in_array("QUANTITY", $arSorts)){
				$arAvailableSort["CATALOG_AVAILABLE"] = array("QUANTITY", "desc");
			}
			$sort = "SHOWS";
			if((array_key_exists("sort", $_REQUEST) && array_key_exists(ToUpper($_REQUEST["sort"]), $arAvailableSort)) || (array_key_exists("sort", $_SESSION) && array_key_exists(ToUpper($_SESSION["sort"]), $arAvailableSort)) || $arParams["ELEMENT_SORT_FIELD"]){
				if($_REQUEST["sort"]){
					$sort = ToUpper($_REQUEST["sort"]);
					$_SESSION["sort"] = ToUpper($_REQUEST["sort"]);
				}
				elseif($_SESSION["sort"]){
					$sort = ToUpper($_SESSION["sort"]);
				}
				else{
					$sort = ToUpper($arParams["ELEMENT_SORT_FIELD"]);
				}
			}
			$sort_order=$arAvailableSort[$sort][1];
			if((array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc"))) || (array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ) || $arParams["ELEMENT_SORT_ORDER"]){
				if($_REQUEST["order"]){
					$sort_order = $_REQUEST["order"];
					$_SESSION["order"] = $_REQUEST["order"];
				}
				elseif($_SESSION["order"]){
					$sort_order = $_SESSION["order"];
				}
				else{
					$sort_order = ToLower($arParams["ELEMENT_SORT_ORDER"]);
				}
			}
			?>

		<?$sort_title = (($sort == 'PRICE' && $sort_order == 'asc') ? 'Сначала дешевые' : $arAvailableSort[$sort][2])?>
		<div class="sort-desktop">
		<div class="sort-current__option">
			<div class="sort-text"><?=$sort_title?></div>
			<div class="sort-icon">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 491.996 491.996">
					<path
						d="M484.132 124.986l-16.116-16.228c-5.072-5.068-11.82-7.86-19.032-7.86-7.208 0-13.964 2.792-19.036 7.86l-183.84 183.848L62.056 108.554c-5.064-5.068-11.82-7.856-19.028-7.856s-13.968 2.788-19.036 7.856l-16.12 16.128c-10.496 10.488-10.496 27.572 0 38.06l219.136 219.924c5.064 5.064 11.812 8.632 19.084 8.632h.084c7.212 0 13.96-3.572 19.024-8.632l218.932-219.328c5.072-5.064 7.856-12.016 7.864-19.224 0-7.212-2.792-14.068-7.864-19.128z" />
					</svg>
			</div>
		</div>
		<div class="sort-list">
			<?foreach($arAvailableSort as $key => $val):?>

			<?$newSort = 'desc';
				$current_url = $APPLICATION->GetCurPageParam('sort='.$key.'&order='.$newSort, 	array('sort', 'order'));
				$url = str_replace('+', '%2B', $current_url);?>
			<a href="<?=$url;?>" class="sort_btn <?=($sort == $key ? 'current' : '')?> <?=$sort_order?> <?=$key?>"
				rel="nofollow">
				<span><?=($key == 'PRICE' ? 'Сначала дорогие' : GetMessage('SECT_SORT_'.$key))?></span>
			</a>
			<?endforeach;?>
			<?
				$current_url = $APPLICATION->GetCurPageParam('sort=PRICE&order=asc', array('sort', 'order'));
				$url = str_replace('+', '%2B', $current_url);?>

			<a href="<?=$url;?>" class="sort_btn asc PRICE" rel="nofollow">
				<span>Сначала дешевые</span>
			</a>
		</div>
		</div>

		<select id="sort-mobile" class="sort-mobile">
			<?foreach($arAvailableSort as $key => $val):?>

			<?$newSort = 'desc';
			$current_url = $APPLICATION->GetCurPageParam('sort='.$key.'&order='.$newSort, 	array('sort', 'order'));
			$url = str_replace('+', '%2B', $current_url);?>
			<option value="<?=$url;?>" <?=($sort == $key ? 'selected="selected"' : '')?>>
				 <?=($key == 'PRICE' ? 'Сначала дорогие' : GetMessage('SECT_SORT_'.$key))?>
			</option>
			<?endforeach;?>
			<?
				$current_url = $APPLICATION->GetCurPageParam('sort=PRICE&order=asc', array('sort', 'order'));
				$url = str_replace('+', '%2B', $current_url);?>

			<option value="<?=$url;?>" <?=($sort == 'PRICE' && $sort_order == 'asc' ? 'selected="selected"' : '')?>>
				<span>Сначала дешевые</span>
			</option>
		</select>
		<?
			if($sort == "PRICE"){
				$sort = $arAvailableSort["PRICE"][0];
			}
			if($sort == "CATALOG_AVAILABLE"){
				$sort = "CATALOG_QUANTITY";
			}
			?>
	</div>
	<!-- <div class="sort_display">
			<?foreach($arDisplays as $displayType):?>
				<?
				$current_url = '';
				$current_url = $APPLICATION->GetCurPageParam('display='.$displayType, 	array('display'));
				$url = str_replace('+', '%2B', $current_url);
				?>
				<a rel="nofollow" href="<?=$url;?>" class="sort_btn <?=$displayType?> <?=($display == $displayType ? 'current' : '')?>"><i title="<?=GetMessage("SECT_DISPLAY_".strtoupper($displayType))?>"></i></a>
			<?endforeach;?>
		</div> -->
	<div class="clearfix"></div>
	<!--/noindex-->
</div>
