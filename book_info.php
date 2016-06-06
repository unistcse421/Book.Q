<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BookQ - 책 정보</title>

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
        
        $book_id = $_REQUEST['book_id'];
        $rate = $_REQUEST['rating'];
        $comment = $_REQUEST['comment'];
        if($user_id == NULL || $book_id == NULL || $rate == NULL || $comment == NULL){}
        else {
            $mysql_handle = mysqli_connect("127.0.0.1", "osteosarcoma", "","c9",3306);
            mysqli_query($mysql_handle,"set session character_set_connection=utf8;");
            mysqli_query($mysql_handle,"set session character_set_results=utf8;");
            mysqli_query($mysql_handle,"set session character_set_client=utf8;");
            
            $query = "insert into read_list values(\"". $user_id . "\", " . $book_id . ", " . $rate . ", \"" . $comment . "\", curdate());";
            $result = mysqli_query($mysql_handle, $query);
            
            $query = "select * from read_list where user_id = ". $user_id." and book_id =". $book_id.";";
            $this_rate = mysqli_fetch_assoc(mysqli_query($mysql_handle, $query))["rate"];
            if($result){
                $query = "select * from read_list where user_id = ". $user_id." and not book_id =". $book_id.";";
                $read_list = mysqli_query($mysql_handle, $query);
                while($row = mysqli_fetch_assoc($read_list)){
                    $query = "update book_to_book_relationship set weight = weight + ".($this_rate-2.5) * ($row["rate"]-2.5)." where (book_id_1 = ". $book_id ." and book_id_2 = ". $row["book_id"] .") or (book_id_1 = ". $row["book_id"] ." and book_id_2 = ". $book_id .");";
                    $update = mysqli_query($mysql_handle,$query);
                }
            }else{
                $query = "update read_list set rate = " . $rate . " where user_id = " . $user_id . " and book_id = ". $book_id . ";";
                $update = mysqli_query($mysql_handle,$query);
                if($comment!=NULL){
                    $query = "update read_list set comment = \"" . $comment . "\" where user_id = " . $user_id . " and book_id = ". $book_id . ";";
                    $update = mysqli_query($mysql_handle,$query);
                }
                $query = "select * from read_list where user_id = ". $user_id." and not book_id =". $book_id.";";
                $read_list = mysqli_query($mysql_handle, $query);
                while($row = mysqli_fetch_assoc($read_list)){
                    $query = "update book_to_book_relationship set weight = weight - ".($this_rate-2.5) * ($row["rate"]-2.5)." where (book_id_1 = ". $book_id ." and book_id_2 = ". $row["book_id"] .") or (book_id_1 = ". $row["book_id"] ." and book_id_2 = ". $book_id .");";
                    $update = mysqli_query($mysql_handle,$query);
                    $query = "update book_to_book_relationship set weight = weight + ".($rate-2.5) * ($row["rate"]-2.5)." where (book_id_1 = ". $book_id ." and book_id_2 = ". $row["book_id"] .") or (book_id_1 = ". $row["book_id"] ." and book_id_2 = ". $book_id .");";
                    $update = mysqli_query($mysql_handle,$query);
                }
            }
        }
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
                <h1 class="page-header">책 정보
                    <?php
                        if ($_REQUEST['book_id'] == NULL){}
                        else{
                            $input= $_REQUEST['book_id'];
                            $mysql_handle = mysqli_connect("127.0.0.1", "osteosarcoma", "","c9",3306);
                            mysqli_query($mysql_handle,"set session character_set_connection=utf8;");
                            mysqli_query($mysql_handle,"set session character_set_results=utf8;");
                            mysqli_query($mysql_handle,"set session character_set_client=utf8;");
                            $query = "select * from book where book_id = $input";
                            $result = mysqli_query($mysql_handle, $query);
                            $row = mysqli_num_rows($result);
                            
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<small>".$row["book_name"]. "</small>";
                            }
                        }
                    ?>
                </h1>

            </div>
        </div>
        <!-- /.row -->

        <!-- Content Row -->
        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">
                <br>
                
                <?php
                    echo "<br>";
                    if ($_REQUEST['book_id'] == NULL){
                        echo " 빈 칸 ";
                    }
                    else{
                        $input= $_REQUEST['book_id'];
                        $mysql_handle = mysqli_connect("127.0.0.1", "osteosarcoma", "","c9",3306);
                        mysqli_query($mysql_handle,"set session character_set_connection=utf8;");
                        mysqli_query($mysql_handle,"set session character_set_results=utf8;");
                        mysqli_query($mysql_handle,"set session character_set_client=utf8;");
                        $query = "select * from book where book_id = $input";
                        $result = mysqli_query($mysql_handle, $query);
                        $row = mysqli_num_rows($result);
                        
                        while($row = mysqli_fetch_assoc($result)){
                            
                            echo " <img class=\"img-responsive\" src= ". $row["picaddress"] . ">";
                            echo "<hr>";
                            echo "<p class=\"lead\">". $row["book_name"]. "</p>";    // <!-- (제목) -->
                            echo "<p>". $row["tag"] . "</p>";  //<!-- (태그) -->
                            echo "<p>". $row["writer"]. "</p>";    //<!-- (저자) -->
                            echo "<p>". $row["publisher"]. "</p>";    //<!-- (출판사) -->
                            echo "<p>". $row["publish_date"]. "</p>";   //<!-- (출간일) -->
                            if($row["translator"] == NULL){
                                 echo "<p>역자 없음</p>";
                             }
                             else{
                                echo "<p>" . $row["translator"] . "</p>" ;
                             }
                            echo "<p>" . $row["nation"] . "</p>"; //<!-- (출판국가) -->
                        }
                    }
                ?>
                
                <hr>
                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    
                    <!-- Rating stars -->
                    
                    <form role="form" action="/book_info.php" method="POST">
                    <fieldset class="rating">
                        <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                        <input type="radio" id="star4half" name="rating" value="4.5" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                        <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                        <input type="radio" id="star3half" name="rating" value="3.5" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2half" name="rating" value="2.5" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                        <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                        <input type="radio" id="star1half" name="rating" value="1.5" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" id="starhalf" name="rating" value="0.5" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                    </fieldset>
                    
                        <div class="form-group">
                            <textarea class="form-control" name="comment" rows="3"></textarea>
                        </div>
                        <input type="hidden" name="book_id" value=<?php echo $_REQUEST['book_id']; ?> />
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                
                <?php
                    $book_id= $_REQUEST['book_id'];
                    $mysql_handle = mysqli_connect("127.0.0.1", "osteosarcoma", "","c9",3306);
                    mysqli_query($mysql_handle,"set session character_set_connection=utf8;");
                    mysqli_query($mysql_handle,"set session character_set_results=utf8;");
                    mysqli_query($mysql_handle,"set session character_set_client=utf8;");
                    $query = "select * from read_list where book_id = $book_id";
                    $result = mysqli_query($mysql_handle, $query);
                    $row = mysqli_num_rows($result);
                    
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<div class=\"media\">";
                        echo    "<a class=\"pull-left\" href=\"#\">";
                        // user name 추출
                            $user_id= $row["user_id"];
                            $query2 = "select * from user where user_id = $user_id";
                            $result2 = mysqli_query($mysql_handle, $query2);
                            $row2 = mysqli_fetch_assoc($result2);
                        $user_name = $row2["user_name"];
                        
                        $rating = $row["rate"];
                        $comment = $row["comment"];
                        $read_date = $row["read_date"];
                ?>
                        <!-- 이 사람이 평가한 별점 위치 -->
                        <fieldset class="rating">
                            <input type="radio" id="star5" name="rating<?php echo $user_id?>" value="5" <?php if($rating == 5) echo "checked=\"checked\""; ?>/><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4half" name="rating<?php echo $user_id?>" value="4.5" <?php if($rating == 4.5) echo "checked=\"checked\""; ?>/><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                            <input type="radio" id="star4" name="rating<?php echo $user_id?>" value="4" <?php if($rating == 4) echo "checked=\"checked\""; ?>/><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3half" name="rating<?php echo $user_id?>" value="3.5" <?php if($rating == 3.5) echo "checked=\"checked\""; ?>/><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                            <input type="radio" id="star3" name="rating<?php echo $user_id?>" value="3" <?php if($rating == 3) echo "checked=\"checked\""; ?>/><label class = "full" for="star3" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2half" name="rating<?php echo $user_id?>" value="2.5" <?php if($rating == 2.5) echo "checked=\"checked\""; ?>/><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                            <input type="radio" id="star2" name="rating<?php echo $user_id?>" value="2" <?php if($rating == 2) echo "checked=\"checked\""; ?>/><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1half" name="rating<?php echo $user_id?>" value="1.5" <?php if($rating == 1.5) echo "checked=\"checked\""; ?>/><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                            <input type="radio" id="star1" name="rating<?php echo $user_id?>" value="1" <?php if($rating == 1) echo "checked=\"checked\""; ?>/><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                            <input type="radio" id="starhalf" name="rating<?php echo $user_id?>" value="0.5" <?php if($rating == 0.5) echo "checked=\"checked\""; ?>/><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                        </fieldset>
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $user_name; ?>
                            <small><?php echo $read_date; ?></small>
                        </h4>
                        <?php echo $comment; ?>
                    </div>
                </div>
                
                <?php   
                    }   // end of while
                ?>
            </div>
            <!-- Comment End -->

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

                <!-- Blog Categories Well -->
                <div class="well">
                <h4>연관 추천 도서</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <ul>
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
                        //echo $final[$i][0]. " : ". $final[$i][1] . "<br>"; // 순서대로 표시, $row 갯수만큼만 위에서 표시, 나머지는 없는값으로 사라짐 0 : 선호도, 1: 책 인덱스
                        //book_id : $final[$i][1]
                        $query = "select * from book where book_id = \"".$final[$i][1]."\"";
                        $result = mysqli_query($mysql_handle, $query);
                        
                        
                        while($row2 = mysqli_fetch_assoc($result)){
                            $count++;
                            echo 
                            "<li><a href=\"book_info.php?book_id=".$row2["book_id"]."\">".$row2["book_name"]."</a></li>";
                            
                        }
                    }
                ?>
                
                            </ul>
                        </div>
                    </div>
                    
                    <!-- /.row -->
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

</body>

</html>
