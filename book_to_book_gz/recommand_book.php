<?php
    // array((유저가 읽은 책 rate-2.5) * (target 책 weight) , target 책 이름 or id)
    $fruits = array ( array(3.45,"lemon"), array(1.55,"orange"), array(1.53,"banana"), array(1.56,"apple"));
    rsort($fruits);
    foreach ($fruits as $val) {
        echo $val[0].$val[1]."\n";
    }
/*
    $mysql_handle = mysqli_connect("127.0.0.1", "osteosarcoma", "","c9",3306);
    $list_idx = 0;
    $book_list[$list_idx]=$rate =>;
    $query = "select * from sampletable";
    $result = mysqli_query($mysql_handle, $query);
    $row = mysqli_num_rows($result);
    echo "<br>";
    while($row = mysqli_fetch_assoc($result)){
        echo "id : ".$row["id"]. "- Name : ".$row["name"]."<br>";
    }  */
?>
