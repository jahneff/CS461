<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Example of carousal with Twitter Bootstrap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Example of carousal with Twitter Bootstrap version 2.0 from w3resource.com">
    <!-- Le styles -->
    <link rel="stylesheet" type="text/css" href="library/bootstrap.css"/>
    <link href="twitter-bootstrap-v2/docs/assets/css/example-fixed-layout.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="twitter-bootstrap-v2/docs/examples/images/favicon.ico">
    <link rel="apple-touch-icon" href="twitter-bootstrap-v2/docs/examples/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="twitter-bootstrap-v2/docs/examples/images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="twitter-bootstrap-v2/docs/examples/images/apple-touch-icon-114x114.png">
</head>
<body>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#"><img src="/images/w3r.png" width="111" height="30" alt="w3resource logo" /></a>
            <div class="nav-collapse">
                <ul class="nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>
<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <div class="span4">
            <h2>HTML5 and JS Apps</h2>
            <p> </p>
            <div id="myCarousel" class="carousel slide">
                <!-- Carousel items -->
                <div class="carousel-inner">
                    <div class="active item"><img src="/update-images/html5_logo.png" alt="HTML5 logo" width="500" height="99" /></div>
                    <div class="item"><img src="/update-images/javascript-logo.png" alt="JS logo" width="500" height="99" /></div>
                    <div class="item"><img src="/update-images/schema.png" alt="Schema.org logo" width="500" height="99" /></div>
                    <div class="item"><img src="/update-images/json.gif" alt="JSON logo" width="500" height="99" /></div>
                </div>
                <!-- Carousel nav -->
                <a class="carousel-control left" href="#myCarousel" data-slide="prev">‹</a>
                <a class="carousel-control right" href="#myCarousel" data-slide="next">›</a>
            </div>
        </div>
    </div>
    <hr>
    <footer>
        <p>© Company 2012</p>
    </footer>
</div> <!-- /container -->
<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="twitter-bootstrap-v2/docs/assets/js/jquery.js"></script>
<script src="twitter-bootstrap-v2/docs/assets/js/bootstrap-carousel.js"></script>
</body>
</html>