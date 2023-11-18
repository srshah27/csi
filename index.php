<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/csi-logo.png">
    <link rel="stylesheet" href="plugins/bootstrap-4.6.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <title>CSI</title>
    <?php
    session_start();
    require_once "config.php";
    // Fetching Access Details
    $access = NULL;
    if (isset($_SESSION["role_id"])) {
        $role_id = $_SESSION["role_id"];
        $access = getValue("SELECT * FROM `csi_role` WHERE `csi_role`.`id`=$role_id");
    }
    ?>
</head>

<body>
    <!-- Navbar -->
    <?php require "usernavbar.php"; ?>
    <!-- Navbar -->

    <!-- Landing  -->
    <section class="home">
        <div class="container text-center">
            <div class="home-heading">
                <img src="images/logo.png" alt="" class="homelogo ">
                <h3>"Building Technical skills professionally"</h3>
            </div>
        </div>
    </section>
    <!-- Landing  -->

    <!--Event Timer  -->
    <?php
    $data;
    $queryNextEvent = execute("SELECT `id`, `title`, `e_from_date`,  `e_from_time` FROM `csi_event` WHERE `live`='1'");
    while ($rowNextEvent = mysqli_fetch_assoc($queryNextEvent)) {
        if ((date("Y-m-d", strtotime($rowNextEvent['e_from_date'])) > date("Y-m-d", strtotime("now"))) && (isset($data) ? (date("Y-m-d", strtotime($rowNextEvent['e_from_date'])) <= date("Y-m-d", strtotime($data['e_from_date']))) : true)) {
            $data = $rowNextEvent;
        } else if (date("Y-m-d", strtotime($rowNextEvent["e_from_date"])) == date("Y-m-d", strtotime("now"))) {
            if ((date("H:i:s", strtotime($rowNextEvent['e_from_time'])) > date("H:i:s", strtotime("now"))) && (isset($data) ? (date(" H:i:s", strtotime($rowNextEvent['e_from_time'])) < date(" H:i:s", strtotime($data['e_from_time']))) : true)) {
                $data = $rowNextEvent;
            }
        }
    }
    if (isset($data)) {
    ?>
        <!-- Event Timer -->
        <section class="event_time_area">
            <div class="container">
                <div class="event_time_inner">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="event_text">
                                <h3>Next Event will Start in</h3>
                                <p><?php echo $data['title']; ?></p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="timer_inner">
                                <div id="timer" class="timer">
                                    <input type="hidden" id="next_event" value="<?php echo (date("M d, Y", strtotime($data['e_from_date']))) . (date(" H:i:s", strtotime($data['e_from_time']))); ?>">
                                    <div class="timer__section days">
                                        <div class="timer__number" id="days"></div>
                                        <div class="timer__label">days</div>
                                    </div>
                                    <div class="timer__section hours">
                                        <div class="timer__number" id="hours"></div>
                                        <div class="timer__label">hours</div>
                                    </div>
                                    <div class="timer__section minutes">
                                        <div class="timer__number" id="minutes"></div>
                                        <div class="timer__label">Minutes</div>
                                    </div>
                                    <div class="timer__section seconds">
                                        <div class="timer__number" id="seconds"></div>
                                        <div class="timer__label">seconds</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Event Timer  -->
    <?php
    }
    ?>

    <!-- About US  -->
    <section id="about" class="p_120">
        <div class="container">
            <div class="welcome row">
                <?php
                // query for image and description in about us section 
                $rowaboutus = getValue("SELECT * FROM `csi_aboutus`");
                ?>
                <div class="col-lg-5">
                    <div class="">
                        <img src="AboutUs/<?php echo $rowaboutus['photo']; ?>" alt="About US - Image" class="img-fluid about_img">
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="welcome_text">
                        <h3>Welcome to CSI SAKEC</h3>
                        <p><?php echo $rowaboutus['description']; ?></p>
                        <?php
                        if (isset($access) && $access['main_page_edit'] == "1") {
                        ?>
                            <a class="btn main_btn_gradient" href="About.php">Edit About US</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About US  -->

    <!-- Magazine -->
    <section id="magzine" class="p_120">
        <div class="container">
            <div class="welcome row m">
                <div class="col-lg-6 offset-lg-1">
                    <div class="welcome_text">
                        <h3>CACHE V10.0</h3>
                        <p>The CSI-SAKEC Editorial team is proud to announce the release of the latest issue of our annual magazine – Cache 10.0. As most of you are aware, our theme for the year 2020-2021 is ‘Healthcare Technology’. Why did we plump for this topic? Healthcare technology is the topic of current interest, and with the scenario today worldwide, this subdomain of technology was a clear win. Healthcare technology includes electronic health records, tele-medicine, mHealth, remote health monitoring tools, prosthetics, and much more. The field also intersects with artificial intelligence and virtual reality, which clearly indicates the vastness of the topic. Cache 10.0 provides you with an opportunity to have a brief insight into the advancements of the field, by assembling the some of the most exciting updates in healthcare technology. The magazine is loaded with brilliant technical articles, submitted by our very own SAKEC members! </p>
                        <p>CAUTION: THE MAGAZINE IS A REAL FIXATION. BEWARE!</p>
                        <a class="btn main_btn_gradient" href="CACHE_V10.0.pdf">See Our Magazine </a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="">
                        <img src="images\magzine.jpg" alt="Magzine" class="img-fluid about_img" target="_blank">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Magazine -->

    <!-- Our Team  -->
    <section id="team" class="team_area p_120">
        <div class="container">
            <div class="main_title">
                <h2>OUR CSI SAKEC TEAM</h2>
                <?php
                if (isset($_SESSION['email']) && isset($access) && $access['main_page_edit'] == 1) {
                ?>
                    <a class="btn main_btn_gradient" href="coordinator.php">Edit Team</a>
                <?php
                }
                ?>
            </div>
            <div class="spacer" style="height:45px;"></div>

            <?php
            $querycoordinator = execute("SELECT  name, r.role_name as duty, c.image as image
                                        FROM `csi_coordinator` as c, `csi_userdata` as u,`csi_role` as r
                                        WHERE c.user_id = u.id and u.role = r.id and (r.role_name like '%Coordinator%' || r.role_name = 'General Secretary' || r.role_name like '%Team%') ORDER BY `preference`");
            $number_of_coordinator = mysqli_num_rows($querycoordinator);
            // Will execute for no of coordinators
            while ($number_of_coordinator > 0) {
            ?>
                <div class="row team_inner">
                    <?php
                    // Will show 4 coordinators in same line for large
                    // TODO: change col-lg-3 and col-sm-6 if you need to change from 4 members in one row
                    for ($count = 0; $count < 4; $count++, $number_of_coordinator--) {
                        if ($number_of_coordinator == 0) {
                            break;
                        }
                        $rowcoordinator = mysqli_fetch_assoc($querycoordinator);

                    ?>
                        <div class="col-lg-3 col-sm-6">
                            <div class="team_item">
                                <div class="team_img"><img style="height:250px; width:auto;" src="<?php echo "Coordinator_Photo/" . trim($rowcoordinator['image']); ?>" alt=""></div>
                                <div class="team_name">
                                    <h4><?php echo $rowcoordinator['name']; ?></h4>
                                </div>
                                <p class="grey-text mb-3"><?php echo $rowcoordinator['duty']; ?></p>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="spacer" style="height:45px;"></div>
            <?php
            }
            ?>
        </div>
        <!-- <div class="container">
            <div class="main_title">
                <h2>OUR CSI SAKEC TEAM</h2>
                <a class="btn main_btn_gradient" href="coordinator.php">Edit Team</a>
            </div>
            <div class="spacer" style="height:45px;"></div>
            <div class="row team_inner">
                <div class="col-lg-3 col-sm-6">
                    <div class="team_item">
                        <div class="team_img"><img style="height:250px; width:auto;" src="CPO/DhruviJain_GeneralSecretary.jpeg" alt=""></div>
                        <div class="team_name">
                            <h4>Dhruvi Jain</h4>
                        </div>
                        <p class="grey-text mb-3">General Secretary</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="team_item">
                        <div class="team_img"><img style="height:250px; width:auto;" src="CPO/Yukta_Lapsiya_General_Coordinator.jpg" alt=""></div>
                        <div class="team_name">
                            <h4>Yukta Lapsiya</h4>
                        </div>
                        <p class="grey-text mb-3">General Coordinator</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="team_item">
                        <div class="team_img"><img style="height:250px; width:auto;" src="CPO/Pratik Upadhyay_Student_Coordinator.jpeg" alt=""></div>
                        <div class="team_name">
                            <h4>Pratik Upadhyay</h4>
                        </div>
                        <p class="grey-text mb-3">Student Coordinator</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="team_item">
                        <div class="team_img"><img style="height:250px; width:auto;" src="CPO/Preet_Karia_Events Head.jpg" alt=""></div>
                        <div class="team_name">
                            <h4>Preet Karia</h4>
                        </div>
                        <p class="grey-text mb-3">Event Head</p>
                    </div>
                </div>
            </div>
            <div class="spacer" style="height:45px;"></div>
            <div class="row team_inner">
                <div class="col-lg-3 col-sm-6">
                    <div class="team_item">
                        <div class="team_img"><img style="height:250px; width:auto;" src="CPO/Krutik_Patel_events cohead.jpg" alt=""></div>
                        <div class="team_name">
                            <h4>Krutik Patel</h4>
                        </div>
                        <p class="grey-text mb-3">Event Coordinator</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="team_item">
                        <div class="team_img"><img style="height:250px; width:auto;" src="CPO/Zarana_Desai_DocumentationHead.jpeg" alt=""></div>
                        <div class="team_name">
                            <h4>Zarana Desai</h4>
                        </div>
                        <p class="grey-text mb-3">Documentation Head</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="team_item">
                        <div class="team_img"><img style="height:250px; width:auto;" src="CPO/Parth_Panchal_Design-Head.jpg" alt=""></div>
                        <div class="team_name">
                            <h4>Parth Panchal</h4>
                        </div>
                        <p class="grey-text mb-3">Design Head</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="team_item">
                        <div class="team_img"><img style="height:250px; width:auto;" src="CPO/Aaryan_Mehta_Design_Co_Head.jpg" alt=""></div>
                        <div class="team_name">
                            <h4>Aaryan Mehta</h4>
                        </div>
                        <p class="grey-text mb-3">Design Coordinator</p>
                    </div>
                </div>
            </div>
            <div class="spacer" style="height:45px;"></div>
            <div class="row team_inner">
                <div class="col-lg-3 col-sm-6">
                    <div class="team_item">
                        <div class="team_img"><img style="height:250px; width:auto;" src="CPO/Bhavika_Salshingikar_Design_Co_Head.jpg" alt=""></div>
                        <div class="team_name">
                            <h4>Bhavika Salshingikar</h4>
                        </div>
                        <p class="grey-text mb-3">Design Coordinator </p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="team_item">
                        <div class="team_img"><img style="height:250px; width:auto;" src="CPO/Ritika_Boricha _Design_Co_Head.jpg" alt=""></div>
                        <div class="team_name">
                            <h4>Ritika Boricha</h4>
                        </div>
                        <p class="grey-text mb-3">Design Coordinator</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="team_item">
                        <div class="team_img"><img style="height:250px; width:auto;" src="CPO/Shalin_Gund_Registration_Head.jpg" alt=""></div>
                        <div class="team_name">
                            <h4>Shalin Gund</h4>
                        </div>
                        <p class="grey-text mb-3">Registration Head</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="team_item">
                        <div class="team_img"><img style="height:250px; width:auto;" src="CPO/Simran_Jindal_Registration Head.jpeg" alt=""></div>
                        <div class="team_name">
                            <h4>Simran Jindal</h4>
                        </div>
                        <p class="grey-text mb-3">Registration Head</p>
                    </div>
                </div>
            </div>
            <div class="spacer" style="height:45px;"></div>
            <div class="row team_inner">
                <div class="col-lg-3 col-sm-6">
                    <div class="team_item">
                        <div class="team_img"><img style="height:250px; width:auto;" src="CPO/Riddhi_Dagha_Treasurer.jpg" alt=""></div>
                        <div class="team_name">
                            <h4>Riddhi Dagha</h4>
                        </div>
                        <p class="grey-text mb-3">Treasurer</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="team_item">
                        <div class="team_img"><img style="height:250px; width:auto;" src="CPO/Aagam_Sheth_Technical Head.jpeg" alt=""></div>
                        <div class="team_name">
                            <h4>Aagam Sheth</h4>
                        </div>
                        <p class="grey-text mb-3">Technical Head</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="team_item">
                        <div class="team_img"><img style="height:250px; width:auto;" src="CPO/Rutvik_Deshpande_Technical_Co-Head.png" alt=""></div>
                        <div class="team_name">
                            <h4>Rutvik Deshpande</h4>
                        </div>
                        <p class="grey-text mb-3">Technical Coordinator</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="team_item">
                        <div class="team_img"><img style="height:250px; width:auto;" src="CPO/Ritik_Mahajan_Publicity_Head.jpg" alt=""></div>
                        <div class="team_name">
                            <h4>Ritik Mahajan</h4>
                        </div>
                        <p class="grey-text mb-3">Publicity Head</p>
                    </div>
                </div>
            </div>
            <div class="spacer" style="height:45px;"></div>
        </div> -->
    </section>
    <!-- Our Team  -->

    <!-- Total Likes, Registration and Event -->
    <?php
    $likes = getSpecificValue("SELECT COUNT(`csi_event_likes`.`id`) as `likes` FROM `csi_event_likes`", 'likes');
    $events = getSpecificValue("SELECT COUNT(`csi_event`.`id`)  `events` FROM `csi_event`", 'events');
    $registration  = getSpecificValue("SELECT COUNT(`csi_collection`.`id`)as `registration` FROM `csi_collection` WHERE `confirmed`='1'", 'registration');
    ?>
    <section class="event_time_area">
        <div class="container">
            <div class="count_inner">
                <div class="row">
                    <div class="col">
                        <button class="btn icon_btn"><i class="fas fa-thumbs-up fa-2x"></i></button>
                        <span class="counter"><?php echo $likes; ?></span>
                        <br>
                        Likes
                    </div>
                    <div class="col">
                        <button class="btn icon_btn"><i class="fas fa-calendar-check fa-2x"></i></button>
                        <span class="counter"><?php echo $events; ?></span>
                        <br>
                        Events
                    </div>
                    <div class="col">
                        <button class="btn icon_btn"><i class="fas fa-users fa-2x"></i></button>
                        <span class="counter"><?php echo $registration; ?></span>
                        <br>
                        Registration
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Total Likes, Registration and Event -->

    <!-- Events -->
    <section id="events" class="p_120">
        <div class="container">
            <div class="event_schedule_inner">
                <div class="tab" style="text-align: center;">
                    <button class="tablinks active" onclick="openCity(event, 'London')">Upcoming AND RECENT events</button>
                </div>
                <div id="London" class="tabcontent" style="display:block;">
                    <div class="row ">
                        <?php
                        date_default_timezone_set('Asia/Kolkata');
                        $currentdate = date("Y-m-d");
                        $queryevent = execute("SELECT * FROM csi_event where live = 1 ORDER BY e_from_date desc LIMIT 3");
                        if (mysqli_num_rows($queryevent) > 0) {
                            while ($rowevent = mysqli_fetch_assoc($queryevent)) {
                                if ($rowevent['live'] == 1) {
                                    $eventdate = date("d F Y", strtotime($rowevent['e_from_date']));
                        ?>
                                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                                        <div class="posts">
                                            <img src="<?php echo "Banner/" . trim($rowevent['banner']); ?>" alt="" class="img-fluid">
                                            <div class="blog-inner">
                                                <h2><?php echo $rowevent['title']; ?></h2>
                                                <div class="mh-blog-post-info">
                                                    <p>
                                                        <strong>Event on </strong>
                                                        <!-- <span class="event_date"> 24 </span>
                                                            <span class="event_date">April 2021</span> -->
                                                        <span class="event_date"><?php echo $eventdate; ?></span>
                                                    </p>
                                                </div>
                                                <p class="line-clamp">
                                                    <?php echo $rowevent['e_description']; ?>
                                                </p>
                                                <?php
                                                $event_id = $rowevent['id'];
                                                $email = NULL;
                                                if (isset($_SESSION['email']))
                                                    $email = $_SESSION['email'];
                                                $count = getSpecificValue("SELECT COUNT(user_id) as count FROM `csi_event_likes` where `event_id` = " . $rowevent['id'], 'count');
                                                $liked = getValue("SELECT COUNT(`csi_event_likes`.`id`) as count FROM `csi_event_likes`, `csi_userdata` WHERE `emailID` = '$email' AND `user_id`= `csi_userdata`.`id` AND`event_id` = '$event_id'");
                                                ?>
                                                <div class="likes" id="likes_<?php echo $event_id; ?>">
                                                    <?php
                                                    if ($liked['count'] == 0) {
                                                    ?>
                                                        <button class="btn icon_btn" name="like" value="<?php echo $event_id; ?>"><i class="far fa-thumbs-up fa-2x"></i></button>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <button class="btn icon_btn" name="unlike" value="<?php echo $event_id; ?>"><i class="fas fa-thumbs-up fa-2x"></i></button>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php echo $count; ?>
                                                </div>
                                                <form action="event.php" method="GET">
                                                    <input type="hidden" name="event_id" value="<?php echo $rowevent['id']; ?>">
                                                    <button class="btn main_btn_gradient bottom_post" type="submit">Read More</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="tab" style="text-align: center;">
                <a href="allevents.php" class="btn main_btn_gradient mt-5">All Events</a>
            </div>
        </div>
    </section>
    <!-- Event  -->

    <!-- Gallery  -->
    <section id="gallery" class="p_120">
        <div class="container">
            <div class="main_title">
                <h2>Gallery</h2>
                <?php
                if (isset($_SESSION['email']) && isset($access) && $access['main_page_edit'] == 1) {
                ?>
                    <a class="btn main_btn_gradient" href="Gallery_images/gallery.php">Edit Gallery</a>
                <?php
                }
                ?>
            </div>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php
                    $querygallery = execute("SELECT `image` FROM `csi_gallery` WHERE `status`=1");
                    $number_of_images_gallery = mysqli_num_rows($querygallery);
                    for ($i = 0; $i < $number_of_images_gallery; $i++) {
                    ?>
                        <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" <?php if ($i == 0) {
                                                                                                            echo 'class="active"';
                                                                                                        } ?>></li>
                    <?php
                    }
                    ?>
                </ol>
                <div class="carousel-inner">
                    <?php
                    for ($i = 0; $i < $number_of_images_gallery; $i++) {
                        $rowgallery = mysqli_fetch_assoc($querygallery);
                    ?>
                        <div class="carousel-item <?php if ($i == 0) {
                                                        echo "active";
                                                    } ?>">
                            <img class="d-block w-100" src="Gallery_Images/<?php echo $rowgallery['image']; ?>" alt="Error Photo Not Found">
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </section>
    <!-- Gallery  -->


    <!-- Javascript -->
    <script src="plugins/jquery.min.js"></script>
    <script src="plugins/bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/fontawesome-free-5.15.3-web/js/all.min.js"></script>
    <script src="plugins/waypoints.min.js"></script>
    <script src="plugins/counterup.min.js"></script>
    <script src="plugins/smtp.min.js"></script>
    <script src="plugins/google.gsi.client.js" async defer></script>
    <script src="plugins/jwt-decode.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/email.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', "button[name='like']", function() {
                var event_id = $(this).val();
                var email =
                    <?php
                    if (isset($_SESSION['email'])) {
                        echo '"' . $_SESSION['email'] . '"';
                    } else {
                        echo "null";
                    }
                    ?>;
                if (email !== null) {
                    $("#likes_" + event_id).load("likes.php", {
                        e_id: event_id,
                        increment: 1
                    });
                }
            });
            $(document).on('click', "button[name='unlike']", function() {
                var event_id = $(this).val();
                var email =
                    <?php
                    if (isset($_SESSION['email'])) {
                        echo '"' . $_SESSION['email'] . '"';
                    } else {
                        echo "null";
                    }
                    ?>;
                if (email !== null) {
                    $("#likes_" + event_id).load("likes.php", {
                        e_id: event_id,
                        increment: 0
                    });
                }
            });
            $('.counter').counterUp({
                delay: 100,
                time: 1000
            });
        });
    </script>
    <!-- Javascript -->
    <!-- Footer -->
    <?php require_once 'footer.php'; ?>
    <!-- Footer -->

</body>

</html>