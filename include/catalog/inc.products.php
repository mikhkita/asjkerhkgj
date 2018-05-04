<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $APPLICATION->IncludeComponent("novagr.shop:catalog.list", "catalog.list.custom", Array(
	"CATALOG_IBLOCK_TYPE" => "catalog",	// Тип информационного блока 'Каталоги'
		"CATALOG_IBLOCK_ID" => "19",	// Каталог
		"OFFERS_IBLOCK_TYPE" => "offers",	// Тип информационного блока 'Торговые предложения'
		"OFFERS_IBLOCK_ID" => "21",	// Торговые предложения
		"ROOT_PATH" => "/catalog/",	// Путь к каталогу, относительно корня сайта
		"BRAND_ROOT" => "/brand/",	// Путь к брендам, относительно корня сайта
		"nPageSize" => (empty($_REQUEST["nPageSize"]))?16:(int)$_REQUEST["nPageSize"],
		"USE_SEARCH_STATISTIC" => "Y",	// Учитывать статистику
		"SHOW_QUANTINY_NULL" => "Y",	// Выводить ТП у которых нулевые остатки
		"OPT_GROUP_ID" => "5",	// ID группы оптовиков
		"OPT_PRICE_ID" => "2",	// ID оптовой цены
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "2592000",	// Время кеширования (сек.)
		"CACHE_GROUPS" => "N",	// Учитывать права доступа
	),
	false
);?>