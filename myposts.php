<?php
include 'config.php';
session_start();
  if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
  }
  $idofuser =$_SESSION["user_id"];
  
  //like dislike
if(isset($_POST['like_button'])){
    $sql = "SELECT * FROM post_tbl";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result)) {
    $row = mysqli_fetch_assoc($result);
}

    $likerID = $_SESSION['user_id'];
    $postID = $row['post_id'];
    $preselect = "SELECT * FROM likedislike_tbl WHERE liker_id = '$likerID' AND post_id = '$postID'";   
    $PSresult = mysqli_query($conn, $preselect);

    if(mysqli_num_rows($PSresult) > 0){
        $row=mysqli_fetch_assoc($PSresult);
        $typeReact = $row['typeReact'];
        if($typeReact == 'like'){
            $updateLike = "DELETE FROM likedislike_tbl WHERE liker_id = '$likerID' AND post_id = '$postID'";
            $ULresult = mysqli_query($conn, $updateLike);
            $selectUpdate1 = "SELECT * FROM post_tbl WHERE post_id ='$postID' LIMIT 1";
            $selectResult1 = mysqli_query($conn, $selectUpdate1);
            if(mysqli_num_rows($selectResult1) > 0){
                $row1=mysqli_fetch_assoc($selectResult1);
                $likeamount1=$row1['like_amount'];
                $likeamount1 = $likeamount1 - 1;
                $update_Like1 = "UPDATE post_tbl SET like_amount = '$likeamount1' WHERE post_id ='$postID'";
                mysqli_query($conn, $update_Like1);
            }
        }else{
            $updatedisLikeToLike = "UPDATE likedislike_tbl SET typeReact = 'like' WHERE liker_id = '$likerID' AND post_ID = '$postID'";
            $ULTDresult = mysqli_query($conn, $updatedisLikeToLike);
            $selectUpdate = "SELECT * FROM post_tbl WHERE post_id ='$postID' LIMIT 1";
            $selectResult = mysqli_query($conn, $selectUpdate);
            if(mysqli_num_rows($selectResult) > 0){
                $row1=mysqli_fetch_assoc($selectResult);
                $dislikeamount1=$row1['dislike_amount'];
                $dislikeamount1 = $dislikeamount1 - 1;
                $likeamount1=$row1['like_amount'];
                $likeamount1 = $likeamount1 + 1;
                $update_Like1 = "UPDATE post_tbl SET like_amount = '$likeamount1', dislike_amount = '$dislikeamount1' WHERE post_id ='$postID'";
                mysqli_query($conn, $update_Like1);
            }
        }

    }else {
        $insertL = "INSERT INTO likedislike_tbl SET post_id = '$postID', liker_id = '$likerID', typeReact = 'like'";
        $resultiL = mysqli_query($conn, $insertL);
        $selectUpdate2 = "SELECT * FROM post_tbl WHERE post_id ='$postID' LIMIT 1";
        $selectResult2 = mysqli_query($conn, $selectUpdate2);

        if(mysqli_num_rows($selectResult2) > 0){
            $row2=mysqli_fetch_assoc($selectResult2);
            $likeamount2=$row2['like_amount'];
            $likeamount2++;
            $update_Like2 = "UPDATE post_tbl SET like_amount = '$likeamount2' WHERE post_id ='$postID'";
            mysqli_query($conn, $update_Like2);
        }
    }

}

