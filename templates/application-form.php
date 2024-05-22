

<h1><?php the_title(); ?></h1>
<form id="zon-testimonial-form"  class="zon-form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>" enctype="multipart/form-data">
  <?php $current_user = wp_get_current_user(); echo $current_user->user_login; ?>

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

    <!-------file-upload------->
    <input type="file"  name="fileupload" id="fileupload">
    <button id="upload-button" onclick="saveFile()">Upload</button>
  
    
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
</form>

<!---- Calendar Popup Container ----->
<!---- Calendar Popup Container End ----->   
<button class="uplo">fghdfghdfgh</button>

<script>

const btn = document.querySelector('.uplo');
const clickHandler = async () => {
  const res = await fetch('<?php echo plugin_dir_url( __FILE__ ); ?>/upload.php', {
    method: "get", 
    body: formData
  });
}
btn.addEventListener('click', clickHandler);


async function saveFile() {
  let formData = new FormData();
  formData.append("file", fileupload.files[0]);
  await fetch('<?php echo plugin_dir_url( __FILE__ ); ?>/upload.php', {
    method: "POST", 
    body: formData
  });
}
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
                            s.append("file", cv.files[0]);
                            saveFile()
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
