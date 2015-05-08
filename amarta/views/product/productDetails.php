<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title>Shoppest: Product Details Three</title>
	<meta name="description" content="">
	<meta name="author" content="Ahmed Saeed">
	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- CSS
  ================================================== -->
	  <?php
	//cs()->registerCssFile(bt('css/bootstrap.min.css'));
	//<!-- jquery ui css -->
	//cs()->registerCssFile(bt('css/jquery-ui-1.10.1.min.css'));
	cs()->registerCssFile(bt('css/customize.css'));
	cs()->registerCssFile(bt('css/font-awesome.css'));
	cs()->registerCssFile(bt('css/style.css'));
	//<!-- fancybox -->
	//cs()->registerCssFile(bt('js/fancybox/jquery.fancybox.css'));
	//<!--[if lt IE 9]>
	//	cs()->registerScriptFile(bt('http://html5shim.googlecode.com/svn/trunk/html5.js'));
	//	cs()->registerScriptFile(bt('http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js'));
	//	cs()->registerCssFile(bt('css/font-awesome-ie7.css'));
	//<![endif]-->
	//<!-- Favicons
	//================================================== -->
	//<link rel="shortcut icon" href="images/favicon.html">
	//<link rel="apple-touch-icon" href="images/apple-touch-icon.html">
	//<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.html">
	//<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.html">
        ?>
</head>

