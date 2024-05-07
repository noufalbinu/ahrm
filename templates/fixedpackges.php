<?php get_header(); 



    echo '<link rel="stylesheet" type="text/css" href="'.plugin_dir_url( __FILE__ ) . '/package/template-style/package-style.css">'."\n";
    echo '<script type="module" src="'. plugins_url('/air-datepicker.js"', __DIR__ ). '></script>'."\n";
?>



<style type="text/css">
  #zon-testimonial-form .field-container{position:relative;margin-bottom:20px}#zon-testimonial-form .field-msg{display:none;position:absolute;left:2px;bottom:-14px;font-size:9px;text-transform:uppercase;font-weight:600;letter-spacing:0.05em}#zon-testimonial-form .field-msg.show{display:block}#zon-testimonial-form .error{color:#901313}#zon-testimonial-form .success{color:#2f812f}

/*# sourceMappingURL=form.css.map */
</style>


<style type="text/css">
#fixedpack {
    margin: 0px 10%;
    border-radius: 10px;
    background-size: 30% auto;
    background-repeat: no-repeat;
}

</style>

<?php

    $data = get_post_meta( $post->ID, '_zonpackk_testimonial_key', true );
    $p1 = isset($data['p1']) ? $data['p1'] : '';
    $p2 = isset($data['p2']) ? $data['p2'] : '';
    $p3 = isset($data['p3']) ? $data['p3'] : '';
    $p4 = isset($data['p4']) ? $data['p4'] : '';
    $p5 = isset($data['p5']) ? $data['p5'] : '';
    $p6 = isset($data['p6']) ? $data['p6'] : '';
    $p7 = isset($data['p7']) ? $data['p7'] : '';
    $p8 = isset($data['p8']) ? $data['p8'] : '';
    $p9 = isset($data['p9']) ? $data['p9'] : ''; 

    $ticketcount = isset($data['ticketcount']) ? $data['ticketcount'] : '';
    $fixeddeparture = isset($data['fixeddeparture']) ? $data['fixeddeparture'] : '';
    
    $picture1 = isset($data['picture1']) ? $data['picture1'] : '';
    $picture2 = isset($data['picture2']) ? $data['picture2'] : '';
    $picture3  = isset($data['picture3']) ? $data['picture3'] : '';


    //package Header
    $budget = isset($data['budget']) ? $data['budget'] : '';
    $economy = isset($data['economy']) ? $data['economy'] : '';
    $premium = isset($data['premium']) ? $data['premium'] : '';

    $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');


    $pm1 = isset($data['pm1']) ? $data['pm1'] : '';
    $pm2 = isset($data['pm2']) ? $data['pm2'] : ''; 
    $pm3 = isset($data['pm3']) ? $data['pm3'] : ''; 
    $pm4 = isset($data['pm4']) ? $data['pm4'] : ''; 
    $pm5 = isset($data['pm5']) ? $data['pm5'] : '';
    $pm6 = isset($data['pm6']) ? $data['pm6'] : '';
    $pm7 = isset($data['pm7']) ? $data['pm7'] : '';
    $pm8 = isset($data['pm8']) ? $data['pm8'] : ''; 



    $packagecode = isset($data['packagecode']) ? $data['packagecode'] : '';
    $packtitle = isset($data['packtitle']) ? $data['packtitle'] : '';
    $packdiscription = isset($data['packdiscription']) ? $data['packdiscription'] : '';
    $dataoption = isset($data['dataoption']) ? $data['dataoption'] : '';


    if (isset($_POST['dataoption'])) {
      $zonoption = $_POST['dataoption'];
      $_SESSION['dataoption'] = $dataoption ;
    } else {
      $zonoption  = $_SESSION['dataoption'];
    }

 ?>





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
<p><i class="fas fa-dot-circle"></i> <?php echo esc_attr($pm8); ?></p></div></div>
 </div>



<form id="zon-testimonial-form"  class="zon-form" action="#" method="post" 
data-url="<?php echo admin_url('admin-ajax.php'); ?>">
  <div class="packdiscription">
