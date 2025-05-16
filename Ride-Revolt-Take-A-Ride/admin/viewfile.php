<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if the user is logged in
if(strlen($_SESSION['login']) == 0){
    header('location:index.php');
    exit;
}

if(isset($_GET['type']) && ($_GET['type'] == 'adhar' || $_GET['type'] == 'licence')) {
    $email = $_SESSION['login'];
    $fileType = $_GET['type'];

    // Determine the file column based on 'type'
    $fileColumn = ($fileType == 'adhar') ? 'AdharCardFile' : 'DRLicenceFile';

    // Prepare the SQL query to fetch the file
    $sql = "SELECT $fileColumn FROM tblusers WHERE EmailId = :email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();

    // Fetch the file data
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Set the content-type based on the file type
        if ($fileType == 'adhar') {
            header('Content-Type: application/pdf'); // Assuming the Adhar file is a PDF
        } else {
            header('Content-Type: application/pdf'); // Assuming the Licence file is a PDF
        }

        // Output the file content
        echo $result[$fileColumn];
    } else {
        echo "File not found!";
    }
} else {
    echo "Invalid file type!";
}
?>
