<?php
$con = new mysqli('localhost','root','','test');

if($con == true){
    echo "connected";
}
$sql = "SELECT * FROM `user` WHERE names";
$res = $con -> query($sql);
while($row = $res->fetch_assoc()){
    echo $row["id"].$row["names"].$row["age"];
}

?>
