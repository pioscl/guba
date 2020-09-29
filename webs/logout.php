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
            <ul class="nav navbar-nav navbar-right">
                <li><a href="login.php">登录</a></li>
                <li><a href="register.php">注册</a></li>
            </ul>

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
</div>
<div class="cont">
    <?php
    if(isset($_COOKIE['user_email'])){
        setcookie('user_email','', time()-3600);
        echo('you have logged out');
    }
    if(isset($_COOKIE['adminid'])){
        setcookie('adminid','', time()-3600);
    }

    ?>
</div>

</body>

</html>