<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BookQ - 책 검색하기</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Custom CSS -->
    <link href="css/rating-stars.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <?php
        session_start();
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];
    ?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php" style="color: #FF720A"><b>Book Q</b></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#">테마별 추천</a>
                    </li>
                    <li>
                        <a href="/search.php">책 검색하기</a>
                    </li>
                    
                    <?php
                    if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
                    ?>
                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php echo $_SESSION['user_name']?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">개인 정보 수정</a>
                            </li>
                            <li>
                                <a href="#">내가 읽은 책</a>
                            </li>
                            <li>
                                <a href="#">내 친구</a>
                            </li>
                            <li>
                                <a href="logout.php">Log out</a>
                            </li>
                        </ul>
                    <?php
                    }else{
                    ?>
                        <li>
                        <a href="login.php">Log in</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">내가 읽은 책
                    <small> 몇권이나 읽었나요?</small>
                </h1>

            </div>
        </div>
        <!-- /.row -->
        <?php
            if($_SESSION["user_id"] == null) {  // if not log in
                echo "<script> alert('로그인이 필요합니다.');history.back();</script>";
                exit;
            }else{
                $now_user = $_SESSION["user_id"];
                $mysql_handle = mysqli_connect("127.0.0.1", "osteosarcoma", "","c9",3306);
                mysqli_query($mysql_handle,"set session character_set_connection=utf8;");
                mysqli_query($mysql_handle,"set session character_set_results=utf8;");
                mysqli_query($mysql_handle,"set session character_set_client=utf8;");
                $query = "select * from read_list where user_id = \"".$now_user."\"";
                $read_list = mysqli_query($mysql_handle, $query);
                    
                while($row = mysqli_fetch_assoc($read_list)){
                    //echo "<br>". $final[$i][0]. " : ". $final[$i][1]; // 순서대로 표시, $row 갯수만큼만 위에서 표시, 나머지는 없는값으로 사라짐 0 : 선호도, 1: 책 인덱스
                    //book_id : $final[$i][1]
                    $query = "select * from book where book_id = \"".$row['book_id']."\"";
                    $result = mysqli_query($mysql_handle, $query);
                    
                    while($row2 = mysqli_fetch_assoc($result)){
                        $count++;
                        echo 
                        "<div class=\"col-md-3\">".
                             "<div class=\"panel panel-default\">".
                                "<div class=\"panel-heading\">".
                                    "<h4><a href=\"book_info.php?book_id=".$row2["book_id"]."\">".$row2["book_name"]."</a></h4>".
                                "</div>".
                                "<div class=\"panel-body\">".
                                    " <a href=\"book_info.php?book_id=".$row2["book_id"]."\"><img src=".$row2["picaddress"].
                                    " style=\"width:100%; height:100%\"></a>".
                                 "</div>".
                            "</div>".
                        "</div>";
                        if($count == 4) {   // 이쁘게 정렬하기
                            echo "　";
                            echo "<br>";
                            echo "<br>";
                            echo "<br>";
                            echo "<br>";
                            echo "<br>";
                            $count = 0;
                        }
                    }
                }
            }
        ?>
        <!-- Content Row -->
        <div class="row">


        </div>
        <!-- /.row -->

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Book Q 2016</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <!-- 여기있던 php 코드는 temp_search.php 로 옮겨둠 -->
    
    
</body>

</html>
