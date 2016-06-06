<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
<?php
    $user_id = 10002;
    $book_id = 1;
    $rate = 5;
    $comment = "괜찮은 책인 것 같습니다";
    if($rate == NULL){}
    else {
        $mysql_handle = mysqli_connect("127.0.0.1", "osteosarcoma", "","c9",3306);
        mysqli_query($mysql_handle,"set session character_set_connection=utf8;");
        mysqli_query($mysql_handle,"set session character_set_results=utf8;");
        mysqli_query($mysql_handle,"set session character_set_client=utf8;");
        
        $query = "insert into read_list values(\"". $user_id . "\", " . $book_id . ", " . $rate . ", \"" . $comment . "\", curdate());";
        $result = mysqli_query($mysql_handle, $query);
        
        $query = "select * from read_list where user_id = ". $user_id." and book_id =". $book_id.";";
        $this_rate = mysqli_fetch_assoc(mysqli_query($mysql_handle, $query))["rate"];
        if($result){
            $query = "select * from read_list where user_id = ". $user_id." and not book_id =". $book_id.";";
            $read_list = mysqli_query($mysql_handle, $query);
            while($row = mysqli_fetch_assoc($read_list)){
                $query = "update book_to_book_relationship set weight = weight + ".($this_rate-2.5) * ($row["rate"]-2.5)." where (book_id_1 = ". $book_id ." and book_id_2 = ". $row["book_id"] .") or (book_id_1 = ". $row["book_id"] ." and book_id_2 = ". $book_id .");";
                $update = mysqli_query($mysql_handle,$query);
                echo "\n -->".$query;
            }
        }else{
            echo "-->>". $this_rate . " " . $rate;
            $query = "update read_list set rate = " . $rate . " where user_id = " . $user_id . " and book_id = ". $book_id . ";";
            $update = mysqli_query($mysql_handle,$query);
            echo $query;
            if($comment){
                $query = "update read_list set comment = " . $comment . " where user_id = " . $user_id . " and book_id = ". $book_id . ";";
                $update = mysqli_query($mysql_handle,$query);
            }
            $query = "select * from read_list where user_id = ". $user_id." and not book_id =". $book_id.";";
            $read_list = mysqli_query($mysql_handle, $query);
            $row = mysqli_num_rows($read_list);
            while($row = mysqli_fetch_assoc($read_list)){
                $query = "update book_to_book_relationship set weight = weight - ".($this_rate-2.5) * ($row["rate"]-2.5)." where (book_id_1 = ". $book_id ." and book_id_2 = ". $row["book_id"] .") or (book_id_1 = ". $row["book_id"] ." and book_id_2 = ". $book_id .");";
                
                echo "<br>". $query;
                echo "<br>". $book_id." ".$row["book_id"];
                $update = mysqli_query($mysql_handle,$query);
                $query = "update book_to_book_relationship set weight = weight + ".($rate-2.5) * ($row["rate"]-2.5)." where (book_id_1 = ". $book_id ." and book_id_2 = ". $row["book_id"] .") or (book_id_1 = ". $row["book_id"] ." and book_id_2 = ". $book_id .");";
                $update = mysqli_query($mysql_handle,$query);
                echo $query;
            }
        }
        $query = "select * from read_list where user_id = ". $user_id." and book_id =". $book_id.";";
        $read_list = mysqli_query($mysql_handle, $query);
        while($row = mysqli_fetch_assoc($read_list)){
            echo "<br> -->".$row["rate"]. " ".$row["comment"]." ".$row["read_date"];
        }
    }
?>
</<head>
    
</head>
</html>
