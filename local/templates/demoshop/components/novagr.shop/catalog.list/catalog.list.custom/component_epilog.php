<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/comments.js');
    $APPLICATION->AddHeadScript('/local/js/novagroup/jquery.lwtCountdown-1.0.js');

    $arFilter = Array("IBLOCK_ID"=>19);
	$db_list = CIBlockSection::GetList(Array(), $arFilter, true, $arSelect=Array('UF_TITLE_H1'));
	while($ar_result = $db_list->GetNext()){
	    if ($arResult["CUR_SECTION_CODE"] == $ar_result["CODE"]) {
	        $APPLICATION->SetTitle($ar_result['UF_TITLE_H1']);
	    }
	}
	
?>	