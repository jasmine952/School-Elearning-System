<?php
$up_id = $_GET['up_id'];

include('header.php');
include('session.php');
$user_query = mysqli_query($conn, "select * from files where file_id='$up_id'") or die(mysqli_error($conn));
$file_row = mysqli_fetch_array($user_query);

if (mysqli_num_rows($user_query) != 1) {
    die("Access To This Record Is Denied");
}
$redirect_id = $file_row['class_id'];
$comment_query = mysqli_query($conn, "SELECT * from comments where upload_id = '$up_id'");
?>


<?php
if (isset($_POST['response'])) {
    $response = $_POST['response'];
    $id = $_POST['upload_id'];
    $response = mysqli_real_escape_string($conn, $response);
    $update = mysqli_query($conn, "UPDATE comments SET response = '$response' WHERE id = '$id' ");
    if ($update) {
        echo "<script>alert('Response Updated!'); </script>";
    } else {
        echo "<script>alert('Error occurred while updating. Please try again!'); </script>";
    }
}


$comment_query = mysqli_query($conn, "SELECT * from comments where upload_id = '$up_id'");

?>

<body>

    <?php include('navhead_user.php'); ?>

    <div class="container">
        <div class="row-fluid">
            <div class="span3">
                <div class="hero-unit-3">
                    <div class="alert-index alert-success">
                        <i class="icon-calendar icon-large"></i>
                        <?php
                        $Today = date('y:m:d');
                        $new = date('l, F d, Y', strtotime($Today));
                        echo $new;
                        ?>
                    </div>
                </div>
                <div class="hero-unit-1">
                    <ul class="nav  nav-pills nav-stacked">
                        <li class="nav-header">Links</li>
                        <li>
                            <a href="teacher_home.php"><i class="icon-home icon-large"></i>&nbsp;Home
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-large"></i>
                                </div>
                            </a>

                        </li>
                        <li class="active">
                            <a href="teacher_class.php"><i class="icon-group icon-large"></i>&nbsp;Class
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-large"></i>
                                </div>
                            </a>
                        </li>
                        <li><a href="teacher_subject.php"><i class="icon-file-alt icon-large"></i>&nbsp;Courses
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-large"></i>
                                </div>
                            </a></li>
                        <li><a href="students.php"><i class="icon-group icon-large"></i>&nbsp;Students
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-large"></i>
                                </div>
                            </a></li>


                    </ul>
                </div>

            </div>
            <div class="span9">

                <a href="class.php?id=<?php echo $redirect_id ?>" class="btn btn-success"><i
                        class="icon-arrow-left"></i>&nbsp;Back</a>
                <br><br>
                <div class="alert alert-info center" align='center'>

                    <a href="<?php echo $file_row['floc']; ?>" class="btn btn-primary pull-left">Download Upload
                        File</a>



                    <br>
                    <hr>
                    <?php echo $file_row['fname'] ?> - <?php echo $file_row['fdatein'] ?>
                    <hr>
                    <?php echo $file_row['fdesc'] ?>
                    <?php

                    $base = pathinfo($file_row['floc'], PATHINFO_EXTENSION);
                    if (in_array($base, array('mp4', '3gp', 'avi', 'flv', 'mov', 'mpeg', 'mkv'))) {
                        echo "<hr/>";
                    ?>

                    <video controls>
                        <source src="<?php echo $file_row['floc'] ?>" type="video/<?php echo $base ?>">
                    </video>
                    <?php
                    }
                    ?>

                </div>

                <div class="hero-unit-3">
                    <?php
                    if (mysqli_num_rows($comment_query) < 1) {
                        echo "No Comments Made Yet For This Upload";
                    } else {
                        // Display Comments
                        while ($comment_row = mysqli_fetch_array($comment_query)) {
                            $id = $comment_row['id'];

                    ?>

                    <div class="hero-unit-3">
                        <div class="alert alert-info"><b>From :</b> <?php

                                                                            $student =  mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM student WHERE student_id = '$comment_row[student_id]'"));
                                                                            $name =  $student['lastname'] . ", " . $student['firstname'];

                                                                            echo $name, " <b><i>On</i></b> ", $comment_row['stamp'];

                                                                            ?> - <a
                                href="#reply<?php echo $comment_row['id']; ?>" role="button" data-toggle="modal"
                                class="btn btn-success pull-right"><i class="icon-reply"></i></a></div>
                        <p>
                            <?php echo $comment_row['comment'] ?>
                            <hr>Response :
                            <?php $r = $comment_row['response'];
                                    if (strlen($r) < 1)
                                        echo " - - - - - - - ";
                                    else echo $r;
                                    ?>

                        </p>
                    </div>

                    <div id="reply<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <form method="post" action="">
                            <div class="modal-header">
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-info center" style="align-items: center; align-content: center;"
                                    align="center">Give a response to this comment (Not a must)
                                </div>
                                <input type="hidden" name="upload_id" value="<?php echo $id; ?>">

                                <div class="control-group">
                                    <textarea name="response" required minlength="4" class="input-block-level"
                                        rows="10"><?php echo $comment_row['response'] ?></textarea>
                                </div>

                            </div>
                            <div class="modal-footer">

                                <button class="btn" data-dismiss="modal" aria-hidden="true"><i
                                        class="icon-remove icon-large"></i>&nbsp;Close</button>

                                <button class="btn btn-primary" type="submit"><i
                                        class="icon-trash icon-large"></i>&nbsp;Submit</button>
                            </div>
                        </form>
                    </div>
                    <?php
                        }
                    }
                    ?>
                    <!-- end slider -->
                </div>
            </div>

            <div id="<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true">
                <form method="post" action="add_comment.php">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">Add Your Comment (This is seen by others)</div>
                        <input type="hidden" name="upload_id" value="<?php echo $up_id; ?>">

                        <input type="hidden" name="student_id" value="<?php echo $_SESSION['id']; ?>">
                        <div class="control-group">
                            <textarea name="comment" required minlength="4" class="input-block-level"
                                rows="10"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">

                        <button class="btn" data-dismiss="modal" aria-hidden="true"><i
                                class="icon-remove icon-large"></i>&nbsp;Close</button>

                        <button class="btn btn-primary" type="submit"><i
                                class="icon-trash icon-large"></i>&nbsp;Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </div>
    </div>
    </div>






</body>

</html>