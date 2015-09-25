<?php
/* @var $this SiteController */
$this->pageTitle = 'Dashboard - Selamat Datang di Area Administrator';
$siteConfig = SiteConfig::model()->listSiteConfig();
?>

<div class="row-fluid">
    <div class="span8">
        <div class="row-fluid">
        </div>
    </div>
    <div class="span4">
        <div class="row-fluid">
            <div class="box">
                <div class="title">

                    <h4>
                        <span class="icon16 silk-icon-office"></span>
                        <span><?php echo $siteConfig->client_name ?></span>
                    </h4>
                </div>
                <div class="content">
                    <?php
                    $img = Yii::app()->landa->urlImg('site/', $siteConfig->client_logo, param('id'));
                    echo '<img src="' . $img['big'] . '" class="img-polaroid"/>';
                    ?>
                    <div class="clearfix"></div>
                    <dl>

                        <!--                        <dt>Telephone</dt>
                                                <dd></dd>-->
                    </dl>
                </div>

            </div>


            <!--            <div class="reminder">
                            <h4>Today's Activity Count
                                <a href="#" class="icon tip" oldtitle="Configure" title=""><span class="icon16 iconic-icon-cog"></span></a>
            
                            </h4>
                            <ul>
                                <li class="clearfix">
                                    <div class="icon">
                                        <span class="icon16 entypo-icon-forward"></span>
                                    </div>
                                    <span class="txt">Sales</span>
                                    <span class="number">Rp. 7.750.000</span> 
                                </li>
                                <li class="clearfix">
                                    <div class="icon">
                                        <span class="icon16 entypo-icon-forward"></span>
                                    </div>
                                    <span class="txt">Transfer</span>
                                    <span class="number">Rp. 1.254.000</span> 
                                </li>
                                <li class="clearfix">
                                    <div class="icon">
                                        <span class="icon16 entypo-icon-forward"></span>
                                    </div>
                                    <span class="txt">Waste</span>
                                    <span class="number">Rp. 233.500</span> 
                                </li>
                                <li class="clearfix">
                                    <div class="icon">
                                        <span class="icon16 entypo-icon-reply"></span>
                                    </div>
                                    <span class="txt">Buy</span> 
                                    <span class="number">Rp. 3.350.000</span> 
                                </li>        
                            </ul>
                        </div> End .reminder -->
        </div>
    </div>
</div>
