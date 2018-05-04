<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);?>

<?if (!empty($arResult)):?>
<div class="header__menu">

<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	<?if($arItem["SELECTED"]):?>
		<span><a href="<?=$arItem["LINK"]?>" class="selected"><?=$arItem["TEXT"]?></a></span>
	<?else:?>
		<span><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></span>
	<?endif?>
	
<?endforeach?>

</div>
<?endif?>