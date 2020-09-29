<!DOCTYPE html>
<head>
    <meta charset="utf8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1">
    <title>UserPage</title>
    <script src="../scripts/jquery_2.1.4_jquery.min.js"></script>
    <link rel="stylesheet" href="../scripts/bootstrap.min.css">
    <link rel="stylesheet" href="../scripts/main.css">
    <style>

        .panel{
            padding: 40px 15px;
            text-align:center;
            max-width: 500px;
            padding: 15px;
            margin: 0 auto;
        }

    </style>
</head>
<body>
<?php
if(empty($_COOKIE['user_email'])){
    header('Location: http://localhost/guba/webs/login.php');
}
?>
<div class="container"></div>
<nav class="navbar navbar-default " role="navigation">
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
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">My Stocks</h3>
    </div>
    <div class="panel-body" style="text-align: left">

        绿色表示积极情感值低，红色表示积极情感值高，蓝色表示正常。<br>
        点击股票代码查看详情。
    </div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th><center>Code</center></th>
                <th><center>Name</center></th>
                <?php
                if (!empty($_COOKIE['user_email'])){
                    echo "<th><center>Unfollow</center></th>";
                }
                ?>

            </tr>
            </thead>
            <tbody>
            <?php
            $dbc = mysqli_connect("127.0.0.1", "root", "Mysql0pass,", "guba")
            or die('<br>error connecting to db');

            $query = "select * from follow where Email='" . $_COOKIE['user_email'] ."'";
            $data = mysqli_query($dbc, $query);
            while($row=mysqli_fetch_array($data)){
                echo "<tr>";
                echo "<td><a class='btn btn-primary' href='stockpage.php?code=".$row['Code']."'>".$row['Code']."</a></td>";
                $getnamequery = "select * from stocks where Code='" . $row['Code'] ."'";
                $nameofcode = mysqli_query($dbc, $getnamequery);
                $getratequery = "select * from Emotion_score where Code='". $row['Code'] . "' order by Time desc limit 1";
                $rate = mysqli_query($dbc,$getratequery);
                if (mysqli_num_rows($rate)==1){

                    $rowrate = mysqli_fetch_array($rate);
                    $avps = $rowrate['AVP_score'];
                    $avns = $rowrate['AVN_score'];
                }

                if (mysqli_num_rows($nameofcode)==1){

                    $rowname = mysqli_fetch_array($nameofcode);
                    $namecode = $rowname['Name'];
                }
                if ($avps>2){
                    echo "<td><a class='btn btn-danger' href='#'>".$namecode."</a></td>";
                }elseif ($avps<0.5){
                    echo "<td><a class='btn btn-success' href='#'>".$namecode."</a></td>";
                }else{
                    echo "<td><a class='btn btn-primary' href='#'>".$namecode."</a></td>";
                }

                echo "<td><a class='btn btn-primary' href='follow.php?follow=0&code=".$row['Code']."'>"."Unfollow"."</a></td>";
            }
            ?>
            </tbody>
        </table>
</div>

</body>

</html>