<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Dжекиt");
$APPLICATION->SetPageProperty("description", "Интернет-каталог одежды для мужчин и женщин Dжекиt");
$APPLICATION->SetTitle("Dжекиt");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
?><?$APPLICATION->IncludeComponent(
	"novagroup:main.banners", 
	"djekit", 
	array(
		"BANNER_IBLOCK_TYPE" => "banners",
		"BANNER_IBLOCK_ID" => "15",
		"ELEMENT_ID" => "223",
		"ELEMENT_CODE" => "banners-on-main",
		"SORT_FIELD" => "SORT",
		"SORT_BY" => "ASC",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	), 
	false
);?><?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>