<!DOCTYPE html>
<head>
    <meta charset="utf8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1">
    <title><?php echo $_GET['code'] ?></title>
    <script src="../scripts/jquery_2.1.4_jquery.min.js"></script>
    <script src="../scripts/bootstrap.js"></script>
    <link rel="stylesheet" href="../scripts/bootstrap.min.css">
    <link rel="stylesheet" href="../scripts/main.css">
    <script src="../scripts/highcharts.js"></script>
    <script src="../scripts/echarts.min.js"></script>
    <script src="../scripts/tushareK.js"></script>
    <script src="../scripts/bootstrapValidator.js"></script>
    <style>
        .cont{
            padding: 40px 15px;
            text-align:center;
            max-width: 500px;
            padding: 15px;
            margin: 0 auto;
        }
        .cont{
            text-align: right;
        }

    </style>
</head>
<body>
<div class="col-md-4"></div>
<nav class="navbar navbar-default" role="navigation">
    <div class="containerna">
        <!-- Logo -->
        <div class="navbar-header">
            <a href="mainpage.php" class="navbar-brand">舆情监控系统</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="userpage.php">主页</a></li>
                <li class="active"><a href="allstocks.php">查看所有股票</a></li>
                <?php
                if (!empty($_COOKIE['adminid'])){
                    ?>
                    <ul class="nav navbar-nav">
                        <li><a href="admin.php">管理用户</a></li>
                    </ul>
                <?php }
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        View Pics
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><input type='button' id="btn_1" class="btn btn-link" value="Average Score"></li>
                        <li><input type='button' id="btn_2" class="btn btn-link" value="Rate"></li>
                        <li><input type='button' id="btn_3" class="btn btn-link" value="Rate_p"></li>
                        <li><input type='button' id="btn_4" class="btn btn-link" value="Real Data"></li>
                    </ul>
                </li>
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
<div id="container" style="width: 550px; height: 400px; margin: 0 auto"></div>
<script>
    $(document).ready(function() {
        var str = window.location.href;
        var reg = new RegExp("(^|&)" + "code" + "=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        var code = unescape(r[2]);

        var chart = {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        };
        var title = {
            text: 'Average Score'
        };
        var subtitle = {
            text: 'Source: me'
        };
        var xAxis = {
            categories: ['day', 'day', 'day', 'day', 'day', 'day',
                'day', 'day', 'day', 'day', 'day', 'day'
            ]
        };
        var plotOptions = {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}%</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        };
        var yAxis = {
            title: {
                text: 'AVP_score'
            },
            plotLines: [{
                value: 0,
                width: 0.1,
                color: '#808080'
            }]
        };

        var tooltip = {
            valueSuffix: ''
        }
        var pietooltip = {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        };

        var legend = {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        };

        var series = [{
            type: 'line',
            name: 'Tokyo',
            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2,
                26.5, 23.3, 18.3, 13.9, 9.6
            ]
        }, {
            type: 'line',
            name: 'New York',
            data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8,
                24.1, 20.1, 14.1, 8.6, 2.5
            ]
        }];
        var pieseries = [{
            type: 'pie',
            name: 'Browser share',
            data: [
                ['Firefox', 45.0],
                ['IE', 26.8]
            ]
        }];

        var json = {};
        var piejson = {};

        json.title = title;
        json.subtitle = subtitle;
        json.xAxis = xAxis;
        json.yAxis = yAxis;
        json.tooltip = tooltip;
        json.legend = legend;
        json.series = series;

        piejson.plotOptions = plotOptions;
        piejson.chart = chart;
        piejson.title = title;
        piejson.tooltip = pietooltip;
        piejson.series = pieseries;

        $.ajax({
            url: "getemotion.php?code="+code,
            datatype: "json",
            crossDomain: true,
            success: function(result) {
                var obj = eval('(' + result + ')');
                json.series[0].name = 'Positive';
                json.series[0].data = obj.avps;
                json.series[1].name = 'Negative';
                json.series[1].data = obj.avns;
                json.yAxis.title.text = 'Average Score';
                json.xAxis.categories = obj.time;
                json.title.text = obj.name;

                $('#container').highcharts(json);
            }
        });

        $("#btn_1").click(function() {
            $.ajax({
                url: "getemotion.php?code="+code,
                datatype: "json",
                crossDomain: true,
                success: function(result) {
                    var obj = eval('(' + result + ')');
                    json.series[0].name = 'Positive';
                    json.series[0].data = obj.avps;
                    json.series[1].name = 'Negative';
                    json.series[1].data = obj.avns;
                    json.yAxis.title.text = 'Average Score';
                    json.xAxis.categories = obj.time;
                    json.title.text = obj.name;

                    $('#container').highcharts(json);
                }
            });

        });

        $("#btn_2").click(function() {
            $.ajax({
                url: "getemotion.php?code="+code,
                datatype: "json",
                crossDomain: true,

                success: function(result) {
                    var obj = eval('(' + result + ')');
                    json.series[0].name = 'Positive';
                    json.series[0].data = obj.ratep;
                    json.series[1].name = 'Negative';
                    json.series[1].data = obj.raten;
                    json.yAxis.title.text = 'Rate of Positive and Negative';
                    json.xAxis.categories = obj.time;
                    json.title.text = obj.name;
                    $('#container').highcharts(json);
                }
            });

        });

        $("#btn_3").click(function() {
            $.ajax({
                url: "getemotion.php?code="+code,
                datatype: "json",
                crossDomain: true,
                success: function(result) {
                    var obj = eval('(' + result + ')');

                    var lastratep = obj.lastratep;
                    var lastraten = obj.lastraten;
                    pieseries = [{
                        type: 'pie',
                        name: obj.name,
                        data: [
                            ['Positive', lastratep],
                            ['Negative', lastraten]
                        ]
                    }]
                    piejson.title.text = obj.name;
                    piejson.series = pieseries;
                    $('#container').highcharts(piejson);
                }
            });

        });
        $("#btn_4").click(function() {
            $.ajax({
                url: "gettushare.php?code="+code,
                datatype: "json",
                crossDomain: true,
                success: function(result) {
                    var obj = eval('(' + result + ')');
                    json.series[0].name = 'Open';
                    json.series[0].data = obj.opendata;
                    json.series[1].name = 'Close';
                    json.series[1].data = obj.closedata;
                    json.yAxis.title.text = 'Price';
                    json.xAxis.categories = obj.time;
                    json.title.text = 'Data from Tushare';

                    $('#container').highcharts(json);
                }
            });

        });

    });
