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
  require ('./dbConfig.php');
  $querystring = "SELECT e.fname, e.lname, m.fname, m.lname de.dependent_name FROM employee as e,  employee as m, deparment as d, dependent as de  where de.dependent_name = $dependents and de.essn = e.ssn and e.dno = d.dnumber and d.mgr_ssn = m.snn";
  $result = mysqli_query($con, $querystring);
  if (!$result) {
    print ( "Could not successfully run query ($querystring) from DB: " . mysqli_error($con) . "<br>");
    exit;
  }

  if (mysqli_num_rows($result) == 0) {
    print ("No rows found, nothing to print so am exiting<br>");
    exit;
  }

  print("Results: <br>");
  while ($rows = mysqli_fetch_assoc($result)) {
    foreach ($rows as $row) {
      print $row." ";
    }
    print "<br>";
  }
  mysqli_close($con);
}
?>
