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
$query = "
    SELECT A.pno, e1.fname, e1.lname, e2.fname, e2.lname
    FROM Works_On A, Works_On B, employee e1, employee e2
    WHERE A.PNO = B.PNO AND A.ESSN < B.ESSN AND e1.ssn = a.essn AND e2.ssn = b.essn
    ORDER BY PNO, e1.fname, e1.lname, e2.fname, e2.lname";

$results = mysqli_query($con, $query);
if (!$results) {
  print ( "Could not successfully run query ($query) from DB: " . mysqli_error($con) . "<br>");
  exit;
}

if (mysqli_num_rows($results) == 0) {
  print ("No rows found, nothing to print so am exiting<br>");
  exit;
}

print("Results: <br>");

while($record = mysqli_fetch_assoc($results)){
  print("$record <br>");

}
mysqli_close($con);

?>
