<?php
// Start the session
session_start();

$id = $_SESSION["email"]

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Sysop Tasks</title>
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

      @media only screen and (max-width: 1000px) {
        .email_address {
          display: none;
        }
      }  
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
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
            <select class="custom-select" id= "jquery-select">
            
                <option value="0" selected="selected"  >Dashboard </option>
                <option value="1" selected="selected"  >Rate a TA </option>

                <?php

                    $conn = mysqli_connect("localhost","root","","ta-management");

                    if ($conn -> connect_error){
                    die ("Connection failed: " . $conn->connect_error);
                    }

                
                    $query = "SELECT MAX(userTypeId) FROM user_usertype WHERE userId = '$id'";
                    $query_run = mysqli_query($conn, $query);
              
              
                    if(mysqli_num_rows($query_run) > 0)
                    {
              
                      //while ($row = mysqli_fetch_array($result)){
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
          <a
            class="nav-item nav-link active"
            data-toggle="tab"
            href="#nav-profs"
            role="tab"
            >Professors</a
          >
          <a
            class="nav-item nav-link"
            data-toggle="tab"
            href="#nav-courses"
            role="tab"
            >Courses</a
          >
          <a
            class="nav-item nav-link"
            data-toggle="tab"
            href="#nav-users"
            role="tab"
            >Users</a
          >
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <br />
        <!-- Professors -->
        <div class="tab-pane fade show active" id="nav-profs" role="tabpanel">
          <div>
            <!-- Import Professors -->
            <button
              type="button"
              class="btn btn-outline-secondary"
              data-toggle="modal"
              data-target="#import-profs"
            >
              <i class="fa fa-download"></i>
              Import Professors
            </button>
            <div
              class="modal fade"
              id="import-profs"
              tabindex="-1"
              role="dialog"
            >
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form
                    id="upload-prof-form"
                    action="../cgi_bin/import_profs.php"
                    method="post"
                    enctype = "multipart/form-data"
                  >
                    <div class="modal-header">
                      <h3 class="modal-title">Import Professors</h3>
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
                      <input type="submit" class="btn btn-light"/>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Add Professors -->
            <br />
            <br />
            <div class="container d-flex flex-row">
              <div class="row">
                <div class="col-auto mr-auto">
                  <h2 id="title">All Professors</h2>
                </div>
              </div>
              <div class="col-auto align-self-center">
                <button
                  type="button"
                  class="btn btn-light"
                  data-toggle="modal"
                  data-target="#add-new-prof"
                >
                  <i class="fa fa-plus" style="font-size: 24px"></i>
                </button>
                <div
                  class="modal fade"
                  id="add-new-prof"
                  tabindex="-1"
                  role="dialog"
                >
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <form
                        id="add-profs-form"
                        action="../cgi_bin/add_profs.php"
                        method="post"
                      >
                        <div class="modal-header">
                          <h3 class="modal-title">Add a Professor</h3>
                          <button
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                          >
                            <i class="fa fa-close"></i>
                          </button>
                        </div>

                        <div class="modal-body">
                          <div id="prof-form-modal">
                            <input
                              class="form-control"
                              placeholder="Instructor Email"
                              type="text"
                              name="professor"
                            /><br />
                            <select class="form-control" name="faculty">
                              <option value="" selected disabled>
                                Select a Faculty...
                              </option>
                              <option value="Science">Science</option>
                              <option value="Engineering">Engineering</option>
                              <option value="Arts">Arts</option></select
                            ><br />
                            <select class="form-control" name="department">
                              <option value="" selected disabled>
                                Select a Department...
                              </option>
                              <option value="Computer Science">
                                Computer Science
                              </option>
                              <option value="Mathematics">Mathematics</option>
                              <option value="Physics">Physics</option></select
                            ><br />
                            <input
                              class="form-control"
                              placeholder="Course Number"
                              type="text"
                              name="course"
                            /><br />
                            <div id="prof-error-msg-cont"></div>
                          </div>
                        </div>

                        <div class="modal-footer">
                          <input
                            type="button"
                            class="btn btn-light"
                            data-dismiss="modal"
                            value="Cancel"
                          />
                          <input
                            type="submit"
                            class="btn btn-light"
                            value="Save"
                          />
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <br />

            <!-- Display Professors -->
            <div style="margin-bottom:100px;" id="profs-table"><?php include '../cgi_bin/get_profs.php';?></div>
          </div>
        </div>

        <!-- Courses -->
        <div class="tab-pane fade" id="nav-courses" role="tabpanel">
          <div>
            <!-- Import Courses -->
            <button
              type="button"
              class="btn btn-outline-secondary"
              data-toggle="modal"
              data-target="#import-courses"
            >
              <i class="fa fa-download"></i>
              Import Courses
            </button>
            <div
              class="modal fade"
              id="import-courses"
              tabindex="-1"
              role="dialog"
            >
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form
                    id="upload-course-form"
                    action="../cgi_bin/import_courses.php"
                    method="post"
                    enctype = "multipart/form-data"
                  >
                    <div class="modal-header">
                      <h3 class="modal-title">Import Courses</h3>
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
                      <input
                        type="submit"
                        class="btn btn-light"
                      />
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Add Courses -->
            <br />
            <br />
            <div class="container d-flex flex-row">
              <div class="row">
                <div class="col-auto mr-auto">
                  <h2 id="title">All Courses</h2>
                </div>
              </div>
              <div class="col-auto align-self-center">
                <button
                  type="button"
                  class="btn btn-light"
                  data-toggle="modal"
                  data-target="#add-new-course"
                >
                  <i class="fa fa-plus" style="font-size: 24px"></i>
                </button>
                <div
                  class="modal fade"
                  id="add-new-course"
                  tabindex="-1"
                  role="dialog"
                >
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <form
                        id="add-course-form"
                        action="../cgi_bin/add_courses.php"                          
                        method="post"
                        
                      >
                        <div class="modal-header">
                          <h3 class="modal-title">Add a Course</h3>
                          <button
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                          >
                            <i class="fa fa-close"></i>
                          </button>
                        </div>

                        <div class="modal-body">
                          <div id="course-form-modal">
                            <input
                              class="form-control"
                              placeholder="Please enter the course number."
                              type="text"
                              name="course-number"
                            /><br />
                            <input
                              class="form-control"
                              placeholder="Please enter the course name."
                              type="text"
                              name="course-name"
                            /><br />
                            <input
                              class="form-control"
                              placeholder="Please enter the course description."
                              type="text"
                              name="course-description"
                            /><br />
                            <input
                              class="form-control"
                              placeholder="Please enter the course term."
                              type="text"
                              name="course-term"
                            /><br />
                            <input
                              class="form-control"
                              placeholder="Please enter the course year."
                              type="text"
                              name="course-year"
                            /><br />
                            <input
                              class="form-control"
                              placeholder="Please enter the course instructor's email."
                              type="text"
                              name="instructor-email"
                            /><br />
                            <div id="course-error-msg-cont"></div>
                          </div>
                        </div>

                        <div class="modal-footer">
                          <input
                            type="button"
                            class="btn btn-light"
                            data-dismiss="modal"
                            value="Cancel"
                          />
                          <input
                            type="submit"
                            class="btn btn-light"
                            value="Save"
                          />
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <br />

            <!-- Display Courses -->
            <div style="margin-bottom:100px;" id="course-table"><?php include '../cgi_bin/get_courses.php';?></div>
          </div>
        </div>

        <!-- Users -->
        <div class="tab-pane fade" id="nav-users" role="tabpanel">
          <!-- Import Users -->
          <button
            type="button"
            class="btn btn-outline-secondary"
            data-toggle="modal"
            data-target="#import-users"
          >
            <i class="fa fa-download"></i>
            Import Users
          </button>
          <div class="modal fade" id="import-users" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form
                  id="upload-user-form"
                  action="../cgi_bin/import_users.php"
                  method="post"
                  enctype = "multipart/form-data"
                >
                  <div class="modal-header">
                    <h3 class="modal-title">Import Users</h3>
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
                    <input type="submit" class="btn btn-light"/>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Add Users -->
          <br />
          <br />
          <div class="container d-flex flex-row">
            <div class="row">
              <div class="col-auto mr-auto">
                <h2 id="title">All Users</h2>
              </div>
              <div class="col-auto align-self-center">
                <!-- Add Users -->
                <button
                  type="button"
                  class="btn btn-light"
                  data-toggle="modal"
                  data-target="#add-new-user"
                >
                  <i class="fa fa-plus" style="font-size: 24px"></i>
                </button>
                <div
                  class="modal fade"
                  id="add-new-user"
                  tabindex="-1"
                  role="dialog"
                >
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <form
                        id="add-user-form"
                        action="../cgi_bin/add_users.php"
                        method="post"
                      >
                        <div class="modal-header">
                          <h3 class="modal-title">Add a User</h3>
                          <button
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                          >
                            <i class="fa fa-close"></i>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div id="account-info">
                            <input
                              class="form-control"
                              placeholder="Enter the first name of the user"
                              type="text"
                              name="firstname"
                            /><br />
                            <input
                              class="form-control"
                              placeholder="Enter the last name of the user"
                              type="text"
                              name="lastname"
                            /><br />
                            <input
                              class="form-control"
                              placeholder="abc@xyz.com"
                              type="email"
                              name="email"
                            /><br />
                            <input
                              class="form-control"
                              placeholder="Enter temporary password"
                              type="password"
                              name="password"
                            /><br />
                            <div class="container">
                              <div class="flex-row">
                                <div class="d-flex justify-content-between">
                                  <div>
                                    <input
                                      type="checkbox"
                                      class="form-check-input"
                                      name="usertypes[]"
                                      value="1"
                                    /> Student
                                  </div>
                                  <div>
                                    <input
                                      type="checkbox"
                                      name="usertypes[]"
                                      value="2"
                                    />
                                    Professor
                                  </div>
                                </div>
                              </div>
                              <div class="flex-row">
                                <div class="d-flex justify-content-between">
                                  <div>
                                    <input
                                      class="form-check-input"
                                      type="checkbox"
                                      name="usertypes[]"
                                      value="4"
                                    />
                                    TA Administrator
                                  </div>
                                  <div>
                                    <input
                                      class="form-check-input"
                                      type="checkbox"
                                      name="usertypes[]"
                                      value="3"
                                    />
                                    Teaching Assistant
                                  </div>
                                </div>
                              </div>
                              <div class="flex-row">
                                <div class="d-flex justify-content-between">
                                  <div>
                                    <input
                                      class="form-check-input"
                                      type="checkbox"
                                      name="usertypes[]"
                                      value="5"
                                    />
                                    System Operator
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div id="error-msg-cont"></div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <input
                            type="button"
                            class="btn btn-light"
                            data-dismiss="modal"
                            value="Cancel"
                          />
                          <input
                            type="submit"
                            class="btn btn-light"
                            value="Save"
                          />
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br />

          <!-- Display Users -->
          <div style="margin-bottom:100px;" id="user-table"> <?php include '../cgi_bin/get_users.php';?>
          </div>
        </div>
      </div>
    </div>
    <div class="footer">.</div> 
    <script>
      function loadExistingData() {
        getProfAccounts();
        getCourses();
        getAccounts();
      }
      document.onload = loadExistingData();
    </script>
  </body>
</html>
