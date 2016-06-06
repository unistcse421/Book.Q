<?php
        echo $_REQUEST['keyword'];  // 위에 검색에서 받은 값은 $_REQUEST['keyword'] 에 저장 됨
        echo "<br>";
        if ($_REQUEST['keyword'] == NULL){
            echo " 빈 칸 ";
        }
        else{
        $input= $_REQUEST['keyword'];
        $mysql_handle = mysqli_connect("127.0.0.1", "osteosarcoma", "","c9",3306);
        mysqli_query($mysql_handle,"set session character_set_connection=utf8;");
        mysqli_query($mysql_handle,"set session character_set_results=utf8;");
        mysqli_query($mysql_handle,"set session character_set_client=utf8;");
        $query = "select * from book where book_name like \"%" .  $input . "%\" or  tag like \"%" .  $input . "%\" or  writer like \"%" .  $input . "%\" or publisher like\"%" .  $input . "%\" or translator like\"%" .  $input . "%\" or nation like\"%" .  $input . "%\" " ;
        $result = mysqli_query($mysql_handle, $query);
        $row = mysqli_num_rows($result);
        while($row = mysqli_fetch_assoc($result)){
             echo "book_id : ". $row["book_id"]. "<br>"
             . "book_Name : ". $row["book_name"]. "<br>" 
             . "tag : " . $row["tag"] . "<br>" 
             . "writer : " . $row["writer"]. "<br>"
             . "publisher : ". $row["publisher"]. "<br>" 
             . "publish_date  : ". $row["publish_date"]. "<br>" ;
             if($row["translator"] == NULL){
                 echo "translator :  none <br>";
             }
             else{
                echo "translator : " . $row["translator"] . "<br>" ;
             }
             echo  "nation : " . $row["nation"] . "<br>";
             ;
             echo " <a href=\"#\"><img src= ". $row["picaddress"] . " style=\"width:100px; height:100px\"></a>";
             echo $row['picaddress'] . "<br>";
             }
        }
    ?>