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
        .table{
            text-align: center;
        }

    </style>
</head>
<body>
<?php
if (empty($_COOKIE['adminid'])){
    header('Location: http://localhost/guba/webs/login.php');
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
            <ul class="nav navbar-nav">
                <li><a href="admin.php">管理用户</a></li>
            </ul>
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
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th><center>Email</center></th>
            <th><center>积分</center></th>
            <th><center>管理用户</center></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $dbc = mysqli_connect("127.0.0.1", "root", "Mysql0pass,", "guba")
        or die('<br>error connecting to db');

        $query = "select * from users";
        $data = mysqli_query($dbc, $query);
        while($row=mysqli_fetch_array($data)){
            echo "<tr>";
            echo "<td>".$row['Email']."</td>";
            echo "<td>".$row['Credit']."</td>";
            echo "<td><a class='btn btn-primary' href='adminuser.php?user=". $row['Email'] . "'> 管理用户</a></td>";
        }
        ?>
        </tbody>
    </table>
</div>



</body>

</html>