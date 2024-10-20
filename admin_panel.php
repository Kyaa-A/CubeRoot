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


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                                src="<?php echo BASE_URL . "/includes/icons/administrator.png"; ?>"
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
                            <!-- <i style="font-size: 26px;" class="fas fa-sign-out-alt"></i> -->
                            <img src="<?php echo BASE_URL . "/includes/icons/logout.png"; ?>" alt="" height="26.25px" width="26.25px" />

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
                                <h2>User's Data</h2>
                                <!-- <div class="input-group">
                                    <input type="search" class="search_data" id="searchInput" placeholder="Search Data...">
                                </div> -->
                                <div class="input-group">
                                    <input type="search" class="search_data" id="adminSearchInput" placeholder="Search Data...">
                                </div>
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
                                            <tr data-id="<?= $user['id'] ?>">
                                                <td><?= $user['id']; ?></td>
                                                <td>
                                                    <img src="assets/images/users/<?= $user['img']; ?>" alt="" style="width: 36px; height: 35px">
                                                    <?= $user['username']; ?>
                                                </td>

                                                <td><?= $user['email']; ?></td>
                                                <td>
                                                    <button class="edit-user"
                                                        data-toggle="modal"
                                                        data-target="#editUserModal"
                                                        data-id="<?= $user['id'] ?>"
                                                        data-username="<?= $user['username'] ?>"
                                                        data-email="<?= $user['email'] ?>">
                                                        Edit
                                                    </button>
                                                </td>

                                                <td><button class="delete-user" data-id="<?php echo $user['id']; ?>">Delete</button></td>
                                                <td>
                                                    <button class="toggle-status <?php echo $user['status'] == 1 ? 'active' : 'inactive'; ?>"
                                                        data-id="<?php echo $user['id']; ?>"
                                                        data-status="<?php echo $user['status']; ?>">
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
    <script src="delete.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="edit.js"></script>



    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="userId">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="saveChanges" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>





</body>

<style>
    .container {
        padding-left: 55px;
    }
</style>

</html>