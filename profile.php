<?php
session_start();
include 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
}
$table_data = "";
$username = $_SESSION['user_id'];
$FName = "";
$LName = "";
$Gender = "";
$Age = "";
$Email = "";
$User = "";
$CNumber = "";
$ProfileImahe="";
$Bio="";
$query1 = "SELECT * FROM users_tbl WHERE ID = '$username' LIMIT 1";
$query2 = "SELECT * FROM users_img WHERE ID = '$username' LIMIT 1";
$result1 = mysqli_query($conn, $query1);

if (mysqli_num_rows($result1)) {
    $row = mysqli_fetch_assoc($result1);
    $FName = $row['fname'];
    $LName = $row['lname'];
    $Sex = $row['sex'];
    $Age = $row['age'];
    $Email = $row['email'];
    $Cnum = $row['contactnumber'];
    $User = $row['username'];
}
$result2 = mysqli_query($conn, $query2);
if (mysqli_num_rows($result2)) {
    $row = mysqli_fetch_assoc($result2);
    $ProfileImahe=$row['profile_image'];
    $Bio = $row['bio'];
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"/>
    <link rel="stylesheet" href="style_editprofile.css"/>
    <title>Profile</title>
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
        <h2 style="text-align:center; border-top: 5px solid #5AC7C7; border-bottom: 5px solid #5AC7C7;  border-radius: 5px;">Profile</h2>
            <table class="content-table" style="width:95%;">
                <tr>
                    <th colspan="3"><a href="profile.php"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;Refresh</a></th>
                </tr>
                <tr style="background-color: #555; color: #fff;">
                    <th style="font-size: 17px;padding:15px">My Account</th>
                    <th style="font-size: 17px;padding:15px">Data</th>
                    <th style="font-size: 17px;padding:15px">Action</th>
                </tr>
                <tr style="background-color:#5AC7C7; color: black;">
                    <th colspan="2" style="padding:5px">Personal Information</th>
                    <td><a href="#" onclick="PersonalInformation('a','1','b','2','c','3','d','4')" id="edit1">Edit</a>
                    </td>
                </tr>
                <form name="frmProfile" method="post" enctype="multipart/form-data">
                    <tr>
                        <td>First Name</td>
                        <td>
                            <div id='1'><?php echo $FName ?></div>
                            <div id="a" style="display: none;"><input type="text/css" value=<?php echo $FName ?> id='txt_fname' name='fname'></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Last Name</td>
                        <td>
                            <div id='2'><?php echo $LName ?></div>
                            <div id="b" style="display: none;"><input type="text/css" value=<?php echo $LName ?> id='txt_lname' name='lname'></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Sex</td>
                        <td>
                            <div id='3'><?php echo $Sex ?></div>
                            <div id="c" style="display: none;"><input type="text/css" value=<?php echo $Sex ?> id='txt_sex' name='sex'></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Age</td>
                        <td>
                            <div id='4'><?php echo $Age ?></div>
                            <div id="d" style="display: none;"><input type="text/css" value=<?php echo $Age ?> id='txt_age' name='age'></div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button id="save1" style="display: none;margin-top:5px;" type="submit" name="save1">Save</button>
                            <button onclick="Cancel1('a','1','b','2','c','3','d','4','cancel1','edit1','save1')" id="cancel1" style="display: none;margin-top:5px">Cancel</button>
                        </td>
                    </tr>

                    <tr style="background-color: #5AC7C7; color: black;">
                        <th colspan="3" style="padding:5px">Profile Display</th>
                    </tr>
                    <tr>
                        <td>Profile Picture</td>
                        <td><div id='7'><?php echo $ProfileImahe ?></div><div style="display: none;" id="imahe"><?php echo "Select image:"?> <input type="file" name="fileToUpload" id="fileToUpload"/></div>
                    </td>
                        <td><button id="change1" type="submit" name="change1" onclick="Change1();return false;">Change</button>
                        <input type="submit" value="Save" name="submit" id="submit1" style="display: none;"/>
                        <input type="submit" value="Cancel" name="cancel" id="cancel3" style="display: none;"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Bio</td>
                        <td><div id='8'><?php echo $Bio ?></div>
                        <div id="g" style="display: none;"><input type="text/css" value='<?php echo $Bio ?>'  name='txt_bio'></div>
                    </td>
                        
                        <td><button id="change2" type="submit" name="change2" onclick="Change2();return false;">Change</button>
                        <input type="submit" value="Save" name="submit1" id="submit2" style="display: none;"/>
                        <input type="submit" value="Cancel" name="cancel1" id="cancel4" style="display: none;"/>
                    </td>
                    </tr>
                    <tr style="background-color: #5AC7C7; color: black;">
                        <th colspan="2" style="padding:5px">Contact Information</th>
                        <td><a href="#" onclick="ContactInformation('e','5','f','6')" id="edit2">Edit</a></td>
                    </tr>
                    <td>Email Address</td>
                    <td>
                        <div id='5'><?php echo $Email ?></div>
                        <div id="e" style="display: none;"><input type="email" value=<?php echo $Email ?> id='txt_email' name='email'></div>
                    </td>
                    </tr>
                    <tr>
                        <td>Contact Number</td>
                        <td>
                            <div id='6'><?php echo $Cnum ?></div>
                            <div id="f" style="display: none;"><input type="text/css" value=<?php echo $Cnum ?> id='txt_contactnum' name='contactnum'></div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button id="save2" style="display: none;margin-top:5px" type="submit" name="save2">Save</button>
                            <button onclick="Cancel2('e','5','f','6','cancel2','edit2','save2')" id="cancel2" style="display: none;margin-top:5px">Cancel</button>
                        </td>
                    </tr>
                    <tr style="background-color: #5AC7C7; color: black;">
                        <th colspan="3" style="padding:5px">Security and Verification</th>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td><?php echo $User ?></td>
                        <td><a href="#" onclick="PersonalInformation('a','1','b','2','c','3','d','4')">Edit</a></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>********</td>
                        <td><a href="#" onclick="PersonalInformation('a','1','b','2','c','3','d','4')">Edit</a></td>
                    </tr>
                    <tr>
                        <td>Varification Status</td>
                        <td>Not Verified</td>
                        <td><a href="#">Update</a></td>
                    </tr>

                </form>

                <?php

                echo  $table_data;

                ?>

        </div>
    </div>





</body>

</html>

<script>
    function PersonalInformation(a1, a2, b1, b2, c1, c2, d1, d2) {

        var z1 = document.getElementById(a1);
        var z2 = document.getElementById(a2);

        var y1 = document.getElementById(b1);
        var y2 = document.getElementById(b2);

        var x1 = document.getElementById(c1);
        var x2 = document.getElementById(c2);

        var w1 = document.getElementById(d1);
        var w2 = document.getElementById(d2);

        var edit = document.getElementById("edit1");
        var save = document.getElementById("save1");
        var cancel = document.getElementById("cancel1");

        if (z1.style.display === "none" && y1.style.display === "none" && x1.style.display === "none" && w1.style.display === "none") {
            z1.style.display = "block";
            z2.style.display = "none";
            y1.style.display = "block";
            y2.style.display = "none";
            x1.style.display = "block";
            x2.style.display = "none";
            w1.style.display = "block";
            w2.style.display = "none";
            edit.style.display = "none";
            save.style.display = "inline-block";
            cancel.style.display = "inline-block";
        }
        return false;
    }

    function ContactInformation(a1, a2, b1, b2) {
        var z1 = document.getElementById(a1);
        var z2 = document.getElementById(a2);

        var y1 = document.getElementById(b1);
        var y2 = document.getElementById(b2);

        var edit = document.getElementById("edit2");
        var save = document.getElementById("save2");
        var cancel = document.getElementById("cancel2");


        if (z1.style.display === "none" && y1.style.display === "none") {
            z1.style.display = "block";
            z2.style.display = "none";
            y1.style.display = "block";
            y2.style.display = "none";
            edit.style.display = "none";
            save.style.display = "inline-block";
            cancel.style.display = "inline-block";

        } else {
            z1.style.display = "none";
            z2.style.display = "block";
            y1.style.display = "none";
            y2.style.display = "block";

        }
    }

    function Cancel1(a1, a2, b1, b2, c1, c2, d1, d2, cancel, edit, save) {
        var z1 = document.getElementById(a1);
        var z2 = document.getElementById(a2);

        var y1 = document.getElementById(b1);
        var y2 = document.getElementById(b2);

        var x1 = document.getElementById(c1);
        var x2 = document.getElementById(c2);

        var w1 = document.getElementById(d1);
        var w2 = document.getElementById(d2);

        var x = document.getElementById(cancel);
        var y = document.getElementById(edit);
        var z = document.getElementById(save);


        if (x.style.display === "inline-block") {
            x.setAttribute.href = "?token=z";
            x.style.display = "none";
            y.style.display = "inline-block";
            z.style.display = "none";

            z1.style.display = "none";
            z2.style.display = "block";
            y1.style.display = "none";
            y2.style.display = "block";
            x1.style.display = "none";
            x2.style.display = "block";
            w1.style.display = "none";
            w2.style.display = "block";
        }
    }

    function Cancel2(a1, a2, b1, b2, cancel, edit, save) {
        var z1 = document.getElementById(a1);
        var z2 = document.getElementById(a2);

        var y1 = document.getElementById(b1);
        var y2 = document.getElementById(b2);

        var x = document.getElementById(cancel);
        var y = document.getElementById(edit);
        var z = document.getElementById(save);


        if (x.style.display === "inline-block") {
            x.style.display = "none";
            y.style.display = "inline-block";
            z.style.display = "none";
            z1.style.display = "none";
            z2.style.display = "block";
            y1.style.display = "none";
            y2.style.display = "block";
        }
    }
    function Change1(){
        var x=document.getElementById('submit1');
        var y=document.getElementById('cancel3');
        var z=document.getElementById('change1');
        var a=document.getElementById('imahe');
        var b=document.getElementById('7');

        if(x.style.display==="none"&&y.style.display==="none"){
            x.style.display="inline-block";
            y.style.display="inline-block";
            z.style.display="none";
            a.style.display="inline-block";
            b.style.display="none";
        }
    }
    function Change2(){
        var x=document.getElementById('submit2');
        var y=document.getElementById('cancel4');
        var z=document.getElementById('change2');
        var a=document.getElementById('g');
        var b=document.getElementById('8');
        
        if(x.style.display==="none"&&y.style.display==="none"){
            x.style.display="inline-block";
            y.style.display="inline-block";
            z.style.display="none";
            a.style.display="inline-block";
            b.style.display="none";
        }
    }
</script>

<?php
if (isset($_POST['save1'])) {
    $cfname = $_POST['fname'];
    $clname = $_POST['lname'];
    $csex = $_POST['sex'];
    $cage = $_POST['age'];

    $sql = "UPDATE users_tbl SET fname='$cfname',lname='$clname',sex='$csex',age='$cage' WHERE ID='$username'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<div class='alert alert-success'>Personal Information Changed!</div>";
    }
}
if (isset($_POST['save2'])) {
    $cemail = $_POST['email'];
    $ccnum = $_POST['contactnum'];
    $sql = "UPDATE users_tbl SET email='$cemail',contactnumber='$ccnum' WHERE ID='$username'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<div class='alert alert-success'>Contact Information changed!</div>";
    }
}


?>

<?php 
if (isset($_POST['submit1'])) {
    $cbio=$_POST['txt_bio'];

    $sql = "UPDATE users_img SET bio='$cbio' WHERE ID='$username'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<div class='alert alert-success'>Bio has been changed!</div>";
    }
}   
?>

<?php


// Check if image file is a actual image or fake image
if(isset($_POST["submit"])&&isset($_FILES["fileToUpload"])&&!empty($_FILES["fileToUpload"]["tmp_name"])) {
    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
     $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    echo "<div class='alert alert-danger'>File is not an image.</div>";
    $uploadOk = 0;
  }

  // Check if file already exists

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "<div class='alert alert-danger'>Your file is too large.</div>";
    $uploadOk = 0;
  }
  
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    echo "<div class='alert alert-danger'>Only JPG, JPEG, PNG & GIF files are allowed.</div>";
    $uploadOk = 0;
  }
  
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "<div class='alert alert-danger'>Sorry, your file was not uploaded.</div>";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $sql="UPDATE users_img SET profile_image='$target_file' WHERE ID='$username'";
        mysqli_query($conn,$sql);
      echo "<div class='alert alert-success'>Profile picture has been changed.</div>";
    } else {
      echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
    }
}


}

?>