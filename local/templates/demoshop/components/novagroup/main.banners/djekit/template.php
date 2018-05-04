<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();$this->setFrameMode(true);
if (!empty($arResult["PREVIEW_TEXT"])) {
    ?>
    <div class="text-block top">
    <?=$arResult["PREVIEW_TEXT"]?>
	</div>
<?
}
if ($arResult["PROPERTY_VIEW_VALUE"] == "slider") {
?>

<div class="carusel-my">
	<div class="carousel slide" id="myCarousel">
		<div class="carousel-inner mycarousel-inner">
			<?php
			$i = 1;
			for ($j=1; $j<13; $j++) {

				if (!empty($arResult["SLIDE".$j]['PICTURE'])) {
					if ($i==1) {
						$addClass = " active";
					} else {
						$addClass = "";
					}
					?>
					<div class="item<?=$addClass?>">
					    <?$file = CFile::ResizeImageGet($arResult["SLIDE".$j]['PICTURE'], array('width'=>988, 'height'=>700), BX_RESIZE_IMAGE_EXACT, false); ?>
                        <img alt="<?=$arResult['SITE']['SITE_NAME']?>" title="<?=$arResult['SITE']['SITE_NAME']?>" src="<?=$file['src'];?>">
						<?if(!empty($arResult["SLIDE".$j]['LINK1'])):?>
							<?if(empty($arResult["SLIDE".$j]['LINK2'])):?>
								<a href="<?=$arResult["SLIDE".$j]['LINK1']?>" class="slider__button" style="<?if($arResult["SLIDE".$j]['LINK1_COLOR1']):?>background-color: #<?=$arResult["SLIDE".$j]['LINK1_COLOR1']?>;<?endif;?>color: <?if($arResult["SLIDE".$j]['LINK1_TEXTCOLOR1']):?> #<?=$arResult["SLIDE".$j]['LINK1_TEXTCOLOR1']?>!important<?else:?>white!important;<?endif;?>"
								   onmouseover="<?if($arResult["SLIDE".$j]['LINK1_COLOR2']):?>this.style.backgroundColor='#<?=$arResult["SLIDE".$j]['LINK1_COLOR2']?>';<?endif;?><?if($arResult["SLIDE".$j]['LINK1_TEXTCOLOR2']):?>this.style.setProperty('color','#<?=$arResult["SLIDE".$j]['LINK1_TEXTCOLOR2']?>','important');<?endif;?>"
								   onmouseout="<?if($arResult["SLIDE".$j]['LINK1_COLOR1']):?>this.style.backgroundColor='#<?=$arResult["SLIDE".$j]['LINK1_COLOR1']?>';<?endif;?><?if($arResult["SLIDE".$j]['LINK1_TEXTCOLOR1']):?>this.style.setProperty('color','#<?=$arResult["SLIDE".$j]['LINK1_TEXTCOLOR1']?>','important');<?else:?>this.style.setProperty('color','white','important');<?endif;?>"
								><?=$arResult["SLIDE".$j]['LINK1_TEXT']?>
									<span class="slider__button_arrow"></span>
								</a>
							<?else:?>
								<a href="<?=$arResult["SLIDE".$j]['LINK1']?>" class="slider__button slider__button_left" style="<?if($arResult["SLIDE".$j]['LINK1_COLOR1']):?>background-color: #<?=$arResult["SLIDE".$j]['LINK1_COLOR1']?>;<?endif;?>color: <?if($arResult["SLIDE".$j]['LINK1_TEXTCOLOR1']):?> #<?=$arResult["SLIDE".$j]['LINK1_TEXTCOLOR1']?>!important<?else:?>white!important;<?endif;?>"
								   onmouseover="<?if($arResult["SLIDE".$j]['LINK1_COLOR2']):?>this.style.backgroundColor='#<?=$arResult["SLIDE".$j]['LINK1_COLOR2']?>';<?endif;?><?if($arResult["SLIDE".$j]['LINK1_TEXTCOLOR2']):?>this.style.setProperty('color','#<?=$arResult["SLIDE".$j]['LINK1_TEXTCOLOR2']?>','important');<?endif;?>"
								   onmouseout="<?if($arResult["SLIDE".$j]['LINK1_COLOR1']):?>this.style.backgroundColor='#<?=$arResult["SLIDE".$j]['LINK1_COLOR1']?>';<?endif;?><?if($arResult["SLIDE".$j]['LINK1_TEXTCOLOR1']):?>this.style.setProperty('color','#<?=$arResult["SLIDE".$j]['LINK1_TEXTCOLOR1']?>','important');<?else:?>this.style.setProperty('color','white','important');<?endif;?>"
								><?=$arResult["SLIDE".$j]['LINK1_TEXT']?>
									<span class="slider__button_arrow"></span>
								</a>
								<a href="<?=$arResult["SLIDE".$j]['LINK2']?>" class="slider__button slider__button_right" style="<?if($arResult["SLIDE".$j]['LINK2_COLOR1']):?>background-color: #<?=$arResult["SLIDE".$j]['LINK2_COLOR1']?>;<?endif;?>color: <?if($arResult["SLIDE".$j]['LINK2_TEXTCOLOR1']):?> #<?=$arResult["SLIDE".$j]['LINK2_TEXTCOLOR1']?>!important<?else:?>white!important;<?endif;?>"
								   onmouseover="<?if($arResult["SLIDE".$j]['LINK2_COLOR2']):?>this.style.backgroundColor='#<?=$arResult["SLIDE".$j]['LINK2_COLOR2']?>';<?endif;?><?if($arResult["SLIDE".$j]['LINK2_TEXTCOLOR2']):?>this.style.setProperty('color','#<?=$arResult["SLIDE".$j]['LINK2_TEXTCOLOR2']?>','important');<?endif;?>"
								   onmouseout="<?if($arResult["SLIDE".$j]['LINK2_COLOR1']):?>this.style.backgroundColor='#<?=$arResult["SLIDE".$j]['LINK2_COLOR1']?>';<?endif;?><?if($arResult["SLIDE".$j]['LINK2_TEXTCOLOR1']):?>this.style.setProperty('color','#<?=$arResult["SLIDE".$j]['LINK2_TEXTCOLOR1']?>','important');<?else:?>this.style.setProperty('color','white','important');<?endif;?>"
								><?=$arResult["SLIDE".$j]['LINK2_TEXT']?>
									<span class="slider__button_arrow"></span>
								</a>
							<?endif;?>
						<?endif;?>
	             	</div>

					<?php
					$i++;
				}
			}
			?>
		</div>
        <? if ($i > 2) { ?>
            <a data-slide="prev" href="#myCarousel" class="left carousel-control">&nbsp;</a>
            <a data-slide="next" href="#myCarousel" class="right carousel-control">&nbsp;</a>
        <? } ?>
	</div>
</div>
<div class="clear"></div>
<script>
$(document).ready(function(){
	$('#myCarousel').carousel({
		  interval: 5000
	})
});
</script>
<?php
} elseif ($arResult["PROPERTY_VIEW_VALUE"] == "slider_setka") {
	?>
	<div class="carusel-my02">
		<div class="carousel slide" id="myCarousel">
            <div class="carousel-inner mycarousel-inner">
            <?php
			$i = 1;
			for ($j=9; $j<13; $j++) {

				if (!empty($arResult["SLIDE".$j]['PICTURE'])) {
					if ($i==1) {
						$addClass = " active";
					} else {
						$addClass = "";
					}

					?>
					<div class="item<?=$addClass?>">
					    <?$file = CFile::ResizeImageGet($arResult["SLIDE".$j]['PICTURE'], array('width'=>988, 'height'=>494), BX_RESIZE_IMAGE_EXACT, false); ?>
	                    <img alt="<?=$arResult['SITE']['SITE_NAME']?>" title="<?=$arResult['SITE']['SITE_NAME']?>" src="<?=$file['src'];?>">
						<?if(!empty($arResult["SLIDE".$j]['LINK1'])):?>
							<?if(empty($arResult["SLIDE".$j]['LINK2'])):?>
								<a href="<?=$arResult["SLIDE".$j]['LINK1']?>" class="slider__button" style="<?if($arResult["SLIDE".$j]['LINK1_COLOR1']):?>background-color: #<?=$arResult["SLIDE".$j]['LINK1_COLOR1']?>;<?endif;?>color: <?if($arResult["SLIDE".$j]['LINK1_TEXTCOLOR1']):?> #<?=$arResult["SLIDE".$j]['LINK1_TEXTCOLOR1']?>!important<?else:?>white!important;<?endif;?>"
								   onmouseover="<?if($arResult["SLIDE".$j]['LINK1_COLOR2']):?>this.style.backgroundColor='#<?=$arResult["SLIDE".$j]['LINK1_COLOR2']?>';<?endif;?><?if($arResult["SLIDE".$j]['LINK1_TEXTCOLOR2']):?>this.style.setProperty('color','#<?=$arResult["SLIDE".$j]['LINK1_TEXTCOLOR2']?>','important');<?endif;?>"
								   onmouseout="<?if($arResult["SLIDE".$j]['LINK1_COLOR1']):?>this.style.backgroundColor='#<?=$arResult["SLIDE".$j]['LINK1_COLOR1']?>';<?endif;?><?if($arResult["SLIDE".$j]['LINK1_TEXTCOLOR1']):?>this.style.setProperty('color','#<?=$arResult["SLIDE".$j]['LINK1_TEXTCOLOR1']?>','important');<?else:?>this.style.setProperty('color','white','important');<?endif;?>"
								><?=$arResult["SLIDE".$j]['LINK1_TEXT']?>
									<span class="slider__button_arrow"></span>
								</a>
							<?else:?>
								<a href="<?=$arResult["SLIDE".$j]['LINK1']?>" class="slider__button slider__button_left" style="<?if($arResult["SLIDE".$j]['LINK1_COLOR1']):?>background-color: #<?=$arResult["SLIDE".$j]['LINK1_COLOR1']?>;<?endif;?>color: <?if($arResult["SLIDE".$j]['LINK1_TEXTCOLOR1']):?> #<?=$arResult["SLIDE".$j]['LINK1_TEXTCOLOR1']?>!important<?else:?>white!important;<?endif;?>"
								   onmouseover="<?if($arResult["SLIDE".$j]['LINK1_COLOR2']):?>this.style.backgroundColor='#<?=$arResult["SLIDE".$j]['LINK1_COLOR2']?>';<?endif;?><?if($arResult["SLIDE".$j]['LINK1_TEXTCOLOR2']):?>this.style.setProperty('color','#<?=$arResult["SLIDE".$j]['LINK1_TEXTCOLOR2']?>','important');<?endif;?>"
								   onmouseout="<?if($arResult["SLIDE".$j]['LINK1_COLOR1']):?>this.style.backgroundColor='#<?=$arResult["SLIDE".$j]['LINK1_COLOR1']?>';<?endif;?><?if($arResult["SLIDE".$j]['LINK1_TEXTCOLOR1']):?>this.style.setProperty('color','#<?=$arResult["SLIDE".$j]['LINK1_TEXTCOLOR1']?>','important');<?else:?>this.style.setProperty('color','white','important');<?endif;?>"
								><?=$arResult["SLIDE".$j]['LINK1_TEXT']?>
									<span class="slider__button_arrow"></span>
								</a>
								<a href="<?=$arResult["SLIDE".$j]['LINK2']?>" class="slider__button slider__button_right" style="<?if($arResult["SLIDE".$j]['LINK2_COLOR1']):?>background-color: #<?=$arResult["SLIDE".$j]['LINK2_COLOR1']?>;<?endif;?>color: <?if($arResult["SLIDE".$j]['LINK2_TEXTCOLOR1']):?> #<?=$arResult["SLIDE".$j]['LINK2_TEXTCOLOR1']?>!important<?else:?>white!important;<?endif;?>"
									onmouseover="<?if($arResult["SLIDE".$j]['LINK2_COLOR2']):?>this.style.backgroundColor='#<?=$arResult["SLIDE".$j]['LINK2_COLOR2']?>';<?endif;?><?if($arResult["SLIDE".$j]['LINK2_TEXTCOLOR2']):?>this.style.setProperty('color','#<?=$arResult["SLIDE".$j]['LINK2_TEXTCOLOR2']?>','important');<?endif;?>"
									onmouseout="<?if($arResult["SLIDE".$j]['LINK2_COLOR1']):?>this.style.backgroundColor='#<?=$arResult["SLIDE".$j]['LINK2_COLOR1']?>';<?endif;?><?if($arResult["SLIDE".$j]['LINK2_TEXTCOLOR1']):?>this.style.setProperty('color','#<?=$arResult["SLIDE".$j]['LINK2_TEXTCOLOR1']?>','important');<?else:?>this.style.setProperty('color','white','important');<?endif;?>"
								><?=$arResult["SLIDE".$j]['LINK2_TEXT']?>
									<span class="slider__button_arrow"></span>
								</a>
							<?endif;?>
						<?endif;?>
<!--						<a href="--><?//=$arResult["PROPERTY_LINK_BANNER" . $j . "_VALUE"]?><!--" class="slider__button">Подробнее-->
<!--							<span class="slider__button_arrow"></span>-->
<!--						</a>-->

	              </div>

					<?php
					$i++;
				}
			}
			?>

            </div>
            <? if ($i > 2) { ?>
                <a data-slide="prev" href="#myCarousel" class="left carousel-control">&nbsp;</a>
                <a data-slide="next" href="#myCarousel" class="right carousel-control">&nbsp;</a>
            <? } ?>
          </div>
	</div>
	<div class="home-block">
		<?php
		for ($i=1; $i<9; $i++) {

			if (!empty($arResult["SLIDE".$i]['PICTURE'])) {
				$file = CFile::ResizeImageGet($arResult["SLIDE".$i]['PICTURE'], array('width'=>988, 'height'=>494), BX_RESIZE_IMAGE_EXACT, false);
				?>
				<div style="position: relative;"><a href="<?=$arResult["SLIDE".$i]['LINK1']?>"><img width="247" height="247" src="<?=$file['src'];?>" alt="<?=$arResult['SITE']['SITE_NAME']?>" title="<?=$arResult['SITE']['SITE_NAME']?>">
					<a href="<?=$arResult["SLIDE".$i]['LINK1']?>" class="link__button" style="<?if($arResult["SLIDE".$i]['LINK1_COLOR1']):?>background-color: #<?=$arResult["SLIDE".$i]['LINK1_COLOR1']?>;<?endif;?>color: <?if($arResult["SLIDE".$i]['LINK1_TEXTCOLOR1']):?> #<?=$arResult["SLIDE".$i]['LINK1_TEXTCOLOR1']?>!important<?else:?>white!important;<?endif;?>"
					   onmouseover="<?if($arResult["SLIDE".$i]['LINK1_COLOR2']):?>this.style.backgroundColor='#<?=$arResult["SLIDE".$i]['LINK1_COLOR2']?>';<?endif;?><?if($arResult["SLIDE".$i]['LINK1_TEXTCOLOR2']):?>this.style.setProperty('color','#<?=$arResult["SLIDE".$i]['LINK1_TEXTCOLOR2']?>','important');<?endif;?>"
					   onmouseout="<?if($arResult["SLIDE".$i]['LINK1_COLOR1']):?>this.style.backgroundColor='#<?=$arResult["SLIDE".$i]['LINK1_COLOR1']?>';<?endif;?><?if($arResult["SLIDE".$i]['LINK1_TEXTCOLOR1']):?>this.style.setProperty('color','#<?=$arResult["SLIDE".$i]['LINK1_TEXTCOLOR1']?>','important');<?else:?>this.style.setProperty('color','white','important');<?endif;?>"
					><?=$arResult["SLIDE".$i]['LINK1_TEXT']?>
					</a></a></div>
				<?php
			}

		}
		?>
	</div>
	<div class="clear"></div>
	<script>
	$(document).ready(function(){
		$('#myCarousel').carousel({
			  interval: 5000
		})
	});
	</script>
	<?
} else {
	?>
	<div class="home-left">
<?php
		for ($i=1; $i<7; $i++) {

			if (!empty($arResult["SLIDE".$i]['PICTURE'])) {
				?>
				<div><a href="<?=$arResult["SLIDE".$i]['LINK1']?>"><img width="247" height="247" alt="<?=$arResult['SITE']['SITE_NAME']?>" title="<?=$arResult['SITE']['SITE_NAME']?>" src="<?=CFile::GetPath($arResult["SLIDE".$j]['PICTURE'])?>">
						<a href="<?=$arResult["SLIDE".$i]['LINK1']?>" class="link__button">Подробнее
						</a></a></div>
				<?php
			}

		}
		?>
	</div>
	<div class="home-right">
		<?php

		for ($i=7; $i<13; $i++) {

			if (!empty($arResult["SLIDE".$i]['PICTURE'])) {
				?>
				<div><a href="<?=$arResult["SLIDE".$i]['LINK1']?>"><img width="247" height="247" alt="<?=$arResult['SITE']['SITE_NAME']?>" title="<?=$arResult['SITE']['SITE_NAME']?>" src="<?=CFile::GetPath($arResult["SLIDE".$i]['PICTURE'])?>"><a href="<?=$arResult["SLIDE".$i]['LINK1']?>" class="link__button">Подробнее
						</a></a></div>
				<?php
			}
		}
		?>
	</div>
	<div class="clear"></div>
	<?php
}

if (!empty($arResult["DETAIL_TEXT"])) {
    ?>
    <div class="text-block bottom-block">
    <?=$arResult["DETAIL_TEXT"]?>
    </div>
    <?
}
?><??>