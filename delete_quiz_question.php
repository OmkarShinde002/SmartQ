<?php
include('header.php');
include('session.php');

if (isset($_POST['selector']) && is_array($_POST['selector'])) {
    $id = $_POST['selector'];
    $N = count($id);

    for ($i = 0; $i < $N; $i++) {
        $result = mysqli_query($conn, "DELETE FROM quiz_question WHERE quiz_question_id='$id[$i]'") or die(mysqli_error($conn));
    }

    header("location: quiz_question.php");
} else {
    echo "No questions selected for deletion.";
}
?>
