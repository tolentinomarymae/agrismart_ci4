
<br><br>

<br><br><br><br><br><br>
<section class="sign-in"  ;>
	<div class="container">
		<div class="signin-content">
			<div class="signin-image">
				<figure><img src="<?= base_url() ?>loginRegister/images/small-logo.png" alt="sing up image"></figure>
				
			</div>
			<div class="signin-form">
				<h2 class="form-title">Log In</h2>
				<form method="POST" action="/loginauth"class="login-form" id="login-form">
					<div class="form-group">
						<label for="username"><i class="fa-solid fa-user"></i></label>
						<input type="text" name="username" id="username" placeholder="Username" />
					</div>
					<div class="form-group">
						<label for="password"><i class="fa-solid fa-lock"></i></label>
						<input type="password" name="password" id="password" placeholder="Password" />
					</div>
					<div class="form-group">
						<input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
						<label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
					</div>
					<div class="form-group form-button">
						<input type="submit" name="signin" id="signin" class="form-submit" value="Log in" />
						<br><a href="/register">Don't have an account? Register</a>
						<br><a href="/dashboards">Dashboard</a>
					</div>
				</form>
				
			</div>
		</div>
	</div>
</section>