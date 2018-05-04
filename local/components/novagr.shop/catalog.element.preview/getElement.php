<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arResult = $data = Novagroup_Classes_General_CatalogOffers::getElementByLastResult($arParams['ELEMENT_ID']);
$data["PROPERTIES"] = array(); // $obElement->GetProperties();
$data['PROPERTIES']['SPECIALOFFER']['VALUE'] = $data['PROPERTY_SPECIALOFFER_VALUE'];
$data['PROPERTIES']['NEWPRODUCT']['VALUE'] = $data['PROPERTY_NEWPRODUCT_VALUE'];
$data['PROPERTIES']['SALELEADER']['VALUE'] = $data['PROPERTY_SALELEADER_VALUE'];
$data['PROPERTIES']['SALE']['VALUE'] = $data['PROPERTY_SALE_VALUE'];
$data['PROPERTIES']['SALE_LEADER']['VALUE'] = $data['PROPERTY_SALE_LEADER_VALUE'];
$data['PROPERTIES']['LAST_SIZE']['VALUE'] = $data['PROPERTY_LAST_SIZE_VALUE'];
$data['PROPERTIES']['NEW']['VALUE'] = $data['PROPERTY_NEW_VALUE'];
$data['PROPERTIES']['OFFER']['VALUE'] = $data['PROPERTY_OFFER_VALUE'];
$data['PROPERTIES']['DISCOUNTED']['VALUE'] = $data['PROPERTY_DISCOUNTED_VALUE'];

// TODO � ��������� ���������
$arParams["PRODUCT_ID_VARIABLE"] = 'id';
$arParams["ACTION_VARIABLE"] = 'action';

$arParams['ELEMENT_ID'] = $data['ID'];
$arParams['ELEMENT_NAME'] = $data['NAME'];


// ������������ �������� �����������
$arResult["CURRENT_ELEMENT"]["COLORS"] = array();
$arResult["CURRENT_ELEMENT"]["STD_SIZE"] = array();
$arResult["OFFERS"] = array();

$arResult['OBJECT_PRICE'] =  $price = new Novagroup_Classes_General_CatalogPrice($arParams['ELEMENT_ID'],$arParams["CATALOG_IBLOCK_ID"], $arParams['PRICE_ID']);
$arResult['PRICE'] = $price->getPrice();

$arOffers = $price->getLastOffersResult();

// ������� ���� ��� ���� ���� �� ���� �� � �������� ������� ������ 0
$arResult["PRODUCT_IN_STOCK"] = 0;
foreach ($arOffers as $arOffer) {
    $arOffer["PROPERTIES"]["COLOR"]["VALUE"] = $arOffer["PROPERTY_COLOR_ID"];
    $arOffer["PROPERTIES"]["STD_SIZE"]["VALUE"] = $arOffer["PROPERTY_STD_SIZE_ID"];

    if ($arOffer["CATALOG_QUANTITY"] > 0) {
        $arResult["PRODUCT_IN_STOCK"] = 1;
    }
    // ��������� ���� � ������ ������ ��� ������
    if (!empty($arOffer["PROPERTIES"]["COLOR"]["VALUE"]) &&
        !in_array($arOffer["PROPERTIES"]["COLOR"]["VALUE"], $arResult["CURRENT_ELEMENT"]["COLORS"])
    ) {
        $arResult["CURRENT_ELEMENT"]["COLORS"][] = $arOffer["PROPERTIES"]["COLOR"]["VALUE"];
        $arResult["CURRENT_ELEMENT"]["COLORS_SORT"][] = $arOffer["PROPERTY_COLOR_SORT"];
        $arResult["CURRENT_ELEMENT"]["COLORS_PREVIEW_PICTURE"][] = $arOffer["PROPERTY_COLOR_PREVIEW_PICTURE"];
        $arResult["CURRENT_ELEMENT"]["COLORS_NAME"][] = $arOffer["PROPERTY_COLOR_NAME"];

    }
    $tmpOffers[] = $arOffer;
}

$arResult["OFFERS"] = $tmpOffers;
$arElements[$data['ID']] = $data;


?>