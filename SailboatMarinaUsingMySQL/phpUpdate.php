<?php
$col_name=array("slipNo","sailboatType","sailboatYear","sailboatLength","slipPayment","sailboatMotor","slipassign","sailorFname","sailorLname");
  function checkEmpty($toCheck){
    if(!strcasecmp($toCheck,"EMPTY"))
    {
        return 0;
    }
    else
    {
        return 1;
    }
  }
  $ARG[0] = $_REQUEST["SlipNo"];
  $ARG[1] = $_REQUEST["Type"];
  $ARG[2] = $_REQUEST["Year"];
  $ARG[3] = $_REQUEST["Length"];
  $ARG[4] = $_REQUEST["Paid"];
  $ARG[5] = $_REQUEST["Motor"];
  $ARG[6] = $_REQUEST["Fname"];
  $ARG[7] = $_REQUEST["Lname"];


  $servername = "localhost";
  $username = "root";
  $password = "Friends";
  $dbname = "sailboatMarina";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
        print "<p>Connection failed: " . $conn->connect_error."</p> ";
  }
  for($x = 0; $x < 8; $x++) {
      $ret_value = checkEmpty($ARG[$x]);
      if($ret_value == 0){
          break;
      }
  }
  $condition="SELECT * FROM sailboatMarina.info where ";
  if($ret_value == 0){
    for($x = 0; $x < 8; $x++) {
      $ret_value = checkEmpty($ARG[$x]);
      if($ret_value == 0){
          continue;
      }
      $condition = $condition.$col_name[$x]."='".$ARG[$x]."' AND ";
    }
    $condition = $condition."5=5";
    $result = $conn->query($condition);
    print "<p>Option: Querying <br><br> Here is the sql query: $condition; </p> ";


    print "<p>slipNo, sailorFname, sailorLname, sailboatType ,sailboatYear, sailboatLength, sailboatMotor, slipPayment </p>";

    if ($result->num_rows > 0) {
     // output data of each row

     while($row = $result->fetch_assoc()) {
         print "<p>".$row["slipNo"].",\t".$row["sailorFname"].",\t".$row["sailorLname"].",\t".$row["sailboatType"].",\t".$row["sailboatYear"].",\t".$row["sailboatLength"].",\t".$row["sailboatMotor"].",\t".$row["slipPayment"]."</p>";
     }
   }
  }
  else
  {
    $condition = "select * from sailboatMarina.info where slipNo='$ARG[0]'";
    $result = $conn->query($condition);
    $total = $result->num_rows;
    if ($total > 0) {
      $condition = "Update sailboatMarina.info set slipNo='$ARG[0]',sailboatType='$ARG[1]',sailboatYear='$ARG[2]', sailboatLength='$ARG[3]', slipPayment='$ARG[4]', sailboatMotor='$ARG[5]', sailorFname='$ARG[6]', sailorLname='$ARG[7]' where slipNo='$ARG[0]'";
        if ($conn->query($condition) === TRUE) {
          print "Record updated successfully<br><br>";
      } else {
        echo "Error updating record: " . $conn->error;
      }
      print "Option: Updating <br><br> Here is the sql query: $condition";

    }
    else {
    $condition = "insert into sailboatMarina.info values('$ARG[0]','$ARG[6]', '$ARG[7]','$ARG[1]','$ARG[2]','$ARG[3]','$ARG[5]','$ARG[4]')";
    if ($conn->query($condition) === TRUE) {
      print "New record created successfully";
    } else {
      print "Error: " . $sql . "<br>" . $conn->error;
    }

    print "<p>Option: Inserting $ARG[0], $ARG[1], $ARG[2],$ARG[3],$ARG[4],$ARG[5],$ARG[6],$ARG[7] <br><br> Here is the sql query: $condition</p> ";
  }
  $conn->close();
  }
?>