<h2><?php echo esc_attr($packtitle); ?></h2>
<p><?php echo esc_attr($packdiscription); ?></p>
<p>
<?php $current_user = wp_get_current_user(); echo $current_user->user_login; ?>
</p>
</div>
<?php
switch ($dataoption) {
    case 'page2': ?>


<div class="fixedbox">
  <div class="fixed-departure">
    <img src="<?php echo esc_url($picture1); ?>">
    <h4 class="hotel-title"><?php echo esc_attr( $budget ); ?></h4>
  </div>
  <div class="fixed-container">
    <h3><?php echo esc_attr($fixeddeparture); ?></h3>
    <p><?php echo esc_attr($packagecode); ?> : ₹ <?php echo esc_attr($p1); ?></p>
    <p>Ticket Avilability : <?php echo esc_attr($ticketcount); ?></p>
    <p> <input type="hidden" name ="package" value="<?php echo esc_attr($packagecode); ?>">
      <?php echo esc_attr($packagecode); ?></p>
  </div> 
</div>
    




   

       <?php break;
    case 'page1': ?>
        <div id="clmn3">

<div class="cnt"><div class="row" style="margin-left: 0; background-image: url(<?php echo esc_url($picture1); ?>);"><h3><?php echo esc_attr( $budget ); ?></h3>
 <label class="zon-container"><p>2 Nights 3 Days: <?php echo esc_attr($p1); ?></p>
  <input class="chb" placeholder="dfhdsghdgj" type="checkbox" name="package" value="3000" checked="checked">
  <span class="checkmark"></span>
</label>
<label  class="zon-container"><p>3 Nights 4 Days : <?php echo esc_attr($p2); ?></p>
  <input  class="chb"  type="checkbox" name="package" value="budget2">
  <span class="checkmark"></span>
</label>
<label class="zon-container"><p>4 Nights 5 Days : <?php echo esc_attr($p3); ?></p>
  <input class="chb"  type="checkbox" name="package" value="budget3">
  <span class="checkmark"></span>
</label>
</div></div>


<div class="cnt"><div class="row" style="background: url(<?php print $picture2; ?>);"><h3><?php echo esc_attr( $economy ); ?></h3>
<label class="zon-container"><p>2 Nights 3 Days: <?php echo esc_attr($p4); ?></p>
  <input class="chb" type="checkbox" name="package" value="economy1">
  <span class="checkmark"></span>
</label>
<label  class="zon-container"><p>3 Nights 4 Days : <?php echo esc_attr($p5); ?></p>
  <input class="chb" type="checkbox" name="package" value="economyt2">
  <span class="checkmark"></span>
</label>
<label class="zon-container"><p>4 Nights 5 Days : <?php echo esc_attr($p6); ?></p>
  <input class="chb" type="checkbox" name="package" value="economy3">
  <span class="checkmark"></span>
</label>
</div></div>


<div class="cnt"><div class="row" style="margin-right: 0;background: url(<?php print $picture3; ?>);"><h3><?php echo esc_attr( $premium ); ?></h3>
<label class="zon-container"><p>2 Nights 3 Days: <?php echo esc_attr($p7); ?></p>
  <input class="chb" type="checkbox" name="package" value="premium1">
  <span  class="checkmark"></span>
</label>
<label  class="zon-container"><p>3 Nights 4 Days : <?php echo esc_attr($p8); ?></p>
  <input class="chb"  type="checkbox" name="package" value="premium2">
  <span class="checkmark"></span>
</label>
<label class="zon-container"><p>4 Nights 5 Days : <?php echo esc_attr($p9); ?></p>
  <input  class="chb" type="checkbox" name="package" value="premium3">
  <span class="checkmark"></span>
</label>
</div></div>
</div>

        <?php
        break;
        default:
        echo "Package Not Selected";
}
?>


