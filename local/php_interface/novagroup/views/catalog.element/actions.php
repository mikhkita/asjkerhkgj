<div class="label-card">
<!--    --><?//$APPLICATION->IncludeComponent(
//        "novagroup:catalog.timetobuy",
//        "label",
//        Array(
//            "IBLOCK_ID"=>$val['IBLOCK_ID'],
//            "ID"=>$val['ID']
//        )
//    );?>
    <?
//    if( !empty($val['PROPERTIES']['SPECIALOFFER']['VALUE']) )
//        echo'<div class="card-spec-min"></div>';
//    if( !empty($val['PROPERTIES']['NEWPRODUCT']['VALUE']) )
//        echo'<div class="card-new-min"></div>';
//    if( !empty($val['PROPERTIES']['SALELEADER']['VALUE']) )
//        echo'<div class="card-lider-min"></div>';



//        pre($arResult["OFFERS"]);
        $discount = 0;
//        $cheapest_item = array();
//        $cheapest_item["PRICES"][$arResult["CUR_PRICE_CODE"]]["DISCOUNT_VALUE_VAT"] = PHP_INT_MAX;
        $now = new \Bitrix\Main\Type\DateTime();
        $now = $now->toString();
        foreach ($arResult["OFFERS"] as $item) {
            $dbProductDiscounts = CCatalogDiscount::GetList(array("SORT" => "ASC"), array("PRODUCT_ID" =>$item["ID"], "ACTIVE"=>"Y","!>ACTIVE_FROM" => $now,"!<ACTIVE_TO" => $now), false, false,array("ID", "VALUE"));
            if($arProductDiscounts = $dbProductDiscounts->Fetch()) {
//                if ($cheapest_item["PRICES"][$arResult["CUR_PRICE_CODE"]]["DISCOUNT_VALUE_VAT"] > $item["PRICES"][$arResult["CUR_PRICE_CODE"]]["DISCOUNT_VALUE_VAT"]) {
                if($arProductDiscounts["VALUE"]> $discount){
                    $discount = $arProductDiscounts["VALUE"];
                };
            }
        }
//        $percentage = round(($cheapest_item["PRICES"][$arResult["CUR_PRICE_CODE"]]["VALUE_VAT"]-$cheapest_item["PRICES"][$arResult["CUR_PRICE_CODE"]]["DISCOUNT_VALUE_VAT"])*100/$cheapest_item["PRICES"][$arResult["CUR_PRICE_CODE"]]["VALUE_VAT"]);
//        echo'<div class="card-sale" style="margin: 5px"></div><div class="sale-percent" >-'.round(($cheapest_item["PRICES"][$arResult["CUR_PRICE_CODE"]]["VALUE_VAT"]-$cheapest_item["PRICES"][$arResult["CUR_PRICE_CODE"]]["DISCOUNT_VALUE_VAT"])*100/$cheapest_item["PRICES"][$arResult["CUR_PRICE_CODE"]]["VALUE_VAT"]).'%</div>';

//        echo'<div class="card-sale" style="margin: 10px"></div>';
//    if(!empty($val['PROPERTIES']['SALE']['VALUE'])||!empty($val['PROPERTIES']['OFFER']['VALUE'])||!empty($val['PROPERTIES']['LAST_SIZE']['VALUE'])||!empty($val['PROPERTIES']['DISCOUNTED']['VALUE']))
    if($discount >0) {
        echo '<div class="card-sale" style="margin: 5px"><div class="sale-percent" >-' . (int)$discount . '%</div></div>';
    }
//    if( !empty($val['PROPERTIES']['OFFER']['VALUE']) )
//        echo'<div class="card-sale" style="margin: 5px"><div class="sale-percent" >-'.$discount.'%</div></div>';
    //        echo'<div class="card-offer" style="margin: 5px; display: block"></div>';
//    if( !empty($val['PROPERTIES']['LAST_SIZE']['VALUE']) )
//        echo'<div class="card-last-size" style="margin: 5px; display: block"></div>'
//        echo'<div class="card-sale" style="margin: 5px"><div class="sale-percent" >-'.$discount.'%</div></div>';
//    if( !empty($val['PROPERTIES']['DISCOUNTED']['VALUE']) )
//        echo'<div class="card-last-size" style="margin: 5px; display: block"></div>'
//        echo'<div class="card-sale" style="margin: 5px"><div class="sale-percent" >-'.$discount.'%</div></div>';

    if( !empty($val['PROPERTIES']['NEW']['VALUE']) )
        echo'<div class="card-new" style="margin: 5px; display: block"></div>';
    if( !empty($val['PROPERTIES']['SALE_LEADER']['VALUE']) )
        echo'<div class="card-leader" style="margin: 5px; display: block"></div>';

    ?>
</div>