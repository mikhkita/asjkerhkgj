<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "pure_detail",
    Array(
        "AJAX_MODE" => "N",
        "IBLOCK_TYPE" => "system",
		"IBLOCK_ID" => "14",
        "ELEMENT_ID" => '',
        "ELEMENT_CODE" => "conditions-of-work-with-a-site",
        "CHECK_DATES" => "Y",
        "FIELD_CODE" => array(),
        "PROPERTY_CODE" => array(),
        "IBLOCK_URL" => "",
        "META_KEYWORDS" => "-",
        "META_DESCRIPTION" => "-",
        "BROWSER_TITLE" => "-",
        "SET_TITLE" => "N",
        "SET_STATUS_404" => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "USE_PERMISSIONS" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_GROUPS" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TITLE" => GetMessage("T_PAGER_TITLE"),
        "PAGER_TEMPLATE" => "",
        "PAGER_SHOW_ALL" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "N",
        "AJAX_OPTION_HISTORY" => "N"
    ),
false
);?>