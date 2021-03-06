<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

//$ajaxUrl = $templateFolder . '/ajax.php';
$ajaxUrl = SITE_DIR.'include/ajax/add2basket.php';
$APPLICATION->SetTitle("Каталог");

// pre($arResult['OFFERS']);

if (!empty($arResult['ELEMENT']["ID"])) {
	$val = $arResult['ELEMENT'];

//    pre($arResult['ELEMENT']);
    
	// assembled links PhotoID and Source
	$arPhotoID = array();

    // var_dump($arResult['ELEMENT']);
	// compiled array for ajaximgload
    
	foreach ($arResult["OFFERS"] as $item)
	{  

        $itemColor[$item['ID']] = $item['PROPERTIES']['COLOR']['VALUE'];
        $arColors['COLORS'] = array_unique($itemColor);

        $photos_properties = array('curPhotosSmall','curPhotosMiddle');
		foreach($photos_properties as $photo_property)
		{
			if(is_array($arResult['DETAIL_IMAGES'][$item['ID']][$photo_property]))
			{
				foreach($arResult['DETAIL_IMAGES'][$item['ID']][$photo_property] as $key => $photo)
				{
					if(!empty($photo) && ((int)$photo == 0))
					{
						$arPhoto[$photo_property][ $item['ID'] ][$key]['IMG_ID'] = array_search($photo,$arPhotoID);
						$arPhoto[$photo_property][ $item['ID'] ][$key]['SOURCE'] = $photo;
					}
				}
			}
		}
	}
    
?>

	<div class="col-left">
		<div class="detalet-cart">
			<div class="img-photos-demo">
				<div class="big-demo" id="photos">
				<?php /* fotos prints by js */ ?>
				</div>
                <?
                Novagroup_Classes_General_Main::getView('catalog.element','actions',array("val"=>$val, "arResult"=> $arResult));
                ?>
			</div>
			<div class="thumbs" id="thumbs">
			<?php /* fotos prints by js */ ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
        

    <?$i = 0;?>
        <div class="slick-container">
            <?foreach ($arColors['COLORS'] as $id => $item):?>  
                    <?if($i == 0):?>
                        <div class="single-slide" data-color = "<?=$item?>">
                    <?else:?>
                        <div class="single-slide hide-slick" data-color = "<?=$item?>">
                    <?endif;?>
                            <div style="text-align: center"><img src="<?=$arResult['DETAIL_IMAGES'][$id]["curPhotosBig"][0]?>"></div>
                            <div style="text-align: center"><img src="<?=$arResult['DETAIL_IMAGES'][$id]["curPhotosBig"][1]?>"></div>
                        </div>
                <?$i++;?>
            <?endforeach;?>
        </div>
	</div>
	<div class="col-right">
		<div class="card-tab-det">

        <div class="bs-tab">
        <?php
        Novagroup_Classes_General_Main::getView('catalog.element','print_button',array());
        if ($arParams['SHOW_EDIT_BUTTON'] == "Y") {
            Novagroup_Classes_General_Main::getView('catalog.element','edit_button',array("val"=>$val));
        }
        ?>

        <!-- ��������� �������� -->
        <div class="detail">

            <div class="head-title" style="width:310px"><h1><?=$val['NAME']?></h1></div>
            <?$APPLICATION -> SetTitle($val['NAME']); ?>
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

            if (is_array($arResult["CURRENT_ELEMENT"]["COLORS"])) {
                $params = array();
                foreach ($arResult["CURRENT_ELEMENT"]["COLORS"] as $color) {
                    $params[] = array(
                        "button"=>array(
                            "data-original-title"=>$arResult['mixData'][$color]['NAME'],
                            "id"=>"color-".$arResult['mixData'][$color]['ID']."-".$val['ID']."-set-by-hash",
                            "class"=>"btn",
                            "data-placement"=>"top",
                            "rel"=>"tooltip",
                            "data-color"=>$arResult['mixData'][$color]['ID'],
                            "type"=>"button",
                        ),
                        "img"=>array(
                            "src"=>(!empty($arResult['PREVIEW_PICTURE'][$color])) ? $arResult['PREVIEW_PICTURE'][$color] : "/local/templates/demoshop/images/not-f.jpg",
                            "width"=>"88",
                            "height"=>"auto",
                            "position"=>"absolute",
                            "top"=> "0",
                            "left"=> "0",
                            //"border"=>"0",
                            "alt"=>$arResult['mixData'][$color]['NAME']
                        )
                    );
                }
                foreach($arResult['OFFERS'] as $key=> $value){
                    if (!$offers[$value["PROPERTY_COLOR_ID"]]) {
                        $offers[$value["PROPERTY_COLOR_ID"]] = CFile::GetPath($value["DETAIL_PICTURE"]);
                    }
                }

                $i = 0;
            	foreach ($arColors['COLORS'] as $key => $value) {
                    $params[$i]["img"]["src"] = $offers[$params[$i]['button']['data-color']];
                    $i++;
            	}

                Novagroup_Classes_General_Main::getView('catalog.element','colors_button', array("params"=>$params) );
            }

            ?>

            <div class="choice-size "><?=GetMessage("CHOOSE_SIZE_LABEL")?>:</div>
            <div id="size-table" >
                &nbsp;<a href="#myModal8" ><?=GetMessage("SIZE_TABLE")?></a>
            </div>

            <div class="tab-choice tooltip-demo">
            <?php

            Novagroup_Classes_General_Main::includeView( SITE_DIR.'include/catalog/element/size_table.php', array("arResult"=>$arResult, "Params"=>$arParams) );
            Novagroup_Classes_General_Main::includeView(SITE_DIR.'include/catalog/element/actual-price.php', array("arResult"=>$arResult) );
            ?>
<!--            <div class="aside addToBasket">-->
<!--                <div class="set">-->
<!--                    <div id="box-shelve" style="display: none;">-->
<!--                        <div class="message-demo set-tool">--><?//=GetMessage("ADDED_TO_SHELVES")?><!--</div>-->
<!--                    </div>-->
<!--                    <a href="#" id="shelve-product" data-action="addToShelve" data-elem-id="" >--><?//=GetMessage("ADD_TO_SHELVES")?><!--</a>-->
<!--                </div>-->
<!---->
<!--            </div>-->
                <?

//            Novagroup_Classes_General_Main::includeView(SITE_DIR.'include/catalog/element/quick-buy.php');
//            Novagroup_Classes_General_Main::includeView(SITE_DIR.'include/catalog/element/basket.php');
            ?>

            <div class="clear"></div>
            </div>
            <br>
            <div class="stock-availability" >Наличие в магазинах:</div>
            <?
            $stocks = array("SKLAD_1", "SKLAD_2","SKLAD_3","SKLAD_4","SKLAD_5");
            foreach($stocks as $stock):?>
                <div class="wrapper-avail" id="wrapper-avail-<?=$stock?>">
                    <span class="address-line"><?=GetMessage($stock.'_TITLE')?>:</span>
                    <span class="avail-count" id="avail-count-<?=$stock?>"></span>
                    <div class="address-line"><?=GetMessage($stock.'_ADDRESS')?></div>
                    <span class="map-show" data-store="<?=$stock?>">
                        <span class="map-icon"></span>
                        <span class="map-text">Посмотреть на карте</span>
                    </span>
                </div>
                <?
//                    Novagroup_Classes_General_Main::getView('catalog.element','properties', $data);
            endforeach;?>
        </div>

        <ul class="nav nav-tabs" id="myTab1">
            <?php
            $emptyDetailTextFlag = true;

            if (!empty($val['DETAIL_TEXT'])) {
                ?>
                <li class="active"><a data-toggle="tab" href="#description"><?=GetMessage("DESCR_LABEL")?></a></li>
                <?
                $emptyDetailTextFlag = false;
            }
            if ($arResult["COMMENTS_ON"] == 1) {
                ?>
                <li><a data-toggle="tab" onclick="product.getComments();" href="#comment"><?=GetMessage("COMMENTS_LABEL")?></a></li>
            <?
            }
            ?>
        </ul>
            <?php
            if ($emptyDetailTextFlag == false) {?>
        <div class="tab-content" id="myTabContent1">
                <div id="description" class="tab-pane in active">
                    <?=$val['DETAIL_TEXT']?>
                </div>

<!--            <div id="delivery" class="tab-pane --><?//=( $emptyDetailTextFlag == true ? 'in active' : 'fade')?><!--">-->
<!---->
<!--                --><?//=$arResult["delivery"]?>
<!---->
<!--            </div>-->
            <?
            Novagroup_Classes_General_Main::includeView(SITE_DIR.'include/catalog/element/comments.php',array("arResult"=>$arResult,"ajaxUrl"=>$ajaxUrl));
            ?>
        </div>
                <?
            }
            ?>

        </div>

        <div class="clear"></div>
        <?
 		//if($_REQUEST['CAJAX']!=="1")
		//{
	    //	Novagroup_Classes_General_Main::getView('catalog.element','yashare',array("arResult"=>$arResult, "val"=>$val));
	    //}
        ?>

		</div>   
	</div>


    <?
    if (($_REQUEST['CAJAX']!=="1") || ($_REQUEST['FULL'] == 1)) {

        $APPLICATION->IncludeComponent("novagroup:catalog.element.recommend", ".default", array(
                "ELEMENT_ID" => $arResult["ID"],
                "CATALOG_IBLOCK_ID" => $arParams['CATALOG_IBLOCK_ID'],
                "OFFERS_IBLOCK_ID" => $arParams['CATALOG_OFFERS_IBLOCK_ID'],
                "CACHE_TYPE"	=> "A",
                "CACHE_TIME" => $arParams['CACHE_TIME']*2,
                "CUR_PRICE_ARR" => $arResult["CUR_PRICE_ARR"],
            ), false,
            Array(
                'ACTIVE_COMPONENT' => 'Y',
            ));
    }
    ?>

	<div class="clear"></div>

	<div id="myModal8" class="modal hide fade size-tab-my mod-size" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
        <div class="modal-header" id="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h3 id="myModalLabel8"><?=GetMessage("SIZE_TABLE2")?></h3>
        </div>
	    <div class="modal-body" id="modal-body">
<!--	    --><?//=$arResult["tablitsa-razmerov"]?>
            <img src="<?=SITE_DIR?>local/templates/demoshop/images/size-table.png">
		</div>
	</div>
<?php 
}
?>

