<?php
# Illustrates a query with a browser input value
#  and returns a row of value using MySQL
print ("<br>");
$deparment = isset($_POST['deparment']) ? $_POST['deparment'] : '';
$visited = isset($_POST['visited']) ? $_POST['visited'] : '';
$errormsg = '';
if (!($deparment )) {
  if ($visited) {
    if (! $deparment) {
       $errormsg = 'Please enter valid department name';
    }
  }

 // printing the form to enter the user input
 print <<<_HTML_
 <FORM method="POST" action="{$_SERVER['PHP_SELF']}">
 <br>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
 <font color= 'red'>$errormsg</font><br>
  Department Name: <input type="text" name="deparment" size="9" value="$deparment">
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

    $querystring1="SELECT dname as DepartmentName,  fname, lname
    FROM  department,employee
    WHERE dname='$deparment' AND mgrssn=ssn";

    $querystring2="SELECT Count(dname) AS total_dependents
    FROM  department,employee,dependent
    WHERE dname='$deparment' AND dnumber=dno AND ssn=essn";

    $res_department = mysqli_query($con, $querystring1);
    $res_dependets = mysqli_query($con, $querystring2);
    if (!$res_department && !$res_dependets) {
      print ( "Could not successfully run query ($querystring1) from DB: " . mysqli_error($con) . "<br>");
      print ( "Could not successfully run query ($querystring2) from DB: " . mysqli_error($con) . "<br>");
      exit;
    }

    if (mysqli_num_rows($res_department) == 0 && mysqli_num_rows($res_dependets) == 0) {
      print ("No rows found, nothing to print so am exiting<br>");
      exit;
    }

  // Print the column names as the headers of a table
  echo '<table border="1|0"><tr>';
  for($n = 0; $n < mysqli_num_fields($res_department); $n++) {
      $field_info = mysqli_fetch_field($res_department);
      echo "<th>{$field_info->name}</th>";
  }

  // Print the data
  while($row = mysqli_fetch_row($res_department)) {
      echo "<tr>";
      foreach($row as $_column) {
          echo "<td>  {$_column}  </td>";
      }
      echo "</tr>";
  }

  echo "</table> <br>" ;

// Print the column names as the headers of a table
echo '<table border="1|0"><tr>';
for($n = 0; $n < mysqli_num_fields($res_dependets); $n++) {
    $field_info = mysqli_fetch_field($res_dependets);
    echo "<th>{$field_info->name}</th>";
}

// Print the data
while($row = mysqli_fetch_row($res_dependets)) {
    echo "<tr>";
    foreach($row as $_column) {
        echo "<td>  {$_column}  </td>";
    }
    echo "</tr>";
}

echo "</table>";
    mysqli_close($con);
}
?>
