<?php

/**
 * WSocialButton class file
 * @author Harry Tang (admin@justshowof.com)
 * @link http://www.justshowof.com/
 */
class WSocialButton extends CWidget {

    public $type = 'horizontal';
    public $style = 'standard';

    public function init() {
        parent::init();
        Yii::app()->clientScript->registerScriptFile('https://apis.google.com/js/plusone.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile('http://platform.twitter.com/widgets.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile('http://connect.facebook.net/en_US/all.js#appId=220227991326675&xfbml=1', CClientScript::POS_END);
        cs()->registerCss('social-button', '#social-button td {color: none;
                                                background: none;
                                                border-radius: none;
                                                border: none;
                                                padding: none 
                                                }
                                                #social-button {
                                                margin : 5px;
                                                }
'
        );
    }

    public function run() {
        if ($this->type == 'horizontal')
            $this->horizontal();
        if ($this->type == 'vertical')
            $this->vertical();
    }

    public function vertical() {
        ?>

        <?php if ($this->style == 'standard'): ?>
            <table style="width: auto;float: right;" id="social-button">
                <tr><td><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a></td></tr>
                <tr><td><g:plusone size="medium"></g:plusone></td></tr>            
            <tr><td><div id="fb-root"></div><fb:like href="" send="false" layout="button_count" width="" show_faces="true" font=""></fb:like></td></tr>
            </table>
        <?php endif; ?>

        <?php if ($this->style == 'box'): ?>
            <table style="width: auto;float: right;" id="social-button">
                <tr><td><a href="http://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a></td></tr>
                <tr><td><g:plusone size="tall"></g:plusone></td></tr>            
            <tr><td><div id="fb-root"></div><fb:like href="" send="false" layout="box_count" width="" show_faces="true" font=""></fb:like></td></tr>
            </table>
        <?php endif; ?>

        <?php
    }

    public function horizontal() {
        ?>

        <?php if ($this->style == 'standard'): ?>
            <style>
                ul.post_meta_links {
                    margin: 0px 0px 0px -6px;
                    padding: 0px 0px 0px 0px;
                }
                .post_meta_links li {
                    float: left;
                    margin: 0px;
                    padding: 0px 0px 0px 25px;
                    list-style-type: none;
                    color: #999;
                }
                .post_meta_links li a {
                    color: #a1a1a1;
                    padding: 0px 18px 0px 0px;
                    text-decoration: none;
                    font-size: 11px;
                }
                .post_meta_links li a:hover {
                    color: #727272;
                    text-decoration: none;
                }
            </style>
            <div id="social-button" class="row-fluid">
                <div class="span6">
                    <ul class="post_meta_links">
                        <li><a href="#"><i class="icon-user"></i>Adam Harrison</a></li>
                        <li><a href="#"><i class="icon-calendar"></i>14 July</a></li> 
                        <li><a href="#"><i class="icon-eye-open"></i>18 Hits</a></li>
                    </ul>
                </div>
                <div class="span6">
                    <ul class="post_meta_links pull-right">
                        <li><div id="fb-root"></div><fb:like href="" send="false" layout="button_count" width="" show_faces="true" font=""></fb:like></td></li>
                        <li><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a></li>
                        <li><g:plusone size="medium"></g:plusone></li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($this->style == 'box'): ?>
            <div style="width: auto;" id="social-button">
                <a href="http://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a>
                <g:plusone size="tall"></g:plusone>
                <div id="fb-root"></div><fb:like href="" send="false" layout="box_count" width="" show_faces="true" font=""></fb:like>
            </div>
        <?php endif; ?>

        <?php
    }

}
