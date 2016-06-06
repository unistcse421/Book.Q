<head>
<meta charset="utf-8">
</head>
<?php
    $final = array(array());
    $sum = array();
    $input = 10; // input  here
    $mysql_handle = mysqli_connect("127.0.0.1", "osteosarcoma", "","c9",3306);
    mysqli_query($mysql_handle,"set session character_set_connection=utf8;");
    mysqli_query($mysql_handle,"set session character_set_results=utf8;");
    mysqli_query($mysql_handle,"set session character_set_client=utf8;");
    $query = "select * from book where true";
    $result = mysqli_query($mysql_handle, $query);
    $row = mysqli_num_rows($result);
    while($row = mysqli_fetch_assoc($result)){ // 리셋
        $final[$row["book_id"]] = array(0, 0);
        $sum[$row["book_id"]] = 0;
    }
    $query_book_relation = "select * from book_to_book_relationship where book_id_1 = ".$input. ";";
    $result_book_relation = mysqli_query($mysql_handle, $query_book_relation);
    while($row_book_relation = mysqli_fetch_assoc($result_book_relation)){
        $sum[$row_book_relation["book_id_2"]] =  $sum[$row_book_relation["book_id_2"]] + $row_book_relation["weight"];
    }
    $query_book_relation = "select * from book_to_book_relationship where book_id_2 = ".$input. ";";
    $result_book_relation = mysqli_query($mysql_handle, $query_book_relation);
    while($row_book_relation = mysqli_fetch_assoc($result_book_relation)){
        $sum[$row_book_relation["book_id_1"]] =  $sum[$row_book_relation["book_id_1"]] + $row_book_relation["weight"];
    }
    $result = mysqli_query($mysql_handle, $query);
    $row = mysqli_num_rows($result);
    while($row = mysqli_fetch_assoc($result)){
        $final[$row["book_id"]] = array($sum[$row["book_id"]], $row["book_id"]);
    }
    $final[$input] = array(NULL, NULL); // delete itself
    $row = mysqli_num_rows($result);
    $row = $row - 1;
    rsort($final); // 역순정렬
    for($i = 0; $i < $row; $i++){
        echo $final[$i][0]. " : ". $final[$i][1] . "<br>"; // 순서대로 표시, $row 갯수만큼만 위에서 표시, 나머지는 없는값으로 사라짐 0 : 선호도, 1: 책 인덱스
        
    }
?>