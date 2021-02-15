<?php

define('DOT', '.');
//require_once(DOT ."/bootstrap.php");
if (isset($_REQUEST['form'])) {
	$frm = $_REQUEST['form'];
	require_once("index/{$frm}/{$frm}.php");
	$title = $SEO['title'];
} else {
	$title = "CR Associate Finance & Consultancy";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<base href="https://crassociatefinance.com/">

	<title><?= $title ?></title>

	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="keywords" content="" />
	<script type="application/x-javascript">
		addEventListener("load", function() {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!--// Meta tag Keywords -->
	<link rel="shortcut icon" href="./favicon.png" type="image/png">
	<!-- For about Slider-->
	<link rel="stylesheet" href="css/owl.carousel.css" type="text/css" media="all" /> <!-- Owl-Carousel-CSS -->
	<!-- //For about -->
	<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="all" /><!-- for testimonials -->

	<!-- css files -->
	<link rel="stylesheet" href="css/bootstrap.css"> <!-- Bootstrap-Core-CSS -->
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" /> <!-- Style-CSS -->
	<link rel="stylesheet" href="css/fontawesome-all.css"> <!-- Font-Awesome-Icons-CSS -->
	<!-- //css files -->

	<!-- web-fonts -->
	<link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=latin-ext" rel="stylesheet">
	<!-- //web-fonts -->

</head>

<body>

	<!--Header-->
	<header>
		<div class="container agile-banner_nav">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">

				<a class="navbar-brand" href="./"><img src="images/almalogo.png" /></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
					<?php include_once("public/menubar.phtml") ?>
				</div>

			</nav>
		</div>
	</header>
	<!--Header-->

	<?php if (isset($_REQUEST['form'])) : ?>

		<!-- inner page banner-->
		<div class="inner-banner">

		</div>
		<!-- //inner page banner-->


		<?php require_once("index/{$frm}/{$frm}.phtml");  ?>



	<?php else : ?>

		<!--/banner-->
		<div class="banner">
			<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
				</ol>
				<div class="carousel-inner" role="listbox">
					<div class="carousel-item active">
						<div class="carousel-caption">
							<h3>Technology <span>Funding</span></h3>
							<p class="text-capitalize mt-3 mb-sm-5 mb-4">Our team are innovation ready</p>
							<a href="./about-us/">Find Out More <span class="fas fa-long-arrow-alt-down"></span></a>
						</div>
					</div>
					<div class="carousel-item item2">
						<div class="carousel-caption">
							<h3>Finance Consultancy <span>Services</span></h3>
							<p class="text-capitalize mt-3 mb-sm-5 mb-4">We help businesses reach the top</p>
							<a href="./about-us/">Find Out More <span class="fas fa-long-arrow-alt-down"></span></a>
						</div>
					</div>
					<div class="carousel-item item3">
						<div class="carousel-caption">
							<h3>Creative Funding <span>Agency</span></h3>
							<p class="text-capitalize mt-3 mb-sm-5 mb-4">Agressive modern technological assessment</p>
							<a href="./about-us/">Find Out More <span class="fas fa-long-arrow-alt-down"></span></a>
						</div>
					</div>
					<div class="carousel-item item4">
						<div class="carousel-caption">
							<h3>Project Analytics & <span>Management</span></h3>
							<p class="text-capitalize mt-3 mb-sm-5 mb-4">Let us lead the way, follow us</p>
							<a href="./about-us/">Find Out More <span class="fas fa-long-arrow-alt-down"></span></a>
						</div>
					</div>
				</div>
				<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
		<!--//banner-->

		<!-- Welcome -->
		<section class="welcome py-5 my-lg-5">
			<div class="container">
				<div class="row welcome_grids">
					<div class="col-lg-7 mb-lg-0 mb-5">
						<h3 class="mb-3 text-capitalize">CR Associate Finance & Consultancy.</h3>
						<p class="mb-5 mt-4">Technology is fast changing the world as we all know it today, and to meet up with the trend requires persistent researches and development. <strong>CR Associate Finance</strong> through leadership leads a team of graduates and undergraduates, policy experts, technologists and patent holders. Working with the best minds CR Finance has been consulted by 65 companies all over the world.</p>
						<a href="./about-us/" class="text-uppercase"><span class="fas fa-home"></span> Company Profile </a>
					</div>
					<div class="col-lg-5 welcome_right">
						<img src="images/slide1.jpg" class="img-fluid">
					</div>
				</div>
			</div>
		</section>
		<!-- //Welcome -->

		<!-- Testimonials -->
		<section class="testimonials py-5">
			<div class="container py-lg-5">
				<div class="row">
					<!-- Clients -->
					<div class=" col-lg-6 clients">
						<div class="slider p-sm-5 p-4">
							<div class="flexslider">
								<ul class="slides">
									<li>
										<div class="client row">
											<div class="col-sm-4">
												<img src="images/t1.jpg" alt="" />
											</div>
											<div class="col-sm-8">
												<h5 class="my-2">Dr, Waziri Mendez</h5>
												<h6>Bahrain</h6>
												<ul class="rating mt-2">
													<li class="mx-1"><span class="fas fa-star"></span></li>
													<li class="mx-1"><span class="fas fa-star"></span></li>
													<li class="mx-1"><span class="fas fa-star"></span></li>
													<li class="mx-1"><span class="fas fa-star"></span></li>
													<li class="mx-1"><span class="fas fa-star-half"></span></li>
												</ul>
											</div>
										</div>
										<p class="my-4">"CR Associate Finance LLC is simply the best. They make our work easier and always provide the best research results."</p>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- //Clients -->
					<div class="col-lg-6 collections mt-lg-0 mt-5 px-sm-5 px-4">
						<h3>An Unbeatable Customer Value</h3>
						<p class="my-4">CR Associate Finance LLC considers her customers to be first in all. We focus our team spirit to the service of our clients.</p>
						<a href="./services/" class="text-capitalize" data-toggle="modal" data-target="#exampleModalCenter" role="button">Read more <i class="fas fa-angle-right"></i></a>
					</div>
				</div>
			</div>
		</section>
		<!-- Testimonials -->

		<!-- Process -->
		<section class="process py-5 my-lg-5">
			<div class="container">
				<div class="row process-grids">
					<div class="col-lg-4 col-md-6 grid1">
						<span class="fab fa-digital-ocean"></span>
						<h3 class="text-uppercase mt-3">Research Consult</h3>
						<p class="mt-sm-5 mt-3">Our research & development team ensures our clients stay updated and ahead of their competitors, giving us an instant edge over other agencies.</p>
						<ul class="mt-4">
							<li class="mt-2"><span class="fas fa-angle-right"></span>Consult us with your problem.</li>
							<li class="mt-2"><span class="fas fa-angle-right"></span>We will dedicate a team to it.</li>
							<li class="mt-2"><span class="fas fa-angle-right"></span>Team documents all findings.</li>
						</ul>
					</div>
					<div class="col-lg-4 col-md-6 grid1 mt-md-0 mt-5">
						<span class="fab fa-digital-ocean"></span>
						<h3 class="text-uppercase mt-3">R & D & Processes</h3>
						<p class="mt-sm-5 mt-3">Our team of experts develops a custom digital marketing strategy for each client, keeping in mind the challenges and problems faced by companies.</p>
						<ul class="mt-4">
							<li class="mt-2"><span class="fas fa-angle-right"></span>Internationally acceptable standards.</li>
							<li class="mt-2"><span class="fas fa-angle-right"></span>Global R & D Integrations/Findings.</li>
							<li class="mt-2"><span class="fas fa-angle-right"></span>Technological Fact Finding.</li>
						</ul>
					</div>
					<div class="col-lg-4 col-md-12 grid1 mt-lg-0 mt-5">
						<span class="fab fa-digital-ocean"></span>
						<h3 class="text-uppercase mt-3">Results & Reports</h3>
						<p class="mt-sm-5 mt-3">We have produced outstanding results for all our clients. We are sure that we will do the same for your company and we defend our results internationally.</p>
						<ul class="mt-4">
							<li class="mt-2"><span class="fas fa-angle-right"></span>Collaborative report and analysis.</li>
							<li class="mt-2"><span class="fas fa-angle-right"></span>Administrative report documentation.</li>
							<li class="mt-2"><span class="fas fa-angle-right"></span>Verifyable Research Identity Code.</li>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<!-- //Process -->


		<!-- odometer stats-->
		<section class="odometer1">
			<div class="layer py-5">
				<div class="container py-lg-5">
					<h3 class="heading mb-5 text-capitalize text-center">Global Score Board</h3>
					<div class="row w3layouts_statistics_grid_right">
						<div class="col-sm-4 col-6 text-center w3_stats_grid">
							<h3 id="w3l_stats2" class="odometer">0</h3>
							<p class="mt-2">Research Consults</p>
						</div>
						<div class="col-sm-4 col-6 mt-sm-0 mt-4 text-center w3_stats_grid">
							<h3 id="w3l_stats3" class="odometer">0</h3>
							<p class="mt-2">Team Members</p>
						</div>
						<div class="col-sm-4 col-6 mt-sm-0 mt-4 text-center w3_stats_grid">
							<h3 id="w3l_stats4" class="odometer">0</h3>
							<p class="mt-2">Research Projects</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- //odometer stats -->

		<!-- team -->
		<div class="banner-bottom py-5 my-lg-5">
			<div class="container">
				<h3 class="heading mb-5 text-capitalize text-center">Our Leaders </h3>
				<div class="row w3_testimonials_grids">

					<div class="col-md-12 col-sm-12 text-center w3layouts_team_grid">
						<h4 class="mb-2">Ennels  Jones</h4>
						<p>Founder/CEO</p>
						<hr>
					</div>
					<div class="col-md-3 col-sm-6 mt-sm-0 mt-5 text-center w3layouts_team_grid">
						<h4 class="mb-2">Williams Roxburgh</h4>
						<p>Co-Founder/Director</p>
					</div>
					<div class="col-md-3 col-sm-6 mt-md-0 mt-5 text-center w3layouts_team_grid">
						<h4 class="mb-2">Kingsley Ernest </h4>
						<p>Director</p>
					</div>
					<div class="col-md-3 col-sm-6 mt-md-0 mt-5 text-center w3layouts_team_grid">
						<h4 class="mb-2">GONZALO J. Calixta</h4>
						<p>Financial Controler.</p>
					</div>
					<div class="col-md-3 col-sm-6 mt-md-0 mt-5 text-center w3layouts_team_grid">
						<h4 class="mb-2">Antoniete Spike.</h4>
						<p>Secretary.</p>
					</div>

				</div>
			</div>
		</div>
		<!-- //team -->


	<?php endif; ?>

	<!-- project -->
	<section class="project py-5 text-center">
		<div class="container">
			<h3 class="text-capitalize mb-5">Do you want to consult our advisory team.</h3>
			<a href="./contact-us/" class="text-uppercase"><i class="fas fa-envelope-open"></i> contact us </a>
		</div>
	</section>
	<!-- //project -->

	<!-- footer -->
	<footer>
		<div class="container py-5">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<h3 class="text-uppercase mb-3">Address</h3>
					<address>
						<p><strong>U.S.A:</strong></p>
						<p class="mb-3"> 3045 Austell Road. Marietta, GA.30008</p>
						<p><strong>Phone</strong> : +1-956-300-0187</p>
						<p><strong>Email</strong> : <a href="mailto:info@crassociatefinance.com">info@crassociatefinance.com</a></p>
					</address>
				</div>
				<div class="col-lg-2 col-md-6 mt-lg-0 mt-sm-0 mt-4 p-md-0">
					<h3 class="text-uppercase mb-3">links</h3>
					<div class="links">
						<a class="pt-2 text-capitalize" href="./"><i class="fas fa-angle-right"></i> Home</a>
						<a class="pt-2 text-capitalize" href="./about-us/"><i class="fas fa-angle-right"></i> About Us</a>
						<a class="pt-2 text-capitalize" href="./the-team/"><i class="fas fa-angle-right"></i> Team</a>
						<a class="pt-2 text-capitalize" href="./services/"><i class="fas fa-angle-right"></i> Services</a>
						<a class="pt-2 text-capitalize" href="./contact-us/"><i class="fas fa-angle-right"></i> Contact Us</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 mt-lg-0 mt-4">
					<h3 class="text-uppercase mb-3">Recent posts</h3>
					<div class="posts">

						<p class="pt-2">Relocation of finance team
							<span class="font-italic">31st march, 2018.</span>
						</p>

						<p class="py-2 my-2 middle">Induction of new technologists
							<span class="font-italic">2nd April, 2019.</span>
						</p>

						<p class="py-2 my-2">Signs appropration audit with Asia
							<span class="font-italic">4th October, 2020.</span>
						</p>

					</div>
				</div>
				<div class="col-lg-4 col-md-6 mt-lg-0 mt-4">
					<h3 class="text-uppercase mb-3">Newsletter</h3>
					<p class="mb-4 pt-2">Subscribe to Our Newsletter to get Importantresearch news & More</p>
					<form action="#" method="post" disabled>
						<input type="email" name="Email" placeholder="Enter your email..." required disabled>
						<button class="btn1" disabled><i class="far fa-envelope"></i></button>
						<div class="clearfix"> </div>
					</form>
				</div>
			</div>
		</div>
	</footer>
	<!-- footer -->


	<!-- copyright -->
	<div class="copyright py-4">
		<div class="container">
			<div class="copyrightgrids row">
				<div class="col-lg-6 col-12">
					<p>© 2018 - 2020 CR Associate & Finance LLC.</p>
				</div>
				<div class="col-lg-6 col-12">
					<ul class="social text-right mt-lg-0 mt-3">
						<li>
							<p class="mx-2 text-capitalize">follow us on : </p>
						</li>
						<li class="mx-2"><a href="#"><span class="fab fa-facebook-f"></span></a></li>
						<li class="mx-2"><a href="#"><span class="fab fa-twitter"></span></a></li>
						<li class="mx-2"><a href="#"><span class="fab fa-google-plus-g"></span></a></li>
						<li class="mx-2"><a href="#"><span class="fab fa-linkedin-in"></span></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- //copyright -->

	<!-- js-scripts -->

	<!-- js -->
	<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script> <!-- Necessary-JavaScript-File-For-Bootstrap -->
	<!-- //js -->

	<!-- Owl-Carousel-JavaScript -->
	<script src="js/owl.carousel.js"></script>
	<script>
		$(document).ready(function() {
			$("#owl-demo").owlCarousel({
				items: 3,
				lazyLoad: true,
				autoPlay: true,
				pagination: true,
			});
		});
	</script>
	<!-- //Owl-Carousel-JavaScript -->

	<?php if (!isset($_REQUEST['form'])) : ?>
		<!-- odometer-script -->
		<script src="js/odometer.js"></script>
		<script>
			window.odometerOptions = {
				format: '(ddd).dd'
			};
		</script>
		<script>
			setTimeout(function() {
				jQuery('#w3l_stats2').html(330);
			}, 1500);
		</script>
		<script>
			setTimeout(function() {
				jQuery('#w3l_stats3').html(15);
			}, 1500);
		</script>
		<script>
			setTimeout(function() {
				jQuery('#w3l_stats4').html(690);
			}, 1500);
		</script>
		<!-- //odometer-script -->
	<?php endif; ?>

	<!-- start-smoth-scrolling -->
	<script src="js/SmoothScroll.min.js"></script>
	<script type="text/javascript" src="js/move-top.js"></script>
	<script type="text/javascript" src="js/easing.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".scroll").click(function(event) {
				event.preventDefault();
				$('html,body').animate({
					scrollTop: $(this.hash).offset().top
				}, 1000);
			});
		});
	</script>


	<!-- here stars scrolling icon -->
	<script type="text/javascript">
		$(document).ready(function() {
			/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
				};
			*/

			$().UItoTop({
				easingType: 'easeOutQuart'
			});

		});
	</script>
	<!-- //here ends scrolling icon -->
	<!-- start-smoth-scrolling -->

	<?php if (!isset($_REQUEST['form'])) : ?>
		<!-- FlexSlider-JavaScript -->
		<script defer src="js/jquery.flexslider.js"></script>
		<script type="text/javascript">
			$(function() {
				SyntaxHighlighter.all();
			});
			$(window).load(function() {
				$('.flexslider').flexslider({
					animation: "slide",
					start: function(slider) {
						$('body').removeClass('loading');
					}
				});
			});
		</script>
		<!-- //FlexSlider-JavaScript -->
	<?php endif; ?>
	<!-- //js-scripts -->

</body>

</html>