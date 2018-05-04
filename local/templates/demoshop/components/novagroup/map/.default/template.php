<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();$this->setFrameMode(true);?>

    <?php
//        pre($arResult);


        if(count($MENU = $arResult['MENU'])>0){
            foreach ($arResult['MENU'] as $key=>$section) {
                if($APPLICATION->GetCurDir() == $key ){//если находимся в секции
                    $MENU = array($key => $section);
                }
            }
        ?>

        <ul class="">
            <?php
                foreach ($MENU as $key=>$item) {

                    if (count($CHILDS = $item['CHILDS'])>0) {
                    ?>
                    <li class="">
                        <?
                        if ($item["IS_CATALOG"] == 1) {
                            ?>
                            <span class="level-cat-1" > <i class="icon-thumbs-up"></i> <?=$item[0]?></span>
                            <?
                        } else {
                            ?>
                            <a class="" href="<?=$item[1]?>"> <i class="icon-thumbs-up"></i> <?=$item[0]?></a>
                            <?
                        }
                        ?>


                        <ul class="catalog-list-map">
                            <li>
                                <ul>
                                    <li class="cat-lvl">
                                        <?php
                                            $itemsCount = round(count($CHILDS)/2);
                                            $itemsChildCount = round(count($CHILDS)/4);
                                            if($item['IS_CATALOG']==true){
                                                foreach($CHILDS as $KEY_CHILD => $CHILD){
                                                    if(

                                                            $KEY_CHILD%$itemsChildCount == 0
                                                            &&
                                                            $KEY_CHILD>0


                                                    ){
                                        ?>
                                    </li>
                                </ul>
                                <ul>
                                    <li>

                                        <?
                                        }
                                        if(
                                            is_array($CHILD['CHILDS']) &&
                                            count($CHILD['CHILDS'])>0)
                                        {
                                        ?>
                                        <span href="<?=$CHILD[1]?>" class="level-2-cat parent"><?=$CHILD[0]?></span>
                                        <ul class="catalog-list-map-last-lvl">
                                            <?php
                                                foreach($CHILD['CHILDS'] as $CCITEM){
                                                ?>
                                                <li>
                                                    <a href="<?=$CCITEM[1]?>"><?=$CCITEM[0]?></a>
                                                </li>
                                                <?php
                                                }
                                            ?>
                                        </ul>
                                        <?
                                        } else {
                                        ?>
                                        <ul class="catalog-list-map-last-lvl">
                                            <li>
                                                <a href="<?=$CHILD[1]?>"><?=$CHILD[0]?></a>
                                            </li>
                                        </ul>
                                        <?
                                        }
                                    }
                                } else {
                                ?>
                                <?php
                                    foreach($CHILDS as $KEY_CHILD => $CHILD){
                                        if(
                                            $KEY_CHILD%$itemsCount == 0
                                            &&
                                            $KEY_CHILD>0
                                        )
                                        {
                                        ?>
                                    </li>
                                </ul>
                                <ul>
                                    <li>
                                        <ul class="catalog-list-map-last-lvl">
                                            <?
                                            }
                                            $aTTRBSStr = array();
                                            if(is_array($aTTRBS = $CHILD[3]))
                                            {
                                                foreach($aTTRBS as $artK=>$artV)
                                                {
                                                    if($artK=='DATA_TOGGLE')
                                                    {
                                                        $artK = 'data-toggle';
                                                    }
                                                    $aTTRBSStr[] = strtolower($artK).'="'.htmlspecialchars($artV).'"';
                                                }
                                            }
                                            ?>
                                            <li>
                                                <a <?=implode(" ",$aTTRBSStr)?> href="<?=$CHILD[1]?>"><?=$CHILD[0]?></a>
                                            </li>
                                            <?
                                            }
                                            ?>
                                        </ul>
                                        <?
                                        }
                                        ?>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- ======================================================== -->
                    <?php
                    } else {
                    ?>
                    <li>
                        <a class="root-item" href="<?=$item[1]?>"><i class="icon-thumbs-up"></i> <?=$item[0]?></a>
                    </li>
                    <?php
                    }
                ?>
                <?php
                }
            ?>
        </ul>

        <?php
        }
    ?>