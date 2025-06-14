<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('session.php');
require("opener_db.php");
$conn = $connector->DbConnector();

$name = mysqli_real_escape_string($conn, $_POST['name']);
$filedesc = mysqli_real_escape_string($conn, $_POST['desc']);
$input_name = basename($_FILES['uploaded_file']['name']);

if ($input_name == "") {
    $id = $_POST['selector'];
    $N = count($id);
    for ($i = 0; $i < $N; $i++) {
        mysqli_query($conn, "INSERT INTO assignment (fdesc, fdatein, teacher_id, class_id) 
            VALUES ('$filedesc', NOW(), '$session_id', '$id[$i]')") or die(mysqli_error($conn));
        
        mysqli_query($conn, "INSERT INTO notification (teacher_class_id, date_of_notification, link) 
            VALUES ('$id[$i]', NOW(), 'assignment_student.php')") or die(mysqli_error($conn));
    }
    echo "success";
} else {
    $rd2 = mt_rand(1000, 9999) . "_File";
    $filename = basename($_FILES['uploaded_file']['name']);
    $ext = substr($filename, strrpos($filename, '.') + 1);

    // Validate file extension
    $allowed_ext = ['pdf', 'docx', 'pptx', 'txt', 'zip'];
    if (!in_array(strtolower($ext), $allowed_ext)) {
        echo "Invalid file type.";
        exit;
    }

    $newname = "admin/uploads/" . $rd2 . "_" . $filename;
    $name_notification = 'Add Assignment file name <b>' . $name . '</b>';

    if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $newname)) {
        $id = $_POST['selector'];
        $N = count($id);
        for ($i = 0; $i < $N; $i++) {
            mysqli_query($conn, "INSERT INTO assignment (fdesc, floc, fdatein, teacher_id, fname, class_id) 
                VALUES ('$filedesc', '$newname', NOW(), '$session_id', '$name', '$id[$i]')") or die(mysqli_error($conn));

            mysqli_query($conn, "INSERT INTO notification (teacher_class_id, notification, date_of_notification, link) 
                VALUES ('$id[$i]', '$name_notification', NOW(), 'assignment_student.php')") or die(mysqli_error($conn));
        }
        echo "success";
    } else {
        echo "File upload failed.";
    }
}
?>
