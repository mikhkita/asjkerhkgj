<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
}

/*
$APPLICATION->IncludeComponent("novagroup:sale.basket.basket.line", ".default", array(
        "PATH_TO_BASKET" => SITE_DIR."cabinet/cart/",
        "PATH_TO_PERSONAL" => SITE_DIR."cabinet/",
        "SHOW_PERSONAL_LINK" => "N"
    ),
    false,
    Array('')
);*/

$APPLICATION->IncludeComponent("novagroup:top.basket", "demoshop", array(
        "PATH_TO_ORDER" => SITE_DIR . "cabinet/order/make/",
        "PATH_TO_BASKET" => SITE_DIR."cabinet/cart/",
        "PATH_TO_PERSONAL" => SITE_DIR."cabinet/",
        'CATALOG_IBLOCK_ID' => "19",
        "OFFERS_IBLOCK_ID" => "21"
    ),
    false,
    Array('')
);
?>