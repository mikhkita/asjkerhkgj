<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<nav id="menu">
	<h2 class="menu-header">Меню</h2>
	 <ul class="menu-wrap">   
	 	<li><a href="/"><h3>Главная</h3></a></li>
        <li><a href="<?=$arResult[0]['LINK']?>"><h3><?=$arResult[0]['TEXT']?></h3></a></li>
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
		<li><a href="<?=$arResult[1]['LINK']?>"><h3><?=$arResult[1]['TEXT']?></h3></a></li>
	</ul>	
</nav>