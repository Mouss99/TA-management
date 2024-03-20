<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../media/favicon.ico" type="image/ico">
    <link rel="stylesheet" href="register.css">
    <title>Register Page</title>
    </style>
    <script type="text/javascript" src="./register.js"></script>
</head>


<?php

    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $dbname = "ta-management";

    // Connect to database and check if successful
    $conn = mysqli_connect($servername, $username, $db_password, $dbname);


    if(isset($_POST['submit'])){

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword= $_POST['cpassword'];
        $studentID = $_POST['sID'] ?? false;
        $userType = $_POST['BoxSelect'] ?? false;
        $studentCourses = $_POST['studentCourses'] ?? false;
        $taCourses = $_POST['taCourses'] ?? false;
        $isStudent = False;
        $isTA= False;

        date_default_timezone_set('America/New_York');
        $time = date('y-m-d h:i:s');

        //check if account is duplicate
        $query = "SELECT email FROM user WHERE email = '$email'";
        $duplicate = mysqli_query($conn, $query);
        if(mysqli_num_rows($duplicate) > 0){
            $error[] = 'User already exists with this email!';
        }

        //check if passwords match
        elseif($password != $cpassword){
            $error[] = 'Input passwords do not match!';
        }

        else{
            //check if all required field are filled (without courses)
            if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password) && (!empty($userType)))
                {   
                    foreach($userType as $chkval){
                        if ($chkval == 'isStudent'){
                            $isStudent = True;}
            
                        if ($chkval == 'isTA'){
                            $isTA = True;
                        }
                    }
                    if (($isStudent && !($studentCourses)) || ($isTA && !($taCourses))){
                        $error[] = 'Must select at least 1 course per user type';
                    }
                    else{

                   //save to general user database once all requirements are checked
                   $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
                    $query = "insert into user (firstName,lastName,email,password,createdAt,updatedAt) values ('$fname','$lname','$email', '$hashed_pass','$time','$time')";
                    mysqli_query($conn, $query);
                    
                    //fill corresponding tables for each usertype
                    foreach($userType as $chkval){

                        #add student info to corresponding tables
                        if ($chkval == 'isStudent'){
                            
                            //insert to user_usertype table
                            $query1= "insert into user_usertype (userId, userTypeId) values ('$email',1)";
                            mysqli_query($conn, $query1);

                            //insert to all_student table
                            foreach($studentCourses as $val){
                                //split string of info
                                $split = (explode(" ", $val));
                                $course = $split[0] . ' '  .$split[1];
                                $term = $split[2];
                                $year = $split[3];
                                $query1= "insert into all_students (email,studentID,courseNumber,term,year,firstName,lastName) values ('$email','$studentID','$course','$term','$year','$fname','$lname')";
                                mysqli_query($conn, $query1);
                            }
                        }
                        
                        //add prof info to corresponding table
                        if ($chkval == 'isProf'){
                            
                            //insert to user_usertype table
                            $query2= "insert into user_usertype (userId, userTypeId) values ('$email',2)";
                            mysqli_query($conn, $query2);
                        }
                        
                        #add TA info to corresponding tables
                        if ($chkval == 'isTA'){
                            
                            //insert to user_usertype table
                            $query3= "insert into user_usertype (userId, userTypeId) values ('$email',3)";
                            mysqli_query($conn, $query3);

                            //insert to all_student table
                            foreach($taCourses as $val){
                                //split string of info
                                $split = (explode(" ", $val));
                                $course = $split[0] . ' '  .$split[1];
                                $term = $split[2];
                                $year = $split[3];
                                $query3= "insert into all_ta (email,courseNumber,term,year,firstName,lastName) values ('$email','$course','$term','$year','$fname','$lname')";
                                mysqli_query($conn, $query3);
                            }
                        }
                        
                        #if TA admin info to corresponding tables
                        if ($chkval == 'isAdmin'){

                            $query4= "insert into user_usertype (userId, userTypeId) values ('$email',4)";
                            mysqli_query($conn, $query4);  
                        }
                    }
                    //redirect to login after successful register
                    header("Location: ../login/login.html");
                    die;}}
                else
                {
                    $error[] = 'Please fill all required fields!';
                }
        }
    }
?>



