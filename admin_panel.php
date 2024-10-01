<?php
include 'core/init.php';
include 'handle/handleNotifications.php';

$user_id = $_SESSION['user_id'];
$user = User::getData($user_id);
$who_users = Follow::whoToFollow($user_id);

// update notification count
User::updateNotifications($user_id);

$notify_count = User::CountNotification($user_id);
$notofication = User::notification($user_id);
// var_dump($notofication);
// die();
if (User::checkLogIn() === false)
    header('location: index.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications | TwitterClone</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/profile_style.css?v=<?php echo time(); ?>">

    <link rel="shortcut icon" type="image/png" href="assets/images/twitter.svg">

    <style>
        .slider {
            width: 800px;
            height: 400px;
            border-radius: 10px;
            overflow: hidden;
            position: absolute;
            left: 10%;
        }

        .slides {
            width: 500%;
            height: 500px;
            display: flex;
        }

        .slides input {
            display: none;
        }

        .slide {
            width: 20%;
            transition: 3s;
            background-color: #fff;
        }
    </style>
</head>

<body>

    <script src="assets/js/jquery-3.5.1.min.js"></script>


    <div id="mine">
        <div class="wrapper-left">
            <div class="sidebar-left">
                <div class="grid-sidebar" style="margin-top: 40px">
                    <div class="icon-sidebar-align">
                        <img src="<?php echo BASE_URL . "/assets/images/twitterlogo.png"; ?>" alt="" height="50px" width="50px" />
                    </div>
                </div>

                <a href="admin_dashboard.php">
                    <div class="grid-sidebar bg-active" style="margin-top: 50px">
                        <div class="icon-sidebar-align">
                            <img src="<?php echo BASE_URL . "/includes/icons/tweethome.png"; ?>" alt="" height="26.25px" width="26.25px" />
                        </div>
                        <div class="wrapper-left-elements">
                            <a href="admin_dashboard.php" style="margin-top: 4px;"><strong>Home</strong></a>
                        </div>
                    </div>
                </a>

                <a href="admin_notification.php">
                    <div class="grid-sidebar" style="margin-top: 30px">
                        <div class="icon-sidebar-align position-relative">
                            <?php if ($notify_count > 0) { ?>
                                <i class="notify-count"><?php echo $notify_count; ?></i>
                            <?php } ?>
                            <img
                                src="<?php echo BASE_URL . "/includes/icons/tweetnotif.png"; ?>"
                                alt=""
                                height="26.25px"
                                width="26.25px" />
                        </div>

                        <div class="wrapper-left-elements">
                            <a href="admin_notification.php" style="margin-top: 4px"><strong>Notifications</strong></a>
                        </div>
                    </div>
                </a>

                <a href="admin_panel.php">
                    <div class="grid-sidebar" style="margin-top: 30px;">
                        <div class="icon-sidebar-align position-relative">
                            <?php if ($notify_count > 0) { ?>
                                <i class="notify-count"><?php echo $notify_count; ?></i>
                            <?php } ?>
                            <img
                                src="<?php echo BASE_URL . "/includes/icons/tweetnotif.png"; ?>"
                                alt=""
                                height="26.25px"
                                width="26.25px" />
                        </div>

                        <div class="wrapper-left-elements">
                            <a class="wrapper-left-active" href="admin_panel.php" style="margin-top: 4px"><strong>Admin Panel</strong></a>
                        </div>
                    </div>
                </a>

                <a href="<?php echo BASE_URL . $user->username; ?>">
                    <div class="grid-sidebar" style="margin-top: 30px;">
                        <div class="icon-sidebar-align">
                            <img src="<?php echo BASE_URL . "/includes/icons/tweetprof.png"; ?>" alt="" height="26.25px" width="26.25px" />
                        </div>

                        <div class="wrapper-left-elements">
                            <!-- <a href="/twitter/<?php echo $user->username; ?>"  style="margin-top: 4px"><strong>Profile</strong></a> -->
                            <a href="<?php echo BASE_URL . $user->username; ?>" style="margin-top: 4px"><strong>Profile</strong></a>

                        </div>
                    </div>
                </a>
                <a href="<?php echo BASE_URL . "admin_account.php"; ?>">
                    <div class="grid-sidebar " style="margin-top: 30px;">
                        <div class="icon-sidebar-align">
                            <img src="<?php echo BASE_URL . "/includes/icons/tweetsetting.png"; ?>" alt="" height="26.25px" width="26.25px" />
                        </div>

                        <div class="wrapper-left-elements">
                            <a href="<?php echo BASE_URL . "admin_account.php"; ?>" style="margin-top: 4px"><strong>Settings</strong></a>
                        </div>


                    </div>
                </a>
                <a href="includes/logout.php">
                    <div class="grid-sidebar" style="margin-top: 30px;">
                        <div class="icon-sidebar-align">
                            <i style="font-size: 26px;" class="fas fa-sign-out-alt"></i>
                        </div>

                        <div class="wrapper-left-elements">
                            <a href="includes/logout.php" style="margin-top: 4px"><strong>Logout</strong></a>
                        </div>
                    </div>
                </a>
                <button class="button-twittear" style="margin-top: 25px;">
                    <strong>Tweet</strong>
                </button>
                <!-- PROFILE DOWN -->
                <!-- <div class="box-user">
          <div class="grid-user">
            <div>
              <img
                src="assets/images/users/<?php echo $user->img ?>"
                alt="user"
                class="img-user" />
            </div>
            <div>
              <p class="name"><strong><?php if ($user->name !== null) {
                                            echo $user->name;
                                        } ?></strong></p>
              <p class="username">@<?php echo $user->username; ?></p>
            </div>
            <div class="mt-arrow">
              <img
                src="https://i.ibb.co/mRLLwdW/arrow-down.png"
                alt=""
                height="18.75px"
                width="18.75px" />
            </div>
          </div>
        </div> -->
            </div>
        </div>



        <div class="grid-posts">
            <div class="border-right">
                <div class="grid-toolbar-center">
                    <div class="center-input-search">

                    </div>

                </div>

                <div class="box-fixed" id="box-fixed"></div>

                <div class="box-home feed">
                    <div class="container">
                        <div style="border-bottom: 1px solid #F5F8FA;" class="row position-fixed box-name">
                            <div class="col-xs-2">
                                <a href="javascript: history.go(-1);"> <i style="font-size:20px;" class="fas fa-arrow-left arrow-style"></i> </a>
                            </div>
                            <div class="col-xs-10">
                                <p style="margin-top: 12px;" class="home-name"> Notifications</p>
                            </div>
                        </div>

                    </div>
                    <div class="container mt-5" style="border: 1px solid red; min-height: 532px; width: 90%; margin-left: 58px">

                        <!-- SLIDER -->
                        <!-- <div class="slider">
                            <div class="slides">
                                <div class="slide first">
                                    <div class="header">List of User</div>
                                    <div class="container">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php

                                                $sql = "SELECT * FROM users";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {

                                                        $stud_id = $row['stud_id'];
                                                ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $stud_id; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['stud_name']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['email']; ?>
                                                            </td>
                                                            <td>
                                                                <a href="edit_page.php?id=<?php echo $stud_id; ?>">
                                                                    <button type="button" class="icon">Edit</button>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <form method="POST" enctype="multipart/form-data"
                                                                    action="delete_function.php?id=<?php echo $stud_id; ?>">
                                                                    <button type="submit" name="delete" class="icon">Delete</button>
                                                                </form>
                                                            </td>
                                                            <td><span class="status official">Active</span></td>
                                                        </tr>
                                                <?php
                                                    }
                                                } else {
                                                    echo "No users found.";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>



                </div>
            </div>

            <div class="wrapper-right">
                <div style="width: 90%;" class="container">

                    <div class="input-group py-2 m-auto pr-5 position-relative">

                        <i id="icon-search" class="fas fa-search tryy"></i>
                        <input type="text" class="form-control search-input" placeholder="Search Twitter">
                        <div class="search-result">


                        </div>
                    </div>
                </div>



                <div class="box-share">
                    <p class="txt-share"><strong>Who to follow</strong></p>
                    <?php
                    foreach ($who_users as $user) {
                        //  $u = User::getData($user->user_id);
                        $user_follow = Follow::isUserFollow($user_id, $user->id);
                    ?>
                        <div class="grid-share">
                            <a style="position: relative; z-index:5; color:black" href="<?php echo $user->username;  ?>">
                                <img
                                    src="assets/images/users/<?php echo $user->img; ?>"
                                    alt=""
                                    class="img-share" />
                            </a>
                            <div>
                                <p>
                                    <a style="position: relative; z-index:5; color:black" href="<?php echo $user->username;  ?>">
                                        <strong><?php echo $user->name; ?></strong>
                                    </a>
                                </p>
                                <p class="username">@<?php echo $user->username; ?>
                                    <?php if (Follow::FollowsYou($user->id, $user_id)) { ?>
                                        <span class="ml-1 follows-you">Follows You</span>
                                </p>
                            <?php } ?></p>
                            </div>
                            <div>
                                <button class="follow-btn follow-btn-m 
                      <?= $user_follow ? 'following' : 'follow' ?>"
                                    data-follow="<?php echo $user->id; ?>"
                                    data-user="<?php echo $user_id; ?>"
                                    data-profile="<?php echo $u_id; ?>"
                                    style="font-weight: 700;">
                                    <?php if ($user_follow) { ?>
                                        Following
                                    <?php } else {  ?>
                                        Follow
                                    <?php }  ?>
                                </button>
                            </div>
                        </div>

                    <?php } ?>


                </div>

            </div>
        </div>
    </div>

    <script src="assets/js/search.js"></script>
    <script src="assets/js/photo.js"></script>
    <script src="assets/js/follow.js?v=<?php echo time(); ?>"></script>
    <script src="assets/js/users.js?v=<?php echo time(); ?>"></script>
    <script type="text/javascript" src="assets/js/hashtag.js"></script>
    <script type="text/javascript" src="assets/js/like.js"></script>
    <script type="text/javascript" src="assets/js/comment.js?v=<?php echo time(); ?>"></script>
    <script type="text/javascript" src="assets/js/retweet.js?v=<?php echo time(); ?>"></script>
    <script src="https://kit.fontawesome.com/38e12cc51b.js" crossorigin="anonymous"></script>
    <!-- <script src="assets/js/jquery-3.4.1.slim.min.js"></script> -->
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

<style>
    .container {
        padding-left: 55px;
    }
</style>

</html>