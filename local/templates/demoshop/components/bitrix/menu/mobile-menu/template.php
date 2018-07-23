<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<nav id="menu">
	<h2 class="menu-header">Меню</h2>
	 <ul class="menu-wrap">   
	 	<li><a href="/"><h3>Главная</h3></a></li>
	 	<?$first_item = array_shift($arResult);?>
        <li><a href="<?=$first_item['LINK']?>"><h3><?=$first_item['TEXT']?></h3></a></li>
		<li>
			<?foreach($arResult['MENU'] as $arItem): ?>
				<?if($arItem['CHILDS']):?>
				<div class="accordion-mobile">
					<h3><a href="#"><?=$arItem['NAME']?></a></h3>
					<div>
	                    <ul>
	                    	<?foreach($arItem['CHILDS'] as $child):?>
		                        <li><a href="<?=$child["SECTION_PAGE_URL"]?>"><?=$child['NAME']?></a></li>
	                        <?endforeach;?>
	                    </ul>
	                </div>
	            </div>
				<?else:?>
					<a href="<?=$arItem['SECTION_PAGE_URL']?>"><h3><?=$arItem['NAME']?></h3></a>
				<?endif;?>
            <?endforeach;?>
		</li>
		<?for($arCount = 0; $arCount < count($arResult) - 1; $arCount++):?>
			<li><a href="<?=$arResult[$arCount]['LINK']?>"><h3><?=$arResult[$arCount]['TEXT']?></h3></a></li>
		<?endfor;?>
	</ul>	
</nav>