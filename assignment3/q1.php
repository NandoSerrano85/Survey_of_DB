<?php
# Illustrates a query with a browser input value
#  and returns several rows of values using MySQL
print ("<br>");
$dependents = isset($_POST['dependents']) ? $_POST['dependents'] : '';
$visited = isset($_POST['visited']) ? $_POST['visited'] : '';
$errormsg = '';

if (!($dependents )) {
  if ($visited) {
     $errormsg = 'Please enter a dependent name';
  }

 // printing the form to enter the user input
 print <<<_HTML_
 <FORM method="POST" action="{$_SERVER['PHP_SELF']}">
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
 <font color= 'red'>$errormsg</font><br>
 Department Number: <input type="text" name="dependents" size="9" value="$dependents">
 <br/>
 <br>
 <INPUT type="submit" value=" Submit ">
 <INPUT type="hidden" name="visited" value="true">
 </FORM>
_HTML_;

}
else {
  $host = "localhost";
  $user="root";
  $password="";
  $dbname = "company";
  $con=mysqli_connect($host, $user, $password, $dbname);
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MariaDB: " . mysqli_connect_error();
    exit;
  }
  $querystring1 = "
      SELECT e.fname, e.lname, de.dependent_name
      FROM employee e,  employee m, department d, dependent de
      WHERE de.dependent_name = '$dependents' AND de.essn = e.ssn
      AND e.dno = d.dnumber AND d.mgrssn = m.ssn";

  $querystring2 = "
          SELECT m.fname, m.lname
          FROM employee e,  employee m, department d, dependent de
          WHERE de.dependent_name = '$dependents' AND de.essn = e.ssn
          AND e.dno = d.dnumber AND d.mgrssn = m.ssn";
  $dep_emp = mysqli_query($con, $querystring1);
  $emp_mgr = mysqli_query($con, $querystring2);
  if (!$dep_emp) {
    print ( "Could not successfully run query ($querystring1) from DB: " . mysqli_error($con) . "<br>");
    exit;
  }

  if (!$emp_mgr) {
    print ( "Could not successfully run query ($querystring2) from DB: " . mysqli_error($con) . "<br>");
    exit;
  }
  if (mysqli_num_rows($emp_mgr) == 0 && mysqli_num_rows($dep_emp) == 0) {
    print ("No rows found, nothing to print so am exiting<br>");
    exit;
  }

  print("Results: <br>");
  while (($q1 = mysqli_fetch_assoc($dep_emp)) && ($q2 = mysqli_fetch_assoc($emp_mgr))) {
      print("Dependent: $q1[dependent_name] <br>");
      print("Employee: $q1[fname] $q1[lname]<br>");
      print("Manager: $q2[fname] $q2[lname]<br>");

    print "<br>";
  }
  mysqli_close($con);
}
?>
