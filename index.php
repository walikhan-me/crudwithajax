<?php
$conn = mysqli_connect('localhost','root','','crud');
extract($_POST);
//display
if(isset($_POST["readrecord"]))
{
    $data = '<table class="table table-bordered table-striped table-hover">
             <th>NO</th>
             <th>FIRST NAME</th>
             <th>LAST NAME</th>
             <th>EMAIL</th>
             <th>MOBILE</th>
             <th>EDIR</th>
             <th>DELETE</th>';
     $displayquery = "SELECT * FROM EMP";
     $result = mysqli_query($conn,$displayquery);
     if(mysqli_num_rows($result)>0)
     {
         $number = 1;
         while($row = mysqli_fetch_array($result))
         {
              $data .='<tr>
                         <td>'.$number.'</td>
                         <td>'.$row['firstname'].'</td>
                         <td>'.$row['lastname'].'</td>
                         <td>'.$row['email'].'</td>
                         <td>'.$row['mobile'].'</td>
                         <td><button type="button" class="btn btn-primary" onclick="getuserdetail('.$row['id'].')">EDIT</button></td>
                         <td><button type="button" class="btn btn-danger" onclick="deleteuserdetail('.$row['id'].')">DELETE</button></td>
                       </tr>';
                       $number++;
         }

     }
     $data.="</table>";
     echo $data;

}

//insert 
if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['mobile']))
{
    $insertquery = "INSERT INTO EMP (FIRSTNAME,LASTNAME,EMAIL,MOBILE) VALUES('$firstname','$lastname','$email','$mobile')";
    $succes = mysqli_query($conn,$insertquery);
   


}
//delete
if(isset($_POST['delete_id'])){
    $user_id=$_POST['delete_id'];
    $deletequery = "DELETE FROM EMP WHERE ID ='$user_id'";
    mysqli_query($conn,$deletequery);
}
//get user id for update

if(isset($_POST["id"]) && isset($_POST["id"])!="")
{
  $user_id = $_POST["id"];
  $query = "SELECT * FROM EMP WHERE ID = '$user_id'";
  if(!$result = mysqli_query($conn,$query))
  {
      exit(mysqli_error());
  }
  $response = array();
  if(mysqli_num_rows($result) > 0)
  {
      while($row=mysqli_fetch_assoc($result))
      {
          $response = $row;
      }
  }
  else
  {
      $response['status']=200;
      $response['message']="data not found";

  }
  echo json_encode($response);

}

else{
    $response['status']=200;
    $response['message']="invalid request";
}
 

//update data

if(isset($_POST['hidden_user_id'])){
    $hidden_user_id = $_POST[ "hidden_user_id"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    
    $email= $_POST["lname"];
    $mobile = $_POST["mobile"];

    $query = "UPDATE `emp` SET `firstname`='$fname ',`lastname`='$lname',`email`='$email',`mobile`='$mobile' WHERE ID='$hidden_user_id'";
    mysqli_query($conn,$query );

}
  


?>