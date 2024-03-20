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
    <title>TA Administration</title>
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
  <style type="text/css">
    .import-button {
        margin-top: 20px;
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

    .change_color {
      background-color: #ec1b2f;
    }

    .alert_text {
      color: #ec1b2f;
      font-weight: bold;
    }

    .fix_error_div {
      margin-bottom: 20px;
    }

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

    .confirm-btn {
      border: 1px solid black ;
      color: rgb(0, 0, 0);
      padding: 12px 24px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      font-weight: bold;
      margin: 4px 2px;
      transition-duration: 0.4s;
      cursor: pointer;
  }

  .confirm-btn:hover {
    background: crimson;
    font-weight: bold;
    color:#fff;
  }

  @media only screen and (max-width: 1000px) {
  
    .email_address {
      display: none;
    }
  }
  </style>

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
            <select class="custom-select" id="jquery-select">
              <option value="0" selected="selected"  >Dashboard</option>
              <option value="1" selected="selected"  >Rate a TA</option>
              
              <?php
                $query = "SELECT MAX(userTypeId) FROM user_usertype WHERE userId = '$id'";
                $query_run = mysqli_query($conn, $query);
          
          
                if(mysqli_num_rows($query_run) > 0)
                {
                    while ($row = $query_run->fetch_assoc()){
                      if ($row['MAX(userTypeId)'] == 5){
                        echo '<option value="2" selected="selected">TA management </option>';
                        echo '<option value="4" selected="selected">TA administration</option>';
                        echo '<option value="5" selected="selected">Sysop tasks</option>';
                      }
          
                      if ($row['MAX(userTypeId)'] == 4){
                        echo '<option value="2" selected="selected" >TA management</option>';
                        echo '<option value="4" selected="selected" >TA administration</option>';
                      }
                      
                      if ($row['MAX(userTypeId)'] == 3 || $row['MAX(userTypeId)'] ==2) {
                        echo '<option value="2" selected="selected" >TA management</option>';
                      }
                }
              }
              ?>
              <option hidden disabled selected value> -- change page -- </option>
            </select>
          </div>
          <!-- Logout -->
          <div style="display:flex;">
            <div class="email_address"style="font-size:24px; color: #007bff;"><?php echo $id ?></div>
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
        </div>
      </nav>
      <nav>
        <!-- Show the nagivation options on the webpage -->
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a
            class="nav-item nav-link active"
            data-toggle="tab"
            href="#nav-ta-info"
            role="tab"
            >TA Info</a
          >
          <a
            class="nav-item nav-link"
            data-toggle="tab"
            href="#nav-ta-history"
            role="tab"
            >TA History</a
          >
          <a
            class="nav-item nav-link"
            data-toggle="tab"
            href="#nav-courses"
            role="tab"
            >Courses</a
          >
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-ta-info" role="tabpanel">
            <!-- Import TA cohort -->
          <button
          type="button"
          class="btn btn-outline-secondary import-button"
          data-toggle="modal"
          data-target="#import-ta"
        >
          <i class="fa fa-download"></i>
          Import TA Cohort
        </button>
        <div class="modal fade" id="import-ta" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form
                id="upload-user-form"
                action="../cgi_bin/import_ta_cohort.php"
                method="post"
                enctype = "multipart/form-data"
              >
                <div class="modal-header">
                  <h3 class="modal-title">Import TA Cohort</h3>
                  <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                  >
                    <i class="fa fa-close"></i>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="file" name="myfile"/>
                </div>
                <div class="modal-footer">
                  <input
                    type="button"
                    class="btn btn-light"
                    data-dismiss="modal"
                    value="Cancel"
                  />
                  <input type="submit" class="btn btn-light" />
                </div>
              </form>
            </div>
          </div>
        </div>
          <!-- View the TA info on this page -->
          <div style="text-align: center;"><h3 style="margin-top: 20px; color: #a72530">Click on a TA to view their application</h3></div>
          <?php
            $result = $conn -> query("SELECT * FROM ta_cohort ORDER BY TermYear");
              while($row = mysqli_fetch_array($result)) {
          ?>
            <!-- Get the info from the ta_cohort database -->
            <button class="accordion"><?php echo $row['TAName']?> <?php echo " - " . $row['TermYear'] ?></button>
            <div class="panel" style="margin-top: 20px;">
              <p><b>Legal name: </b><?php echo $row['LegalName']?></p>
              <p><b>Student ID: </b><?php echo $row['StudentID']?></p>
              <p><b>Email: </b><?php echo $row['Email']?></p>
              <p><b>Grad/Ugrad: </b><?php echo $row['GradUgrad']?></p>
              <p><b>Supervisor Name: </b><?php echo $row['SupervisorName']?></p>
              <p><b>Priority: </b><?php echo $row['Priority']?></p>
              <p><b>Number of hours: </b><?php echo $row['NumberHours']?></p>
              <p><b>Date Applied: </b><?php echo $row['DateApplied']?></p>
              <p><b>Location: </b><?php echo $row['TheLocation']?></p>
              <p><b>Phone: </b><?php echo $row['Phone']?></p>
              <p><b>Degree: </b><?php echo $row['Degree']?></p>
              <p><b>Courses Applied To: </b><?php echo $row['CoursesApplied']?></p>
              <p><b>Open to other courses: </b><?php echo $row['OpenToOtherCourses']?></p>
              <p><b>Notes: </b><?php echo $row['Notes']?></p>
            </div>
          <?php
            }
          ?>
        </div>
        <div class="tab-pane fade" id="nav-ta-history" role="tabpanel">
          <!-- View the TA history on this page -->
        <div style="text-align: center;"><h3 style="margin-top: 20px; color: #a72530">Click on a TA to view their history</h3></div>
        <?php
            $result = $conn -> query("SELECT * FROM ta_cohort GROUP BY Email");
              while($row = mysqli_fetch_array($result)) {
          ?>
            <!-- Get the records from the ta_history database -->
            <button class="accordion"><?php echo $row['TAName']?></button>
            <div class="panel" style="margin-top: 20px;">
              <p><b>Legal name: </b><?php echo $row['LegalName']?></p>
              <p><b>Student ID: </b><?php echo $row['StudentID']?></p>
              <p><b>Email: </b><?php echo $row['Email']?></p>
              <h3 style="margin: 50px 0px 20px 0px;">TA Record</h3>
              <?php
              $email = $row['Email'];
              $result1 = $conn -> query("SELECT * FROM ta_history WHERE TAEmail='$email' ORDER BY TermYear");
              if (mysqli_num_rows($result1) == 0) { ?>
                <p><b><?php echo "Never been a TA" ?></b></p>
              <?php }
              while($row1 = mysqli_fetch_array($result1)) { ?>
              <p><b><?php echo $row1['TermYear'] . ": " ?></b><?php echo $row1['CourseNumber']?></p>
              <?php
                }
              ?>
              <!-- Get the student ratings from the database -->
              <h3 style="margin: 50px 0px 20px 0px;">Ratings</h3>
              <?php
              $average = 0;
              $counter = 0;
              $email = $row['Email'];
              $result2 = $conn -> query("SELECT * FROM ta_rating WHERE rating_for='$email'");
              while($row2 = mysqli_fetch_array($result2)) {
                $counter = $counter + 1;
                $average = $average + $row2['rating'];
              }
              echo "<p><b>Average rating: </b>"; 
              if (mysqli_num_rows($result2) > 0) {
                $average = $average / $counter;
                echo "<b>" . $average . "/5</b></p>"; 
              } ?>
              <?php
              $result2 = $conn -> query("SELECT * FROM ta_rating WHERE rating_for='$email'");
              while($row2 = mysqli_fetch_array($result2)) { ?>
              <p><?php echo "<b>Comment from " . $row2['rated_by'] . " in " . $row2['course'] . " - " . $row2['term'] . " " . $row2['year'] . ": " . "</b>" . "<i>" . $row2['comment'] . "</i>"; ?></p>
              <p></p>
              <?php
                }
              ?>
              <!-- Get the student performance log from the database -->
              <h3 style="margin: 50px 0px 20px 0px;">Performance Log</h3>
              <?php
              $email = $row['Email'];
              $result3 = $conn -> query("SELECT * FROM ta_performance WHERE TAEmail='$email'");
              if (mysqli_num_rows($result3) == 0) { ?>
                <p><b><?php echo "No record found" ?></b></p>
              <?php }
              while($row3 = mysqli_fetch_array($result3)) { ?>
              <p><?php echo "<b>Comment from prof in " . $row3['CourseNumber'] . " - " . $row3['TermYear'] . ": " . "</b>" . "<i>" . $row3['Comment'] . "</i>"; ?></p>
              <p></p>
              <?php
                }
              ?>
              <!-- Show the admin if a student is on a prof's wishlist -->
              <h3 style="margin: 50px 0px 20px 0px;">Prof wishlist</h3>
              <?php
              $email = $row['Email'];
              $result4 = $conn -> query("SELECT * FROM ta_wishlist WHERE TAEmail='$email'");
              if (mysqli_num_rows($result4) == 0) { ?>
                <p><b><?php echo "Not on any wishlist" ?></b></p>
              <?php }
              while($row4 = mysqli_fetch_array($result4)) { ?>
              <p><?php echo "<i>TA on " . $row4['ProfName'] . "'s wishlist for " . $row4['CourseNumber'] . " - " . $row4['TermYear'] . "</i>"; ?></p>
              <p></p>
              <?php
                }
              ?>
            </div>
          <?php
            }
          ?>
        </div>
        <div class="tab-pane fade" id="nav-courses" role="tabpanel">
          <!-- Import TA cohort -->
            <button
          type="button"
          class="btn btn-outline-secondary import-button"
          data-toggle="modal"
          data-target="#import-quota"
        >
          <i class="fa fa-download"></i>
          Import Courses Quota
        </button>
        <div class="modal fade" id="import-quota" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form
                id="upload-user-form"
                action="../cgi_bin/import_course_quota.php"
                method="post"
                enctype = "multipart/form-data"
              >
                <div class="modal-header">
                  <h3 class="modal-title">Import Courses Quota</h3>
                  <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                  >
                    <i class="fa fa-close"></i>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="file" name="myfile"/>
                </div>
                <div class="modal-footer">
                  <input
                    type="button"
                    class="btn btn-light"
                    data-dismiss="modal"
                    value="Cancel"
                  />
                  <input type="submit" class="btn btn-light" />
                </div>
              </form>
            </div>
          </div>
        </div>
            <!-- View the list of courses on this page -->
            <div style="text-align: center;"><h3 style="margin-top: 20px; color: #a72530">Click on a course for more info</h3></div>
            <?php
                $result = $conn -> query("SELECT * FROM courses_quota ORDER BY TermYear");
                while($row = mysqli_fetch_array($result)) {
            ?>
                <!-- Get the info from the courses_quota database -->
                <button class="accordion"><?php echo $row['CourseNumber']?></button>
                <div class="panel" style="margin-top: 20px;">
                <p>
                  <b>Term Year: </b>
                  <span><?php echo $row['TermYear']?></span>
                </p>
                <p><b>Course Name: </b><?php echo $row['CourseName']?></p>
                <p><b>Course Type: </b><?php echo $row['CourseType']?></p>
                <p><b>Instructor Name: </b><?php echo $row['InstructorName']?></p>
                <p><b>Enrollment Number: </b><b style="font-weight: normal;" class="enrollment-number"><?php echo $row['EnrollmentNumber']?></b></p>
                <p><b>TA Quota: </b><b style="font-weight: normal;" class="ta-quota"><?php echo $row['TAQuota']?></b></p>
                <p><b>Remaining TA positions to assign: </b><b style="font-weight: normal;"><?php echo $row['PositionsToAssign']?></b></p>
                <?php
                  $term = $row['TermYear'];
                  $course_num = $row['CourseNumber'];
                  $result4 = $conn -> query("SELECT TAName FROM ta_assigned WHERE (TermYear='$term' AND CourseNum='$course_num')");
                ?>
                <!-- Get the TAs assigned to each course and display them-->
                <p><b>TA's assigned so far: </b>
                <?php
                  while ($row_ta = mysqli_fetch_array($result4)) { echo $row_ta['TAName'] . ", "; }  
                ?>
                </p>
                </div>       
            <?php
                }
            ?>
            <?php
                $result1 = $conn -> query("SELECT DISTINCT TermYear FROM courses_quota ORDER BY TermYear"); 
                while($row = mysqli_fetch_array($result1)) {
              ?>
              <!-- Add TA to a course for each unique semester-->
            <div>
            <h1 style="margin: 50px 0px 20px 0px; color: #a72530;">Add TA to a course in <?php echo $row['TermYear'];?> </h1>
            <form action="../cgi_bin/add_ta_to_course.php" method="post">
                <?php
                $term_year = $row['TermYear'];
                ?>
                <input style="display: none;" type="text" name="term" value="<?php echo $term_year; ?>">
                <?php $result2 = $conn -> query("SELECT Email FROM ta_cohort WHERE TermYear = '$term_year' AND TAName NOT IN (SELECT TAName from ta_assigned WHERE TermYear = '$term_year')"); ?>
                <i>Choose a TA to add:</i>
                <select style="width:auto;" name="chosenTA" class="custom-select" required>
            <?php
                while($row2 = mysqli_fetch_array($result2)) {
            ?>   
                  <option value="<?php echo $row2['Email']; ?>">
                  <?php echo $row2['Email']; ?>
                  </option>
                  <?php
                }
                ?>
                </select>
                <?php $result3 = $conn -> query("SELECT CourseNumber FROM courses_quota WHERE (TermYear = '$term_year' AND PositionsToAssign > 0)"); ?>
                <p></p>
                <i>Choose a course for the TA:</i>
                <select style="width:auto;" name="chosenCourse" class="custom-select" required>
            <?php
                while($row3 = mysqli_fetch_array($result3)) {
            ?>   
                  <option value="<?php echo $row3['CourseNumber']; ?>">
                  <?php echo $row3['CourseNumber']; ?>
                  </option>
                  <?php
                }
                ?>
                </select>
                <p></p>
                <input style="cursor: pointer;" class="confirm-btn" type="submit">
              </form> 
              </div>
              <?php } ?> 
              
              <?php
                $result4 = $conn -> query("SELECT * FROM ta_assigned ORDER BY TermYear"); 
              ?>
              <!-- Remove TA from a course they have been assigned to-->
            <div>
            <h1 style="margin: 50px 0px 20px 0px; color: #a72530;">Remove a TA from a course</h1>
            <form action="../cgi_bin/remove_ta_from_course.php" method="post">
              <p></p>
              <i>Choose which TA to remove: </i>
              <select style="width:auto;" class="custom-select" name="chosenID" required>
            <?php
                while($row4 = mysqli_fetch_array($result4)) {
            ?>   
                  <option class="select-options" value="<?php echo $row4['AssignID']; ?>">
                  <?php echo $row4['TAEmail'] . " from " . $row4['CourseNum'] . " - " . $row4['TermYear']; ?>
                  </option>
                  <?php
                }
                ?>
                </select>
                <p></p>
                <input style="margin: 0px 0px 100px 0px; cursor: pointer;" class="confirm-btn" type="submit">
              </form> 
              </div>  
        </div>
      </div>
    </div>
    <div style="margin: 0px 0px 100px 0px;"></div>
    <div class="footer">.</div> 
    <script src="./dashboard_admin.js"></script>
  </body>
</html>