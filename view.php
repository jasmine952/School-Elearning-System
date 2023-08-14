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


<body>

    <?php include('navhead_student.php'); ?>

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
                            <a href="student_home.php"><i class="icon-home icon-large"></i>&nbsp;Home
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-large"></i>
                                </div>
                            </a>

                        </li>
                        <li class="active">
                            <a href="student_class.php"><i class="icon-group icon-large"></i>&nbsp;Class
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-large"></i>
                                </div>
                            </a>
                        </li>




                    </ul>
                </div>

            </div>
            <div class="span9">

                <a href="class_student.php?id=<?php echo $redirect_id ?>" class="btn btn-success"><i
                        class="icon-arrow-left"></i>&nbsp;Back</a>
                <br><br>
                <div class="alert alert-info center" align='center'><a href="<?php echo $file_row['floc']; ?>"
                        class="btn btn-primary pull-left">Download Upload
                        File</a> - <a href="#new" role="button" data-toggle="modal"
                        class="btn btn-danger pull-right">Add Comment</a>
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
                    ?>

                    <div class="hero-unit-3">
                        <div class="alert alert-info"><b>From :</b> <?php

                                                                            $student =  mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM student WHERE student_id = '$comment_row[student_id]'"));
                                                                            $name =  $student['lastname'] . ", " . $student['firstname'];
                                                                            if ($_SESSION['id'] == $comment_row['student_id']) {
                                                                                $name  = " Me ";
                                                                            }
                                                                            echo $name, " <b><i>On</i></b> ", $comment_row['stamp'];

                                                                            ?></div>
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
                    <?php

                        }
                    }
                    ?>
                    <!-- end slider -->
                </div>
            </div>

            <div id="new" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
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