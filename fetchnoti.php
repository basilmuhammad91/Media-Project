<?php
//fetch.php;

 include("connect.php");
 if($_POST["view"] != '')
 {
  $update_query = "UPDATE comments SET comment_status=1 WHERE comment_status=0";
  mysqli_query($connect, $update_query);
 }
 $query = "SELECT * FROM notifications ORDER BY notification_id DESC LIMIT 5";
 $result = mysqli_query($connect, $query);
 $output = '';
 
 if(mysqli_num_rows($result) > 0)
 {
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
   <li>
    <a href="#">
     <strong>'.$row[0].'</strong><br />
     <small><em>'.$row[1].'</em></small>
    </a>
   </li>
   <li class="divider"></li>
   ';
  }
 }
 else
 {
  $output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
 }
 
 // $query_1 = "SELECT * FROM notifications WHERE status=0";
 // $result_1 = mysqli_query($connect, $query_1);
 // $count = mysqli_num_rows($result_1);
 // $data = array(
 //  'notification'   => $output,
 //  'unseen_notification' => $count
 );
 // echo json_encode($data);