<div class="zon-input-fields">
  <div class="field-container">
    <input value="<?php echo $current_user->user_login; ?>" type="text" class="field-input" placeholder="Name" id="name" name="name" required>
    <small class="field-msg error" data-error="invalidName">Your Name is Required</small>
  </div>

  <div class="field-container">
    <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="field-input" placeholder="Mobile"  maxlength="10" id="phone" name="phone" required>
    <small class="field-msg error" data-error="invalidMobile">The Mobile number is not valid</small>
  </div>  

  <div class="field-container">
    <input value="<?php echo $current_user->user_email; ?>" type="text" class="field-input" placeholder="Email" id="adult" name="email" required>
    <small class="field-msg error" data-error="invalidEmail">Your Email is Required</small>
  </div>

  <div class="field-container">
    <input type="text" class="field-input" placeholder="Person/s" id="infant" name="message" >
    <small class="field-msg error" data-error="invalidName">Child is Required</small>
  </div>

  <div class="field-container">
    <input type="text" class="field-input" id="my-element" placeholder="Date" id="" name="date" required>
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

<!---- Calendar Popup Container ----->
<!---- Calendar Popup Container End ----->   




<script>
  jQuery(".chb").change(function() {
      jQuery(".chb").prop('checked', false);
      jQuery(this).prop('checked', true);
  });
</script>

<script>
  jQuery(document).ready(function() {
    $menuLeft = jQuery('.pushmenu-left');
    $nav_list = jQuery('#nav_list');

    $nav_list.click(function() {
      jQuery(this).toggleClass('active');
      jQuery('.pushmenu-push').toggleClass('pushmenu-push-toright');
      $menuLeft.toggleClass('pushmenu-open');
    });
  });
</script>


<script>

! function o(n, i, u) {
    function c(r, e) {
        if (!i[r]) {
            if (!n[r]) {
                var t = "function" == typeof require && require;
                if (!e && t) return t(r, !0);
                if (l) return l(r, !0);
                var s = new Error("Cannot find module '" + r + "'");
                throw s.code = "MODULE_NOT_FOUND", s
            }
            var a = i[r] = {
                exports: {}
            };
            n[r][0].call(a.exports, function(e) {
                return c(n[r][1][e] || e)
            }, a, a.exports, o, n, i, u)
        }
        return i[r].exports
    }
    for (var l = "function" == typeof require && require, e = 0; e < u.length; e++) c(u[e]);
    return c
}({
    1: [function(e, r, t) {
        "use strict";

        function o() {
            document.querySelectorAll(".field-msg").forEach(function(e) {
                return e.classList.remove("show")
            })
        }
        document.addEventListener("DOMContentLoaded", function(e) {
            var a = document.getElementById("zon-testimonial-form");
            a.addEventListener("submit", function(e) {
                e.preventDefault(), o();
                var r = {
                    name: a.querySelector('[name="name"]').value,
                    email: a.querySelector('[name="email"]').value,
                    message: a.querySelector('[name="message"]').value,
                    package: a.querySelector('[name="package"]').value,




                    nonce: a.querySelector('[name="nonce"]').value
                };
                if (r.name)
                    if (/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(r.email).toLowerCase()))
                        if (r.message) {
                            var t = a.dataset.url,
                                s = new URLSearchParams(new FormData(a));
                            a.querySelector(".js-form-submission").classList.add("show"), fetch(t, {
                                method: "POST",
                                body: s
                                
                            }).then(function(e) {
                                return e.json()

          
                            }).catch(function(e) {
                                o(), a.querySelector(".js-form-error").classList.add("show")
                            }).then(function(e) {
                                o(), 0 !== e && "error" !== e.status ? (a.querySelector(".js-form-success").classList.add("show"), a.reset()) : a.querySelector(".js-form-error").classList.add("show")
                            })
                        } else a.querySelector('[data-error="invalidMessage"]').classList.add("show");
                else a.querySelector('[data-error="invalidEmail"]').classList.add("show");
                else a.querySelector('[data-error="invalidName"]').classList.add("show")
            })
        })
    }, {}]
}, {}, [1]);
//# sourceMappingURL=form.js.map
</script>







<!-- Footer -->
<?php include (TEMPLATEPATH . '/footer.php'); ?>
<!-- Footer -->