if(isset($_POST['dislike_button'])){
    $sql = "SELECT * FROM post_tbl";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result)) {
    $row = mysqli_fetch_assoc($result);
}
    $dislikerID = $_SESSION['user_id'];
    $postID = $row['post_id'];
    $preselect = "SELECT * FROM likedislike_tbl WHERE liker_id = '$dislikerID' AND post_id = '$postID'";   
    $PSresult = mysqli_query($conn, $preselect);

    if(mysqli_num_rows($PSresult) > 0){
        $row=mysqli_fetch_assoc($PSresult);
        $typeReact = $row['typeReact'];
        if($typeReact == 'dislike'){
            $updatedisLike = "DELETE FROM likedislike_tbl WHERE liker_id = '$dislikerID' AND post_id = '$postID'";
            $ULresult = mysqli_query($conn, $updatedisLike);
            $selectUpdate1 = "SELECT * FROM post_tbl WHERE post_id ='$postID' LIMIT 1";
            $selectResult1 = mysqli_query($conn, $selectUpdate1);
            if(mysqli_num_rows($selectResult1) > 0){
                $row1=mysqli_fetch_assoc($selectResult1);
                $dislikeamount1=$row1['dislike_amount'];
                $dislikeamount1 = $dislikeamount1 - 1;
                $update_disLike1 = "UPDATE post_tbl SET dislike_amount = '$dislikeamount1' WHERE post_id ='$postID'";
                mysqli_query($conn, $update_disLike1);
            }
        }else{
            $updateLikeTodisLike = "UPDATE likedislike_tbl SET typeReact = 'dislike' WHERE liker_id = '$dislikerID' AND post_ID = '$postID'";
            $ULTDresult = mysqli_query($conn, $updateLikeTodisLike);
            $selectUpdate = "SELECT * FROM post_tbl WHERE post_id ='$postID' LIMIT 1";
            $selectResult = mysqli_query($conn, $selectUpdate);
            if(mysqli_num_rows($selectResult) > 0){
                $row1=mysqli_fetch_assoc($selectResult);
                $dislikeamount1=$row1['dislike_amount'];
                $dislikeamount1 = $dislikeamount1 + 1;
                $likeamount1=$row1['like_amount'];
                $likeamount1 = $likeamount1 - 1;
                $update_disLike1 = "UPDATE post_tbl SET like_amount = '$likeamount1', dislike_amount = '$dislikeamount1' WHERE post_id ='$postID'";
                mysqli_query($conn, $update_disLike1);
            }
        }

    }else {
        $insertdL = "INSERT INTO likedislike_tbl SET post_id = '$postID', liker_id = '$dislikerID', typeReact = 'dislike'";
        $resultiL = mysqli_query($conn, $insertdL);
        $selectUpdate2 = "SELECT * FROM post_tbl WHERE post_id ='$postID' LIMIT 1";
        $selectResult2 = mysqli_query($conn, $selectUpdate2);

        if(mysqli_num_rows($selectResult2) > 0){
            $row2=mysqli_fetch_assoc($selectResult2);
            $dislikeamount2=$row2['dislike_amount'];
            $dislikeamount2++;
            $update_disLike2 = "UPDATE post_tbl SET dislike_amount = '$dislikeamount2' WHERE post_id ='$postID'";
            mysqli_query($conn, $update_disLike2);
        }
    }

}

  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"/>
    <link rel="stylesheet" href="style_myposts.css"/>
    <link rel="stylesheet" href="style_cards2.css"/>
  
    <title>My Posts</title>
</head>

<body>

    <div>
        <script src="//code.jquery.com/jquery.min.js"></script>
        <div id="nav-placeholder">
            <script>
                $.get("homepage.php", function(data) {
                    $("#nav-placeholder").replaceWith(data);
                });
            </script>
        </div>
    </div>
    
<div class="container-fluid" style="background-color: white;height:100vh">
<div class="contentx">
  
<h2 style="text-align:center; border-top: 5px solid #5AC7C7; border-bottom: 5px solid #5AC7C7;  border-radius: 5px;">My Posts</h2>
            <br>  
            <div class="row">         
               <?php
                    $sql= "SELECT * FROM post_tbl WHERE userid ='$idofuser' ORDER BY post_date DESC";
                    $result = $conn->query($sql);
                    
                    while($row = mysqli_fetch_assoc($result))
                    {
                       echo'
                       <div class="column">
                            <div class="card">
                            <img src="'.$row['post_picture'].'" alt="" style="width:100%">    
                            <div class="container">
                            <br>
                                <h8 style ="color:gray; font-weight: bold;">Date: </h8>
                                <h9>'.$row['post_date'].'<br>'.'
                                <h8 style ="color:gray; font-weight: bold;">Post ID: </h8>'.'
                                <h9>'.$row['post_id'].'</h9>
                                <hr style= "border-top: 5px solid #cccc;"></hr>
                                <h2>'.$row['post_title'].'</h2>
                                <p style= "white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 350ch;">'.$row['post_content'].'</p>
                            </div>
                            <form  name="likedislike" method="post">
                                        <div class ="card_info">
                                        <button id = "like_button" name ="like_button" class ="fas fa-thumbs-up" style="font-size:17px; margin-right: 15px; "><p>'.$row['like_amount'].'</p></button>
                                        <button id = "dislike_button" name ="dislike_button" class ="fas fa-thumbs-down" style="font-size:15px; "><p>'.$row['dislike_amount'].'</p></button>
                                        <button class="card_link1"><a href="delete.php?token='. $row['post_id'] .'" style ="text-decoration: none; color:black;">Delete</a></button>
                                        <button class="card_link2"><a href="viewpost.php?token='. $row['post_id'] .'" class = "link">View article</a></button>
                                        </form>
                            </div>
                            </div>
                    </div>';
                    } 
               ?> 
               <script type="text/javascript">
                    var elems = document.getElementsByClassName('card_link1');
                    var confirmIt = function (e) {
                        if (!confirm('Are you sure?')) e.preventDefault();
                    };
                    for (var i = 0, l = elems.length; i < l; i++) {
                        elems[i].addEventListener('click', confirmIt, false);
                    }
                </script>


            </div>
</div>
</div>
</body>

</html>