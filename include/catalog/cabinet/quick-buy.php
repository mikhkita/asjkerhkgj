<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
}

$APPLICATION->IncludeComponent("novagroup:catalog.element.quickbuy.cart", "", array(
        "ORDER_LIST_IBLOCK_ID" => "16",
        "ORDER_PRODUCT_IBLOCK_ID" => "17",
    ),
    false,
    Array('')
);
?>