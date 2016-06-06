<!DOCTYPE html>

<?php
    session_start();
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BookQ - Book curation service</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                                <a href="read_list.php">내가 읽은 책</a>
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

    <!-- Header Carousel -->
    <header id="myCarousel" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <div class="fill" style="background-image:url('/carousel/main_notperfect.jpg');"></div>
                <div class="carousel-caption">
                    <h2><!--캡션 입력 가능--></h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('/carousel/main_namiya.jpg');"></div>
                <div class="carousel-caption">
                    <h2><!--캡션 입력 가능--></h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('/carousel/main_boyiscoming.jpg');"></div>
                <div class="carousel-caption">
                    <h2><!--캡션 입력 가능--></h2>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>
    </header>

    <!-- Page Content -->
    <div class="container">

        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    추천 도서
                    
                </h1>
            </div>
            
            <?php
                if($_SESSION["user_id"] == null) {  // if not log in
                    $input= $_REQUEST[' '];
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
                
                else {
                    $now_user = $_SESSION["user_id"];
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
                        //echo "<br>". $final[$i][0]. " : ". $final[$i][1]; // 순서대로 표시, $row 갯수만큼만 위에서 표시, 나머지는 없는값으로 사라짐 0 : 선호도, 1: 책 인덱스
                        //book_id : $final[$i][1]
                        $query = "select * from book where book_id = \"".$final[$i][1]."\"";
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
        </div>
        <hr>
        <!-- /.row -->

        <!-- Portfolio Section -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">컬렉션 추천</h2>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="portfolio-item.html">
                    <img class="img-responsive img-portfolio img-hover" src="http://placehold.it/700x450" alt="">
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="portfolio-item.html">
                    <img class="img-responsive img-portfolio img-hover" src="http://placehold.it/700x450" alt="">
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="portfolio-item.html">
                    <img class="img-responsive img-portfolio img-hover" src="http://placehold.it/700x450" alt="">
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="portfolio-item.html">
                    <img class="img-responsive img-portfolio img-hover" src="http://placehold.it/700x450" alt="">
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="portfolio-item.html">
                    <img class="img-responsive img-portfolio img-hover" src="http://placehold.it/700x450" alt="">
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="portfolio-item.html">
                    <img class="img-responsive img-portfolio img-hover" src="http://placehold.it/700x450" alt="">
                </a>
            </div>
        </div>
        <!-- /.row -->

        <!-- Features Section -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Modern Business Features</h2>
            </div>
            <div class="col-md-6">
                <p>The Modern Business template by Start Bootstrap includes:</p>
                <ul>
                    <li><strong>Bootstrap v3.2.0</strong>
                    </li>
                    <li>jQuery v1.11.0</li>
                    <li>Font Awesome v4.1.0</li>
                    <li>Working PHP contact form with validation</li>
                    <li>Unstyled page elements for easy customization</li>
                    <li>17 HTML pages</li>
                </ul>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis, omnis doloremque non cum id reprehenderit, quisquam totam aspernatur tempora minima unde aliquid ea culpa sunt. Reiciendis quia dolorum ducimus unde.</p>
            </div>
            <div class="col-md-6">
                <img class="img-responsive" src="http://placehold.it/700x450" alt="">
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <!-- Call to Action Section -->
        <div class="well">
            <div class="row">
                <div class="col-md-8">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias, expedita, saepe, vero rerum deleniti beatae veniam harum neque nemo praesentium cum alias asperiores commodi.</p>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-lg btn-default btn-block" href="#">Call to Action</a>
                </div>
            </div>
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

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

</body>

</html>
