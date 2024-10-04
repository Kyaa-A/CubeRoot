<?php
include_once 'core/init.php';
include_once 'handle/handleNotifications.php';
include_once 'core/classes/connection.php';

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

$db = Connect::connect(); // Now $db holds the PDO connection object
$stmt = $db->prepare("SELECT id, username, img, email, status FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | CubeLink</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin_panel.css?v=<?php echo time(); ?>">

    <link rel="shortcut icon" type="image/png" href="assets/images/twitterlogo.png">


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
                                <p style="margin-top: 12px;" class="home-name"> Admin Panel</p>
                            </div>
                        </div>

                    </div>
                    <!-- FIX -->
                    <div class="container_panel">
                        <main class="table" id="customers_table">
                            <section class="table__header">
                                <h1>User's Data</h1>

                                <div class="input-group">
                                    <input type="search" placeholder="Search Data...">
                                </div>
                                <!-- EXPORT -->
                                <!-- <div class="export__file">
                                    <label for="export-file" class="export__file-btn" title="Export File"></label>
                                    <input type="checkbox" id="export-file">
                                    <div class="export__file-options">
                                        <label>Export As &nbsp; &#10140;</label>
                                        <label for="export-file" id="toPDF">PDF <img src="images/pdf.png" alt=""></label>
                                        <label for="export-file" id="toJSON">JSON <img src="images/json.png" alt=""></label>
                                        <label for="export-file" id="toCSV">CSV <img src="images/csv.png" alt=""></label>
                                        <label for="export-file" id="toEXCEL">EXCEL <img src="images/excel.png" alt=""></label>
                                    </div>
                                </div> -->
                            </section>
                            <section class="table__body">
                                <table>
                                    <thead>
                                        <tr>
                                            <th> ID </th>
                                            <th> Name </th>
                                            <th> Email </th>
                                            <th> Edit </th>
                                            <th> Delete </th>
                                            <th> Status </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td><?= $user['id']; ?></td>
                                                <td>
                                                    <img src="assets/images/<?= $user['img']; ?>" alt="">
                                                    <?= $user['username']; ?>
                                                </td>
                                                <td><?= $user['email']; ?></td>
                                                <td><button>Edit</button></td>
                                                <td><button class="delete" data-id="<?= $user['id']; ?>">Delete</button></td>
                                                <td>
                                                    <button class="toggle-status" data-id="<?php echo $user['id']; ?>" data-status="<?php echo $user['status']; ?>">
                                                        <?php echo $user['status'] == 1 ? 'Active' : 'Inactive'; ?>
                                                    </button>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </section>


                        </main>
                        <script src="script.js"></script>
                        <!-- END -->
                    </div>

                </div>

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
    <script src="statusToggle.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

<style>
    .container {
        padding-left: 55px;
    }
</style>

</html>