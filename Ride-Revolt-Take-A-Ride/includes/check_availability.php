<?php
include('includes/config.php');

if (!empty($_POST["emailid"])) {
    $email = $_POST["emailid"];
    $sql = "SELECT id FROM tblusers WHERE EmailId = :email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        echo "<span style='color:red'>Email already registered</span>";
    } else {
        echo "<span style='color:green'>Email available</span>";
    }
}

if (!empty($_POST["adharno"])) {
    $adhar = $_POST["adharno"];
    $sql = "SELECT id FROM tblusers WHERE AdharNo = :adhar";
    $query = $dbh->prepare($sql);
    $query->bindParam(':adhar', $adhar, PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        echo "<span style='color:red'>Aadhar already registered</span>";
    } else {
        echo "<span style='color:green'>Aadhar available</span>";
    }
}
?>
