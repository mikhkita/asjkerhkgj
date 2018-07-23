<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Dжекиt");
$APPLICATION->SetPageProperty("description", "Интернет-каталог одежды для мужчин и женщин Dжекиt");
?>
<?
if(CModule::IncludeModule("iblock")){

  $arFilter = Array('IBLOCK_ID'=>19, 'ACTIVE'=>'Y');
  $db_list = CIBlockSection::GetList(Array(), $arFilter, true);
  while($ar_result = $db_list->GetNext())
  {
	if (!$ar_result["IBLOCK_SECTION_ID"]) {
		$myArr[] = $ar_result;
	}
  }
  foreach ($myArr as $key => $value) {
  	$url = CFile::GetPath($value["DETAIL_PICTURE"]);
  	if ($url) {
  		$myArr[$key]['PIC'] = $url;
  	}
  }
}
?>
<a href="<?=$myArr[1]["SECTION_PAGE_URL"]?>" class="main-man" style="background-image: url(<?=$myArr[1]['PIC']?>)">
	<p class="mobile-but"><?=$myArr[1]["NAME"]?></p>
</a>

<a href="<?=$myArr[0]["SECTION_PAGE_URL"]?>" class="main-woman" style="background-image: url(<?=$myArr[0]['PIC']?>);">
	<p class="mobile-but"><?=$myArr[0]["NAME"]?></p>
</a>

<?
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