<?php
class datatype {
    public $code = "";
    public $name = "";
    public $time = array();
    public $avps  = array();
    public $avns = array();
    public $ratep = array();
    public $raten = array();
    public $lastratep = 0.0;
    public $lastraten = 0.0;


}
$result = new datatype();
$code = $_GET['code'];


$dbc = mysqli_connect("127.0.0.1", "root", "Mysql0pass,", "guba")
or die('<br>error connecting to db');

$query = "select * from Emotion_score where Code='". $code . "' order by Time desc limit 12";
$name_query = "select * from stocks where Code='" . $code ."'";
$name_data = mysqli_query($dbc, $name_query);

if (mysqli_num_rows($name_data)==1){
    //the log in is ok
    $row = mysqli_fetch_array($name_data);
    $rowname = $row['Name'];
}

$data = mysqli_query($dbc, $query);
$result->code = $code;

$count = 1;

while($row=mysqli_fetch_array($data)){
    $rowtime = urlencode($row['Time']);
    $result->name = urlencode($rowname);
    array_unshift($result->time, $rowtime);
    array_unshift($result->avps, (float)$row['AVP_score']);
    array_unshift($result->avns,(float)$row['AVN_score']);
    array_unshift($result->ratep,(float)$row['PaP_score']);
    array_unshift($result->raten,(float)$row['PaN_score']);
    if($count==1){
        $result->lastratep = (float)$row['PaP_score'];
        $result->lastraten = (float)$row['PaN_score'];
        $count = $count - 1;
    }

}

echo urldecode(json_encode($result));

?>