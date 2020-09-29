<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="../scripts/bootstrap.min.css">
    <script src="../scripts/jquery_2.1.4_jquery.min.js"></script>
    <style>
        body {
            padding-top: 0px;
            padding-bottom: 40px;
            background-color: #eee;
        }
        .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
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
    <form class="form-signin" action="processlogin.php" method="post">
        <h2 class="form-signin-heading">Please Sign In</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <br>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <br>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <br>
        <label><input name="iden" type="checkbox" value="1">作为管理员登录</label>
        <input type="submit" class="btn btn-lg btn-primary btn-block" type="submit" value="Sign in">
    </form>

</body>
</html>