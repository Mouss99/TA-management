//JAVASCRIPT FOR Student SECTION

//to check if the student checkbox is checked and display student ID field
function displayStudentID() {
    // Get the student checkbox
    var checkBox = document.getElementById("isStudent");
    // Get the student ID box field
    var field = document.getElementById("sID");

    // If the checkbox is checked, display the student ID field and make it required
    if (checkBox.checked){
        field.style.display = "initial";
        field.required = true;
      

    } else {
        field.style.display = "none";
        field.required = false;
       
    }
}

//display select bar
//to check if the student checkbox is checked and display courses
function displayStudentCourses() {
    // Get the student checkbox
    var checkBox = document.getElementById("isStudent");
    // Get the courses checkbox
    var courses = document.getElementById("Student_courses");

    // If the checkbox is checked, display the available courses
    if (checkBox.checked){
        courses.style.display = "initial";
      
    } else {
        courses.style.display = "none";
       
    }
}

var Student_expanded = false;
//display dropdown
function showStudentCheckboxes() {
  var checkboxes = document.getElementById("Student_checkboxes");
  if (!Student_expanded) {
    checkboxes.style.display = "block";
    Student_expanded = true;
  } else {
    checkboxes.style.display = "none";
    Student_expanded = false;
  }
}



// #####################################################

//JAVASCRIPT FOR PROF SECTION

//to check if the professor checkbox is checked and display courses
function displayProfCourses() {
    // Get the professor checkbox
    var checkBox = document.getElementById("isProf");
    //get courses checkboxes
    var courses = document.getElementById("Prof_courses");

    // If the checkbox is checked, display select box
    if (checkBox.checked == true){
        courses.style.display = "initial";
      
    } else {
        courses.style.display = "none";
       
    }
}

var Prof_expanded = false;

//display dropdown
function showProfCheckboxes() {
  var checkboxes = document.getElementById("Prof_checkboxes");
  if (!Prof_expanded) {
    checkboxes.style.display = "block";
    Prof_expanded = true;
  } else {
    checkboxes.style.display = "none";
    Prof_expanded = false;
  }
}

// #####################################################

//JAVASCRIPT FOR TA SECTION

//to check if the TA checkbox is checked and display courses
function displayTaCourses() {
    // Get the TA checkbox
    var checkBox = document.getElementById("isTA");
    // Get the TA courses options
    var courses = document.getElementById("Ta_courses");

    // If the checkbox is checked, display select bar
    if (checkBox.checked == true){
        courses.style.display = "initial";
      
    } else {
        courses.style.display = "none";
       
    }
}

var Ta_expanded = false;

//display dropdown
function showTaCheckboxes() {
  var checkboxes = document.getElementById("Ta_checkboxes");
  if (!Ta_expanded) {
    checkboxes.style.display = "block";
    Ta_expanded = true;
  } else {
    checkboxes.style.display = "none";
    Ta_expanded = false;
  }
}


