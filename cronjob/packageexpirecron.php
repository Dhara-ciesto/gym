<?php

$conn= mysqli_connect("localhost", "admin_fitness5", "fitness5@123","admin_fitness5");
  $query='select * from memberpackages';
  $result=mysqli_query($conn,$query);

     $today = date("Y-m-d"); 
       $enddate= "select * from memberpackages where status=1";
     $result=mysqli_query($conn,$enddate);
     $data=array();
     while($row=mysqli_fetch_assoc($result)){
       $data[]=$row;
     }
    
    for($i=0;$i<count($data);$i++)
    {
      if($data[$i]['expiredate'] < $today){


$query = "INSERT INTO chronjobexpirepackages (memberpackagesid,userid,schemeid,memberTransactionId,joindate,expiredate,upgradeid,transferid,date) VALUES
      ('". $data[$i]['memberpackagesid'] ."',
      '". $data[$i]['userid'] ."',
      '". $data[$i]['schemeid'] ."',
      '".$data[$i]['memberTransactionId']."',
                  '".$data[$i]['joindate']."',
       '".$data[$i]['expiredate']."',
      '". $data[$i]['upgradeid'] ."',
      '" .$data[$i]['transferid'] ."',

      '".date('Y-m-d H:i:s')."')";
      mysqli_query($conn,$query);
         
        $sql= "UPDATE memberpackages SET status='0' where expiredate ='".$data[$i]['expiredate']."'";
            mysqli_query($conn,$sql);
     
           }
    }
       
    
  echo "Package Expire Successfull";


  $query='SELECT *,MAX(expiredate) as maxdate FROM memberpackages where status = 0 GROUP BY userid';
  $result=mysqli_query($conn,$query);

     $today = date("Y-m-d"); 
       $enddate= "SELECT *,MAX(expiredate) as maxdate FROM memberpackages where status = 0 GROUP BY userid";
     $result=mysqli_query($conn,$enddate);
     $data=array();
     while($row=mysqli_fetch_assoc($result)){
       $data[]=$row;
     }
    
    for($i=0;$i<count($data);$i++)
    {
      if($data[$i]['maxdate'] < $today){

        
$query = "INSERT INTO cronjobexpiremember (memberpackagesid,userid,schemeid,memberTransactionId,joindate,expiredate,upgradeid,transferid,date) VALUES
      ('". $data[$i]['memberpackagesid'] ."',
      '". $data[$i]['userid'] ."',
      '". $data[$i]['schemeid'] ."',
      '".$data[$i]['memberTransactionId']."',
                  '".$data[$i]['joindate']."',
       '".$data[$i]['expiredate']."',
      '". $data[$i]['upgradeid'] ."',
      '" .$data[$i]['transferid'] ."',

      '".date('Y-m-d H:i:s')."')";
      mysqli_query($conn,$query);
         
        $sql= "UPDATE member SET status='0' where userid ='".$data[$i]['userid']."'";
            mysqli_query($conn,$sql);
     
           }
    }
  
    echo "12Member Expire Successfull";



    /************************************************* */
    $query='SELECT * FROM memberpackages where status = 1 GROUP BY userid';
    $result=mysqli_query($conn,$query);
  
        
       $data=array();
       while($row=mysqli_fetch_assoc($result)){
         $data[]=$row;
       }
      
      for($i=0;$i<count($data);$i++)
      {
        
           
          $sql= "UPDATE member SET status='1' where userid ='".$data[$i]['userid']."'";
              mysqli_query($conn,$sql);
       
             
      }
    
      echo "Member Activeted Successfull";

?>