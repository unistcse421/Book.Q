<head>
<meta charset="utf-8">
</head>
<?php
    
    $now_user = 10002;
    $mysql_handle = mysqli_connect("127.0.0.1", "osteosarcoma", "","c9",3306);
    mysqli_query($mysql_handle,"set session character_set_connection=utf8;");
    mysqli_query($mysql_handle,"set session character_set_results=utf8;");
    mysqli_query($mysql_handle,"set session character_set_client=utf8;");
    $query = "select * from book where true";
    $result = mysqli_query($mysql_handle, $query);
    $query2 = "select * from read_list where user_id = 10002";
    $result2 = mysqli_query($mysql_handle, $query2);
    $counter2 = 0;
    $arrays2 = array(array());
    while($row = mysqli_fetch_assoc($result2)){
        $arrays2[$counter2] = array($row["book_id"], $row["rate"]);
        $counter2= $counter2 + 1;
    }
    $final = array(array());
    $sum = array();
    $query = "select * from book;";
    $result = mysqli_query($mysql_handle, $query);
    while($row = mysqli_fetch_assoc($result)){
        $final[$row["book_id"]] = array(0, 0);
        $sum[$row["book_id"]] = 0;
    }
    for($num = 0; $num < $counter2; $num++){
        $temp = $arrays2[$num];
        //echo "<br> temp =". $temp[0]. ", ". $temp[1]. "<br>";
        $query_book_relation = "select * from book_to_book_relationship where book_id_1 = ".$temp[0]. ";";
        $result_book_relation = mysqli_query($mysql_handle, $query_book_relation);
        while($row_book_relation = mysqli_fetch_assoc($result_book_relation)){
            $sum[$row_book_relation["book_id_2"]] = $sum[$row_book_relation["book_id_2"]] + ($temp[1] - 2.5) * ($row_book_relation["weight"]); 
        }
        $query_book_relation = "select * from book_to_book_relationship where book_id_2 = ".$temp[0]. ";";
        $result_book_relation = mysqli_query($mysql_handle, $query_book_relation);
        while($row_book_relation = mysqli_fetch_assoc($result_book_relation)){
            $sum[$row_book_relation["book_id_1"]] = $sum[$row_book_relation["book_id_1"]] + ($temp[1] - 2.5) * ($row_book_relation["weight"]); 
        }
    }
    $query = "select * from book;";
    $result = mysqli_query($mysql_handle, $query);
    while($row = mysqli_fetch_assoc($result)){
        $final[$row["book_id"]] = array($sum[$row["book_id"]], $row["book_id"]);
    }
    rsort($final);
    $row = mysqli_num_rows($result);
    for($i = 0; $i < $row; $i++){
        echo "<br>". $final[$i][0]. " : ". $final[$i][1]; 
    }

