<?php
include('includes/config.php');

if (isset($_POST['signup'])) {
    $fname = $_POST['fullname'];
    $email = $_POST['emailid'];
    $mobile = $_POST['mobileno'];
    $adharno = $_POST['adharno'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if Aadhar already exists
    $sql_check = "SELECT id FROM tblusers WHERE AdharNo = :adharno";
    $query_check = $dbh->prepare($sql_check);
    $query_check->bindParam(':adharno', $adharno, PDO::PARAM_STR);
    $query_check->execute();

    if ($query_check->rowCount() > 0) {
        echo "<script>alert('Account already exists with this Aadhar number.');</script>";
    } else {
        // Proceed with registration
        $sql = "INSERT INTO tblusers(FullName, EmailId, ContactNo, Password, AdharNo) 
                VALUES(:fname, :email, :mobile, :password, :adharno)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':adharno', $adharno, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if ($lastInsertId) {
            echo "<script>alert('Registration successful. Now you can login');</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    }
}
?>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- JS: Check Email Availability -->
<script>
function checkEmailAvailability() {
    $("#loaderIcon").show();
    $.ajax({
        url: "check_availability.php",
        data: 'emailid=' + $("#emailid").val(),
        type: "POST",
        success: function (data) {
            $("#user-availability-status").html(data);
            toggleSubmitButton();
            $("#loaderIcon").hide();
        }
    });
}
</script>

<!-- JS: Check Aadhar Availability -->
<script>
function checkAadharAvailability() {
    $("#loaderIcon").show();
    $.ajax({
        url: "check_availability.php",
        data: 'adharno=' + $("#adharno").val(),
        type: "POST",
        success: function (data) {
            $("#aadhar-availability-status").html(data);
            toggleSubmitButton();
            $("#loaderIcon").hide();
        }
    });
}
</script>

<!-- JS: Password Strength Check -->
<script>
function checkPasswordStrength() {
    const password = document.signup.password.value;
    const msg = document.getElementById('password-strength-message');
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    if (!regex.test(password)) {
        msg.style.color = 'red';
        msg.innerHTML = 'Password must be at least 8 characters, include one uppercase, lowercase, number & special character.';
        $('#submit').prop('disabled', true);
    } else {
        msg.style.color = 'green';
        msg.innerHTML = 'Password is strong.';
        toggleSubmitButton();
    }
}
</script>

<!-- JS: Password Match Validation -->
<script>
function valid() {
    if (document.signup.password.value !== document.signup.confirmpassword.value) {
        alert("Password and Confirm Password do not match!");
        document.signup.confirmpassword.focus();
        return false;
    }
    return true;
}
</script>

<!-- JS: Enable/Disable Submit -->
<script>
function toggleSubmitButton() {
    const emailStatus = $("#user-availability-status").text().trim();
    const aadharStatus = $("#aadhar-availability-status").text().trim();
    const passwordMessage = $("#password-strength-message").text().trim();

    if (
        emailStatus === 'Email already registered' ||
        aadharStatus === 'Aadhar already registered' ||
        passwordMessage !== 'Password is strong.'
    ) {
        $('#submit').prop('disabled', true);
    } else {
        $('#submit').prop('disabled', false);
    }
}
</script>

<!-- JS: Toggle Password Eye Icon -->
<script>
function togglePassword() {
    const pwdField = document.getElementById("password");
    const eyeIcon = document.getElementById("togglePasswordIcon");
    if (pwdField.type === "password") {
        pwdField.type = "text";
        eyeIcon.textContent = "🙈"; // eye-off icon
    } else {
        pwdField.type = "password";
        eyeIcon.textContent = "👁️"; // eye icon
    }
}
</script>

<!-- CSS for eye icon -->
<style>
.password-wrapper {
    position: relative;
}
.password-wrapper input {
    width: 100%;
    padding-right: 40px;
}
.toggle-eye {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 18px;
}
</style>

<!-- Signup Modal Form -->
<div class="modal fade" id="signupform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Sign Up</h3>
      </div>
      <div class="modal-body">
        <form method="post" name="signup" onSubmit="return valid();">
          <div class="form-group">
            <input type="text" class="form-control" name="fullname" placeholder="Full Name" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="mobileno" placeholder="Mobile Number" maxlength="10" required>
          </div>
          <div class="form-group">
            <input type="email" class="form-control" name="emailid" id="emailid" placeholder="Email Address" onBlur="checkEmailAvailability()" required>
            <span id="user-availability-status" style="font-size:12px;"></span>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="adharno" id="adharno" placeholder="Aadhar Number" maxlength="12" onBlur="checkAadharAvailability()" required>
            <span id="aadhar-availability-status" style="font-size:12px;"></span>
          </div>
          <div class="form-group password-wrapper">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" onKeyUp="checkPasswordStrength()" required>
            <span class="toggle-eye" id="togglePasswordIcon" onclick="togglePassword()">👁️</span>
            <span id="password-strength-message" style="font-size:12px;"></span>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm Password" required>
          </div>
          <div class="form-group checkbox">
            <input type="checkbox" id="terms_agree" required checked>
            <label for="terms_agree">I Agree with <a href="#">Terms and Conditions</a></label>
          </div>
          <div class="form-group">
            <input type="submit" value="Sign Up" name="signup" id="submit" class="btn btn-block btn-primary" disabled>
          </div>
        </form>
      </div>
      <div class="modal-footer text-center">
        <p>Already got an account? <a href="#loginform" data-toggle="modal" data-dismiss="modal">Login Here</a></p>
      </div>
    </div>
  </div>
</div>
