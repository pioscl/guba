<!DOCTYPE html>
<head>
    <meta charset="utf8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1">
    <title>All Stocks</title>
    <script src="../scripts/jquery_2.1.4_jquery.min.js"></script>
    <script src="../scripts/bootstrap.js"></script>
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
        .table{
            text-align: center;
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

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">All Stocks</h3>
    </div>
    <div class="panel-body">
        所有股票数据如下，点击股票代码查看详情
    </div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th><center>Code</center></th>
                <th><center>Name</center></th>
                <?php
                if (!empty($_COOKIE['user_email'])){
                    echo "<th><center>Follow</center></th>";
                }
                ?>

            </tr>
            </thead>
            <tbody>
            <?php
            $dbc = mysqli_connect("127.0.0.1", "root", "Mysql0pass,", "guba")
            or die('<br>error connecting to db');

            $query = "select * from stocks";
            $data = mysqli_query($dbc, $query);
            while($row=mysqli_fetch_array($data)){
                echo "<tr>";
                echo "<td><a href='stockpage.php?code=".$row['Code']."'>".$row['Code']."</a></td>";
                echo "<td>".$row['Name']."</td>";
                if (!empty($_COOKIE['user_email'])){
                    $follow_query = "select * from follow where Email='" . $_COOKIE['user_email'] . "' and Code='" . $row['Code'] ."'";
                    $follow_data = mysqli_query($dbc, $follow_query);
                    if (mysqli_num_rows($follow_data)==1){
                        //have followed
                        echo '<td>following</td>';
                    }else{
                        echo "<td><a class='btn btn-default' href='follow.php?follow=1&code=".$row['Code']."'>"."follow"."</a></td>";
                    }
                }
            }
            ?>
            </tbody>
        </table>
</div>


</body>

</html>