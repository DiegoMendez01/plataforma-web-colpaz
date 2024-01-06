<?php
require_once("../../config/connection.php");

// Assuming you have a UserCourses class or a similar class to handle course-related functionality
require_once("../../models/UserCourses.php");
$userCourses = new UserCourses();

// Assuming there's a method to fetch user courses, adjust the method name accordingly
$userCoursesData = $userCourses->getUserCourses();

?>

<!DOCTYPE html>
<html>

<head lang="es">
    <!-- Head content remains unchanged -->
</head>

<body>
    <div class="page-center" style="height: 100vh; display: flex; justify-content: center; align-items: center; background-image: url('../../public/img/fondoLogin.png'); background-size: cover; background-repeat: no-repeat;">
        <div class="page-center-in" style="width: 71vh;">
            <div class="container-fluid">
                <div class="user-courses-box">
                    <header class="user-courses-title">Mis Cursos</header>
                    
                    <!-- Display user courses -->
                    <?php foreach ($userCoursesData as $course): ?>
                        <div class="course-item">
                            <h4><?php echo $course['course_name']; ?></h4>
                            <p><?php echo $course['description']; ?></p>
                            <!-- Add more details as needed -->
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
    <!--.page-center-->

    <script src="../../public/js/lib/jquery/jquery.min.js"></script>
    <script src="../../public/js/lib/tether/tether.min.js"></script>
    <script src="../../public/js/lib/bootstrap/bootstrap.min.js"></script>
    <script src="../../public/js/plugins.js"></script>
    <script type="text/javascript" src="../../public/js/lib/match-height/jquery.matchHeight.min.js"></script>
    <script src="../../public/js/app.js"></script>
</body>

</html>
