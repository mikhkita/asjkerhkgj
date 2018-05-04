<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Каталог");
$APPLICATION->SetTitle("Каталог");
$APPLICATION->SetPageProperty("description", "Интернет-каталог одежды для мужчин и женщин Dжэкиt"); global $USER;
?>
<?
Novagroup_Classes_General_Catalog::showCatalog();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>