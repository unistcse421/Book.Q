<head>
<meta charset="utf-8">
</head>
<?php
    
    $now_user = 10001;
    $mysql_handle = mysqli_connect("127.0.0.1", "osteosarcoma", "","c9",3306);
    mysqli_query($mysql_handle,"set session character_set_connection=utf8;");
    mysqli_query($mysql_handle,"set session character_set_results=utf8;");
    mysqli_query($mysql_handle,"set session character_set_client=utf8;");
    $query = "select * from book where true";
    $result = mysqli_query($mysql_handle, $query);
    $query2 = "select * from read_list where user_id = ". $now_user ; // user_id
    $result2 = mysqli_query($mysql_handle, $query2);
    $counter2 = 0;  // 읽은 책 수
    $arrays2 = array(array());
    while($row = mysqli_fetch_assoc($result2)){
        $arrays2[$counter2] = array($row["book_id"], $row["rate"]); // array2 = number of read book, 평가한 정보가 이리로 넘어옴
        $counter2= $counter2 + 1; 
    }
    $final = array(array());
    $sum = array();
    $query = "select * from book;"; 
    $result = mysqli_query($mysql_handle, $query);
    while($row = mysqli_fetch_assoc($result)){ // 리셋
        $final[$row["book_id"]] = array(0, 0);
        $sum[$row["book_id"]] = 0;
    }
    for($num = 0; $num < $counter2; $num++){
        $temp = $arrays2[$num]; // 어레이 내부, 1번 평가부터 총 한 평가수까지 모두 체크
        //echo "<br> temp =". $temp[0]. ", ". $temp[1]. "<br>"; // temp[0] = team[0] = 평가한 책 번호, team[1] = 점수
        $query_book_relation = "select * from book_to_book_relationship where book_id_1 = ".$temp[0]. ";";
        $result_book_relation = mysqli_query($mysql_handle, $query_book_relation);
        while($row_book_relation = mysqli_fetch_assoc($result_book_relation)){
            $sum[$row_book_relation["book_id_2"]] = $sum[$row_book_relation["book_id_2"]] + ($temp[1] - 2.5) * ($row_book_relation["weight"]); 
        } //책 번호를 어레이 인덱스로 해서 1번부터 20번까지 사용, 정렬시 0번은 끝으로가 사라지므로 상관없음(1->2)
        $query_book_relation = "select * from book_to_book_relationship where book_id_2 = ".$temp[0]. ";";
        $result_book_relation = mysqli_query($mysql_handle, $query_book_relation);
        while($row_book_relation = mysqli_fetch_assoc($result_book_relation)){
            $sum[$row_book_relation["book_id_1"]] = $sum[$row_book_relation["book_id_1"]] + ($temp[1] - 2.5) * ($row_book_relation["weight"]); 
        } // 리버스(2->1)
    }
    $query = "select * from book;";
    $result = mysqli_query($mysql_handle, $query);
    while($row = mysqli_fetch_assoc($result)){
        $final[$row["book_id"]] = array($sum[$row["book_id"]], $row["book_id"]);
    }//final = 출력용 변수
    $result = mysqli_query($mysql_handle, $query);
    $row = mysqli_num_rows($result);
    for($num = 0; $num < $counter2; $num++){
        $temp = $arrays2[$num];
        $final[$temp[0]] = array(NULL, NULL);
        $row = $row - 1;
    }
    rsort($final); // 역순정렬
    
    
    for($i = 0; $i < $row; $i++){
        echo "<br>". $final[$i][0]. " : ". $final[$i][1]; // 순서대로 표시, $row 갯수만큼만 위에서 표시, 나머지는 없는값으로 사라짐 0 : 선호도, 1: 책 인덱스
        
    }

