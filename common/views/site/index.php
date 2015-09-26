<?php
/* @var $this SiteController */
$this->pageTitle = 'Dashboard - Selamat Datang di Area Administrator';
$siteConfig = SiteConfig::model()->listSiteConfig();
?>

<div class="row-fluid">
    <div class="span12">
        <?php
        $img = Yii::app()->landa->urlImg('site/', $siteConfig->client_logo, param('id'));
        echo '<img src="' . $img['small'] . '" class="img-polaroid" align="left" style="margin-right:10px"/>';
        ?>
        <b>Amarta Wisesa</b><br/>
        <i class="icon-home"></i> Jl. Jenderal DI Panjaitan No.62, Klojen, Kota Malang<br/>
        <i class="icon-user"></i> (0341) 551 678<br/>
        <i class="icon-envelope"></i> amartawisesa@yahoo.com

    </div>

</div>
