<?php
// Start the session
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$db = "ta-management";
$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_SESSION["email"];
$input = $_POST['course'];
$string_array = explode("|", $input);
$isProf = false;
$isProf_js = "no";

if (count($string_array) == 1 ) {
  // check if user is a TA
  $recordID = $string_array[0];
  $result = $conn->query("SELECT * FROM ta_history WHERE RecordID=$recordID");
  $row = mysqli_fetch_assoc($result);
  $term = $row['TermYear'];
  $selected_course = $row['CourseNumber'];
} else {
  // else, user is a prof or an admin
  $selected_course = $string_array[0];
  $term = $string_array[1] . " " . $string_array[2];
  $isProf = true;
  $isProf_js = "yes";
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>TA Management</title>
    <link href="dashboard_ta_management.css" rel="stylesheet" />
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
    <style type="text/css">
      .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        height:50px;
        background-color: #DC241F;
        color:#DC241F;
        text-align: center;
      }
      .prof {
        display: block;
      }

      .accordion {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
      }

      .active2, .accordion:hover {
        background-color: #ccc; 
      }

      .panel {
        padding: 0 18px;
        display: none;
        background-color: white;
        overflow: hidden;
      }

      @media only screen and (max-width: 1000px) {
        .email_address {
          display: none;
        }
      }  

    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- script to redirect the user to the appropriate page -->
    <script>
        jQuery(function($) {
        $('#jquery-select').on('change', function() {
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


  </head>
  <body>
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
    <div class="container">
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
            <!-- code to show the user which webpages they have access to -->
            <select class="custom-select" id= "jquery-select">
            
                <option value="0" selected="selected"  >Dashboard</option>
                <option value="1" selected="selected"  >Rate a TA </option>

                <?php
                    $query = "SELECT MAX(userTypeId) FROM user_usertype WHERE userId = '$id'";
                    $query_run = mysqli_query($conn, $query);
              
                    if(mysqli_num_rows($query_run) > 0)
                    {
                        while ($row = $query_run->fetch_assoc()){

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
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <!-- TA performance log - Displayed for a prof only -->
        <a
            class="nav-item nav-link active prof"
            data-toggle="tab"
            href="#nav-log"
            role="tab"
            >TA performance log</a
          >
          <!-- All TAs report - Displayed for a prof only -->
          <a
            class="nav-item nav-link prof"
            data-toggle="tab"
            href="#nav-wishlist"
            role="tab"
            >TA wishlist</a
          >
           <!-- Office Hours -->
          <a
            class="nav-item nav-link"
            data-toggle="tab"
            href="#nav-office"
            role="tab"
            >Office Hours</a
          >
          <!-- Channel -->
          <a
            class="nav-item nav-link"
            data-toggle="tab"
            href="#nav-channel"
            role="tab"
            >Channel</a
          >
          <!-- All TAs Report - Displayed for a prof only -->
          <a
            class="nav-item nav-link prof"
            data-toggle="tab"
            href="#nav-report"
            role="tab"
            >All TAs Report</a
          >
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
      <br>
      <h1 style="color: #a72530; font-size:50px;"><?php echo $selected_course . " - " . $term;?></h1>
        <!-- TA performance log - Displayed for a prof only -->
        <div class="tab-pane fade show active prof" id="nav-log" role="tabpanel">
            <div class="form-container" id="form1" style = "background-color='#fff'">
              <form action="../cgi_bin/add_ta_performance.php" method="post">
                <h1 style="color: #a72530;">Write a TA performance </h1>
                <br><br>
                <!-- SELECT TA -->
                <label for ="ta"><h5 style="color: #a72530;">Select the TA from the list</h5></label><br>
                    
                  <select name="TA" id="TA" required class="custom-select" style="width:auto;" required>
                    <?php
                      $ta_query = "SELECT * FROM ta_history WHERE CourseNumber='$selected_course' AND TermYear='$term'";
                      
                      $result = mysqli_query($conn, $ta_query);
                      
                      if(mysqli_num_rows($result) > 0){
                          foreach($result as $r){
                            $email = $r['TAEmail'];
                            $name = $r['TAName']; ?>
                            <option value= "<?php echo $name . "|" . $email . "|" . $selected_course . "|" . $term; ?>"><?php echo $name ?></option>
                          <?php
                          }
                      }
                      else
                      {
                      echo "No Record Found";
                      }
                    ?>
                  </select>
                  <br><br>
                  <!-- Add comment -->
                  <textarea name = "comment" class="comment" placeholder = "Leave a comment here."></textarea>
                  <br><br>            
                  <button type="submit" class ="confirm-btn" id="confirm-btn" name="submit" >Submit</button> <br><br>
              </form>
            </div>
              <div style="margin:0px 0px 100px 0px;">
              <h1 style="text-align:center; margin-top: 20px; color: #a72530;">View your TA performance log</h1>
              <?php $result = $conn -> query("SELECT * FROM ta_performance WHERE (TermYear='$term' AND CourseNumber='$selected_course')");
              while($row = mysqli_fetch_array($result)) {
            ?>
                <!-- Get the info from the ta_history database -->
                <button class="accordion"><?php echo $row['TAName']?></button>
                <div class="panel" style="margin-top: 20px;">
                  <p><b>TA Email: </b><?php echo $row['TAEmail']?></p>
                  <p><b>Comment: </b><i><?php echo $row['Comment']?></i></p>
                  <p><b>Time stamp: </b><?php echo $row['TimeStamp']?></p>
                </div>
              <?php
                }
              ?>
              </div>
      </div>

        <!-- Wishlist - Displayed for a prof only -->
        <div class="tab-pane fade prof" id="nav-wishlist" role="tabpanel">
        <div class="form-container" id="form1" style = "background-color='#fff'">
              <form action="../cgi_bin/add_ta_to_wishlist.php" method="post">
                <h1 style="color: #a72530;">TA Wishlist</h1>
                <br><br>
                <!-- SELECT TA -->
                <label for ="ta"><h5 style="color: #a72530;">Select the TA you wish to have from the list below</h5></label><br>
                    
                  <select name="TA" id="TA" required class="custom-select" style="width:auto;" required>
                    <?php
                      $query = "SELECT firstName, lastName FROM user WHERE email = '$id'";
                      $result = mysqli_query($conn, $query);
                      $row = $result->fetch_assoc(); 
                      $prof_name = $row['firstName'] . " " . $row['lastName'];
                      
                      #email query
                      $ta_query = "SELECT DISTINCT Email FROM ta_cohort WHERE Email NOT IN (SELECT TAEmail FROM ta_wishlist WHERE (TermYear='$term' AND CourseNumber='$selected_course'))";
                      
                      $result = mysqli_query($conn, $ta_query);
                      
                      if(mysqli_num_rows($result) > 0){
                          foreach($result as $r){
                            $email = $r['Email'];
                            
                            #TA name query
                            $ta_name_query = "SELECT TAName FROM ta_cohort WHERE Email='$email'";
                            $result1 = mysqli_query($conn, $ta_name_query);
                            $row1 = $result1->fetch_assoc(); 
                            $name = $row1['TAName']; 
                      ?>
                            <option value= "<?php echo $name . "|" . $email . "|" . $selected_course . "|" . $term . "|" . $prof_name;?>"><?php echo $name ?></option>
                          <?php
                          }
                      }
                      else
                      {
                      echo "No Record Found";
                      }
                    ?>
                  </select>
                  <br><br>         
                  <button type="submit" class ="confirm-btn" id="confirm-btn" name="submit" >Submit</button> <br><br>
              </form>
            </div>
              <div style="margin:0px 0px 100px 0px;">
              <h1 style="text-align:center; margin-top: 20px; color: #a72530;">View your TA Wishlist</h1>
              <?php $result = $conn -> query("SELECT * FROM ta_wishlist WHERE (TermYear='$term' AND CourseNumber='$selected_course')");
              while($row = mysqli_fetch_array($result)) {
            ?>
                <!-- Get the info from the ta_wishlist database -->
                <button class="accordion"><?php echo $row['TAName']?></button>
                <div class="panel" style="margin-top: 20px;">
                  <p><b>TA Email: </b><?php echo $row['TAEmail']?></p>
                </div>
              <?php
                }
              ?>
              </div>
        </div>

        <!-- Office Hours -->
        <div class="tab-pane fade" id="nav-office" role="tabpanel">
        </div>
        
        <!-- Channel -->
        <div class="tab-pane fade" id="nav-channel" role="tabpanel">
        </div>
        
        <!-- All TAs Report - Displayed for a prof only -->
        <div class="tab-pane fade prof" id="nav-report" role="tabpanel">
        </div>
        <?php $conn->close(); ?>
    </div>
    <div class="footer">.</div> 
    <script>
      // show certain navigation options only to a prof user
      var isProf = "<?php echo $isProf_js; ?>";
      if (isProf == "no") {
        var classes = document.getElementsByClassName('prof');
        console.log(classes);
        for (var i = 0; i < classes.length; i++) {
          classes[i].style.display = 'none';
        }
      }
    </script>
    <script src="./dashboard_ta_management.js"></script>
  </body>
</html>