<div id="myModal" class="modal fade card-img" tabindex="-1" aria-hidden="false"  style="display: none;">
    <div id="myCarousel" class="carousel">
        <div class="carousel-inner" id="carousel-inner">
        
        </div>
       <!-- Carousel nav -->
        <a id="left-arr" class="carousel-control left" href="#myCarousel" data-slide="prev"></a>
        <a id="right-arr" class="carousel-control right" href="#myCarousel" data-slide="next"></a>
    </div>
</div>

<?
if (!defined("ERROR_404") && $_REQUEST['CAJAX']!=="1") {
    $APPLICATION->IncludeComponent("bitrix:sale.viewed.product", "demoshop", array(
            "VIEWED_COUNT" => "4",
            "VIEWED_NAME" => "Y",
            "VIEWED_IMAGE" => "Y",
            "VIEWED_PRICE" => "Y",
            "VIEWED_CANBUY" => "Y",
            "EXCLUDE_ID" => $arResult['ELEMENT']["ID"],
            "VIEWED_CANBUSKET" => "Y",
            "CATALOG_IBLOCK_ID" => $arParams['CATALOG_IBLOCK_ID'],
            "IMAGERIES_IBLOCK_ID" => $arParams['FASHION_IBLOCK_ID'],
            "VIEWED_IMG_HEIGHT" => "100",
            "VIEWED_IMG_WIDTH" => "100",
            "BASKET_URL" => "/personal/basket.php",
            "ACTION_VARIABLE" => "action",
            "PRODUCT_ID_VARIABLE" => "id",
            "SET_TITLE" => "N"
        ),
        false
    );
}
?>

