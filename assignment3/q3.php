<?php
# Illustrates a query with a browser input value
#  and returns several rows of values using MySQL
print ("<br>");
$deparments = isset($_POST['deparments']) ? $_POST['deparments'] : '';
$visited = isset($_POST['visited']) ? $_POST['visited'] : '';
$errormsg = '';

if (!($deparments )) {
  if ($visited) {
     $errormsg = 'Please enter a dependent name';
  }

 // printing the form to enter the user input
 print <<<_HTML_
 <FORM method="POST" action="{$_SERVER['PHP_SELF']}">
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
 <font color= 'red'>$errormsg</font><br>
 Department Number: <input type="text" name="deparments" size="9" value="$deparments">
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
  $query = "
      SELECT dname, Count(distinct pname) As NumberOfProjects, SUM(HOURS) As TotalWorkHours
      FROM department, project, works_on
      Where dnum='$departmentnumber'
      AND pno=pnumber
      AND department.dnumber=project.dnum
      Group by dname";

  results = mysqli_query($con, $query);
  if (!$results) {
    print ( "Could not successfully run query ($query) from DB: " . mysqli_error($con) . "<br>");
    exit;
  }

  if (mysqli_num_rows($results) == 0) {
    print ("No rows found, nothing to print so am exiting<br>");
    exit;
  }

  print("Results: <br>");
  $output = mysqli_fetch_assoc($results)
  foreach ($output as $items) {
    print(" &nbsp; &nbsp; &nbsp; &nbsp; Department name: $items[0] <br>");
    print(" &nbsp; &nbsp; &nbsp; &nbsp; Number of project: $items[1] <br>");
    print(" &nbsp; &nbsp; &nbsp; &nbsp; Total work hours: $items[2] <br>");
    print("<br>");
  }
  

    
  mysqli_close($con);
}
?>
