<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="row">
	<div class="col-md-12 ">
		<!-- carousel background part -->
		<div id="carousel-one" class="carousel slide" data-ride="carousel">
	        <ol class="carousel-indicators">
	            <li data-target="#carousel-one" data-slide-to="0" class="active"></li>
	            <li data-target="#carousel-one" data-slide-to="1"></li>
	            <li data-target="#carousel-one" data-slide-to="2"></li>
	        </ol>
	        <div class="carousel-inner">
	            <div class="item active">
	                <img src="<?= base_url('assets/images/login-portal/carousel1.jpg')?>" class="img-responsive" alt="First slide">
	                <div class="carousel-caption">
	                    <p> Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
	                </div>
	            </div>
	            <div class="item">
	                <img src="<?= base_url('assets/images/login-portal/image3.jpg')?>" class="img-responsive" alt="Second slide">
	                <div class="carousel-caption">
	                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
	                </div>
	            </div>
	            <div class="item">
	                <img src="<?= base_url('assets/images/login-portal/image1.jpg')?>" class="img-responsive" alt="Third slide">
	                <div class="carousel-caption">
	                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
	                </div>
	            </div>
	        </div>
	        <a class="left carousel-control" href="#carousel-one" data-slide="prev" style="z-index: 1;"><span class="glyphicon glyphicon-chevron-left"></span></a>
	        <a class="right carousel-control" href="#carousel-one" data-slide="next" style="z-index: 1;" ><span class="glyphicon glyphicon-chevron-right"></span></a>
        </div>
        <!-- END OF CAROUSEL -->

        <!-- main content text -->
        <div class="main-text">
   <!--      	<center  style="z-index: -1;" >
	            <img src="<?//= base_url('assets/images/login-portal/Untitled-1.png') ?>" style="z-index: -1;" class="img-responsive" >
	        </center> -->

	         

			<div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <div class="card imahe">
            		<img id="profile-img" class="img-responsive" src="<?= base_url('assets/images/login-portal/logo.png')?>" /> 
            </div>
            <p id="profile-name" class="profile-name-card"></p>

            <div class="form-signin">
              
               <!-- show the error here, sana katulad din sa buhay ko -->
	            <?php if (isset($error)) : ?>
					<div class="col-md-12">
						<div class="alert alert-danger" role="alert">
							<?= $error ?>
						</div>
					</div>
				<?php endif; ?>
                <?php if (validation_errors()) : ?>
					<div class="col-md-12">
						<div class="alert alert-danger" role="alert">
							<?= validation_errors() ?>
						</div>
					</div>
				<?php endif; ?>

            		<?= form_open();?>
		                <span id="reauth-email" class="reauth-email"></span>
		                <input type="text" name="idNumber" id="inputEmail" class="form-control" placeholder="ID Number" required autofocus>
		                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
		                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
		            </form><!-- /form -->
            </div>
            <a href="#" class="forgot-password">
                Forgot the password?
            </a>
<!-- 
        	<div class="text-center">
        	    <div class="">
                    <a class="btn btn-clear btn-sm btn-min-block" data-toggle="modal"  onClick="$('#myModal').modal()">Login</a>
                    <a class="btn btn-clear btn-sm btn-min-block" href="..">Home</a>
                </div> -->

			</div>
		</div>
	</div>
</div>


		<div id="push">
		</div>
