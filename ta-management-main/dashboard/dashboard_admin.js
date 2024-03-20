var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    /* Toggle between adding and removing the "active2" class,
    to highlight the button that controls the panel */
    this.classList.toggle("active2");

    /* Toggle between hiding and showing the active panel */
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}

var quotas = document.getElementsByClassName("ta-quota");
var enrollments = document.getElementsByClassName("enrollment-number");
for (i = 0; i < quotas.length; i++) {
  var quota = quotas[i].innerHTML;
  var enrollment = enrollments[i].innerHTML;
  var ratio = enrollment / quota;
  var parentDiv;
  var prev;
  
  // if quota ratio not respected,
  if (ratio < 30 || ratio > 45) {
    parentDiv = upTo(quotas[i], "div");
    prev = parentDiv.previousElementSibling;
    prev.className += " change_color";
    p = document.createElement("p");
    p.innerHTML = "The number of students per TA must be between 30 and 45 inclusively. Currently, the ratio is " + ratio + "." + " Please fix the enrollment number and/or the TA quota below.";
    p.className += "alert_text";
    parentDiv.append(p);
    
    // create a form using javascript to let the user fix the TA quota and the enrollment number to respect the guidelines
    var form = document.createElement("form");
    form.action = "../cgi_bin/fix_ta_quota.php";
    form.method = "post";
    form.enctype = "multipart/form-data";

    var input_enroll = document.createElement("input");
    var input_quota = document.createElement("input");
    var input_submit = document.createElement("input");
    var input_course = document.createElement("input");
    var input_term = document.createElement("input");

    input_enroll.type = "number";
    input_enroll.name = "enroll";

    input_quota.type = "number";
    input_quota.name = "quota";
    
    input_submit.type = "submit";
    input_submit.className = "btn btn-light";

    input_course.type = "text";
    input_course.name = "course";
    input_course.value = prev.innerHTML;
    input_course.style.display = "none";

    input_term.type = "text";
    input_term.name = "term";
    var str = parentDiv.children[0].innerHTML;
    var begin = str.indexOf("<span>") + 6;
    var end = str.indexOf("</span>");
    input_term.value = str.substring(begin, end);
    input_term.style.display = "none";

    var div1 = document.createElement("div");
    var div2 = document.createElement("div");
    var div3 = document.createElement("div");

    div1.className = "fix_error_div";
    div2.className = "fix_error_div";
    div3.className = "fix_error_div";
    
    div1.innerHTML = "New Enrollment Number: ";
    div2.innerHTML = "New TA Quota: ";

    div1.append(input_enroll);
    div2.append(input_quota);
    div3.append(input_submit);

    form.append(input_term);
    form.append(input_course);
    form.append(div1);
    form.append(div2);
    form.append(div3);

    parentDiv.append(form);
  }
}

// Find first ancestor of el with tagName
// or undefined if not found
function upTo(el, tagName) {
  tagName = tagName.toLowerCase();

  while (el && el.parentNode) {
    el = el.parentNode;
    if (el.tagName && el.tagName.toLowerCase() == tagName) {
      return el;
    }
  }
  return null;
}