<div id="ajaximgload-thumbs" style="display:none;">
<?
	foreach($arPhoto['curPhotosSmall'] as $subkey => $subval)
		foreach($subval as $subkey2 => $subval2)
		{
			$APPLICATION->IncludeComponent(
				"novagroup:ajaximgload",
				"",
				Array(
					"CALL_FROM_CATALOG"		=> "Y",
					"ATTRIBUTES"	=> array(
						"width"		=> 86,
						"height"	=> 114
					),
					"MICRODATA"		=> array(
						"imgid"	=> $subval2['IMG_ID'],
						"elmid" => $subkey
					),
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
<div id="ajaximgload-medium" style="display:none;">
<?
	foreach($arPhoto['curPhotosMiddle'] as $subkey => $subval)
		foreach($subval as $subkey2 => $subval2)
		{
			$APPLICATION->IncludeComponent(
				"novagroup:ajaximgload",
				"",
				Array(
					"CALL_FROM_CATALOG"		=> "Y",
					"ATTRIBUTES"	=> array(
						"width"		=> 450,
						"height"	=> 580
					),
					"MICRODATA"		=> array(
						"imgid"	=> $subval2['IMG_ID'],
						"elmid" => $subkey
					),
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
<div class="popup">
    <div class="popup__overlay"></div>
    <div class="popup__body" id="map">
    </div>
</div>


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

    <?php

    $i = 0;
    foreach ($arResult["OFFERS"] as $item) {
        $quantity = intval($item["CATALOG_QUANTITY"]);
        $colorId = $item["DISPLAY_PROPERTIES"]["COLOR"]["VALUE"];
        if ($i == 0) {

            ?>
    var curPhotosSmall = [];
    var curPhotosBig = [];
    var curPhotosMiddle = [];
    var curPhotosBigHeight = [];

    var storeQuantity = [];
    <? for ($j=1;$j<6;$j++):?>
        storeQuantity.push(<?=!empty($item["PROPERTIES"]["SKLAD_".$j]["VALUE"])?$item["PROPERTIES"]["SKLAD_".$j]["VALUE"]:0?>);
    <?endfor;?>

    <?php
    $photos_properties = array('curPhotosSmall','curPhotosBig','curPhotosBigHeight','curPhotosMiddle');
    foreach($photos_properties as $photo_property)
    {
        if(is_array($arResult['DETAIL_IMAGES'][$item['ID']][$photo_property])){
            foreach($arResult['DETAIL_IMAGES'][$item['ID']][$photo_property] as $photo)
            {
            ?>
            <?=$photo_property?>.push('<?=$photo?>');
            <?php
            }
        }
    }
// show the first offer with min price
$rsSeoData = new \Bitrix\Iblock\InheritedProperty\ElementValues($arResult["IBLOCK_ID"], $arResult['ID']);
$arSeoData = $rsSeoData->getValues();
?>
    var messages = {
        "DEL_FROM_SHELVES" : "<?=GetMessage("DEL_FROM_SHELVES")?>",
        "ADD_TO_SHELVES" : "<?=GetMessage("ADD_TO_SHELVES")?>",
        "NOT_IN_OPT_STOCK" : "<?=GetMessage("NOT_IN_OPT_STOCK")?>",
        "ALERT_NAME" : "<?=GetMessage("ALERT_NAME")?>",
        "NO_IN_STOCK" : "<?=GetMessage("NO_IN_STOCK")?>",
        "NO_SIZE_LABEL" : "<?=GetMessage("NO_SIZE_LABEL")?>",
        "PRODUCT_ADDED_TO_CART" : "<?=GetMessage("PRODUCT_ADDED_TO_CART")?>",
        "PRODUCT_ALREADY_IN_CART" : "<?=GetMessage("PRODUCT_ALREADY_IN_CART")?>",
        "ADDED_TO_SHELVES" : "<?=GetMessage("ADDED_TO_SHELVES")?>",
        "DELETED_FROM_SHELVES" : "<?=GetMessage("DELETED_FROM_SHELVES")?>",
        "ALERT_MESSAGE" : "<?=GetMessage("ALERT_MESSAGE")?>",
        "SUBSCR_MESSAGE" : "<?=GetMessage("SUBSCR_MESSAGE")?>",
        "CAROUSEL_LABEL1" : "<?=GetMessage("CAROUSEL_LABEL1")?>",
        "CAROUSEL_LABEL2" : "<?=GetMessage("CAROUSEL_LABEL2")?>",
        "PRODUCT_NAME" : "<?=$arSeoData['ELEMENT_PREVIEW_PICTURE_FILE_ALT'];?>"
    }
    product.setSiteID('<?=SITE_ID?>');
    product.photoFirstTime = false;
    var userArr = [];
    userArr["is_opt"] = <?=$arResult['OPT_USER']?>;
    var shelvedItems = [];
    <?
    foreach ($arResult["SHELVED_ITEMS"] as $i) {
        ?>shelvedItems.push(<?=$i?>);
    <?
    }
    ?>
    product.init(
        <?=$item["ID"]?>,
        '<?=$item["PRICES"][$arResult["CUR_PRICE_CODE"]]["PRINT_DISCOUNT_VALUE_VAT"]?>',
        '<?=$item["DISPLAY_PROPERTIES"]["COLOR"]["VALUE"]?>',
        '<?=$item["DISPLAY_PROPERTIES"]["STD_SIZE"]["VALUE"]?>',
        '<?=$arResult['mixData'][$item["DISPLAY_PROPERTIES"]["COLOR"]["VALUE"]]['NAME']?>',
        '<?=$arResult['PREVIEW_PICTURE'][$item["DISPLAY_PROPERTIES"]["COLOR"]["VALUE"]]?>',
        curPhotosSmall,
        curPhotosBig,
        curPhotosBigHeight,
        '<?=$arResult['mixData'][$item["DISPLAY_PROPERTIES"]["STD_SIZE"]["VALUE"]]['NAME']?>','<?=$arResult['mixData'][$item["DISPLAY_PROPERTIES"]["STD_SIZE"]["VALUE"]]['SORT']?>',
        <?=$quantity?>,
        '<?=$item["PRICES"][$arResult["CUR_PRICE_CODE"]]["PRINT_VALUE_VAT"]?>',
        '<?=$ajaxUrl?>',
        <?=$val["ID"]?>,
        messages,
        <?=$arResult["COMMENTS_ON"]?>,
        '<?=$arResult['DETAIL_PAGE_URL']?>',
        <?=($arParams["CATALOG_SUBSCRIBE_ENABLE"] == "Y" ? 'true' : 'false' )?>,
        curPhotosMiddle,
        <?=$arResult["DETAIL_CARD_VIEW"]?>,
        userArr,
        shelvedItems,
        storeQuantity
    );
    <?

        } else {

            ?>
    var curPhotosSmall = [];
    var curPhotosMiddle = [];
    var curPhotosBig = [];
    var curPhotosBigHeight = [];
    var storeQuantity = [];
    <? for ($j=1;$j<6;$j++):?>
    storeQuantity.push(<?=!empty($item["PROPERTIES"]["SKLAD_".$j]["VALUE"])?$item["PROPERTIES"]["SKLAD_".$j]["VALUE"]:0?>);
    <?endfor;
    $photos_properties = array('curPhotosSmall','curPhotosBig','curPhotosBigHeight','curPhotosMiddle');
    foreach($photos_properties as $photo_property)
    {
        if(is_array($arResult['DETAIL_IMAGES'][$item['ID']][$photo_property])){
            foreach($arResult['DETAIL_IMAGES'][$item['ID']][$photo_property] as $photo)
            {
            ?>
            <?=$photo_property?>.push('<?=$photo?>');
			<?php
            }
        }
    }
?>
    product.addToSet(
        <?=$item["ID"]?>,
        '<?=$item["PRICES"][$arResult["CUR_PRICE_CODE"]]["PRINT_DISCOUNT_VALUE_VAT"]?>',
        '<?=$item["DISPLAY_PROPERTIES"]["COLOR"]["VALUE"]?>',
        '<?=$item["DISPLAY_PROPERTIES"]["STD_SIZE"]["VALUE"]?>',
        '<?=$arResult['mixData'][$item["DISPLAY_PROPERTIES"]["COLOR"]["VALUE"]]['NAME']?>',
        '<?=$arResult['PREVIEW_PICTURE'][$item["DISPLAY_PROPERTIES"]["COLOR"]["VALUE"]]?>',
        curPhotosSmall,
        curPhotosBig,
        curPhotosBigHeight,
        '<?=$arResult['mixData'][$item["DISPLAY_PROPERTIES"]["STD_SIZE"]["VALUE"]]['NAME']?>',
        '<?=$arResult['mixData'][$item["DISPLAY_PROPERTIES"]["STD_SIZE"]["VALUE"]]['SORT']?>',
        <?=$quantity?>,
        '<?=$item["PRICES"][$arResult["CUR_PRICE_CODE"]]["PRINT_VALUE_VAT"]?>',
        curPhotosMiddle,
        storeQuantity
    );
    <?php
    }
    $i++;
}
if ($arParams["CATALOG_SUBSCRIBE_ENABLE"] == "Y") {
    ?>
    product.getSubscribed();
    <?php
} 
?>
    product.chooseFirstColor();

    var optionsComments = {
        dataType:  'json',
        beforeSubmit:  product.checkCommentForm,
        success: function(json) {

            hideAjaxLoader();
            if (json.result == "ERROR") {

                $("#alert").attr("class", "alert alert-error").html(json.message);

            } else if (json.result == "OK") {

                product.getComments(1);
                $("#alert").attr("class", "alert alert-success").html(json.message);
                $("#commenForm" )[0].reset();
                $("#controlGroupName").attr("class", "control-group");
                $("#controlGroupText").attr("class", "control-group");
            }
        }
    };
    $('#commenForm').ajaxForm(optionsComments);
    //update comments
    $('.refreshComments').live('click', function() {

        product.getComments(1);
        return false;
    });
    $('.pagination ul li a').live('click', function(){

        product.getComments($(this).attr('data-inumpage'));

        return false;
    });
    var sizeIds = [];
    var getAnchor = location.hash;

    <?
	if (isset($arParams['cs']))
	{
		$cs = explode("-",$arParams['cs']);
		if (is_array($cs))
		{
			foreach($cs as $item)
			{
				?>
				sizeIds[sizeIds.length] = '<?=$item?>';
				<?
			}
		}
	}
	?>
    // fix for ie
    if (sizeIds.length == 0) {
        var getAnchor = location.hash;
        sizeIds = product.getSizeFromAnchorIE(getAnchor);
    }

    <?
    if ($arResult["MAX_COUNT_SIZE"] > 0 && $arResult["MAX_COUNT_COLOR"] > 0) {
    	// choose size and color like smart site
		?>
		product.currentSizeId = <?=$arResult["MAX_COUNT_SIZE"]?>;

		if (product.colorFromUrl == false) {

           // product.changeColor(<?=$arResult["MAX_COUNT_COLOR"]?>);
            $( "button[data-color='<?=$arResult["MAX_COUNT_COLOR"]?>']" ).click();
        }
		<?php 
    }
    ?>

    if ($.isArray(sizeIds)) {
        for (var i = 0; i < sizeIds.length; i++) {
            if (product.checkSize(sizeIds[i])) {

                product.changeSize(sizeIds[i]);
                break;
            }
        }
    }

    // show final photos
    product.photoFirstTime = true;
    product.changePhotos(product.photoBuffer);
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

<!-- >>> ajax image load scripts temporary decision -->
<script>
    $(document).ready(function(e) {
        ajaxImgLoad();
    });
</script>
<!-- <<< ajax image load scripts temporary decision -->
<script>
    var map;
    var marker;
    function init(latLng) {
        map = new google.maps.Map(document.getElementById('map'), {
            center: latLng,
            scrollwheel: true,
            zoom: 18
        });
        marker = new google.maps.Marker({
            map: map,
            position: latLng
        });
    }

    $(document).ready(function() {
        $('.popup').hide();

        $('.map-show').click(function () {
            var latLng;
            switch ($(this).data('store')) {
                case 'SKLAD_1':
                    latLng = {lat: 56.589741609539324, lng: 84.92592573165894};//Северск
                    break;
                case 'SKLAD_2':
                    latLng = {lat: 56.49426338747856, lng: 84.9493682384491};//ГУМ
                    break;
                case 'SKLAD_3':
                    latLng = {lat: 56.51623851565142, lng: 85.03381490707397};//Манеж
                    break;
                case 'SKLAD_4':
                    latLng = {lat: 56.51566932787304, lng: 85.03366954232781};
                    break;
                case 'SKLAD_5':
                    latLng = {lat: 56.589741609539324, lng: 84.92592573165894};//Северск (магазин на Калинина)
                    break;
            }
            $('#top_nav').hide();
            $('.zoomContainer').hide();
            $('.popup').show();
            init(latLng);
        });
        $('.popup__overlay').click(function () {
            $('.popup').hide();
            $('.zoomContainer').show();
            $('#top_nav').show();
        });
    });
</script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAFVE7D-efaN8SvhIOFAwkflMK8pJo8OwI"
            async defer></script>
<??>