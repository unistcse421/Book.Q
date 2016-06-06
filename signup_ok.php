<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
</head>
<?php
    if(!isset($_POST['identity']) || !isset($_POST['password'])) exit;
    if($_POST['password']!=$_POST['password_verify']){
        echo "<script> alert('패스워드가 잘못입력되었습니다.');history.back();</script>";
        exit;
    }
    $user_acc = $_POST['identity'];
    $user_pw = $_POST['password'];
    $user_name = $_POST['name'];
    $user_email = $_POST['email'];
    $user_age = $_POST['age'];
    $user_gender = $_POST['chk_info'];
    $mysql_handle = mysqli_connect("127.0.0.1", "osteosarcoma", "","c9",3306);
    mysqli_query($mysql_handle,"set session character_set_connection=utf8;");
    mysqli_query($mysql_handle,"set session character_set_results=utf8;");
    mysqli_query($mysql_handle,"set session character_set_client=utf8;");
    
    $query = "select * from user;";
    $result = mysqli_query($mysql_handle, $query);
    $success = false;
    $new_id = 10001;
    while($row = mysqli_fetch_assoc($result)){
        if($row["user_account"]==$user_acc ){
            echo "<script> alert('이미 존재하는 아이디입니다.');history.back();</script>";
            exit;
        }
        $new_id++;
    }
    switch($user_gender){
    case "m" : $user_gender = "Male";
        break;
    case "f" : $user_gender = "Female";
        break;
    case "o" : $user_gender = "Other";
        break;
    }
    $query = "insert into user values(\"". $new_id . "\" , \"". $user_name ."\", \"".$user_acc."\", \"".$user_pw."\", \"".$user_email."\", \"".$user_gender."\", \"".$user_age."\")";
    $result = mysqli_query($mysql_handle, $query);
    echo "<script> alert('가입에 성공했습니다.');</script>";
?>
<meta http-equiv='refresh' content='0;url=login.php'>
    