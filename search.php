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
                        <a href="/estimate.php">책 평가하기</a>
                    </li>
                    <li>
                        <a href="#">컬렉션</a>
                    </li>
                    <li>
                        <a href="/search.php">책 검색하기</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">My page <b class="caret"></b></a>
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
                            
                            <!--
                            <li>
                                <a href="portfolio-4-col.html">4 Column Portfolio</a>
                            </li>
                            <li>
                                <a href="portfolio-item.html">Single Portfolio Item</a>
                            </li>
                            -->
                            
                        </ul>
                    <li>
                        <a href="login.php">Log in</a>
                    </li>
                    <!--
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Other Pages <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="full-width.html">Full Width Page</a>
                            </li>
                            <li>
                                <a href="sidebar.html">Sidebar Page</a>
                            </li>
                            <li>
                                <a href="faq.html">FAQ</a>
                            </li>
                            <li>
                                <a href="404.html">404</a>
                            </li>
                            <li>
                                <a href="pricing.html">Pricing Table</a>
                            </li>
                        </ul>
                    </li>
                    -->
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
    
    <?php
        echo $_REQUEST['keyword'];  // 위에 검색에서 받은 값은 $_REQUEST['keyword'] 에 저장 됨
        if ($_REQUEST['keyword'] == NULL){
            echo " 빈 칸 ";
        }
        else{
        $input= $_REQUEST['keyword'];
        $mysql_handle = mysqli_connect("127.0.0.1", "osteosarcoma", "","c9",3306);
        mysqli_query($mysql_handle,"set session character_set_connection=utf8;");
        mysqli_query($mysql_handle,"set session character_set_results=utf8;");
        mysqli_query($mysql_handle,"set session character_set_client=utf8;");
        $query = "select * from book where book_name like \"%" .  $input . "%\"" ;
        $query2 = "select * from book where tag like \"%" .  $input . "%\"" ;
        $query3 = "select * from book where writer like \"%" .  $input . "%\"" ;
        echo $query. "<br>";
        echo $query2. "<br>";
        echo $query3. "<br>";
        $result = mysqli_query($mysql_handle, $query);
        $result2 = mysqli_query($mysql_handle, $query2);
        $result3 = mysqli_query($mysql_handle, $query3);
        $row = mysqli_num_rows($result);
        while($row = mysqli_fetch_assoc($result)){
             echo "book_id : " . $row["book_name"]. "<br>" .  "book_Name : ".$row["tag"]. "<br>";
             <a href="#"><img src=$row["picaddress"] style="width:100%; height:100%"></a>
             }
        while($row = mysqli_fetch_assoc($result2)){
             echo "book_id : " . $row["book_name"]. "<br>" .  "book_Name : ".$row["tag"]. "<br>";
             <a href="#"><img src=$row["picaddress"] style="width:100%; height:100%"></a>
             }
        while($row = mysqli_fetch_assoc($result3)){
             echo "book_id : " . $row["book_name"]. "<br>" .  "book_Name : ".$row["tag"]. "<br>";
             <a href="#"><img src=$row["picaddress"] style="width:100%; height:100%"></a>
             }
        }
    ?>
    
</body>

</html>
