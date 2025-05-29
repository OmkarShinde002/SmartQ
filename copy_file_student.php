<?php
include('admin/dbcon.php');
include('session.php');

if (isset($_POST['delete_user']) && isset($_POST['selector'])) {
    $id = $_POST['selector'];
    $N = count($id);

    for ($i = 0; $i < $N; $i++) {
        $result = mysqli_query($conn, "SELECT * FROM files WHERE file_id = '{$id[$i]}'") or die(mysqli_error());

        while ($row = mysqli_fetch_array($result)) {
            $fname = $row['fname'];
            $floc = $row['floc'];
            $fdesc = $row['fdesc'];
            $teacher_id = $row['teacher_id'];

            mysqli_query($conn, "INSERT INTO student_backpack (floc, fdatein, fdesc, student_id, fname) 
                VALUES ('$floc', NOW(), '$fdesc', '$session_id', '$fname')") or die(mysqli_error());
        }
    }
    ?>
    <script>
        window.location = 'backpack.php';
    </script>
    <?php
} else {
    ?>
    <script>
        alert('No files selected.');
        window.location = 'backpack.php';
    </script>
    <?php
}
?>
