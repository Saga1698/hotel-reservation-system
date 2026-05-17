<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="../CSS/usertable.css"> </head>
  
</html>


<?php


$xml = simplexml_load_file('user.xml');

echo '<table border="1" style = "width:100%">
        <tr>
          <th>Username</th>
          <th>Password</th>
          <th>Email</th>
        </tr>';

foreach ($xml->item as $item) {
    echo '<tr class = "text-center">
            <td>' . $item->username . '</td>
            <td>' . $item->password . '</td>
            <td>' . $item->email . '</td>
          </tr>';
}

echo '</table>';

?>



