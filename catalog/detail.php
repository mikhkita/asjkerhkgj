<?
	if($_REQUEST['CAJAX'] == 1){
		require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	}else
		require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetTitle("Каталог");
?>

<?
if($_REQUEST['print']=='Y'){
	$APPLICATION->IncludeComponent(
		"novagr.shop:catalog.element",
		"print",
		array(
			"SORT_FIELD" => "ID",
			"SORT_BY" => "DESC",
			"CATALOG_IBLOCK_TYPE" => "catalog",
			"CATALOG_IBLOCK_ID" => "19",
			"LANDING_IBLOCK_ID" => "18",
			"LANDING_PAGE" => "N",
			"CATALOG_OFFERS_IBLOCK_ID" => "21",
			"ARTICLES_IBLOCK_ID" => "1",
			"FASHION_IBLOCK_ID" => "20",
			"SAMPLES_IBLOCK_CODE" => "samples",
			"BRANDNAME_IBLOCK_CODE" => "vendor",
			"COLORS_IBLOCK_CODE" => "colors",
			"MATERIALS_IBLOCK_CODE" => "materials",
			"STD_SIZES_IBLOCK_CODE" => "std_sizes",
			"CATALOG_SUBSCRIBE_ENABLE" => "Y",
			"INET_MAGAZ_ADMIN_USER_GROUP_ID" => "7",
			"OPT_GROUP_ID" => "5",
			"OPT_PRICE_ID" => "2",
			"SIZE_NO_ID" => "194",
			"COLOR_NO_ID" => "21",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "2592000",
			"cs" => $_REQUEST["cs"],
			"CATALOG_COMMENTS_ENABLE" => "N"
		),
		false,
		array(
			"ACTIVE_COMPONENT" => "Y"
		)
	);
}
else{
	$APPLICATION->IncludeComponent(
		"novagr.shop:catalog.element",
		"regular",
		array(
			"SORT_FIELD" => "ID",
			"SORT_BY" => "DESC",
			"CATALOG_IBLOCK_TYPE" => "catalog",
			"CATALOG_IBLOCK_ID" => "19",
			"LANDING_IBLOCK_ID" => "18",
			"LANDING_PAGE" => "N",
			"CATALOG_OFFERS_IBLOCK_ID" => "21",
			"ARTICLES_IBLOCK_ID" => "1",
			"FASHION_IBLOCK_ID" => "20",
			"SAMPLES_IBLOCK_CODE" => "samples",
			"BRANDNAME_IBLOCK_CODE" => "vendor",
			"COLORS_IBLOCK_CODE" => "colors",
			"MATERIALS_IBLOCK_CODE" => "materials",
			"STD_SIZES_IBLOCK_CODE" => "std_sizes",
			"CATALOG_SUBSCRIBE_ENABLE" => "Y",
			"INET_MAGAZ_ADMIN_USER_GROUP_ID" => "7",
			"OPT_GROUP_ID" => "5",
			"OPT_PRICE_ID" => "2",
			"SIZE_NO_ID" => "194",
			"COLOR_NO_ID" => "21",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "2592000",
			"cs" => $_REQUEST["cs"],
			"CATALOG_COMMENTS_ENABLE" => "N"
		),
		false,
		array(
			"ACTIVE_COMPONENT" => "Y"
		)
	);
}
?>


<?
if($_REQUEST['CAJAX'] == 1)
{
	$APPLICATION->IncludeFile(SITE_DIR."include/pSubscribe.php");
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
}else
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
                                                        