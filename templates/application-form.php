

<div class="btn">
  <button class="js-btn btn-apply">APPLY NOW!</button>
</div>


<div class="modal">
  <div class="modal_content">
    <span class="close">&times;</span>

    <form id="zon-testimonial-form"  class="zon-form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>" enctype="multipart/form-data">
      <?php $current_user = wp_get_current_user(); echo $current_user->user_login; ?>
      <div class="zon-input-fields">
        <h3>Apply for this position</h3>
        <div class="cv-section-container">
          <div class="cv-section-one">
            <div class="field-container">
              <input value="<?php echo $current_user->user_login; ?>" type="text" class="field-input" placeholder="Name" id="name" name="name" required>
            </div>
            <div class="field-container">
              <input value="sgds" type="hidden" class="field-input" placeholder="CV not attached" id="title" name="title">
            </div>
            <div class="field-container">
              <input value="" type="text" class="field-input" placeholder="CV not attached" id="cv" name="cv">
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
          </div>
          <div class="cv-section-two">
            <!-------file-upload------->
            <div class="cv-preview-container">
              <svg class="cv-preview-default-image" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
              	 viewBox="0 0 512 512" xml:space="preserve">
              <circle style="fill:#FAA85F;" cx="376" cy="400" r="112"/>
              <polygon style="fill:#FFFFFF;" points="376,336 328,400 360,400 360,464 392,464 392,400 424,400 "/>
              <path style="fill:#00384E;" d="M256.352,480H56V32h192v128h128v96c11.008,0,21.696,1.36,32,3.712V137.376L270.624,0H24v512h261.696
              	C274.384,502.864,264.464,492.096,256.352,480z M280,54.624L353.376,128H280V54.624z"/>
              <path style="fill:#72C6EF;" d="M232,400c0-68.384,47.968-125.68,112-140.288V160h-96V64H88v384h152.4
              	C235.056,432.96,232,416.848,232,400z"/>
              <g>
              	<rect x="136" y="240" style="fill:#00384D;" width="160" height="32"/>
              	<path style="fill:#00384D;" d="M268.976,304H136v32h111.2C253.008,324.336,260.352,313.6,268.976,304z"/>
              	<path style="fill:#00384D;" d="M136,368v32h96c0-11.008,1.36-21.696,3.712-32H136z"/>
              </g>
              </svg>
              <div class="file-upload-preview-container">
                <label for="">Upload CV/Resume *</label>
                <embed id="cv-preview"  src='' width="100%" height="300">
                <label for="fileupload" class="custom-file-upload">Upload</label>
                <label for="">Allowed File Type: .pdf,</label>
              </div>
            </div>
           
            <input type="file" onchange="saveFile()" name="fileupload" id="fileupload">
            <div id="progress-bar-file1" class="progress"></div>
          </div>
        </div>
      
        
          
       
    
       
        
      </div>
      <input type="submit"  id="btn-razorpay" class="btn-application-submit"  name="submit" value='SUBMIT YOUR APPLICATION' placeholder="submit">
      <div class="field-container">
          <small class="field-msg js-form-submission">Submission in process, please wait&hellip;</small>
          <small class="field-msg success js-form-success">Application Successfully submitted, thank you!</small>
          <small class="field-msg error js-form-error">There was a problem with the Application Form, please try again!</small>
          <input type="hidden" name="action" value="submit_testimonial">
          <input type="hidden" name="nonce" value="<?php echo wp_create_nonce("testimonial-nonce") ?>"> </form>
        </div>
    </form>
  </div>
</div>


<script>
const the_button = document.querySelector(".js-btn")
const modal = document.querySelector(".modal")
const closeBtn = document.querySelector(".close")

document.addEventListener("DOMContentLoaded",() => {
  the_button.addEventListener("click", handleClick)
})
function handleClick(event) {
  modal.style.display = "block";
  closeBtn.addEventListener("click", () => {
    modal.style.display = "none"
  })
}

//save file
async function saveFile() {
  let formData = new FormData();
  formData.append("file", fileupload.files[0]);
  await fetch('<?php echo plugin_dir_url( __FILE__ ); ?>/upload.php', {
    method: "POST", 
    body: formData
  }).then(function(response){
    return response.json();
  }).then(function(responseData){
    cvinput = responseData.image_source;
    document.getElementById('cv').value = cvinput;

    document.getElementById("cv-preview").src = cvinput + "#toolbar=0&navpanes=0&scrollbar=0";
    //srcinput = cvinput.createObjectURL(event.target.files[0])
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
                    cv: a.querySelector('[name="cv"]').value,
                    email: a.querySelector('[name="email"]').value,
                    message: a.querySelector('[name="message"]').value,
                    title: a.querySelector('[name="title"]').value,
                    nonce: a.querySelector('[name="nonce"]').value
                };
                if (r.name)
                    if (/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(r.email).toLowerCase()))
                        if (r.message) {
                            var t = a.dataset.url,
                            s = new URLSearchParams(new FormData(a));
                            
                            
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