<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div id="<? echo $CID = "composite".$this->randString();?>" class="card-visited">
    <? $createFrame = $this->createFrame($CID,false)->begin();?>
    <?if (count($arResult) > 0):?>
	<div class="head">
		<p class="title"><?echo GetMessage("VIEW_HEADER")?></p>
		<div class="clear"></div>
	</div>
	<div class="mini-list">
	<?php
	foreach($arResult as $key=>$arItem):
        $typeComponent = ($arParams['CATALOG_IBLOCK_ID']==$arItem['IBLOCK_ID']) ? 'catalog' : 'fashion';

        if ($arParams["IMAGERIES_IBLOCK_ID"] == $arItem['IBLOCK_ID']) {
            $isImagery = "Y";
        } else {

            $isImagery = "N";
        }
	?>
		<div class="smoll-preview box-mini">
			<a class="detail-card" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
<?
$APPLICATION->IncludeComponent(
	"novagroup:ajaximgload",
	"",
	Array(
		"CATALOG_IBLOCK_ID"		=> $arItem['IBLOCK_ID'],
		"CATALOG_ELEMENT_ID"	=> $arItem['PRODUCT_ID'],
		"ATTRIBUTES"	=> array(
			"width" => 89,
			"height"=> 119
		),
		"MICRODATA"		=> array(
			"elmid" => $arItem['PRODUCT_ID']
		),
		 "IS_IMAGERY"			=> $isImagery,
		"CALL_FROM_CATALOG"		=> "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "2592000",
	),
	false,
	Array(
		'ACTIVE_COMPONENT' => 'Y',
		//"HIDE_ICONS"=>"Y"
	)
);
?>
            </a>
		</div>
		<?php
	endforeach;
	?>
	</div>
    <?php
    endif;?>
    <?$createFrame->end();?>
</div>