<body>

	<div id="wrapper">
		<!--begain header-->
		<header>
			<div class="topHeader">
				<div class="container">

					<div class="pull-left">
						
						
					</div><!--end pull-left-->


					<div class="pull-right">

						<div class="btn-group">
							<button class="btn dropdown-toggle" data-toggle="dropdown">
							    <i class="icon-shopping-cart"></i> 
							    (2) 
							    <span class="caret"></span>
							</button>
							<div class="dropdown-menu cart-content pull-right">
								<table class="table-cart">
									<tbody>
									<tr>
										<td class="cart-product-info">
											<a href="#"><img src="img/72x72.jpg" alt="product image"></a>
											<div class="cart-product-desc">
												<p><a class="invarseColor" href="#">Foliomania the designer portfolio brochure</a></p>
												<ul class="unstyled">
													<li>Available: Yes</li>
													<li>Color: Black</li>
												</ul>
											</div>
										</td>
										<td class="cart-product-setting">
											<p><strong>1x-$500.00</strong></p>
											<a href="#" class="btn btn-mini remove-pro" data-tip="tooltip" data-title="Delete"><i class="icon-trash"></i></a>
										</td>
									</tr>
									<tr>
										<td class="cart-product-info">
											<a href="#"><img src="img/72x72.jpg" alt="product image"></a>
											<div class="cart-product-desc">
												<p><a class="invarseColor" href="#">Foliomania the designer portfolio brochure</a></p>
												<ul class="unstyled">
													<li>Available: Yes</li>
													<li>Color: Black</li>
												</ul>
											</div>
										</td>
										<td class="cart-product-setting">
											<p><strong>2x-$450.00</strong></p>
											<a href="#" class="btn btn-mini remove-pro" data-tip="tooltip" data-title="Delete"><i class="icon-trash"></i></a>
										</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td class="cart-product-info">
											<a href="cart.html" class="btn btn-small">Vew cart</a>
											<a href="checkout.html" class="btn btn-small btn-primary">Checkout</a>
										</td>
										<td>
											<h3>$1,598.30</h3>
										</td>
									</tr>
								</tfoot>
								</table>
							</div>
						</div>
					</div><!--end pull-right-->

					<div class="pull-right">
						<form method="get" action="http://egythemes.com/shoppest/page" class="siteSearch">
							<div class="input-append">
								<input type="text" class="span2" id="appendedInputButton" placeholder="Start Typing...">
								<button class="btn" type="submit" name=""><i class="icon-search"></i></button>
							</div>
						</form><!--end form-->
					</div><!--end pull-right-->

					<ul class="pull-left inline">
						<li><a class="invarseColor" href="login.html">Login</a></li>
						<li class="sep-vertical"></li>
						<li><a class="invarseColor" href="register.html">Register</a></li>
						<li class="sep-vertical"></li>
						<li><a class="invarseColor" href="blog.html">Blog</a></li>
						<li class="sep-vertical"></li>
						<li><a class="invarseColor" href="contact.html">Contact</a></li>
						<li class="sep-vertical"></li>
						<li><a class="invarseColor" href="account.html">My Account</a></li>
						<li class="sep-vertical"></li>
						<li><a class="invarseColor" href="wishlist.html">Wishlist(4)</a></li>
						<li class="sep-vertical"></li>
						<li><a class="invarseColor" href="cart.html">Shoping Cart</a></li>
						<li class="sep-vertical"></li>
						<li><a class="invarseColor" href="checkout.html">Checkout</a></li>
					</ul>

				</div><!--end container-->
			</div><!--end topHeader-->

			<div class="subHeader">
				<div class="container">
					<div class="navbar">

						<div class="siteLogo pull-left">
							<h1><a href="index.html"><img src="<?php echo bt('img/logo.png') ?>" alt="Shoppest"></a></h1>
						</div>
						<nav id="mainMenu">
                                    <?php $this->widget('ext.landa.widgets.LandaMenu',array('htmlOptions' => array('class' => 'nav pull-right')));?>
                                </nav>

					</div>
				</div><!--end container-->
			</div><!--end subHeader-->
		</header>
		<!-- end header -->


		<div class="container">

			<div class="row">
				
				<div class="span12">

					<div class="row">
						<div class="product-details clearfix">
							<div class="span6">
								<div class="product-title">
									<h1>Foliomania the designer portfolio brochure</h1>
								</div>

								<div class="product-img-thumb-floated">
									<a class="fancybox" href="<?php echo bt('img/650x700.jpg') ?>"><img src="<?php echo bt('img/68x60.jpg') ?>" alt=""></a>
									
								</div><!--product-img-thumb-->

								<div class="product-img-floated">
									<a class="fancybox" href="<?php echo bt('img/650x700.jpg') ?>"><img src="<?php echo bt('img/372x370.jpg') ?>" alt=""></a>
								</div><!--end product-img-->
								
							</div><!--end span6-->

							<div class="span6">
								<div class="product-set">
									<div class="product-price">
										<span><span class="strike-through">$200.00</span> $150.00</span>
									</div><!--end product-price-->
									<div class="product-rate clearfix">
										<ul class="rating">
											<li><i class="star-on"></i></li>
											<li><i class="star-on"></i></li>
											<li><i class="star-on"></i></li>
											<li><i class="star-off"></i></li>
											<li><i class="star-off"></i></li>
										</ul>
										<span>
											18 Review(s)&nbsp;&nbsp;
											<a href="#">
												<i class="icon-pencil"></i> Write a Review
											</a>
										</span>
									</div><!--end product-inputs-->
									<div class="product-info">
										<dl class="dl-horizontal">
										  <dt>Availabilty:</dt>
										  <dd>Available In Stock</dd>

										  <dt>Product Code:</dt>
										  <dd>No. CtAw9458</dd>

										  <dt>Manfactuer:</dt>
										  <dd>Nicka Corparation</dd>

										   <dt>Review Points:</dt>
										  <dd>25 Points</dd>
										</dl>
									</div><!--end product-info-->
									<div class="product-inputs">
										<form method="post" action="http://egythemes.com/shoppest/page">
											<div class="controls-row">
												<select class="span3" name="#">
													<option>-- Select Color --</option>
													<option value="">Red</option>
													<option value="">Blue</option>
													<option value="">Brown</option>
												</select>
												
											</div><!--end controls-row-->

											<div class="controls-row">
												<input type="text" class="span4" name="" value="" placeholder="input...">
												<input type="text" class="span2" name="" value="" placeholder="input...">
											</div><!--end controls-row-->

											<textarea name="" class="span6" placeholder="textarea..."></textarea>

											<div class="input-append">
												<input class="span2" type="text" name="" value="" placeholder="QTY...">

												<button class="btn btn-primary"><i class="icon-shopping-cart"></i> Add To Cart</button>

												<button type="button" class="btn" data-tip="tooltip" data-title="+To Wishlist"><i class="icon-heart"></i></button>

												<button type="button" class="btn" data-tip="tooltip" data-title="+To Compare"><i class="icon-refresh"></i></button>
											</div>
											
										</form><!--end form-->

									</div><!--end product-inputs-->
								</div><!--end product-set-->
							</div><!--end span6-->

						</div><!--end product-details-->
					</div><!--end row-->


					<div class="product-tab">
						<ul class="nav nav-tabs">
							<li class="active">
					  			<a href="#descraption" data-toggle="tab">Descraption</a>
							</li>
							<li>
								<a href="#specfications" data-toggle="tab">Specfications</a>
							</li>
							<li>
						  		<a href="#return-info" data-toggle="tab">Return Info</a>
							</li>
							<li>
				  				<a href="#read-review" data-toggle="tab">Read Reviews</a>
				  			</li>
				  			<li>
				  				<a href="#make-review" data-toggle="tab">Make Review</a>
				  			</li>
						</ul>

						<div class="tab-content">
							<div class="tab-pane active" id="descraption">
								<p>
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a eros neque. In sapien est, malesuada non interdum id, cursus vel neque. Curabitur quis sem vel justo dictum ullamcorper ac vehicula lacus. Duis nisi dolor, suscipit id adipiscing ac, vestibulum in magna. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce ut metus sem. Etiam in odio eu metus ornare convallis in sit amet lorem.

									Suspendisse potenti. In non nisl sem, eu rutrum augue. Donec eu dolor vel massa ornare cursus id eget erat. Mauris in ante magna. Curabitur eget risus mi, non interdum lacus. Duis magna leo, rhoncus eget malesuada quis, semper a quam. Morbi imperdiet imperdiet lectus ac pellentesque. Integer diam sem, vulputate in feugiat ut, porttitor eu libero. Integer non dolor ipsum. Cras condimentum mattis turpis quis vestibulum. Nulla a augue ipsum. Donec aliquam velit vel metus fermentum dictum sodales metus condimentum. Nullam id massa quis nulla molestie ultrices eget sed nulla. Cras feugiat odio at tellus euismod lacinia.
								</p>
								<p>
									Suspendisse potenti. In non nisl sem, eu rutrum augue. Donec eu dolor vel massa ornare cursus id eget erat. Mauris in ante magna. Curabitur eget risus mi, non interdum lacus. Duis magna leo, rhoncus eget malesuada quis, semper a quam. Morbi imperdiet imperdiet lectus ac pellentesque. Integer diam sem, vulputate in feugiat ut, porttitor eu libero. Integer non dolor ipsum. Cras condimentum mattis turpis quis vestibulum. Nulla a augue ipsum. Donec aliquam velit vel metus fermentum dictum sodales metus condimentum. Nullam id massa quis nulla molestie ultrices eget sed nulla. Cras feugiat odio at tellus euismod lacinia.
									
								</p>
							</div>
							<div class="tab-pane" id="specfications">
								<table class="table table-compare">
									<tr>
										<td class="aligned-color"><h5>Momery</h5></td>
										<td>Test One</td>
										<td>16GB</td>
									</tr>
									<tr>
										<td class="aligned-color"><h5>Processor</h5></td>
										<td>No. of Cores</td>
										<td>No.4</td>
									</tr>
									<tr>
										<td class="aligned-color"><h5>Momery</h5></td>
										<td>Test One</td>
										<td>16GB</td>
									</tr>
									<tr>
										<td class="aligned-color"><h5>Processor</h5></td>
										<td>No. of Cores</td>
										<td>No.4</td>
									</tr>
								</table>
							</div>
							<div class="tab-pane" id="return-info">
								<h4>Read our Returning info</h4><br>
								<p>
									Suspendisse potenti. In non nisl sem, eu rutrum augue. Donec eu dolor vel massa ornare cursus id eget erat. Mauris in ante magna. Curabitur eget risus mi, non interdum lacus. Duis magna leo, rhoncus eget malesuada quis, semper a quam. Morbi imperdiet imperdiet lectus ac pellentesque. Integer diam sem, vulputate in feugiat ut, porttitor eu libero. Integer non dolor ipsum. Cras condimentum mattis turpis quis vestibulum. Nulla a augue ipsum. Donec aliquam velit vel metus fermentum dictum sodales metus condimentum. Nullam id massa quis nulla molestie ultrices eget sed nulla. Cras feugiat odio at tellus euismod lacinia.
									
								</p>
							</div>

							<div class="tab-pane" id="read-review">
								<div class="single-review clearfix">
									<div class="review-header">
										<ul class="rating">
											<li><i class="star-on"></i></li>
											<li><i class="star-on"></i></li>
											<li><i class="star-off"></i></li>
											<li><i class="star-off"></i></li>
											<li><i class="star-off"></i></li>
										</ul>
										<h4>John Doe</h4>
										<small>26/11/2012</small>
									</div><!--end review-header-->

									<div class="review-body">
										<p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
									</div><!--end review-body-->
								</div><!--end single-review-->

								<div class="single-review clearfix">
									<div class="review-header">
										<ul class="rating">
											<li><i class="star-off"></i></li>
											<li><i class="star-off"></i></li>
											<li><i class="star-off"></i></li>
											<li><i class="star-off"></i></li>
											<li><i class="star-off"></i></li>
										</ul>
										<h4>John Doe</h4>
										<small>26/11/2012</small>
									</div><!--end review-header-->

									<div class="review-body">
										<p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
									</div><!--end review-body-->
								</div><!--end single-review-->

								<div class="single-review clearfix">
									<div class="review-header">
										<ul class="rating">
											<li><i class="star-on"></i></li>
											<li><i class="star-on"></i></li>
											<li><i class="star-on"></i></li>
											<li><i class="star-off"></i></li>
											<li><i class="star-off"></i></li>
										</ul>
										<h4>John Doe</h4>
										<small>26/11/2012</small>
									</div><!--end review-header-->

									<div class="review-body">
										<p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
									</div><!--end review-body-->
								</div><!--end single-review-->
							</div>


							<div class="tab-pane" id="make-review">
								<form method="post" action="http://egythemes.com/shoppest/page" class="form-horizontal">
									<div class="control-group">
									    <label class="control-label" for="inputName">Your Name <span class="text-error">*</span></label>
									    <div class="controls">
									      <input type="text" name="#" class="span8" id="inputName" placeholder="John Doe...">
									    </div>
									</div>
									<div class="control-group">
										<label class="control-label" for="inputReview">Your Review <span class="text-error">*</span></label>
									    <div class="controls">
									      <textarea name="#" class="span8" id="inputReview" placeholder="Put your review here..."></textarea>
									    </div>
									</div>
									<div class="control-group">
										<label class="control-label">Your Rate <span class="text-error">*</span></label>
									    <div class="controls">
									    	<label class="radio inline">From Bad</label>
									    	<label class="radio inline">
											  <input type="radio" name="rate" value="option1">
											</label>
											<label class="radio inline">
											  <input type="radio" name="rate" value="option2">
											</label>
											<label class="radio inline">
											  <input type="radio" name="rate" value="option3">
											</label>
											<label class="radio inline">
											  <input type="radio" name="rate" value="option3">
											</label>
											<label class="radio inline">
											  <input type="radio" name="rate" value="option3">
											</label>
											<label class="radio inline">To Good</label>
									    </div>
									</div>
									<div class="control-group">
									    <div class="controls">
									      <button type="submit" class="btn btn-primary" name="submit">Add Review</button>
									    </div>
									</div>
								</form><!--end form-->
							</div>
						</div><!--end tab-content-->
					</div><!--end product-tab-->


					<div class="related-product">
						<div class="titleHeader clearfix">
							<h3>Related Product</h3>
						</div><!--end titleHeader-->

						<div class="row">
							<ul class="hProductItems clearfix">
								<li class="span3 clearfix">
									<div class="thumbnail">
										<a href="#"><img src="img/212x192.jpg" alt=""></a>
									</div>
									<div class="thumbSetting">
										<div class="thumbTitle">
											<h3>
											<a href="#" class="invarseColor">Prodcut Title Here</a>
											</h3>
										</div>
										<ul class="rating clearfix">
											<li><i class="star-on"></i></li>
											<li><i class="star-on"></i></li>
											<li><i class="star-on"></i></li>
											<li><i class="star-on"></i></li>
											<li><i class="star-off"></i></li>
										</ul>
										<div class="product-desc">
											<p>
												Praesent ac condimentum felis. Nulla at nisl orci, at dignissim dolor Praesent ac condimentum ...
											</p>
										</div>
										<div class="thumbPrice">
											<span><span class="strike-through">$175.00</span>$150.00</span>
										</div>

										<div class="thumbButtons">
											<button class="btn btn-primary btn-small btn-block">
												SELECT OPTION
											</button>
										</div>
									</div>
								</li>
								<li class="span3 clearfix">
									<div class="thumbnail">
										<a href="#"><img src="<?php echo bt('img/212x192.jpg') ?>" alt=""></a>
									</div>
									<div class="thumbSetting">
										<div class="thumbTitle">
											<h3>
											<a href="#" class="invarseColor">Prodcut Title Here</a>
											</h3>
										</div>
										<ul class="rating clearfix">
											<li><i class="star-on"></i></li>
											<li><i class="star-on"></i></li>
											<li><i class="star-on"></i></li>
											<li><i class="star-on"></i></li>
											<li><i class="star-off"></i></li>
										</ul>
										<div class="product-desc">
											<p>
												Praesent ac condimentum felis. Nulla at nisl orci, at dignissim dolor...
											</p>
										</div>
										<div class="thumbPrice">
											<span><span class="strike-through">$175.00</span>$150.00</span>
										</div>

										<div class="thumbButtons">
											<button class="btn btn-primary btn-small btn-block">
												SELECT OPTION
											</button>
										</div>
									</div>
								</li>
								<li class="span3 clearfix">
									<div class="thumbnail">
										<a href="#"><img src="<?php echo bt('img/212x192.jpg') ?>" alt=""></a>
									</div>
									<div class="thumbSetting">
										<div class="thumbTitle">
											<h3>
											<a href="#" class="invarseColor">Prodcut Title Here</a>
											</h3>
										</div>
										<ul class="rating clearfix">
											<li><i class="star-on"></i></li>
											<li><i class="star-on"></i></li>
											<li><i class="star-on"></i></li>
											<li><i class="star-on"></i></li>
											<li><i class="star-off"></i></li>
										</ul>
										<div class="product-desc">
											<p>
												Praesent ac condimentum felis. Nulla at nisl orci, at dignissim dolor Praesent ac condimentum ...
											</p>
										</div>
										<div class="thumbPrice">
											<span><span class="strike-through">$175.00</span>$150.00</span>
										</div>

										<div class="thumbButtons">
											<button class="btn btn-primary btn-small btn-block">
												SELECT OPTION
											</button>
										</div>
									</div>
								</li>
								<li class="span3 clearfix">
									<div class="thumbnail">
										<a href="#"><img src="<?php echo bt('img/212x192.jpg') ?>" alt=""></a>
									</div>
									<div class="thumbSetting">
										<div class="thumbTitle">
											<h3>
											<a href="#" class="invarseColor">Prodcut Title Here</a>
											</h3>
										</div>
										<ul class="rating clearfix">
											<li><i class="star-on"></i></li>
											<li><i class="star-on"></i></li>
											<li><i class="star-on"></i></li>
											<li><i class="star-on"></i></li>
											<li><i class="star-off"></i></li>
										</ul>
										<div class="product-desc">
											<p>
												Praesent ac condimentum felis. Nulla at nisl orci, at dignissim dolor Praesent ac condimentum ...
											</p>
										</div>
										<div class="thumbPrice">
											<span><span class="strike-through">$175.00</span>$150.00</span>
										</div>

										<div class="thumbButtons">
											<button class="btn btn-primary btn-small btn-block">
												SELECT OPTION
											</button>
										</div>
									</div>
								</li>
							</ul>
						</div><!--end row-->
					</div><!--end related-product-->

				</div><!--end span12-->

			</div><!--end row-->

		</div><!--end conatiner-->


		<!--begain footer-->
		<footer>
		<div class="footerOuter">
			<div class="container">
				<div class="row-fluid">

					<div class="span3">
						<div class="titleHeader clearfix">
							<h3>Usefull Links</h3>
						</div>
						
						<div class="usefullLinks">
							<div class="row-fluid">
								<div class="span12">
									<ul class="unstyled">
										<li><a class="invarseColor" href="#"><i class="icon-caret-right"></i> About Us</a></li>
										<li><a class="invarseColor" href="#"><i class="icon-caret-right"></i> Delivery Information</a></li>
										<li><a class="invarseColor" href="#"><i class="icon-caret-right"></i> Privecy Police</a></li>
										<li><a class="invarseColor" href="#"><i class="icon-caret-right"></i> Tarms &amp; Condations</a></li>
										<li><a class="invarseColor" href="#"><i class="icon-caret-right"></i> Customer Support</a></li>
										<li><a class="invarseColor" href="#"><i class="icon-caret-right"></i> Special Gifts</a></li>
										<li><a class="invarseColor" href="#"><i class="icon-caret-right"></i> Browse Site Map</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div><!--end span6-->


					<div class="span3">
						<div class="titleHeader clearfix">
							<h3>Special Products</h3>
						</div>

						<ul class="pro-list-footer">
							<li class="clearfix">
								<div class="thumbnail">
									<a href="#"><img src="<?php echo bt('img/spesial.jpg') ?>" alt="Product Image">
									</a>
								</div>
								<div class="product-setting">
									<div class="pro-title">
										<a href="#">Foliomania the designer portfolio brochure</a>
									</div>
									<div class="pro-price">
										$110.00
									</div>
								</div>
							</li>
							<li class="clearfix">
								<div class="thumbnail">
									<a href="#"><img src="<?php echo bt('img/spesial.jpg') ?>" alt="Product Image">
									</a>
								</div>
								<div class="product-setting">
									<div class="pro-title">
										<a href="#">Foliomania the designer portfolio brochure</a>
									</div>
									<div class="pro-price">
										$110.00
									</div>
								</div>
							</li>
							<li class="clearfix">
								<div class="thumbnail">
									<a href="#"><img src="<?php echo bt('img/spesial.jpg') ?>" alt="Product Image">
									</a>
								</div>
								<div class="product-setting">
									<div class="pro-title">
										<a href="#">Foliomania the designer portfolio brochure</a>
									</div>
									<div class="pro-price">
										$110.00
									</div>
								</div>
							</li>
						</ul><!--end pro-list-footer-->
					</div><!--end span3-->

					<div class="span3">
						<div class="titleHeader clearfix">
							<h3>Gallery</h3>
						</div>

						 <?php
                                                $oGallerys = Gallery::model()->findAll(array('limit' => 12, 'order' => 'RAND()'));
                                                foreach ($oGallerys as $oGallery) {
                                                    echo '<li class="span3">
                                                <a href="#" class="thumbnail">
                                                    <img class="" src="' . $oGallery->img['small'] . '"/>
                                                </a>
                                                </li>  ';
                                                }
                                                ?>
					</div><!--end span3-->

					<div class="span3">
						<div class="titleHeader clearfix">
							<h3>Brand</h3>
						</div>

						 <?php
                                                $oGallerys = Gallery::model()->findAll(array('condition'=>'gallery_category_id=43'));
                                                foreach ($oGallerys as $oGallery) {
                                                    echo '<li class="span3">
                                                <a href="#" class="thumbnail">
                                                    <img class="" src="' . $oGallery->img['small'] . '"/>
                                                </a>
                                                </li>  ';
                                                }
                                                ?>

					</div><!--end span3-->

				</div><!--end row-fluid-->

			</div><!--end container-->
		</div><!--end footerOuter-->

		<div class="container">
			<div class="row">
				<div class="span12">
					<ul class="payments inline pull-right">
						<li class="visia"></li>
						<li class="paypal"></li>
						<li class="electron"></li>
						<li class="discover"></li>
					</ul>
					<p>© Copyrights 2012 for <a href="index.html">shoppest.com</a><br>
                                         <?php
                                    $siteConfig = SiteConfig::model()->listSiteConfig();
                                    echo '<i class="icon-home"></i>' . $siteConfig->fullAddress . '.<br>';
                                    echo '<i class="icon-phone"></i>' . $siteConfig->phone . ' &nbsp;&nbsp; <i class="icon-envelope"></i><a href="mailto:' . $siteConfig->email . '">' . $siteConfig->email . '</a><br>';
                                    ?>
                                        </p>
				</div>
			</div>
		</div>
		</footer>
		<!--end footer-->

	</div><!--end wrapper-->


	<!-- Sidebar Widget
	================================================== -->
	
	<!-- End Sidebar Widget-->



	<!-- JS
	================================================== -->
	<?php
	
	
    cs()->registerScriptFile(bt('js/custom.js'));
    ?>
    
</body>

</html>