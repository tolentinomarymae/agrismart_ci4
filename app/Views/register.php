<!DOCTYPE html>
<html lang="en">
<head>
    <?= view('login/top');?>
</head>
<body>
    <?= view('login/navbar');?>
    <br><br><br><br><br><br>
    <section class="signup">
        <div class="container">
            <div class="signup-content">
                <div class="signup-form">
                    <h2 class="form-title">Sign up</h2>
                    <form method="POST" action="/authreg"class="register-form" id="register-form">
                        <div class="form-group">
                            <label for="farmer_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="farmer_name" id="farmer_name" placeholder="Full Name" />
                        </div>
                        
                        <div class="form-group">
                            <label for="password"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="password" placeholder="Password (minimum of 8)" />
                        </div>
                        <div class="form-group">
                            <label for="repeat_password"><i class="zmdi zmdi-lock"></i></label>
                            <input type="repeat_password" name="repeat_password" id="repeat_password" placeholder="Repeat Password (minimum of 8)" />
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="signup" id="signup" class="form-submit" value="Register" />
                        </div>
                    </form>
                </div>
                <div class="signup-image">
                    <figure><img src="<?= base_url() ?>loginRegister/images/small-logo.png" alt="sing up image"></figure>

                </div>
            </div>
        </div>
        </section>
       
    <?= view('login/end');?>
</body>
</html>