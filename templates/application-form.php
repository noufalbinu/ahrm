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
                      <label for="">Position applied for *</label>
                      <input value="" type="text" class="field-input" placeholder="" id="papplied" name="papplied" required>
                    </div>
                    <div class="field-container">
                      <label for="">Name *</label>
                      <input value="" type="text" class="field-input" placeholder="Name" id="name" name="name" required>
                    </div>
                    <div class="field-container">
                      <label for="">Age </label>
                      <input value="" type="text" class="field-input" placeholder="Age" id="age" name="age" required>
                    </div>
                    <div class="field-container">
                      <label for="">Qualifications*</label>
                      <textarea class="field-textarea"  name="qualifications" id="qualifications"></textarea>
                      <small class="field-msg error" data-error="invalidMobile">The Mobile number is not valid</small>
                    </div> 
                    
                    <div class="field-container">
                      <label for="">Experience in India (in years)*</label>
                      <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="field-input" placeholder=""  maxlength="2" id="phone" name="expind" required>
                      <small class="field-msg error" data-error="invalidMobile">The Mobile number is not valid</small>
                    </div> 
                    <div class="field-container">
                      <label for="">Experience at Abroad (in years)*</label>
                      <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="field-input" placeholder=""  maxlength="2" id="phone" name="expabroad" required>
                      <small class="field-msg error" data-error="invalidMobile">The Mobile number is not valid</small>
                    </div> 
                    <div class="field-container">
                      <label for="">Address*</label>
                      <textarea class="field-textarea" name="address" id="address"></textarea>
                    </div>
                    <div class="field-container">
                      <label for="">Which countries driving license do you have</label>
                      <input value="" type="text" class="field-input" placeholder="" id="wcd" name="wcd" >
                    </div>
                </div>
                <div class="grid-fields">
                  <div class="field-container">
                    <label for="">Phone Number*</label>
                    <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="field-input" placeholder="Mobile"  maxlength="10" id="phone" name="phone" required>
                    <small class="field-msg error" data-error="invalidMobile">The Mobile number is not valid</small>
                  </div> 
                  <div class="field-container">
                    <label for="">Whatsapp Number*</label>
                    <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="field-input" placeholder="Mobile"  maxlength="10" id="wphone" name="wphone" required>
                    <small class="field-msg error" data-error="invalidMobile">The Mobile number is not valid</small>
                  </div>   
                  <div class="field-container">
                    <label for="">Email ID*</label>
                    <input value="" type="text" class="field-input" placeholder="Email" id="adult" name="email" required>
                    <small class="field-msg error" data-error="invalidEmail">Your Email is Required</small>
                  </div>
                  <b class="form-sub-header">Passport Details</b>
                  <div class="field-container">
                    <label for="">Passport No</label>
                    <input value="" type="text" class="field-input" placeholder="" id="pno" name="pno" >
                  </div>
                  <div class="field-container">
                    <label for="">Place of Issue</label>
                    <input value="" type="text" class="field-input" placeholder="" id="dissue" name="dissue" >
                  </div>
                  <div class="field-container">
                    <label for="">Date of Issue</label>
                    <input value="" type="text" class="field-input" placeholder="" id="pissue" name="pissue" >
                  </div>
                  <div class="field-container">
                    <label for="">Expiry Date</label>
                    <input value="" type="text" class="field-input" placeholder="" id="exdate" name="exdate" >
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
/**
 * Save File Function
 * Handles file upload securely by sending it to the server via POST.
 */
async function saveFile() {
    try {
        const fileInput = document.getElementById('fileupload');
        if (!fileInput || !fileInput.files.length) return;

        const formData = new FormData();
        formData.append("file", fileInput.files[0]);

        const response = await fetch('<?php echo plugin_dir_url(__FILE__); ?>/upload.php', {
            method: "POST",
            body: formData,
        });

        if (!response.ok) {
            throw new Error('File upload failed');
        }

        const result = await response.json();
        document.getElementById('cv').value = result.image_source;
        document.getElementById('cvpath').value = result.image_path;
    } catch (error) {
        console.error("Error during file upload:", error);
        alert("Failed to upload file. Please try again.");
    }
}

/**
 * Clear All Field Messages
 * Hides all error or success messages for fields.
 */
function clearFieldMessages() {
    document.querySelectorAll(".field-msg").forEach((msg) => msg.classList.remove("show"));
}

/**
 * Validate Email Address
 * Returns true if the email format is valid.
 */
function validateEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(String(email).toLowerCase());
}

/**
 * Submit Form Function
 * Validates form input, shows appropriate messages, and sends the form data to the server.
 */
async function submitForm(event) {
    event.preventDefault();
    clearFieldMessages();

    const form = document.getElementById("zon-testimonial-form");
    if (!form) return;

    // Collect form data
    const formData = {
        name: form.querySelector('[name="name"]').value.trim(),
        email: form.querySelector('[name="email"]').value.trim(),
        phone: form.querySelector('[name="phone"]').value.trim(),

        wphone: form.querySelector('[name="wphone"]').value.trim(),
        age: form.querySelector('[name="age"]').value.trim(),
        address: form.querySelector('[name="address"]').value.trim(),
        qualifications: form.querySelector('[name="qualifications"]').value.trim(),
        expabroad: form.querySelector('[name="expabroad"]').value.trim(),
        expind: form.querySelector('[name="expind"]').value.trim(),
        address: form.querySelector('[name="address"]').value.trim(),
        wcd: form.querySelector('[name="wcd"]').value.trim(),

        cv: form.querySelector('[name="cv"]').value.trim(),
        pno: form.querySelector('[name="pno"]').value.trim(),
        pissue: form.querySelector('[name="pissue"]').value.trim(),
        dissue: form.querySelector('[name="dissue"]').value.trim(),
        exdate: form.querySelector('[name="exdate"]').value.trim(),

        cvpath: form.querySelector('[name="cvpath"]').value.trim(),
        jobtitle: form.querySelector('[name="jobtitle"]').value.trim(),
        nonce: form.querySelector('[name="nonce"]').value,
    };

    // Input Validation
    if (!formData.name) {
        form.querySelector('[data-error="invalidName"]').classList.add("show");
        return;
    }
    if (!validateEmail(formData.email)) {
        form.querySelector('[data-error="invalidEmail"]').classList.add("show");
        return;
    }

    // Save File First
    await saveFile();

    // Prepare and send form data
    const submissionURL = form.dataset.url;
    const requestData = new URLSearchParams(new FormData(form));

    try {
        form.querySelector(".js-form-submission").classList.add("show");

        const response = await fetch(submissionURL, {
            method: "POST",
            body: requestData,
        });

        const result = await response.json();

        clearFieldMessages();
        if (response.ok && result.status !== "error") {
            form.querySelector(".js-form-success").classList.add("show");
            form.reset();
        } else {
            throw new Error("Form submission error");
        }
    } catch (error) {
        clearFieldMessages();
        form.querySelector(".js-form-error").classList.add("show");
        console.error("Form submission error:", error);
    }
}

/**
 * Initialize Form Submission Event
 */
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("zon-testimonial-form");
    if (form) {
        form.addEventListener("submit", submitForm);
    }
});
</script>
