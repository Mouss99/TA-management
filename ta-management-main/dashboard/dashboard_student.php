<?php
  // Start the session
  session_start();

  $id = $_SESSION["email"];

  $servername = "localhost";
  $username = "root";
  $db_password = "";
  $dbname = "ta-management";

  // Connect to database and check if successful
  $conn = mysqli_connect($servername, $username, $db_password, $dbname);


  if(isset($_POST['submit'])){

      //fields set as required, no need to check input
      $ta_info_string = $_POST['TA'];
      $ta_info = (explode(" ", $ta_info_string));
      $comment =  $_POST['comment'] ?? false;
      $rating =  $_POST['rating'];
      $ta_email = $ta_info[0];
      $ta_course = $ta_info[1] . ' ' . $ta_info[2];
      $ta_term = $ta_info[3];
      $ta_year = $ta_info[4];
      $anonymous = $_POST['anonymous'] ?? false;

      //if user didn't choose anonymous option add his name to DB as reviewer
      if (empty ($anonymous)){

        $query = "insert into ta_rating (rated_by,rating_for,course,term,year,rating,comment) values ('$id','$ta_email', '$ta_course','$ta_term','$ta_year','$rating','$comment')";
        mysqli_query($conn, $query);
      }

      //else add 'anonymous' as reviewer
      else{
      $query = "insert into ta_rating (rated_by,rating_for,course,term,year,rating,comment) values ('Anonymous','$ta_email', '$ta_course','$ta_term','$ta_year','$rating','$comment')";
      mysqli_query($conn, $query);
      }

      //redirect to main dashboard after successful rating submission
      echo "<script>
      alert('Submission successful! Redirected to main page');
      window.location.href='./dashboard.php';
      </script>";
      die; }

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Rate a TA</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="dashboard.css" rel="stylesheet" />
    <link rel="icon" href="../media/favicon.ico" type="image/ico">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
      integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"

    />
    <link rel="stylesheet" href="dashboard_student.css">
  
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- script to redirect the user to the appropriate page -->
    <script>
        jQuery(function($) {
        $("#jquery-select").on('change', function() {
            var url = $(this).val();

            if($(this).val()=="0")
            window.location = "dashboard.php" 

            if($(this).val()=="1")
            window.location = "dashboard_student.php" 
            
            if($(this).val()=="2")
            window.location = "dashboard_select_course.php" 

            if($(this).val()=="3")
            window.location = "dashboard_select_course.php" 

            if($(this).val()=="4")
            window.location = "dashboard_admin.php" 

            if($(this).val()=="5")
            window.location = "dashboard_sysop.php" 
            });
        });
      </script>
      <!--display email address near top right -->
      <style>
        @media only screen and (max-width: 1000px) {
          .email_address {
            display: none;
          }
        }  
      </style>
      
      
      <script>
      //alphabetical ordering of TA dropdown 
      $(function() {
        // choose target dropdown
        var select = $("#TA");

        select.html(select.find('option').sort(function(x, y) {
          // to change to descending order switch "<" for ">"
          return $(x).text() > $(y).text() ? 1 : -1;
        }));

      });
      </script>

  </head>

  <body >
    <script src="./manage_users.js"></script>
    <script src="./manage_courses.js"></script>
    <script src="./manage_profs.js"></script>
    <script
      src="https://code.jquery.com/jquery-3.3.1.js"
      integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
      integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
      crossorigin="anonymous"
    ></script>
    <div class="container" >
      <nav class="navbar">
        <!-- Header -->
        <div class="container-fluid">
          <!-- Logo and User Role  -->
          <div class="d-flex align-items-center">
          <a href="./dashboard.php">
            <img
              src="../media/mcgill_logo.png"
              style="width: 14rem; height: auto"
              alt="mcgill-logo"
            /></a>
            <select class="custom-select" id = "jquery-select">
                <option value="0" selected="selected"  >Dashboard</option>
                <option value="1" selected="selected"  >Rate a TA</option>

                <?php

                    $conn = mysqli_connect("localhost","root","","ta-management");

                    if ($conn -> connect_error){
                    die ("Connection failed: " . $conn->connect_error);
                    }

                    //get max value of userType ID to give the user access to the pages that he is allowed to
                    $query = "SELECT MAX(userTypeId) FROM user_usertype WHERE userId = '$id'";
                    $query_run = mysqli_query($conn, $query);
              
              
                    if(mysqli_num_rows($query_run) > 0)
                    {   
                        while ($row = $query_run->fetch_assoc()){
                          
                          //if user is a sysop (id = 5) give him access to all pages.
                          if ($row['MAX(userTypeId)'] == 5){
                            echo '<option value="2" selected="selected"  >TA management </option>';
                            echo '<option value="4" selected="selected"   >TA administration</option>';
                            echo '<option value="5" selected="selected" >Sysop Tasks</option>';
                          }
              
                          if ($row['MAX(userTypeId)'] == 4){
                            echo '<option value="2" selected="selected" >TA management </option>';
                            echo '<option value="4" selected="selected" >TA administration</option>';
                          }
                          
                          if ($row['MAX(userTypeId)'] == 3 || $row['MAX(userTypeId)'] ==2) {
                            echo '<option value="2" selected="selected" >TA management </option>';
                
                           }
                    }
                }

                ?>
                <option hidden disabled selected value> -- change page -- </option>
            </select>
          </div>
          <!-- Logout -->
          <div style="display:flex;">
            <div style="font-size:24px; color: #007bff;" class="email_address"><?php echo $id ?></div>
            <div style="float:right;">
              <button
                type="button"
                class="btn btn-link"
                onclick="window.location.replace('../logout/logout.html')"
              >
                <i class="fa fa-sign-out" style="font-size: 24px; color: #007bff;"></i>
              </button>
            </div>
          </div>
      </nav>
              </div>
      
      <br><br>
      
      <div class="form-container" id="form1" style = "background-color='#fff'">
        <form action="./dashboard_student.php" method="post">
          <h1> Rate your TA </h1>

          <br><br>

          <!-- SELECT TA -->
                  
          <label for ="ta"><h5> Select the TA you would like to rate</h5></label><br>
            
          <!-- Display all available TA to the user from the DB with their according course, semester and year. -->
            <select name="TA" id="TA" required class="custom-select" style="width:200px;">
              
              <?php

                $conn = mysqli_connect("localhost","root","","ta-management");

                if ($conn -> connect_error){
                  die ("Connection failed: " . $conn->connect_error);
                  }

                #distinct to avoid duplicates terms and year combinations
                $ta_query = "SELECT DISTINCT * FROM all_ta ";
                
                $result = mysqli_query($conn, $ta_query);
                
                if(mysqli_num_rows($result) > 0){
                    foreach($result as $r){
                        $email = $r['email'];
                        $fname = $r['firstName'];
                        $lname = $r['lastName'];
                        $course = $r['courseNumber'];
                        $term = $r['term'];
                        $year = $r['year'];
                        
                        $ta_val= $email .' ' . $course . ' ' . $term . ' ' .$year;

                        //echo TA from DB as an option 
                        echo "<option value= '$ta_val'/> $fname $lname $course/$term $year <br>";
                    }
                }
              ?>
              
            </select>
            <br><br>
                
            <textarea name = "comment" class="comment" placeholder = "Leave a comment here..."></textarea>

            <br><br>

            <h5 style = 'color:black'><input type="checkbox" name="anonymous" value='anonymous' /> Anonymous review </h5> <br>

            <fieldset class="rating">
              <legend> <h5>Rating out of 5</h5></legend>
              <input type="radio" id="no-rate" class="input-no-rate" name="rating" value="0" checked=""
                  aria-label="No rating." required>

              <input type="radio" id="rate1" name="rating" value="1" >
              <label for="rate1">1 star</label>

              <input type="radio" id="rate2" name="rating" value="2">
              <label for="rate2">2 stars</label>

              <input type="radio" id="rate3" name="rating" value="3">
              <label for="rate3">3 stars</label>

              <input type="radio" id="rate4" name="rating" value="4">
              <label for="rate4">4 stars</label>

              <input type="radio" id="rate5" name="rating" value="5">
              <label for="rate5">5 stars</label>

              <span class="focus-ring"></span>
            </fieldset>  <br>
            
            
            <button type="submit" class ="confirm-btn" id="confirm-btn" name="submit" >Submit</button> <br><br>

        </form>
      </div>
        <div class="footer">.</div> 

  </body>

</html>