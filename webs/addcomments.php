<?php
$dbc = mysqli_connect("127.0.0.1", "root", "Mysql0pass,", "guba")
or die('<br>error connecting to db');
if(isset($_GET['time'])){
    $query = "delete from comments where Email='".$_COOKIE['user_email']."' and Time='".$_GET['time']."'";
    $result = mysqli_query($dbc, $query);
    mysqli_close($dbc);
    header('Location: http://localhost/guba/webs/stockpage?code='.$_GET['code']);
}
if(isset($_COOKIE['user_email'])){
    $query = "insert into comments (Email, Code, Content, Time)" . " values ('" . $_COOKIE['user_email'] . "', '" . $_GET['code'] . "', '" . $_POST['area'] . "', NOW())";
}else{
    $query = "insert into comments (Email, Code, Content, Time)" . " values ('" . "GUEST" . "', '" . $_GET['code'] . "', '" . $_POST['area'] . "', NOW())";
}
$result = mysqli_query($dbc, $query);
mysqli_close($dbc);
header('Location: http://localhost/guba/webs/stockpage?code='.$_GET['code']);

?>
