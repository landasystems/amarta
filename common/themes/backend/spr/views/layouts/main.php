<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <meta name="author" content="Landa - Profesional Website Development" />
        <meta name="application-name" content="Application Default" />
        <link rel="shortcut icon" href="<?php echo bt() ?>/images/favicon.ico" />

        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <?php
        landa()->loginRequired();
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerCssFile(bt() . '/css/icons.css');
        $cs->registerCssFile(bt() . '/css/main.css');
        ?>     

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/apple-touch-icon-144-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-57-precomposed.png" />

        <script type="text/javascript">
            //adding load class to body and hide page
            document.documentElement.className += 'loadstate';
        </script>
    </head>
    <body>
        <img src="<?php echo bt("images/loaders/horizontal/004.gif") ?>" id="loader" />
        <!-- loading animation -->
        <div id="qLoverlay"></div>
        <div id="qLbar"></div>

        <div id="header">

            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container-fluid">
                        <a class="brand" href="<?php echo url('dashboard') ?>">
                            <?php
                            $siteConfig = SiteConfig::model()->listSiteConfig();
                            echo $siteConfig->client_name;
                            ?>
                        </a>
                        <div class="nav-no-collapse">

                            <ul class="nav pull-right usernav">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle avatar" data-toggle="dropdown">
                                        <?php
                                        $img = user()->avatar_img;
                                        echo '<img src="' . $img['small'] . '" alt="" class="image" /> ';
                                        ?>
                                        <span class="txt"><?php echo Yii::app()->user->getState('name'); ?></span>
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="menu">
                                            <?php
                                            $user = User::model()->findByPk(user()->id);
                                            if ($user->roles_id == -1){
                                                $type='user';
                                            }else{
                                                if ($user->Roles->is_allow_login==0){
                                                    $type='guest';
                                                }else{
                                                    $type = 'user';
                                                }
                                            }
                                            $this->widget('zii.widgets.CMenu', array(
                                                'items' => array(
                                                    array('visible' => true, 'label' => '<span class="icon16 icomoon-icon-user-3"></span>Edit profile', 'url' => url('user/updateProfile') . '?type=' . $type),
                                                ),
                                                'encodeLabel' => false,
                                            ));
                                            ?>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="<?php echo bu() ?>/site/logout"><span class="icon16 icomoon-icon-exit"></span> Logout</a></li>
                            </ul>
                        </div><!-- /.nav-collapse -->
                    </div>
                </div><!-- /navbar-inner -->
            </div><!-- /navbar --> 
        </div><!-- End #header -->

        <div id="wrapper">

            <!--Responsive navigation button-->  
            <div class="resBtn">
                <a href="#"><span class="icon16 minia-icon-list-3"></span></a>
            </div>

            <!--Sidebar collapse button-->  

            <!--Sidebar background-->
            <div id="sidebarbg"></div>
            <!--Sidebar content-->
            <div id="sidebar">
                <div class="sidenav">

                    <div class="sidebar-widget" style="margin: -1px 0 0 0;">
                        <h5 class="title" style="margin-bottom:0">Navigation</h5>
                    </div><!-- End .sidenav-widget -->

                    <div class="mainnav">
                        <?php
                        $this->widget('zii.widgets.CMenu', array(
                            'items' => Auth::model()->modules(),
                            'encodeLabel' => false,
                        ));
                        ?>
                    </div>

                    <div class="sidebar-widget">
                        <h5 class="title">Server Information</h5>
                        <div class="content">
                            <table class="table table-condensed">
                                <tr>
                                    <td><b>Date</b></td>
                                    <td> : </td>
                                    <td><?php echo date('d F Y') ?></td>
                                </tr>
                                <tr>
                                    <td><b>Time</b></td>
                                    <td> : </td>
                                    <td><?php echo date('H:i') ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div><!-- End sidenav -->


            </div><!-- End #sidebar -->



            <!--Body content-->
            <div id="content" class="clearfix">
                <div class="contentwrapper"><!--Content wrapper-->

                    <div class="heading">

                        <h3><?php echo CHtml::encode($this->pageTitle); ?></h3>                    


                        <div class="search">
                            <?php // $this->widget('common.extensions.landa.widgets.LandaSearch', array('url' => url('user/searchJson'), 'class' => 'input-text')); ?>
                        </div><!-- End search -->

                        <?php if (isset($this->breadcrumbs)): ?>
                            <?php
                            $this->widget('zii.widgets.CBreadcrumbs', array(
                                'links' => $this->breadcrumbs,
                                'htmlOptions' => array('class' => 'breadcrumb'),
                                'separator' => '<span class="divider"><span class="icon16 icomoon-icon-arrow-right"></span></span>',
                                'homeLink' => '<a href="/site/index" class="tip" title="back to dashboard"><span class="icon16 icomoon-icon-screen"></span></a>'
                            ));
                            ?><!-- breadcrumbs -->
                        <?php endif ?>

                    </div><!-- End .heading-->
                    <div class="clearfix"></div>
                    <!-- Build page from here: -->
                    <?php echo $content; ?>
                    <!-- End Build page -->
                </div><!-- End contentwrapper -->
                <div id="footer" class="span12">
                    <?php echo app()->name . ' ' . param('appVersion') ?>  ©  2013 All Rights Reserved. Designed and Developed by : <a href="http://www.landa.co.id" target="_blank">Landa Systems</a>
                </div>
            </div>
            <!-- End #content -->
        </div><!-- End #wrapper -->
        <a href="#" class="collapseBtn" class="tipR" title="Hide/Show sidebar">
            <div class="landaMin img-polaroid">
                <i class="icon-arrow-left"></i>
            </div>
        </a>
        <?php
        $cs->registerScriptFile(bt() . '/js/main.js', CClientScript::POS_END);
        ?>
    </body>
</html>
