<?php
$dbc = mysqli_connect("127.0.0.1", "root", "Mysql0pass,", "guba")
or die('<br>error connecting to db');
if($_GET['follow']==1){
    $query = "insert into follow (Email, Code) values('" . $_COOKIE['user_email'] . "', '" . $_GET['code'] . "')";
    $update_query = "update users set Fnum=Fnum+1 where Email='" . $_COOKIE['user_email'] . "'";

}else{
    $query = "delete from follow where Email='" . $_COOKIE['user_email'] ."' and Code='" . $_GET['code'] . "'";
    $update_query = "update users set Fnum=Fnum-1 where Email='" . $_COOKIE['user_email'] . "'";
}


$result = mysqli_query($dbc, $query)
or die(" <br>error querying database");
$data = mysqli_query($dbc, $update_query)
or die(" <br>error querying database here");

mysqli_close($dbc);

header('Location: http://localhost/guba/webs/allstocks.php');
if($_GET['follow']==1){
    header('Location: http://localhost/guba/webs/allstocks.php');
}else{
    header('Location: http://localhost/guba/webs/userpage.php');
}

?>