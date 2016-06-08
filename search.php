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
                        <a href="/thame_search.php">테마별 추천</a>
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
                <h1 class="page-header">책 검색하기
                    <small>검색할 키워드를 입력하세요</small>
                </h1>

            </div>
        </div>
        <!-- /.row -->
        
        <!-- Content Row -->
        <div class="row">


            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>책 검색</h4>
                    <form action="/search.php" method="GET">
                    <div class="input-group">
                    
                        <input type="text" class="form-control" name="keyword">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="SUBMIT"><i class="fa fa-search"></i></button>
                        </span>
                    
                    </div>
                    </form>
                    <!-- /.input-group -->
                </div>

            </div>

        </div>
        <!-- /.row -->

        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    추천 도서 (검색된 도서)
                    
                </h1>
            </div>
            
            <?php
                if ($_REQUEST['keyword'] == NULL){
                    echo " 검색 결과 없음 ";
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
                    $count = 0;
                    while($row = mysqli_fetch_assoc($result)){
                        $count++;
                        echo 
                        "<div class=\"col-md-3\">".
                             "<div class=\"panel panel-default\">".
                                "<div class=\"panel-heading\">".
                                    "<h4><a href=\"book_info.php?book_id=".$row["book_id"]."\">".$row["book_name"]."</a></h4>".
                                "</div>".
                                "<div class=\"panel-body\">".
                                    " <a href=\"book_info.php?book_id=".$row["book_id"]."\"><img src=".$row["picaddress"].
                                    " style=\"width:100%; height:100%\"></a>".
                                 "</div>".
                            "</div>".
                        "</div>";
                        if($count == 4) {   // 이쁘게 정렬하기
                            echo "　";
                            echo "<br>";
                            echo "<br>";
                            echo "<br>";
                            $count = 0;
                        }
                    }
                }
            ?>
        </div>
        <hr>

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
