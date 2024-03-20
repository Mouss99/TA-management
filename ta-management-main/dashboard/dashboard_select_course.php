<?php
// Start the session
session_start();

$id = $_SESSION["email"];

$conn = mysqli_connect("localhost","root","","ta-management");
if ($conn -> connect_error){
  die ("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>TA Management</title>

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
    <link rel="stylesheet" href="dashboard_select_course.css">
    
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
    <style>
      @media only screen and (max-width: 1000px) {
        .email_address {
          display: none;
        }
      }  
    </style>
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
            <select class="custom-select" id = "jquery-select">
                <option value="0" selected="selected"  >Dashboard</option>
                <option value="1" selected="selected"  >Rate a TA</option>

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
      <br><br>
      
      <div class="form-container" id="form1">
        <form action="dashboard_ta_management.php" method="post">
          <h1> TA Management </h1>
          <br><br>
          <!-- Select Course -->      
          <label for ="course"><h5>Select the course you would like to see</h5></label><br>
              
            <select name="course" required>
              <?php
            
                $query = "SELECT userTypeId FROM user_usertype WHERE userId = '$id'";
                $query_run = mysqli_query($conn, $query);
          
                if(mysqli_num_rows($query_run) > 0)
                {
                    while ($row = $query_run->fetch_assoc()){
                      
                      // if the user is an admin or a sysop, show him all the courses in the database and let him enter as a prof
                      if ($row['userTypeId'] == 4 || $row['userTypeId'] == 5){
                        $query1 = "SELECT * FROM course";
                        $query_run1 = mysqli_query($conn, $query1);
          
                        if(mysqli_num_rows($query_run1) > 0) { 
                          while ($row1 = $query_run1->fetch_assoc()) { ?>
                            <option value="<?php echo $row1['courseNumber'] . "|" . $row1['term'] . "|" . $row1['year']; ?>">
                            <?php echo $row1['courseNumber'] . " - " . $row1['term'] . " " . $row1['year'] . " as an Admin"; ?>
                            </option>
                        <?php }
                        }
                      }
                      // if the user is a TA, show him all the courses for which he was TA in the past and the ones for which he is currently assigned as TA (data taken from the ta_history database)
                      else if ($row['userTypeId'] == 3){
                        $query3 = "SELECT * FROM ta_history WHERE TAEmail = '$id'";
                        $query_run3 = mysqli_query($conn, $query3);
          
                        if(mysqli_num_rows($query_run3) > 0) { 
                          while ($row3 = $query_run3->fetch_assoc()) { ?>
                            <option value="<?php echo $row3['RecordID']; ?>">
                            <?php echo $row3['CourseNumber'] . " - " . $row3['TermYear'] . " as TA"; ?>
                            </option>
                        <?php }
                        }
                      }
                      // if the user is a prof, show him all the courses in which they were an instructor (data taken from the course database)
                      else if ($row['userTypeId'] == 2 ) {
                        $query2 = "SELECT * FROM course WHERE courseInstructor = '$id'";
                        $query_run2 = mysqli_query($conn, $query2);
          
                        if(mysqli_num_rows($query_run2) > 0) { 
                          while ($row2 = $query_run2->fetch_assoc()) { ?>
                            <option value="<?php echo $row2['courseNumber'] . "|" . $row2['term'] . "|" . $row2['year']; ?>">
                            <?php echo $row2['courseNumber'] . " - " . $row2['term'] . " " . $row2['year'] . " as Prof"; ?>
                            </option>
                        <?php }
                        }
                      }
                }
            }
            ?>
            </select>
            <br>
            <button type="submit" class ="confirm-btn" id="confirm-btn" name="confirm" style="margin:50px 0px 0px 0px;">Confirm selection</button> <br><br>
            </div>
        </form>
      </div>
        <div class="footer">.</div> 
  </body>
</html>