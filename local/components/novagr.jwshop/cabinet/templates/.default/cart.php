<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->IncludeComponent("novagroup:eshop.sale.basket.basket", "demoshop", array(
        "COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
        "COLUMNS_LIST" => array(
            0 => "NAME",
            1 => "PROPS",
            2 => "PRICE",
            3 => "QUANTITY",
            4 => "DELETE",
            5 => "DELAY",
            /*6 => "DISCOUNT",*/
        ),
        "AJAX_MODE" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "PATH_TO_ORDER" => SITE_DIR."cabinet/order/make/",
        "HIDE_COUPON" => "N",
        "QUANTITY_FLOAT" => "N",
        "PRICE_VAT_SHOW_VALUE" => "Y",
        "SET_TITLE" => "N",
        "AJAX_OPTION_ADDITIONAL" => ""
        ),
         $component
    );
?>