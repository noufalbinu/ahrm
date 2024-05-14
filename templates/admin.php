<div class="wrap">
	<h1>vBook Settings</h1>
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Activate Modules</a></li>
		<li><a href="#tab-4">Payment Gateway</a></li>
		<li><a href="#tab-2">Updates</a></li>
		<li><a href="#tab-3">About</a></li>

	</ul>

	<div class="tab-content">
		<div id="tab-1" class="tab-pane active">

			<form method="post" action="options.php">
				<?php 
					settings_fields( 'zon_packages_settings' );
					do_settings_sections( 'zon_packages' );
					submit_button();
				?>
			</form>
			
		</div>

		

		<div id="tab-2" class="tab-pane">
			<h3>Updates</h3>
		</div>

		<div id="tab-3" class="tab-pane">
			<h3>About</h3>
		</div>

		<div id="tab-4" class="tab-pane">
			<h3>RazorPay</h3>
			<?php
	

                    settings_fields('razorpay_fields');
                    do_settings_sections('razorpay_sections');
                    submit_button();


                    ?>


		</div>


	</div>
</div>