<?php
session_start();
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; // Password input

    // SQL query to check if the email exists in the database
    $sql = "SELECT EmailId, Password, FullName FROM tblusers WHERE EmailId = :email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();

    $results = $query->fetch(PDO::FETCH_OBJ); // Fetch single user record

    if ($query->rowCount() > 0) {
        // Check if the password entered matches the hash stored in the database
        if (password_verify($password, $results->Password)) {
            // Password is correct
            $_SESSION['login'] = $email;
            $_SESSION['fname'] = $results->FullName;

            // Redirect to the current page after login
            $currentpage = $_SERVER['REQUEST_URI'];
            echo "<script type='text/javascript'> document.location = '$currentpage'; </script>";
        } else {
            echo "<script>alert('Invalid Password');</script>"; // Invalid password
        }
    } else {
        echo "<script>alert('Invalid Email');</script>"; // Invalid email
    }
}
?>

<!-- Login Modal HTML -->
<div class="modal fade" id="loginform">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Login</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="login_wrap">
                        <div class="col-md-12 col-sm-6">
                            <form method="post">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="Email address*" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="Password*" required>
                                </div>
                                <div class="form-group checkbox">
                                    <input type="checkbox" id="remember"> Remember Me
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="login" value="Login" class="btn btn-block btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <p>Don't have an account? <a href="#signupform" data-toggle="modal" data-dismiss="modal">Signup Here</a></p>
                <p><a href="#forgotpassword" data-toggle="modal" data-dismiss="modal">Forgot Password?</a></p>
            </div>
        </div>
    </div>
</div>
