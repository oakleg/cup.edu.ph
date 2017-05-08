<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>Portal</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="<?=base_url('assets/for_sportal/css/bootstrap.min.css')?>" />
		<link rel="stylesheet" href="<?=base_url('assets/for_sportal/css/bootstrap-responsive.min.css')?>" />
        <link rel="stylesheet" href="<?=base_url('assets/for_sportal/css/matrix-login.css')?>" />
        <link href="<?=base_url('assets/for_sportal/font-awesome/css/font-awesome.css')?>" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

    </head>
    <body>
        <div id="loginbox">            
            
            <?=form_open('do/login/status')?>
				<div class="control-group normal_text"> <h3><?=$name?> Login</h3></div>
                <?php if (isset($error)) : ?>
                    <div class="col-md-12 col-sm-12 col-lg-12">
                        <div class="alert alert-danger" role="alert"><b>
                            <?= $error ?>
                        </b></div>
                    </div>
                <?php endif; ?>

                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"> </i></span><input name="username" type="text" placeholder="Username"  required/>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input name="password" type="password" placeholder="Password" required/>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span>
                    <span class="pull-right"><input type="submit"  class="btn btn-success" value="Login" /> </input></span>
                </div>
            </form>
            <form id="recoverform" action="#" class="form-vertical">
				<p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover a password.</p>
				
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input type="text" placeholder="E-mail address" />    
                        </div>
                    </div>
               
                <div class="form-actions">
                    <span class="pull-left"><a class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>
                    <span class="pull-right"><a class="btn btn-info"/>Reecover</a></span>
                </div>
            </form>
        </div>
        
        <script src="<?=base_url('assets/for_sportal/js/jquery.min.js')?>"></script>  
        <script src="<?=base_url('assets/for_sportal/js/matrix.login.js')?>"></script> 
    </body>

</html>
