<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArticleAccordion
 *
 * @author landa
 */
class DualSelect extends CWidget {

    public $title;
    public $value;

    //put your code here
    public function run() {
        $this->registerScript();

               
        $arrBox1 = landa()->option(CHtml::listData($this->value['box1View'], 'id', 'name'));
        $arrBox2 = landa()->option(CHtml::listData($this->value['box2View'], 'id', 'name'));

        echo '<div class="form-row row-fluid ">
    <div class="span12">
        <div class="leftBox">
            <b>' . $this->title['box1View'] . '</b>
            <hr/>
            <div class="searchBox"><input type="text" id="box1Filter" class="searchField" placeholder="filter ..." /><button id="box1Clear" type="button" class="btn"><span class="icon12 entypo-icon-cancel"></span></button></div>

            <select id="box1View" name="box1View[]" multiple="multiple" class="multiple nostyle" style="height:300px;">
                ' . $arrBox1 . '
            </select>
            <br />
            <span id="box1Counter" class="count"></span>
            <div class="dn"><select id="box1Storage" name="box1Storage" class="nostyle"></select></div>
        </div>

        <div class="dualBtn">
            <button id="to2" type="button" class="btn"><span class="icon12 minia-icon-arrow-right-3"></span></button>
            <button id="allTo2" type="button" class="btn"><span class="icon12 iconic-icon-last"></span></button>
            <button id="to1" type="button" class="btn marginT5"><span class="icon12 minia-icon-arrow-left-3"></span></button>
            <button id="allTo1" type="button" class="btn marginT5"><span class="icon12 iconic-icon-first"></span></button>
        </div>

        <div class="rightBox">
            <b>' . $this->title['box2View'] . '</b>
            <hr/>
            <div class="searchBox"><input type="text" id="box2Filter" class="searchField" placeholder="filter ..." /><button id="box2Clear" type="button" class="btn"><span class="icon12 entypo-icon-cancel"></span></button></div>
            <select id="box2View" name="box2View[]" multiple="multiple" class="multiple nostyle" style="height:300px;">
            ' . $arrBox2 . '
            </select><br />
            <span id="box2Counter" class="count"></span>

            <div class="dn"><select id="box2Storage" class="nostyle"></select></div>
        </div>

    </div> 
</div>';
    }

    public function registerScript() {
        $path = pathinfo(__FILE__); // changed to enable various extension Paths
        $basePath = $path['dirname'] . '/assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath);

        cs()->registerScriptFile($baseUrl . '/jquery.dualListBox-1.3.min.js');
        cs()->registerScript('dualSelect', '
                $.configureBoxes({
                    selectOnSubmit: true
                });
            ');
    }

}

?>
