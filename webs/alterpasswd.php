<!DOCTYPE html>
<head>
    <meta charset="utf8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1">
    <title>MainPage</title>
    <script src="../scripts/jquery_2.1.4_jquery.min.js"></script>
    <script src="../scripts/bootstrap.js"></script>
    <link rel="stylesheet" href="../scripts/bootstrap.min.css">
    <link rel="stylesheet" href="../scripts/main.css">
    <style>
        .cont{
            padding: 40px 15px;
            text-align:center;
            max-width: 500px;
            padding: 15px;
            margin: 0 auto;
        }

    </style>
</head>
<body>
<div class="container"></div>
<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <!-- Logo -->
        <div class="navbar-header">
            <a href="mainpage.php" class="navbar-brand">舆情监控系统</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="userpage.php">主页</a></li>
                <li class="active"><a href="allstocks.php">查看所有股票</a></li>
            </ul>
            <?php
            if (!empty($_COOKIE['adminid'])){
                ?>
                <ul class="nav navbar-nav">
                    <li><a href="admin.php">管理用户</a></li>
                </ul>
            <?php }
            ?>
            <?php
            if (empty($_COOKIE['user_email'])) {
                ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="login.php">登录</a></li>
                    <li><a href="register.php">注册</a></li>
                </ul>

                <?php
            }else {
                ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php">登出</a></li>
                </ul>
                <?php
            }
            ?>

            <form class="navbar-form navbar-right" action="search.php" method="post">
                <select name="option" >
                    <option value="code">Code</option>
                    <option value="name">Name</option>
                </select>
                <input type="text" name="searchtext" placeholder="search stock" class="form-control">
                <button type="submit" class="btn btn-default">Search</button>
            </form>
        </div>
    </div>

</nav>

<div class="cont">
    <?php
    if(empty($_COOKIE['adminid'])){
        echo "<script>alert('Stop! Please sign in as admin user')</script>";
    }else{
        $passwd = $_POST['password'];
        $cfpasswd = $_POST['cfpassword'];

        if ($passwd==$cfpasswd){

            $dbc = mysqli_connect("127.0.0.1", "root", "Mysql0pass,", "guba")
            or die('<br>error connecting to db');


            $query = "update users set Passwd=SHA('".$passwd."') where Email='".$_GET['user']."'";
            $result = mysqli_query($dbc, $query)
            or die(" <br>error querying database");


            mysqli_close($dbc);
            echo "<script>alert('成功修改密码')</script>";
            echo "<br><a class='btn btn-success' href='admin.php'>回到管理界面</a>";

        }else{
            echo "<script>alert('密码不匹配')</script>";
            echo "<br><a class='btn btn-danger' href='adminuser.php?user=".$_GET['user'] ."'>回到修改界面</a>";

        }
    }
    ?>
</div>




</body>

</html>