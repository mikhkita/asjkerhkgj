<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();$this->setFrameMode(true);?>

    <?
//        pre($arResult);
    
        if(count($MENU = $arResult['MENU'])>0){
            foreach ($arResult['MENU'] as $key=>$section) {
                if($APPLICATION->GetCurDir() == $key ){//если находимся в секции
                    $MENU = array($key => $section);
                }
            }
        ?>
            <?foreach ($MENU as $key=>$section):?>
                <?if($section["CHILDS"]): ?>
                <div>
                    <h2><?=$section[0]?></h2>
                    <div class="squares">
                        <?foreach ($section["CHILDS"] as $squareItem):?>
                            <a href="<?=$squareItem[1]?>" class="square">
                            <? $rsParentSection = CIBlockSection::GetByID($squareItem[3]["SECTION"]["ID"]);
                            while ($arSect = $rsParentSection->GetNext()){
                                if ($arSect["PICTURE"]) {
                                    $image = CFile::ResizeImageGet($arSect["PICTURE"], array('width'=>750, 'height'=>500), BX_RESIZE_IMAGE_EXACT, true);?>
                                    <img src="<?=$image["src"]?>"><?
                                }
                                else{
                                    ?><img src="/local/templates/demoshop/images/main-man.jpg"><?
                                }
                            }
                            ?>
                                <h3><?=$squareItem[0]?></h3>
                            </a> 
                       <?endforeach;?>
                    </div>
                </div>
                <?endif;?>
            <?endforeach; ?>
        <?
        }
    ?>