<?php
function mypage_head() {
    echo '<link rel="stylesheet" type="text/css" href="'.plugin_dir_url( __FILE__ ) . '/package/template-style/package-style.css">'."\n";
    echo '<script src="'.plugin_dir_url( __FILE__ ) . 'main.js"></script>'."\n";
  }
add_action('wp_head', 'mypage_head');


?>

<?php
/*
Template Name: aaaaaaa
Template Post Type: page, packages,
*/
get_header(); ?>

<?php echo do_shortcode('[testimonial-form]'); ?>




<div class="package-container">

 <div class="post-img">
<?php
    echo '<img src="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';

 ?>
 
<div class="package-image-title">
  <h1><?php the_title(); ?></h1>
  <p>Lowest Price</p>
  <p class="image-price">₹<?php echo esc_attr($p1); ?></p>
</div>
<div class="package-menu">
  <p class="package-menu-title">Package Includes</p>

<div class="package-menu-p">
<p><i class="fas fa-dot-circle"></i> <?php echo esc_attr($pm1); ?></p>
<p><i class="fas fa-dot-circle"></i> <?php echo esc_attr($pm2); ?></p>
<p><i class="fas fa-dot-circle"></i> <?php echo esc_attr($pm3); ?></p>
<p><i class="fas fa-dot-circle"></i> <?php echo esc_attr($pm4); ?></p>
<p><i class="fas fa-dot-circle"></i> <?php echo esc_attr($pm5); ?></p>
<p><i class="fas fa-dot-circle"></i> <?php echo esc_attr($pm6); ?></p>
<p><i class="fas fa-dot-circle"></i> <?php echo esc_attr($pm7); ?></p>
<p><i class="fas fa-dot-circle"></i> <?php echo esc_attr($pm8); ?></p>
</div>

</div></div>

<div class="packdiscription">
<h2><?php echo esc_attr($packtitle); ?></h2>
<p><?php echo esc_attr($packdiscription); ?></p>
</div>

<form id="zon-testimonial-form"  class="zon-form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">

<div class="zon-input-fields">
  <div class="field-container">
    <input type="text" class="field-input" placeholder="Name" id="name" name="name" required>
    <small class="field-msg error" data-error="invalidName">Your Name is Required</small>
  </div>

  <div class="field-container">
    <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="field-input" placeholder="Mobile"  maxlength="10" id="phone" name="phone" required>
    <small class="field-msg error" data-error="invalidMobile">The Mobile number is not valid</small>
  </div>  


  <div class="field-container">
    <input type="text" class="field-input" placeholder="Email" id="adult" name="email" required>
    <small class="field-msg error" data-error="invalidEmail">Your Email is Required</small>
  </div>

  <div class="field-container">
    <input type="text" class="field-input" placeholder="Person/s" id="infant" name="message" >
    <small class="field-msg error" data-error="invalidName">Child is Required</small>
  </div>


  <div class="field-container">
    <input type="date" class="field-input" placeholder="Date" id="calendar" name="date" required>
    <small class="field-msg error" data-error="invalidDate">The Date is not valid</small>
  </div> 




  

  <div class="field-container">
    <input type="submit"  id="btn-razorpay" class="btn"  name="submit" value='BOOK NOW PAY LATER' placeholder="submit">
  </div>

  <div class="field-container">
    <small class="field-msg js-form-submission">Submission in process, please wait&hellip;</small>
    <small class="field-msg success js-form-success">Message Successfully submitted, thank you!</small>
    <small class="field-msg error js-form-error">There was a problem with the Contact Form, please try again!</small>
    <input type="hidden" name="action" value="submit_testimonial">
    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce("testimonial-nonce") ?>"> </form>
  </div>
</div>
</div>





<script>


var input = document.getElementById("datepicker");
      var today = new Date();
      var day = today.getDate();
      // Set month to string to add leading 0
      var mon = new String(today.getMonth()+1); //January is 0!
      var yr = today.getFullYear();
      
        if(mon.length < 2) { mon = "0" + mon; }
      
        var date = new String( yr + '-' + mon + '-' + day );
      
      input.disabled = false; 
input.setAttribute('min', date);

</script>


<!-- Footer -->
<?php include (TEMPLATEPATH . '/footer.php'); ?>
<!-- Footer -->







