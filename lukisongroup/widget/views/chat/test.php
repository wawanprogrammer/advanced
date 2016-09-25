<?php
use \yii;
use kartik\helpers\Html;
use lukisongroup\assets\AppAssetBegareh;
AppAssetBegareh::register($this);

//echo "test";
?>

 <body ng-controller="login-register">

    <!-- Main Div Wrapper starts-->
  	<div class="container index">
		
		
  		<!-- 
  			Login Box starts 
  		-->
		<div ng-hide="LoginBox" class="login box-container">
			
			<div class="heading">
		  		<h2 class="login-heading">Login</h2>        
			</div>

			<!-- User name Text Field -->
			<div class="input-group username-group">
		  		<span class="input-group-addon iconbg">
					<i class="glyphicon glyphicon-user"></i>
		  		</span>
		  		<input id="login-username" type="text" ng-model="username" class="form-control inputbg" name="username" value="" placeholder="username or email">
			</div>

			<!-- Password Text Field -->
			<div class="input-group password-group">
		  		<span class="input-group-addon iconbg">
					<i class="glyphicon glyphicon-lock"></i>
		  		</span>
		  		<input id="login-password" type="password" ng-model="password" class="form-control inputbg" name="password" placeholder="password">
			</div>

			<!-- ALert Box For Wrong Usernme and password combination -->
			<div class="alert-group" ng-hide="LoginAlert">
		  		<div class="alert alert-danger">
					Wrong Username and Password combination 
		  		</div>
			</div>
	
			<!-- Button to Login -->
			<div class="input-group">
				<button ng-click="login()"id="btn-login" class="btn btn-login btnbg">
					Login 
				</button>
			</div>

			<!-- Link for SingUp Box -->
			<div class="signup-box">
			  	<h4>Don't have an account ? <u><span ng-click="toggle_register()">SignUp</span></u></h4>
			</div>
		</div>
		<!-- 
  			Login Box ends 
  		-->

		
		<!-- 
  			Registration Box starts 
  		-->
		<div ng-hide="RegisterBox" class="register box-container">

			<div class="heading">
				<h2 class="login-heading">Register</h2>        
			</div>

			<!-- User name Text Field -->
			<div class="input-group username-group">
				<span class="input-group-addon iconbg">
					<i class="glyphicon glyphicon-user"></i>
			  	</span>
			  	<input id="register-username" type="text" ng-model="username"  class="form-control inputbg" name="username" value="" placeholder="username or email" ng-keyup="keyup_uncheck()" ng-keydown="keydown_uncheck()" ng-blur="blur_uncheck()"  ng-change="change_uncheck()">
			</div>

			<!-- ALert Box When username is already taken -->
			<div class="alert-group" ng-hide="RegisterAlert">
			  	<div class="alert alert-danger">
					This username is already taken. 
			  	</div>
			</div>

			<!-- Password Text Field -->			
			<div class="input-group password-group">
			  	<span class="input-group-addon iconbg">
					<i class="glyphicon glyphicon-lock"></i>
			  	</span>
			  	<input id="register-password" type="password" ng-model="password"  class="form-control inputbg" name="password" placeholder="password">
			</div>

			<!-- Field upload Image-->			
			<div class="input-group p_photo-group">
				<input id="p_photo-password" type="file" class="p_photo inputbg" file-model = "myFile" name="p_photo">
			</div>
			<div id="selectedFile" class="selectedFile" >Upload Profile Image:</div>

			<!-- Button to Register -->
			<div class="input-group">
				<button id="btn-login" class="btn btn-login btnbg" ng-click="register()">
					Register
			  	</button>
			</div>

			<!-- Link for Login -->
			<div class="signup-box">
				<h4>Already have an account ? <u><span ng-click="toggle_login()">SignIn</span></u></h4>
			</div>
		</div>
	</div>
  </body>