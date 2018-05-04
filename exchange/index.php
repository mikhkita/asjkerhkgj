<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
include 'Import.class.php';
include 'HLBlock.class.php';
$import = new Import('/home/c/cu57484/Upload/');
$import->test();

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");