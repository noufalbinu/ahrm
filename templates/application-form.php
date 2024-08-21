<div class="application-form">
  <div class="application-form-wrap">
    <form id="zon-testimonial-form"  class="zon-form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>" enctype="multipart/form-data">
      <?php $current_user = wp_get_current_user(); ?>
      <div class="job-form-header">
        <h3>Please fill out the form below</h3>
      </div>
      <div class="zon-input-fields"> 
        <div class="cv-section-container">
            <div class="cv-section-one">
                <div class="grid-fields">
                    <div class="field-container">
                      <label for="">Name *</label>
                      <input value="" type="text" class="field-input" placeholder="Name" id="name" name="name" required>
                    </div>
                    
                    <div class="field-container">
                      <label for="">Mobile *</label>
                      <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="field-input" placeholder="Mobile"  maxlength="10" id="phone" name="phone" required>
                      <small class="field-msg error" data-error="invalidMobile">The Mobile number is not valid</small>
                    </div>  
                    <div class="field-container">
                      <label for="">Email *</label>
                      <input value="" type="text" class="field-input" placeholder="Email" id="adult" name="email" required>
                      <small class="field-msg error" data-error="invalidEmail">Your Email is Required</small>
                    </div>
                    <div class="field-container">
                      <label for="">Fathers Name </label>
                      <input value="" type="text" class="field-input" placeholder="Fathers Name" id="name" name="name" required>
                    </div>
                    <div class="field-container">
                      <label for="">Occupation </label>
                      <input value="" type="text" class="field-input" placeholder="Teacher" id="name" name="name" required>
                    </div>
                    <div class="field-container">
                      <label for="">Address</label>
                      <input value="" type="text" class="field-input" placeholder="Address" id="name" name="name" required>
                    </div>
                    <div class="field-container">
                      <label for="">Date of Birth </label>
                      <input value="" type="text" class="field-input" placeholder="30/12/2000" id="name" name="name" required>
                    </div>
                    <div class="field-container">
                      <label for="">Age </label>
                      <input value="" type="text" class="field-input" placeholder="Age" id="name" name="name" required>
                    </div>
                </div>
                
                <div class="grid-fields">
                <b class="form-sub-header">Passport Details</b>
                  <div class="field-container">
                    <label for="">Passport No</label>
                    <input value="" type="text" class="field-input" placeholder="" id="pno" name="pno" required>
                  </div>
                  <div class="field-container">
                    <label for="">Date of Issue</label>
                    <input value="" type="text" class="field-input" placeholder="" id="pissue" name="pissue" required>
                  </div>
                  <div class="field-container">
                    <label for="">Place of Issue</label>
                    <input value="" type="text" class="field-input" placeholder="" id="dissue" name="dissue" required>
                  </div>
                  <div class="field-container">
                    <label for="">Expiry Date</label>
                    <input value="" type="text" class="field-input" placeholder="" id="exdate" name="exdate" required>
                  </div>
                  <b class="form-sub-header">Driving License</b>
                  <div class="field-container">
                    <label for="">Indian</label>
                    <input value="" type="text" class="field-input" placeholder="" id="indian" name="indian" required>
                  </div>
                  <div class="field-container">
                    <label for="">Date of Issue</label>
                    <input value="" type="text" class="field-input" placeholder="" id="ldissue" name="ldissue" required>
                  </div>
                  <div class="field-container">
                    <label for="">Gulf</label>
                    <input value="" type="text" class="field-input" placeholder="" id="gulf" name="gulf" required>
                  </div>
                  <div class="field-container">
                    <label for="">Date of Expiry</label>
                    <input value="" type="text" class="field-input" placeholder="" id="exdate" name="exdate" required>
                  </div>
                </div>
            </div>
            <div class="cv-section-two">
              <!-------file-upload------->
              <div class="field-container file-upload-field">
                <label for="">Upload CV/Resume *</label>
                <div class="container-file">
                    <div class="fileUploadInput">
                      <input type="file" class="upld-field" onchange="saveFile()" name="fileupload" id="fileupload" accept="application/pdf" required/>
                      <button class="upld-btn"><i class="fa-solid fa-arrow-up-from-bracket"></i>Upload</button>
                    </div>
                </div>
                <div class="file-upload-section">
                  <label for="">Allowed File Type: .pdf,</label>
                </div>
              </div>
              <div class="field-container">
                <label for="">Cover Letter *</label>
                <textarea rows="3" class="field-input" id="my-element" id="" name="message" required></textarea>
                <small class="field-msg error" data-error="invalidDate">The Date is not valid</small>
              </div>
              <div class="field-container">
                
                <input value="<?php the_title(); ?>" type="hidden" class="field-input" placeholder="CV not attached" id="jobtitle" name="jobtitle">
              </div>
              <div class="field-container">
                <input value="" type="hidden" class="field-input" placeholder="CV not attached" id="cv" name="cv"/>
              </div>
              <div class="field-container">
                <input value="" type="hidden" class="field-input" placeholder="CV not attached" id="cvpath" name="cvpath"/>
              </div>
              <div class="form-success-error-msg">
              <p class="field-msg js-form-submission">Submission in process, please wait&hellip;</p>
            <p class="field-msg success js-form-success">Application Successfully submitted, thank you!</p>
            <p class="field-msg error js-form-error">There was a problem with the Application Form, please try again!</p>
              </div>
            </div>
        </div>
      </div>
      <div class="job-form-footer">
        <div class="button-wrap">
          <input type="submit"  class="btn-application-submit"  name="submit" value='SUBMIT' placeholder="submit">
        </div>
      </div>
      <div class="field-container">   
          <input type="hidden" name="action" value="submit_testimonial">
          <input type="hidden" name="nonce" value="<?php echo wp_create_nonce("testimonial-nonce") ?>"> </form>
        </div>
    </form>
  </div>
</div>
</div>


<script>


//save file
async function saveFile() { 
    let formData = new FormData();
    formData.append("file", fileupload.files[0]);
    const fileUploadPath = await fetch('<?php echo plugin_dir_url( __FILE__ ); ?>/upload.php', {
      method: "POST", 
      body: formData,
    });
    let cvSource = await fileUploadPath.json(); 
    document.getElementById('cv').value = cvSource.image_source;
    document.getElementById('cvpath').value = cvSource.image_path;
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
                    phone: a.querySelector('[name="phone"]').phone,
                    cv: a.querySelector('[name="cv"]').value,

                    pno: a.querySelector('[name="pno"]').value,
                    pissue: a.querySelector('[name="pissue"]').value,
                    dissue: a.querySelector('[name="dissue"]').value,
                    exdate: a.querySelector('[name="exdate"]').value,
                    indian: a.querySelector('[name="indian"]').value,
                    ldissue: a.querySelector('[name="ldissue"]').value,
                    gulf: a.querySelector('[name="gulf"]').value,
                    exdate: a.querySelector('[name="exdate"]').value,

                    cvpath: a.querySelector('[name="cvpath"]').value,
                    jobtitle: a.querySelector('[name="jobtitle"]').value,
                    message: a.querySelector('[name="message"]').value,
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
                        } 
                else a.querySelector('[data-error="invalidMessage"]').classList.add("show");
                else a.querySelector('[data-error="invalidEmail"]').classList.add("show");
                else a.querySelector('[data-error="invalidName"]').classList.add("show")
            })
        })
    }, {}]
}, {}, [1]);
//# sourceMappingURL=form.js.map
</script>