<body style="background-color:#eee;">
    <div class="header-background">
        <div class = "logo"> </div>
    </div>
    
    <div class="form-container" id="form1">
        <form action="" method="post">
           <h3>register here</h3>
           
           <?php
           //print corresponding error message from register_submit.php
            if(isset($error)){
                foreach($error as $error){
                    echo '<span class="error-msg">'.$error.'</span>';
                }
            }
            ?>
            <!-- required fields for register -->
           <input type="text" name="fname" required placeholder="first name">
           <input type="text" name="lname" required placeholder="last name">
           <input type="email" name="email" required placeholder="email (you@example.com)" multiple>
           <input type="password" name="password" required placeholder="password"> 
           <input type="password" name="cpassword" required placeholder="confirm password">
           <input type="text" name="sID" id = "sID" placeholder="student ID (999999999)" pattern="[0-9]{9}" maxlength="9" style ="display: none"> 
            <br>
            <br>
            
            <!--  ############ START student section ############ -->
            <div style = "text-align:left"> 
            <h2> Select at least ONE user type:</h2>
            <h4><input
               type="checkbox"
               name="BoxSelect[]"
               value="isStudent"
               id= "isStudent"
               onclick="displayStudentID(), displayStudentCourses()"/>
            
            <label for="isStudent">Student</label></h4>
            
            <div class="multiselect" id="Student_courses" style="display:none">
                <div class="selectBox" onclick="showStudentCheckboxes()" >
                    <select>
                        <option>Select at least one*</option>
                    </select>
                    <div class="overSelect"></div>
                </div>
                <div id="Student_checkboxes">
                <?php
                    $con = mysqli_connect("localhost","root","","ta-management");
                    #distinct to avoid duplicates terms and year combinations
                    $query = "SELECT DISTINCT courseNumber,term,year FROM course";
                    $result = mysqli_query($con, $query);
                    
                    if(mysqli_num_rows($result) > 0){
                        foreach($result as $r){
                            $courseNum = $r['courseNumber'];
                            $term = $r['term'];
                            $year = $r['year'];
                                ?>
                                <input type="checkbox" name="studentCourses[]" value="<?= $courseNum . ' ' . $term . ' ' . $year ; ?>" /> 
                                <?= $courseNum . ' ' . $term . ' ' . $year ; ?> <br/>
                                <?php
                        }
                    }
                    else
                    {
                    echo "No Record Found";
                    }
                ?>
                </div>
            </div>
            <!--  ############ END student section ############ -->
            <!--  ############ START professor section ############ -->
            <h4><input
            type="checkbox"
            name="BoxSelect[]"
            value="isProf"
            id= "isProf"
            onclick="displayProfCourses()"/>
            <label for="isProf">Professor</label></h4>
            
            
            <!--  ############ END professor section ############ -->
            <!--  ############ START TA section ############ -->
            <h4><input
            type="checkbox"
            name="BoxSelect[]"
            value="isTA"
            id= "isTA"
            onclick="displayTaCourses()"/>
            <label for="isTA">Teacher Assistant</label></h4>
            
            <div class="multiselect" id="Ta_courses" style="display:none">
                <div class="selectBox" onclick="showTaCheckboxes()" >
                    <select>
                        <option>Select at least one*</option>
                    </select>
                    <div class="overSelect"></div>
                </div>
                <div id="Ta_checkboxes">
                <?php
                    $con = mysqli_connect("localhost","root","","ta-management");
                    #distinct to avoid duplicates terms and year combinations
                    $query = "SELECT DISTINCT courseNumber,term,year FROM course";
                    $result = mysqli_query($con, $query);
                    
                    if(mysqli_num_rows($result) > 0){
                        foreach($result as $r){
                            $courseNum = $r['courseNumber'];
                            $term = $r['term'];
                            $year = $r['year'];
                                #get each course from DB and display it in drop down select bar
                                ?>
                                <input type="checkbox" name="taCourses[]" value="<?= $courseNum . ' ' . $term . ' ' . $year ; ?>" /> 
                                <?= $courseNum . ' ' . $term . ' ' . $year ; ?> <br/>
                                <?php
                        }
                    }
                    else
                    {
                    echo "No Record Found";
                    }
                ?>
                </div>
            </div>
            <!--  ############ END TA section ############ -->
            <!--  ############ START TA admin section ############ -->
            <h4><input
            type="checkbox"
            name="BoxSelect[]"
            value="isAdmin"/>
            <label for="isAdmin">TA Administrator</label></h4><br>
            <!--  ############ END TA admin section ############ -->
                <div style="text-align:center">
                    <input type="submit" name="submit" value="register now" class="form-btn">
                    <p>already have an account? <a href="../login/login.html">login now</a></p>
                </div>
        </form>
    
    </div>
     
    <div class="footer">.</div> 
    
</body>
</html>