</script>

<div class="cont">
    <div class="panel panel-default" style="text-align: left">
        <div class="panel-heading">
            <h3 class="panel-title">Comments</h3>
        </div>
        <ul class="list-group">
            <?php
            $dbc = mysqli_connect("127.0.0.1", "root", "Mysql0pass,", "guba")
            or die('<br>error connecting to db');

            $query = "select * from comments where Code='".$_GET['code']."'order by Time desc";
            $data = mysqli_query($dbc, $query);
            while($row=mysqli_fetch_array($data)) {
                if (isset($_COOKIE['user_email']) && ($_COOKIE['user_email'] == $row['Email'])){
                    echo "<li class=\"list-group-item active\">";
                    echo "<span class=\"badge\">Me</span>";
                    echo $row['Email'];
                    echo "</li>";

                }else{
                    echo "<li class=\"list-group-item active\">" . $row['Email'] . "</li>";
                }
                echo "<li class=\"list-group-item\">" . $row['Content'] . "</li>";
                if (isset($_COOKIE['user_email']) && ($_COOKIE['user_email'] == $row['Email'])) {
                    echo "<li class=\"list-group-item\" style='text-align: right'>" . "<a class='btn btn-danger' href='addcomments.php?time=" . $row['Time'] . "&code=" . $_GET['code'] . "'>delete</a> " . $row['Time'] . "</li>";
                } else {
                    echo "<li class=\"list-group-item\" style='text-align: right'>" . $row['Time'] . "</li>";
                }
            }
            ?>
        </ul>

    </div>
    <form role="form" action="addcomments.php?code=<?php echo $_GET['code'] ?>" method="post">
        <div class="form-group">
            <div style="text-align: left"><label for="name">评论</label></div>
            <textarea name="area" class="form-control" rows="3" placeholder="Comments...."></textarea>
            <button type="submit" class="btn btn-primary ">提交</button>
        </div>
    </form>
</div>
<script>
    $(function () {
        $('form').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                area: {
                    message: '用户名验证失败',
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        },
                        stringLength: {//检测长度
                            min: 6,
                            message: '长度必须大于6'
                        }


                    }
                }
            }
        });
    });
</script>



</body>

</html>