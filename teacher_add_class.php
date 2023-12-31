<?php
include('header.php');
include('session.php');
$user_query = mysqli_query($conn, "select * from teacher where teacher_id='$session_id'") or die(mysqli_error($conn));
$user_row = mysqli_fetch_array($user_query);
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





                <a href="teacher_class.php" class="btn btn-success"><i class="icon-arrow-left icon-large"></i>&nbsp;Back</a>
                <br>
                <br>

                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><i class="icon-user icon-large"></i>&nbsp;Add Class</strong>
                </div>
                <div class="hero-unit-2">
                    <form class="form-horizontal" method="POST">
                        <div class="control-group">
                            <label class="control-label" for="inputEmail">Class</label>
                            <div class="controls">

                                <select name="cys" class="span5" required>
                                    <option></option>
                                    <?php
                                    $query = mysqli_query($conn, "select * from course") or die(mysqli_error($conn));
                                    while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                        <option><?php echo $row['cys']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputEmail">Subject</label>
                            <div class="controls">

                                <select name="subject" class="span6" required>
                                    <option></option>
                                    <?php
                                    $teacher_subject_query = mysqli_query($conn, "select * from teacher_suject") or die(mysqli_error($conn));
                                    $teacher_row = mysqli_fetch_array($teacher_subject_query);
                                    $subject_id = $teacher_row['subject_id'];

                                    $query = mysqli_query($conn, "select * from subject where subject_id in (select subject_id from teacher_suject)") or die(mysqli_error($conn));
                                    while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                        <option><?php echo $row['subject_title']; ?></option>
                                    <?php } ?>
                                    <input type="hidden" name="teacher_id" value="<?php echo $session_id; ?>">
                                </select>
                            </div>
                        </div>




                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" name="save_class" class="btn btn-success"><i class="icon-plus-sign icon-large"></i>&nbsp;Add Class</button>
                            </div>
                            <?php
                            if (isset($_POST['save_class'])) {

                                $subject = $_POST['subject'];
                                $cys = $_POST['cys'];
                                $teacher_id = $_POST['teacher_id'];

                                mysqli_query($conn, "insert into class (subject_id,course_id,teacher_id) values('$subject','$cys','$teacher_id')") or die(mysqli_error($conn));
                                echo ('<script>location.href = "teacher_class.php"</script>');
                            }
                            ?>
                        </div>
                    </form>
                </div>




                <!-- end slider -->
            </div>

        </div>
        <?php include('footer.php'); ?>
    </div>
    </div>
    </div>






</body>

</html>