<!DOCTYPE html>
<head>
    <meta charset="utf8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1">
    <title>MainPage</title>
    <script src="../scripts/jquery_2.1.4_jquery.min.js"></script>
    <link rel="stylesheet" href="../scripts/bootstrap.min.css">
    <link rel="stylesheet" href="../scripts/main.css">
    <script src="../scripts/bootstrapValidator.js"></script>
    <style>
        .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }
        .btn{
            display: inline-block;
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
<form class="form-signin" action="processregister.php" method="post">
    <h2 class="form-signin-heading">Please Sign Up</h2>
    <label for="inputEmail" class="sr-only">Email address</label>
    <br>
    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
    <br>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <br>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="cfpassword" id="inputPassword" class="form-control" placeholder="Confirm Your Password" required>
    <br>
    <input type="submit" class="btn btn-lg btn-primary btn-block" type="submit" value="Sign Up">
</form>
</div>

</body>

</html>