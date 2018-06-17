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
                        <?if(count($MENU) > 1): ?>
                            <h2><?=$section[0]?></h2>
                        <?else:?>

                            <?$APPLICATION->SetTitle($section[0]);?>
                        <?endif;?>

                        <div class="squares">
                            <?foreach ($section["CHILDS"] as $squareItem):?>
                                <?
                                    $el_count = 0;
                                    $arFilter = array('IBLOCK_ID' => 19, 
                                        'SECTION_ID'=>$squareItem[3]["SECTION"]["ID"], 
                                        "ACTIVE"=>"Y");
                                    $res = CIBlockElement::GetList(false, $arFilter, array('IBLOCK_ID'));
                                    if ($el = $res->Fetch()){
                                        $el_count = $el["CNT"];
                                    }
                                ?>
                                <?if($el_count > 0):?>
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
                                <?endif;?>
                           <?endforeach;?>
                        </div>
                    </div>
                <?endif;?>
            <?endforeach; ?>
        <?
        }
    ?>