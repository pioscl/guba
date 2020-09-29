<!DOCTYPE html>
<head>
    <meta charset="utf8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1">
    <title>MainPage</title>
    <script src="../scripts/jquery_2.1.4_jquery.min.js"></script>
    <link rel="stylesheet" href="../scripts/bootstrap.min.css">
    <link rel="stylesheet" href="../scripts/main.css">
    <style>
        .cont{
            padding: 40px 15px;
            text-align:center;
        }

    </style>
</head>
<body>
<?php
$email = $_POST['email'];
$passwd = $_POST['password'];
$dbc = mysqli_connect("127.0.0.1", "root", "Mysql0pass,", "guba")
or die('<br>error connecting to db');

if (isset($_POST['iden'])){
    $query = "select * from admins where ID='" . $email ."' and `KEY`=SHA('" . $passwd ."')";
}else{
    $query = "select * from users where Email='" . $email ."' and Passwd=SHA('" . $passwd ."')";
}
$data = mysqli_query($dbc, $query);

if (mysqli_num_rows($data)==1){
    //the log in is ok
    $logindone = true;
    $row = mysqli_fetch_array($data);
    if(isset($_POST['iden'])){
        setcookie('user_email', $row['ID']);
        setcookie('adminid', $row['ID']);
    }else{
        setcookie('user_email', $row['Email']);
    }
}
?>
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
            if (!isset($logindone)) {
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
                <div class="form-group">
                    Code<input type="radio" name="option" value="code" checked>
                    Name<input type="radio" name="option" value="name">
                    <input type="text" name="searchtext" placeholder="search stock" class="form-control">
                </div>
                <button type="submit" class="btn btn-default">Search</button>
            </form>
        </div>
    </div>

</nav>
</div>
<div class="cont">


    <?php
    if (isset($logindone)){
        echo "<h1>Welcome</h1>";
        echo "You are now logging in as " . $_POST['email'];
    }else{
        echo "<script>alert('邮箱或密码错误')</script>";
        echo '<br><a href="login.php">回到登录界面</a>';
    }
    ?>
</div>


</body>

</html>