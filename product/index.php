<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Лендинг");

$currentUri = $APPLICATION->GetCurPage();
if ($currentUri == '/product/') {
    LocalRedirect("/catalog/", true, '301 Moved permanently');
}
?>
<?$APPLICATION->IncludeComponent(
    "novagr.shop:landing",
    "",
    Array(
        "IBLOCK_ID" => "18",
        "CATALOG_IBLOCK_ID" => "19",
        "ELEMENT_CODE" => $_REQUEST["elem_code"],
        "CATALOG_OFFERS_IBLOCK_ID" => "21",
        "ARTICLES_IBLOCK_ID" => "1",
        "OPT_GROUP_ID" => "5",
        "OPT_PRICE_ID" => "2",
        "CACHE_TYPE" => "Y",
        "CACHE_TIME" => "1",
    ),
    false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>