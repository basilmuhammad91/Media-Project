<?php

//fetch.php;

$data = array();
$user_id = 1;

if(isset($_GET["query"]))
{
 $connect = new PDO("mysql:host=localhost; dbname=mediadb", "root", "");

 $query = "
SELECT * FROM `friends`
INNER JOIN
users
ON
users.user_id = friends.friend_id
WHERE friends.user_id = 1
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 while($row = $statement->fetch(PDO::FETCH_ASSOC))
 {
  $data[] = $row["name"];
 }
}

echo json_encode($data);

?>
