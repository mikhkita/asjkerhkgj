<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$ajaxUrl = $templateFolder . '/ajax.php';
$ajaxUrl = SITE_DIR.'include/ajax/add2basket.php';
$APPLICATION->SetTitle("Каталог");
if (!empty($arResult['ELEMENT']["ID"])) {
	$val = $arResult['ELEMENT'];
    
	// assembled links PhotoID and Source
	$arPhotoID = array();
	foreach($arResult['ELEMENT_PHOTO'] as $key => $value)
		$arPhotoID[ $key ] = $value['SRC'];
	
	// compiled array for ajaximgload
//	foreach ($arResult["OFFERS"] as $item)
//	{
//    $item = current($arResult["OFFERS"]);
//        ?>
<!--        <img src="--><?//=current($arResult['DETAIL_IMAGES'][$item['ID']]['curPhotosMiddle'])?><!--">-->
<!--        <div style="display: block">-->
<!--            --><?//if(is_array($arResult['DETAIL_IMAGES'][$item['ID']]['curPhotosSmall'])){
//                foreach($arResult['DETAIL_IMAGES'][$item['ID']]['curPhotosSmall'] as $photo) {
//                    ?><!--<img src="--><?//= $photo?><!--">--><?//
//                }
//            }
//            ?>
<!--        </div>-->
<!--        --><?//
//    }
    $curPhotosSmall = array();
    $curPhotosMiddle = array();
    if(!empty($_REQUEST['col']) && !empty($_REQUEST['size'])){
        foreach ($arResult["OFFERS"] as $item)
        {
            if($item["PROPERTIES"]["COLOR"]["VALUE"] == $_REQUEST['col'] && $item["PROPERTIES"]["STD_SIZE"]["VALUE"] == $_REQUEST['size']) {
                if (!empty($item["PROPERTIES"]["MORE_PHOTO"]["VALUE"])) {
                    foreach ($item["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $picture) {

                        $arFileTmp = Novagroup_Classes_General_Main::MakeResizePicture(
                            $picture,
                            array('WIDTH' => '450', 'HEIGHT' => '580')
                        );
                        $curPhotosMiddle[] = $arFileTmp["src"];

                        $FILE = CFile::GetFileArray($picture);
                        if (is_array($FILE)) {
                            //                    $curPhotosBig[$item["PROPERTIES"]["COLOR"]["VALUE"]] = $FILE["SRC"];
                            //                    $curPhotosBigHeight[]= $FILE["HEIGHT"];
                            $arFileTmp = Novagroup_Classes_General_Main::MakeResizePicture($picture, array('WIDTH' => '86', 'HEIGHT' => '114'));
                            $curPhotosSmall[] = $arFileTmp["src"];
                        }

                    }
                }
            }
        }
    }
    else{
        $item = current($arResult["OFFERS"]);
        if (!empty($item["PROPERTIES"]["MORE_PHOTO"]["VALUE"])) {
            foreach ($item["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $picture) {

                $arFileTmp = Novagroup_Classes_General_Main::MakeResizePicture(
                    $picture,
                    array('WIDTH' => '450', 'HEIGHT' => '580')
                );
                $curPhotosMiddle[] = $arFileTmp["src"];

                $FILE = CFile::GetFileArray($picture);
                if (is_array($FILE)) {
                    //                    $curPhotosBig[$item["PROPERTIES"]["COLOR"]["VALUE"]] = $FILE["SRC"];
                    //                    $curPhotosBigHeight[]= $FILE["HEIGHT"];
                    $arFileTmp = Novagroup_Classes_General_Main::MakeResizePicture($picture, array('WIDTH' => '86', 'HEIGHT' => '114'));
                    $curPhotosSmall[] = $arFileTmp["src"];
                }

            }
        }
    }


//        $photos_properties = array('curPhotosSmall','curPhotosMiddle');
//        foreach($photos_properties as $photo_property)
//        {
//            if(is_array($arResult['DETAIL_IMAGES'][$item['ID']][$photo_property]))
//            {
//                foreach($arResult['DETAIL_IMAGES'][$item['ID']][$photo_property] as $key => $photo)
//                {
//                    if(!empty($photo) && ((int)$photo == 0))
//                    {
//                        $arPhoto[$photo_property][ $item['ID'] ][$key]['IMG_ID'] = array_search($photo,$arPhotoID);
//                        $arPhoto[$photo_property][ $item['ID'] ][$key]['SOURCE'] = $photo;
//                    }
//                    // reset not resize photo and set default ajax preloader
//                    // TODO: разобраться с размерами
////					$arResult['DETAIL_IMAGES'][$item['ID']][$photo_property][$key] = SITE_TEMPLATE_PATH."/images/transparent.png";
//                }
//            }
//        }
//    }


//        $photos_properties = array('curPhotosSmall','curPhotosMiddle');
//		foreach($photos_properties as $photo_property)
//		{
//			if(is_array($arResult['DETAIL_IMAGES'][$item['ID']][$photo_property]))
//			{
//				foreach($arResult['DETAIL_IMAGES'][$item['ID']][$photo_property] as $key => $photo)
//				{
//					if(!empty($photo) && ((int)$photo == 0))
//					{
//						$arPhoto[$photo_property][ $item['ID'] ][$key]['IMG_ID'] = array_search($photo,$arPhotoID);
//						$arPhoto[$photo_property][ $item['ID'] ][$key]['SOURCE'] = $photo;
//					}
//					// reset not resize photo and set default ajax preloader
//                    // TODO: разобраться с размерами
////					$arResult['DETAIL_IMAGES'][$item['ID']][$photo_property][$key] = SITE_TEMPLATE_PATH."/images/transparent.png";
//				}
//			}
//		}
//	}
?>
<div class="col-left">
	<div class="col-left">
		<div class="detalet-cart">
			<div class="img-photos-demo">
				<div class="big-demo" id="photos">
				<?
                    $item = current($arResult["OFFERS"]);
                ?>
<!--                    <img src="--><?//=current($arResult['DETAIL_IMAGES'][$item['ID']]['curPhotosMiddle'])?><!--">-->
                    <img src="<?=current($curPhotosMiddle)?>">
                    <div style="display: block">
                        <?if(is_array($curPhotosSmall)){
                            foreach($curPhotosSmall as $photo) {
                                    ?><img src="<?= $photo ?>"><?
                                }
                            }
                        ?>
                    </div>
                    <??>
				</div>
                <?
                Novagroup_Classes_General_Main::getView('catalog.element','actions',array("val"=>$val, "arResult" => $arResult));
                ?>
			</div>
			<div class="thumbs" id="thumbs">
                <div style="display: block">
                    <?if(is_array($curPhotosSmall)){
                        foreach($curPhotosSmall as $photo) {
                                ?><img src="<?= $photo ?>"><?
                            }
                        }
                    ?>
                </div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>

	</div>
	<div class="col-right">
		<div class="card-tab-det">

        <div class="bs-tab">
        <?php

        if ($arParams['SHOW_EDIT_BUTTON'] == "Y") {
            Novagroup_Classes_General_Main::getView('catalog.element','edit_button',array("val"=>$val));
        }
        ?>

        <!-- ��������� �������� -->
        <div class="detail">

            <div class="head-title"><h1><?=$val['NAME']?></h1></div>
<!--            --><?//$APPLICATION->IncludeComponent(
//                "novagroup:catalog.timetobuy",
//                "",
//                Array(
//                    "IBLOCK_ID"=>$val['IBLOCK_ID'],
//                    "ID"=>$val['ID']
//                )
//            );?>
            <?
            $discount = 0;
            foreach ($arResult["OFFERS"] as $item) {
                $dbProductDiscounts = CCatalogDiscount::GetList(array("SORT" => "ASC"), array("PRODUCT_ID" =>$item["ID"], "ACTIVE"=>"Y","!>ACTIVE_FROM" => $now,"!<ACTIVE_TO" => $now), false, false,array("ID", "VALUE", "ACTIVE_TO"));
                if($arProductDiscounts = $dbProductDiscounts->Fetch()) {
                    if($arProductDiscounts["VALUE"]> $discount){
                        $discount = $arProductDiscounts["VALUE"];
                        $id = $arProductDiscounts["ID"];
                        $activeTo = $arProductDiscounts["ACTIVE_TO"];
                    };
                }
            }
            $now = new \Bitrix\Main\Type\DateTime();
            $now = $now->toString();
            if($discount):
                $datetime1 = new DateTime($activeTo);
                $datetime2 = new DateTime();
                $interval = $datetime1->diff($datetime2);
                ?>
                <div class="time-buy">
                    <div class="zn-tr">
                        <div class="card-time"></div>
                    </div>
                    <div class="countdown_dashboard" data-year="<?=(int)$datetime1->format('Y')?>" data-month="<?=(int)$datetime1->format('m')?>" data-day="<?=(int)$datetime1->format('d')?>" data-hours="<?=(int)$datetime1->format('H')?>" data-minutes="<?=(int)$datetime1->format('i')?>" data-seconds="<?=(int)$datetime1->format('s')?>">
                        <div class="block_container">
                            <div class="title-block"><?=GetMessage('TO_DATE')?></div>
                            <div class="countdown_container">
                                <div class="dash days_dash">
                                    <span class="dash_title"><?= GetMessage('DD') ?></span>

                                    <div class="digit"><?=(int)substr("00".$interval->format('%d'),0,-1);?></div>
                                    <div class="digit"><?=(int)substr("00".$interval->format('%d'),-1);?></div>
                                </div>

                                <div class="dash hours_dash">
                                    <span class="dash_title"><?=GetMessage('HH')?></span>

                                    <div class="digit"><?=(int)substr("00".$interval->format('%H'),-2,1);?></div>
                                    <div class="digit"><?=(int)substr("00".$interval->format('%H'),-1);?></div>
                                </div>

                                <div class="dash minutes_dash">
                                    <span class="dash_title"><?=GetMessage('MIN')?></span>

                                    <div class="digit"><?=(int)substr("00".$interval->format('%i'),-2,1);?></div>
                                    <div class="digit"><?=(int)substr("00".$interval->format('%i'),-1);?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?endif;?>
            <?php

            $showProperties = array();

            $showProperties["VENDOR"] = array(
                "title"=>GetMessage("BRAND_LABEL"),
                "value"=>$arResult['mixData'][$val["PROPERTIES"]['VENDOR']["VALUE"] ]['NAME']
            );

            $showProperties["CML2_ARTICLE"] = array(
                "title"=>GetMessage("ARTICUL_LABEL"),
                "value"=>$val["PROPERTIES"]['CML2_ARTICLE']["VALUE"]
            );
            $showProperties["CODE"] = array(
                "title" => "Код",
                "value" => ucfirst($val["PROPERTIES"]['CODE']["VALUE"])
            );
            $showProperties["MEH"] = array(
                "title" => "Мех",
                "value" => ucfirst($val["PROPERTIES"]['MEH']["VALUE"])
            );

            $showProperties["MARKA"] = array(
                "title" => "Марка",
                "value" => $val["PROPERTIES"]['MARKA']["VALUE"]
            );

            $showProperties["MANUFACTURE"] = array(
                "title" => "Страна",
                "value" => $val["PROPERTIES"]['MANUFACTURE']["VALUE"]
            );



            if (!empty($val["PROPERTIES"]['MATERIAL_DESC']["VALUE"]["TEXT"])) {

                $showProperties["MATERIAL_DESC"] = array(
                    "title" => GetMessage("MATERIAL_DESC_LABEL"),
                    "value" => $val["PROPERTIES"]['MATERIAL_DESC']["VALUE"]["TEXT"]
                );

            } else {

                $showProperties["MATERIAL_DESC"] = array(
                    "title" => GetMessage("MATERIAL_LABEL"),
                    "value" => $arResult['mixData'][$val["PROPERTIES"]['MATERIAL_LIST']["VALUE"] ]['NAME']
                );
            }
            reset($arResult["CURRENT_ELEMENT"]["COLORS"]);
            $showProperties["COLOR"] = array(
                "title" => "Доступные цвета",
                "value" => $arResult['mixData'][current($arResult["CURRENT_ELEMENT"]["COLORS"])]['NAME']
            );

            while (($color = next($arResult["CURRENT_ELEMENT"]["COLORS"]))!==false) {
                $showProperties["COLOR"]['value'].=','.$arResult['mixData'][$color]['NAME'];
            }
            reset($arResult["CURRENT_ELEMENT"]["STD_SIZE"]);
            $size = current($arResult["CURRENT_ELEMENT"]["STD_SIZE"]);
            $showProperties["1"] = array(
                "title" => "Доступные размеры",
                "value" => $arResult['mixData'][$size["SIZE"]]['NAME']
            );
            while (($size = next($arResult["CURRENT_ELEMENT"]["STD_SIZE"]))!==false) {
                $showProperties["1"]['value'].=','.$arResult['mixData'][$size["SIZE"]]['NAME'];
            }


            $html = array();

            if (is_array($val["PROPERTIES"]['SAMPLES']["VALUE"]))
            foreach($val["PROPERTIES"]['SAMPLES']["VALUE"] as $subval) {
                if(isset($arResult['mixData'][$subval]['NAME']))
                    $html[] = $arResult['mixData'][$subval]['NAME'];
            }
            $showProperties["SAMPLES"] = array(
                "title"=>GetMessage("SAMPLES_LABEL"),
                "value"=>implode(", ",$html)
            );

            foreach($showProperties as $data)
            {
                Novagroup_Classes_General_Main::getView('catalog.element','properties', $data);
            }
            ?>

            <div id="size-table" >
                &nbsp;<a href="#myModal8" ><?=GetMessage("SIZE_TABLE")?></a>
            </div>

            <div class="tab-choice tooltip-demo">
            <?
            $cheapest_item = array();
            $cheapest_item["PRICES"][$arResult["CUR_PRICE_CODE"]]["DISCOUNT_VALUE_VAT"] = PHP_INT_MAX;
            foreach ($arResult["OFFERS"] as $item) {
                if($cheapest_item["PRICES"][$arResult["CUR_PRICE_CODE"]]["DISCOUNT_VALUE_VAT"] > $item["PRICES"][$arResult["CUR_PRICE_CODE"]]["DISCOUNT_VALUE_VAT"]){
                    $cheapest_item = $item;
                };
            }
            ?>
                <div class="wrapper-l">
                    <span class="brand-l">Цена: </span>
            <?
            if($cheapest_item["PRICES"][$arResult["CUR_PRICE_CODE"]]["DISCOUNT_VALUE_VAT"] != $cheapest_item["PRICES"][$arResult["CUR_PRICE_CODE"]]["VALUE_VAT"]){
                ?><span id="sum" class="discount" style="font-size: 20px"><?=intval($cheapest_item["PRICES"][$arResult["CUR_PRICE_CODE"]]["DISCOUNT_VALUE_VAT"])?> руб.</span>
                <span id="old-price" class="old-price" style="font-size: 20px"><?=intval($cheapest_item["PRICES"][$arResult["CUR_PRICE_CODE"]]["VALUE_VAT"])?> руб.</span><?
            }
            else{
            ?><span id="sum" class="default-value" style="font-size: 20px"><?=$cheapest_item["PRICES"][$arResult["CUR_PRICE_CODE"]]["VALUE_VAT"]?> руб.</span><?
            }
            ?>
                </div>
                <?if($val["PROPERTIES"]['SKLAD_1']["VALUE"]+$val["PROPERTIES"]['SKLAD_2']["VALUE"]+$val["PROPERTIES"]['SKLAD_3']["VALUE"]+$val["PROPERTIES"]['SKLAD_4']["VALUE"]+$val["PROPERTIES"]['SKLAD_5']["VALUE"]>0):?>
                    <br>
                    <div class="stock-availability" >Наличие в магазинах:</div>
                    <?
                    $showStock["SKLAD_1"] = array(
                        "title" => "Северск",
                        "value" => $val["PROPERTIES"]['SKLAD_1']["VALUE"]
                    );
                    $showStock["SKLAD_2"] = array(
                        "title" => "ТЦ ГУМ",
                        "value" => $val["PROPERTIES"]['SKLAD_2']["VALUE"]
                    );
                    $showStock["SKLAD_3"] = array(
                        "title" => "ТЦ Манеж",
                        "value" => $val["PROPERTIES"]['SKLAD_3']["VALUE"]
                    );
                    $showStock["SKLAD_4"] = array(
                        "title" => "Сезонный",
                        "value" => $val["PROPERTIES"]['SKLAD_4']["VALUE"]
                    );
                    $showStock["SKLAD_5"] = array(
                        "title" => "Северск магазин",
                        "value" => $val["PROPERTIES"]['SKLAD_5']["VALUE"]
                    );
                    foreach($showStock as $key => $data)
                    {
                        if (!empty($data['value'])) {
                            ?>
                            <div class="wrapper-avail">
                                <span class="address-line"><?=$data['title']?>:</span>
                                <span class="avail-count"><?=$data['value']?></span>
                                <div class="address-line"><?=GetMessage($key)?></div>
                            </span>
                            </div>
                            <?
                        }
//                    Novagroup_Classes_General_Main::getView('catalog.element','properties', $data);
                    }
                endif;?>
            <div class="clear"></div>
            </div>
        </div>
        <?php
            if (!empty($val['DETAIL_TEXT'])) {
        ?>
        <div class="tab-content" id="myTabContent1">
            <div id="description" class="tab-pane in active">
                <h2><?=GetMessage("ABOUT_PRODUCT")?>:</h2>
                <?=$val['DETAIL_TEXT']?>
            </div>
        </div>
        <?
        }
        ?>

        </div>

<!--        <div class="clear"></div>-->
<!--        --><?//
//        if($_REQUEST['CAJAX']!=="1")
//		{
//            Novagroup_Classes_General_Main::getView('catalog.element','yashare',array("arResult"=>$arResult, "val"=>$val));
//        }
//        ?>
<!---->
<!--		</div>   -->
	</div>
</div>
	<div class="clear"></div>

	<div id="myModal8" class="modal hide fade size-tab-my mod-size" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
        <div class="modal-header" id="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h3 id="myModalLabel8"><?=GetMessage("SIZE_TABLE2")?></h3>
        </div>
	    <div class="modal-body" id="modal-body">
	    <?=$arResult["tablitsa-razmerov"]?>
		</div>
	</div>
<?php 
}
?>

<!--<div id="myModal" class="modal fade card-img" tabindex="-1" aria-hidden="false"  style="display: none;">-->
<!--    <div id="myCarousel" class="carousel">-->
<!--        <div class="carousel-inner" id="carousel-inner">-->
<!--        -->
<!--        </div>-->
<!--       <!-- Carousel nav -->
<!--        <a id="left-arr" class="carousel-control left" href="#myCarousel" data-slide="prev"></a>-->
<!--        <a id="right-arr" class="carousel-control right" href="#myCarousel" data-slide="next"></a>-->
<!--    </div>-->
<!--</div>-->

<?
//if (!defined("ERROR_404") && $_REQUEST['CAJAX']!=="1") {
//    $APPLICATION->IncludeComponent("bitrix:sale.viewed.product", "demoshop", array(
//            "VIEWED_COUNT" => "4",
//            "VIEWED_NAME" => "Y",
//            "VIEWED_IMAGE" => "Y",
//            "VIEWED_PRICE" => "Y",
//            "VIEWED_CANBUY" => "Y",
//            "EXCLUDE_ID" => $arResult['ELEMENT']["ID"],
//            "VIEWED_CANBUSKET" => "Y",
//            "CATALOG_IBLOCK_ID" => $arParams['CATALOG_IBLOCK_ID'],
//            "IMAGERIES_IBLOCK_ID" => $arParams['FASHION_IBLOCK_ID'],
//            "VIEWED_IMG_HEIGHT" => "100",
//            "VIEWED_IMG_WIDTH" => "100",
//            "BASKET_URL" => "/personal/basket.php",
//            "ACTION_VARIABLE" => "action",
//            "PRODUCT_ID_VARIABLE" => "id",
//            "SET_TITLE" => "N"
//        ),
//        false
//    );
//}
//?>

<div id="ajaximgload-thumbs" style="display:none;">
<?//
//	foreach($arPhoto['curPhotosSmall'] as $subkey => $subval)
//		foreach($subval as $subkey2 => $subval2)
//		{
//			$APPLICATION->IncludeComponent(
//				"novagroup:ajaximgload",
//				"",
//				Array(
//					"CALL_FROM_CATALOG"		=> "Y",
//					"ATTRIBUTES"	=> array(
//						"width"		=> 86,
//						"height"	=> 114
//					),
//					"MICRODATA"		=> array(
//						"imgid"	=> $subval2['IMG_ID'],
//						"elmid" => $subkey
//					),
//					"CACHE_TYPE" => "A",
//					"CACHE_TIME" => "2592000",
//				),
//				false,
//				Array(
//					'ACTIVE_COMPONENT' => 'Y',
//					//"HIDE_ICONS"=>"Y"
//				)
//			);
//		}
//?>
</div>
<div id="ajaximgload-medium" style="display:none;">
<?
//	foreach($arPhoto['curPhotosMiddle'] as $subkey => $subval)
//		foreach($subval as $subkey2 => $subval2)
//		{
//			$APPLICATION->IncludeComponent(
//				"novagroup:ajaximgload",
//				"",
//				Array(
//					"CALL_FROM_CATALOG"		=> "Y",
//					"ATTRIBUTES"	=> array(
//						"width"		=> 450,
//						"height"	=> 580
//					),
//					"MICRODATA"		=> array(
//						"imgid"	=> $subval2['IMG_ID'],
//						"elmid" => $subkey
//					),
//					"CACHE_TYPE" => "A",
//					"CACHE_TIME" => "2592000",
//				),
//				false,
//				Array(
//					'ACTIVE_COMPONENT' => 'Y',
//					//"HIDE_ICONS"=>"Y"
//				)
//			);
//		}
//?>
</div>
<?
/*
<div id="ajaximgload-fullhd" style="display:none;">
<?
	foreach($arPhoto as $photoID)
	{
		$APPLICATION->IncludeComponent(
			"novagroup:ajaximgload",
			"",
			Array(
				//"CATALOG_IBLOCK_ID"		=> $item['IBLOCK_ID'],	// if it is established then IMG_ID as COLOR_ID and photos will be selected by CATALOG_ELEMENT_ID
				//"CATALOG_ELEMENT_ID"	=> $item['ID'],			// CATALOG BLOCK_ID, CATALOG ELEMENT_ID and IMG_ID required fields
				"IMG_ID"				=>  $photoID,		// if need select photo by ID then set IMG_ID as PHOTO_ID and CATALOG_IBLOCK_ID and CATALOG_ELEMENT_ID was not be filled
				"IMG_WIDTH"				=> "900",				// if not defined then set default as 240
				"IMG_HEIGHT"			=> "1200",				// if not defined then set default as 180
				"IMG_TITLE"				=> "",
				"IMG_ALT"				=> "",
				"CALL_FROM_CATALOG"		=> "Y",					// if call from catalog set Y to show normal after clear cache and edit mode for admin
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "2592000",
			),
			false,
			Array(
				'ACTIVE_COMPONENT' => 'Y',
				//"HIDE_ICONS"=>"Y"
			)
		);
	}
?>
</div>
*/
?>

    <script>
    $(document).ready(function(){
        // click handler on the size
        $("#myTab a").live("click", function(){
            var sizeId = $(this).data("size");
            product.changeSize(sizeId);

            return false;
        });
        // handler click the button to buy
        $(".addToBasket").unbind('click');
        $(".addToBasket").click(function(){
            product.buyClick(this);
            return false;
        });

        $("#size-table a").bind('click', function(){

            $("#myModal8").modal('show');
            $("#modal-body").css({'max-height':($(window).height() -68) + 'px' });
            top_proc = 0;
            $("#myModal8").css({'top':top_proc+'px', 'margin-top': top_proc+'px'});
            return false;
        });


    $(".header, #footer, #panel, .top_nav, .tooltip-demo.card-tool, #size-table, .oneClick, .addToBasket, #btnsel, .basket-tab, #delivery, #chain-hint, .card-visited, .addthis_toolbox.addthis_default_style").css({"display":"none", "visibility": "hidden"});
    window.print() ;

});
$(document).ready(function () {
        var messages = [];
        messages['NOTIFY_ERR_LOGIN'] = '<?= GetMessageJS("NOTIFY_ERR_LOGIN") ?>';
        messages['NOTIFY_ERR_MAIL'] = '<?= GetMessageJS("NOTIFY_ERR_MAIL") ?>';
        messages['NOTIFY_ERR_CAPTHA'] = '<?= GetMessageJS("NOTIFY_ERR_CAPTHA") ?>';
        messages['NOTIFY_ERR_MAIL_EXIST'] = '<?= GetMessageJS("NOTIFY_ERR_MAIL_EXIST") ?>';
        messages['NOTIFY_ERR_REG'] = '<?= GetMessageJS("NOTIFY_ERR_REG") ?>';
        messages['NOTIFY_SUBSCRIBED'] = '<?= GetMessageJS("NOTIFY_SUBSCRIBED") ?>';
        messages['NOTIFY_EMAIL_WRING1'] = '<?= GetMessageJS("NOTIFY_EMAIL_WRING1") ?>';
        messages['NOTIFY_EMAIL_WRING2'] = '<?= GetMessageJS("NOTIFY_EMAIL_WRING2") ?>';
        messages['NOTIFY_ALREADY_SUBSCRIBED'] = '<?= GetMessageJS("NOTIFY_ALREADY_SUBSCRIBED") ?>';
        messages['NOTIFY_YOU_ARE_SUBSCRIBE'] =  '<?= GetMessageJS("NOTIFY_YOU_ARE_SUBSCRIBE") ?>';
        pSubscribe.init(messages);
    }
);
</script>

<!-- >>> ajax image load scripts temporary decision-->
<script>
	$(document).ready(function(e) {
		ajaxImgLoad();
	});
</script>
<!-- <<< ajax image load scripts temporary decision-->
<??>