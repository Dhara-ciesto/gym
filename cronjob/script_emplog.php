<?php

$conn= mysqli_connect("localhost", "admin_fitness5", "fitness5@123","admin_fitness5");
//$conn= mysqli_connect("localhost", "admin_fitness5mumbai", "fitness5mumbai@123","admin_fitness5mumbai");

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $confirmdate = '';
  $count = 0;
  
  $employee = mysqli_query($conn, "SELECT * FROM employee WHERE status = 1");
  if(!$employee){
    echo mysqli_error($conn);
  }

  $employeecount = mysqli_num_rows($employee);
  
  if($employeecount > 0){

    while($row_employee = mysqli_fetch_array($employee, MYSQLI_ASSOC)) {
      $empid = $row_employee['employeeid'];
    

      $emplog = mysqli_query($conn, 'SELECT * FROM user_log WHERE UserId = "'.$empid.'" ORDER BY log_id asc ');

      if(!$emplog){
        echo mysqli_error($conn);
      }

      $emplogcount = mysqli_num_rows($emplog);

      if($emplogcount > 0){

      while($row_emplog = mysqli_fetch_array($emplog, MYSQLI_ASSOC)) {
        $count++;
        $lastlog = mysqli_query($conn, 'SELECT * FROM employeelog WHERE userid = "'.$empid.'" ORDER BY emplogid DESC LIMIT 1');
        if(!$lastlog){
          echo mysqli_error($conn);
        }

        $lastlogcount = mysqli_num_rows($lastlog);

        if($lastlogcount > 0){
          $datetimelog = mysqli_fetch_array($lastlog, MYSQLI_ASSOC);
          $punchdate = $datetimelog['punchdate'];
          $checkin = $datetimelog['checkin'];
          $checkout = $datetimelog['checkout'];
          $emplogid = $datetimelog['emplogid'];

          $checkindate = $punchdate.' '.$checkin;
          $checkoutdate = $punchdate.' '.$checkout;

          if(date('Y-m-d', strtotime($row_emplog['PunchDateTime'])) >= $punchdate){
            if(empty($checkout) && $punchdate == date('Y-m-d', strtotime($row_emplog['PunchDateTime'])) && date('H:i:s', strtotime($row_emplog['PunchDateTime']))> $checkin){
              $updatelog = mysqli_query($conn, 'UPDATE employeelog SET checkout="'.date('H:i:s', strtotime($row_emplog['PunchDateTime'])).'" WHERE emplogid="'.$emplogid.'"');

                  if(!$updatelog){
                    echo mysqli_error($conn);
                  }
            }else{

              if($row_emplog['PunchDateTime'] > $checkindate && $row_emplog['PunchDateTime'] > $checkoutdate){

                $insertlog = mysqli_query($conn, 'INSERT INTO employeelog (userid, punchdate, checkin, checkout) VALUES ("'.$empid.'", "'.date('Y-m-d', strtotime($row_emplog['PunchDateTime'])).'", "'.date('H:i:s', strtotime($row_emplog['PunchDateTime'])).'", null)');
                  if(!$insertlog){
                    echo mysqli_error($conn);
                  }
              }
            }
        }

          
          
        }else{

          $insertlog = mysqli_query($conn, 'INSERT INTO employeelog (userid, punchdate, checkin, checkout) VALUES ("'.$empid.'", "'.date('Y-m-d', strtotime($row_emplog['PunchDateTime'])).'", "'.date('H:i:s', strtotime($row_emplog['PunchDateTime'])).'", null)');
          $confirmdate = date('Y-m-d', strtotime($row_emplog['PunchDateTime']));
          if(!$insertlog){
            echo mysqli_error($conn);
          }


        }



      }

      }


    }



  } 

$conn->close();


?>