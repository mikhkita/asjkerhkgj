<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); $this->setFrameMode(true)  ?>
<?$APPLICATION->IncludeComponent(
    "novagroup:brands.list",
    ".default",
    Array(
        "SORT_FIELD" => "NAME",
        "SORT_BY" => "ASC",
        "BRANDS_IBLOCK_CODE" => "vendor",
        "COUNT_RECORDS" => "5",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "360000"
    )
);?>