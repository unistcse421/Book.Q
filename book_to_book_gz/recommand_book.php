<?php
    $mysql_handle = mysqli_connect("127.0.0.1", "osteosarcoma", "","c9",3306);
    
    $query = "select * from sampletable";
    $result = mysqli_query($mysql_handle, $query);
    $row = mysqli_num_rows($result);
    echo "<br>";
    while($row = mysqli_fetch_assoc($result)){
        echo "id : ".$row["id"]. "- Name : ".$row["name"]."<br>";
    }  
?>