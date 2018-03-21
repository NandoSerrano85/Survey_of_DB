<?php
# Illustrates a query with a browser input value
# and returns several rows of values using MySQL
print ("<br>");

$host = "localhost";
$user="root";
$password="";
$dbname = "company";
$con=mysqli_connect($host, $user, $password, $dbname);
if (mysqli_connect_errno()) {
  echo "Failed to connect to MariaDB: " . mysqli_connect_error();
  exit;
}
$query =
        "SELECT A.pno, e1.fname AS First1, e1.lname AS Last1, e2.fname AS First2, e2.lname AS Last2
        FROM works_on A, works_on B,  employee e1, employee e2
        WHERE  A.pno = B.pno AND A.essn < B.essn AND e1.ssn = A.essn AND e2.ssn = B.essn
        ORDER by A.pno";
 $result = mysqli_query($con, $query);
 if (!$result) {
   print ( "Could not successfully run query ($query) from DB: " . mysqli_error($con) . "<br>");
   exit;
 }

 if (mysqli_num_rows($result) == 0) {
   print ("No rows found, nothing to print so am exiting<br>");
   exit;
 }

     // Print the column names as the headers of a table
     echo '<table border="1|0"><tr>';
     for($i = 0; $i < mysqli_num_fields($result); $i++) {
         $field_info = mysqli_fetch_field($result);
         echo "<th>{$field_info->name}</th>";
     }

     // Print the data
     while($row = mysqli_fetch_row($result)) {
         echo "<tr>";
         foreach($row as $_column) {
             echo "<td>  {$_column}  </td>";
         }
         echo "</tr>";
     }

     echo "</table>";
mysqli_close($con);

?>
