<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="notetext">
<?
if (!empty($arResult["ORDER"]))
{
	?>
	<h3><?=GetMessage("SOA_TEMPL_ORDER_COMPLETE")?></h3>
	<p>
		<?= GetMessage("SOA_TEMPL_ORDER_SUC", Array("#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"], "#ORDER_ID#" => $arResult["ORDER_ID"]))?><br /><br />
		<?= GetMessage("SOA_TEMPL_ORDER_SUC1", Array("#LINK#" => $arParams["PATH_TO_PERSONAL"])) ?>
	</p>
	<?
	if (!empty($arResult["PAY_SYSTEM"]))
	{
		?>
		<p><?=GetMessage("SOA_TEMPL_PAY")?>: <?= $arResult["PAY_SYSTEM"]["NAME"] ?></p><br />
		<?
		if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
		{
			if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
			{
				?>
				<script language="JavaScript">
					window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?= $arResult["ORDER_ID"] ?>');
				</script>
				<p><?=GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$arResult["ORDER_ID"])) ?></p>
				<?
			}
			else
			{
				if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
				{
					include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
				}
			}
		}
	}
}
else
{
	?>
	<p>
	<b><?=GetMessage("SOA_TEMPL_ERROR_ORDER")?></b><br />
	<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ORDER_ID"]))?>
	<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?>
	</p>
	<?
}
?>
</div>
