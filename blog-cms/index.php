<?php ob_start(); ?>
<?php include("includes/header.php") ?>


<body>
    <?php

    if (isset($_POST['logout'])) {
        redirect("./includes/logout.php");
    }
    if (isset($_POST['new_post'])) {
        if (isset($_SESSION['username'])) {
            redirect("includes/add_post.php");
        } else {
            redirect("login.php");
        }
    }

    ?>


    <nav>
        <div class="container">
            <div class="header">
                <a href="<?php
                            if (isset($_SESSION['username'])) {
                                echo "admin.php";
                            } else {
                                echo "includes/login.php";
                            } ?>" class="logo">Blog Management</a>
                <div class="header-right">
                    <a class="active" href="
                    <?php if (isset($_SESSION['username'])) : ?>
                        includes/add_post.php
                    <?php else: ?>
                        includes/login.php
                    <?php endif; ?>
                    "><img src="images/Icon.png" alt="" id="icon"> New Blog Post</a>
                    <?php if (isset($_SESSION['username'])) : ?>
                        <a href="includes/logout.php" id="log">Logout</a>
                    <?php else : ?>
                        <a href="includes/login.php" id="log">Login</a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
            <!-- <div>
                <ul style="
            <?php
            if (!isset($_SESSION['username'])) {
                echo "grid-template-columns: 1fr 1fr;";
            } else {
                echo "";
            }
            ?>
            ">

                    <li><a href="<?php
                                    if (isset($_SESSION['username'])) {
                                        echo "admin.php";
                                    } else {
                                        echo "login.php";
                                    } ?>">Blog Managment</a></li>
                    <li><form action="" method="POST"><button name="new_post" id="btn" class="button2" style="background-color: #4ECE3D;"><img src="images/Icon.png"
                                alt="" id="icon"> New Blog Post</button></form></li>
                    <?php if (isset($_SESSION['username'])) : ?>
                    <li>
                        <form action="" method="post"><button type="submit" method name="logout" id="btn"
                                class="loginbtn" style="float: right;">Logout</button></form>
                    </li>
                    <?php endif; ?>


                </ul>
            </div>
        </div> -->

    </nav>
    <?php

    $per_page = 5;

    if (isset($_GET['page'])) {

        $page = $_GET['page'];
    } else {
        $page = "";
    }

    if ($page == "" || $page == 1) {
        $page_1 = 0;
    } else {
        $page_1 = ($page * $per_page) - $per_page;
    }


    $post_query_count = "SELECT * FROM posts";
    $find_count = mysqli_query($connection, $post_query_count);
    $count = mysqli_num_rows($find_count);

    if ($count < 1) {

        echo "<h1 class='text-center'>No posts available</h1>";
    } else {

        $count  = ceil($count / $per_page);

        $query = "SELECT * FROM posts ORDER BY ID DESC LIMIT $page_1, $per_page";
        $select_all_posts_query = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
            $post_id = $row['ID'];
            $post_title = $row['title'];
            // $post_author = $row['user'];
            $post_date = $row['date'];
            $post_image = $row['imageURL'];
            $post_content = substr($row['content'], 0, 400);
            // $post_status = $row['post_status'];


    ?>


            <!---------User Input------------->
            <div class="container second">
                <div class="posts">
                    <h1><?php echo $post_title ?></h1>
                    <p><?php echo $post_date ?></p>
                    <hr>
                    <div class="image"><img style="max-height: 35vh; width:100%;" src="images/<?php echo $post_image ?>" alt="Image"></div>
                    <hr>
                    <div class="content"><?php echo $post_content ?></div>
                    <a href="post.php?post_id=<?php echo $post_id ?>"><button id="btn" class="button3" style="background-color: rgb(22, 115, 236);">Read More</button></a>
                    <hr>
                </div>
            </div>
    <?php }
    } ?>
    <style>
        .pager_div {
            display: flex;
            justify-content: center;
        }

        .pager {
            text-align: center;
            display: flex;
            overflow: hidden;
            width: 54%;
        }

        .pager li {
            text-align: center;
            display: inline;
            margin: 10px 14px -5px 14px;


        }

        .pager li a {
            color: black;
            width: 30px;
        }

        .active {
            font-size: 20px;
        }
    </style>
    <div class="pager_div">
        <ul class="pager">
            <?php
            $number_list = array();
            for ($i = 1; $i <= $count; $i++) {

                if ($i == $page) {

                    echo "<li '><a class='active' href='index.php?page={$i}'>{$i}</a></li>";
                } else {

                    echo "<li '><a href='index.php?page={$i}'>{$i}</a></li>";
                }
            }

            ?>
        </ul>
    </div>
</body>

<script>
    function logoutbtn() {
        document.location.href = "includes/logout.php"
    }
</script>

</html>