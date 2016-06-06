<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
<?php
    $user_id = 10001;
    $book_id = 1;
    $rate = 4.5;
    $comment = "괜찮은 책인 것 같습니다";
    $read_date = 2016-05-03;
    if(user_id == NULL){}
    else {
        $mysql_handle = mysqli_connect("127.0.0.1", "osteosarcoma", "","c9",3306);
        $query = "insert into read_list values(\"";
        $query = $query . 1001 . "/", /"" . "";
        echo $query;
    }
                     
                    // $result = mysqli_query($mysql_handle, $query);
                    // $row = mysqli_num_rows($result);
                    // echo "<br>";
                    // while($row = mysqli_fetch_assoc($result)){
                    //     echo "id : ".$row["id"]. "- Name : ".$row["name"]."<br>";
                    // }
?>
</<head>
    
</head>
</html>
