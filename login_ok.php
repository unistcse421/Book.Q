<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
</head>
<?php
    if(!isset($_POST['user_id']) || !isset($_POST['user_pw'])) exit;
    
    $user_id = $_POST['user_id'];
    $user_pw = $_POST['user_pw'];
    
    $mysql_handle = mysqli_connect("127.0.0.1", "osteosarcoma", "","c9",3306);
    mysqli_query($mysql_handle,"set session character_set_connection=utf8;");
    mysqli_query($mysql_handle,"set session character_set_results=utf8;");
    mysqli_query($mysql_handle,"set session character_set_client=utf8;");
    
    $query = "select * from user;";
    $result = mysqli_query($mysql_handle, $query);
    $success = false;
    while($row = mysqli_fetch_assoc($result)){
        if($row["user_account"]==$user_id && $row["user_password"]==$user_pw){
            $success = true;
            $query = "select * from user where user_account = \"".$user_id."\";";
            $result = mysqli_query($mysql_handle, $query);
            break;
        }
        else{
            echo "<script>alert('아이디 또는 패스워드가 잘못되었습니다.');history.back();</script>";
            exit;
        }
    }
    session_start();
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = mysqli_fetch_assoc($result)["user_name"];
?>
<meta http-equiv='refresh' content='0;url=index.php'>