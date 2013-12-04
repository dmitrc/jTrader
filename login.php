<?php
	error_reporting(0);
	require_once(dirname(__FILE__).'/./inc/user.php');
	session_start(); 
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">-->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="js/jquery.ba-hashchange.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="js/main.js"></script>
	<title>jTrade</title>
</head>

<body>

<!-- Navigation bar -->

<nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="main-navbar">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
		    <span class="sr-only">Toggle navigation</span>
		    <span class="icon-bar"></span>
		    <span class="icon-bar"></span>
		    <span class="icon-bar"></span>
		   	</button>
			<a href="index.php" class="navbar-brand">jTrader</a>
		</div>
		<div class="navbar-collapse collapse navbar-ex1-collapse">
			<ul class="navbar-nav nav">
			</ul>
			<form class="navbar-form navbar-left" role="search">
				<div class="form-group">
					<input id="search_bar" type="text" class="form-control" placeholder="Search">
				</div>
				<div id="search_button" class="btn btn-default">Go!</div>
			</form>
			<ul class="navbar-nav nav navbar-right">
				<li><a href="index.php">Home</a></li>
				<li><a data-toggle="modal" href="#about-modal">About</a></li>
				<li><a data-toggle="modal" href="#contact-modal">Contact</a></li>
				<?php
					$username = isLoggedIn();
					if (!$username) {
						echo '<li class="active"><a href="login.php">Login</a></li>';
					}
					else {
						echo '<li><a href="add_item.php">Add item</a></li>';
						echo '<li><a href="#" id="logout">Logout &nbsp;&nbsp;<em>('.$username.')</em></a></li>';
					}
				?>
			</ul>
		</div>
	</div>
</nav>

<!-- Main -->

<?php
	if (isLoggedIn()) {
		echo '<div class="row"><div class = "container well"><br/><p class = "lead text-danger textcenter">Already logged in!</p></div></div>';
		exit();
	}
?>

<div class="row"><br/></div>
<div class="row"><br/></div>

<div class="row">
	<div class="container col-lg-4 col-sm-6 col-lg-offset-4 col-sm-offset-3 well well-lg">

      <form class="form-signin">
        <h2 class="form-signin-heading">Please sign in with your CampusNet data:</h2>
        <input type="text" class="form-control" id="form_name" placeholder="Username" autofocus>
        <input type="password" class="form-control" id="form_pass" placeholder="Password">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <div class="login_button btn btn-lg btn-primary btn-block">Sign in</div>
      </form>

    </div>
</div>

<div class="row"><br/></div>
<div class="row"><br/></div>

<!-- Footer -->

<div id="footer">
    <div class="container">
    	<div class="row">
    		<div class="col-lg-6 col-sm-6"><p class="credit text-muted"><em>Created by Dmitrii Cucleschin, Andrei Giurgiu and Nikolche Kolev. ©2013</em></p></div>
    		<div class="col-lg-2 col-sm-2 col-lg-offset-4 col-sm-offset-4 text-muted"><a class="text-muted" data-toggle="modal" href="#about-modal">About</a> | <a class="text-muted" data-toggle="modal" href="#contact-modal">Imprint</a></div>
    	</div>
	</div>
</div>

<!-- Common modal windows -->


<div class="modal fade" id="results-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	      <h4 class="modal-title">Results</h4>
	    </div>
	    <div class="modal-body">
	      	<div id="results-content">
	      	</div>
	    </div>
	  </div>
	</div>
</div>

<div class="modal fade" id="contact-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	      <h4 class="modal-title">Contact information</h4>
	    </div>
	    <div class="modal-body">
	      	<p>For all the inquiries, including but not limited to help requests, suggestions, bug notifications etc., please contact us via one of the following emails:</p>
	      	<p><em><strong>d.cucleschin</strong>_at_jacobs-university.de</em></p>
	      	<p><em><strong>an.giurgiu</strong>_at_jacobs-university.de</em></p>
	      	<p><em><strong>n.kolev</strong>_at_jacobs-university.de</em></p>

	      	<small class="text-muted">For each external link existing on this website, we initially have checked that the target page does not contain contents which is illegal wrt. German jurisdiction. However, as we have no influence on such contents, this may change without our notice. Therefore we distance ourselves from the contents of any website referenced through our external links. This website is student lab work and does not necessarily reflect Jacobs University Bremen opinions. Jacobs University Bremen does not endorse this site, nor is it checked by Jacobs University Bremen regularly, nor is it part of the official Jacobs University Bremen web presence.</small>
	    </div>
	  </div>
	</div>
</div>

<div class="modal fade" id="about-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	      <h4 class="modal-title">About jTrader</h4>
	    </div>
	    <div class="modal-body">
	      	<p>jTrader was created by Dmitrii, Andrei and Nikolche as their practical project for Databases & Web Applications course.</p>
			<p>However, it never felt like an assignment, but more like a personal project, that can greatly improve our development skills and bring benefit to Jacobs University students and faculty.</p>
			<div class="thumbnail">
				<img src="http://placehold.it/500x300" alt="Img" class="img-responsive img-rounded">
				<div class="description">
					<h5>Here will be happy picture of us after getting 1.0 in the course :)</h5>
				</div>
			</div>
	    </div>
	  </div>
	</div>
</div>

<!-- Scripts -->

<script>
 $("#logout").click(function () {
    $.post("inc/api.php", { action:'logout'}, function(results){
          	window.location.reload(true);
    });
  });
</script>

<script type="text/javascript">
  $(".login_button").click(function () {
    var form_login = $("#form_name").val();
    var form_pass = $("#form_pass").val(); 
    $.post("inc/api.php", { action:'login', args:[form_login,form_pass]}, function(results){
      if (results != "true") {
      	$("#results-content").html(results);
      	$('#results-modal').modal('show');
      }
      else {
      	window.location.href = "index.php";
      }
    });
  });

  $('#form_name').keydown(function(event){    
      if(event.keyCode==13){
           $('.login_button').trigger('click');
           return false;
      }
  });

    $('#form_pass').keydown(function(event){    
      if (event.keyCode==13){
        $('.login_button').trigger('click');
           return false;
      }
  });

   $("#search_button").click( function() {
 	location.href = "search.php?query="+$("#search_bar").val();
 });

   $('#search_bar').keydown(function(event){    
      if(event.keyCode==13){
           $('#search_button').trigger('click');
           return false;
      }
  });

</script>

</body>
</html>