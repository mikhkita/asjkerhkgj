<div class="choice-color">Доступные цвета:</div>
<div class="btn-group color-ch " data-toggle="buttons-radio">
    <div id="color-ch" class="bs-docs-tooltip-examples">
        <? foreach ($params as $param) {
            $button = $img = array();
            if(is_array($param['button']))
            {
                foreach($param['button'] as $k=>$v)$button[] = "{$k}='{$v}'";
                $tmp = explode('-',$param['button']['id']);
                $button[] = "data-color-id=".$tmp[2];
                $button[] = "data-name=data-color-button-".$tmp[2].'-'.$tmp[1];
                $button[] = "data-color-code=".$param['button']['data-color'];
            }
            if(is_array($param['img']))
            {
                foreach($param['img'] as $k=>$v)$img[] = "{$k}='{$v}'";
            }
            ?>
            <span <?=implode(" ", $button)?> style="padding: 5px"><?=$param['img']['alt']?></span>
        <? } ?>
        <div class="clear"></div>
    </div>
</div>