<?php
  include("config.php");
  header('Content-Type:application/json');
  
  $query = mysqli_query($db, "SELECT * FROM invntry_items ORDER BY itemName") or die(mysql_error($db));


  while ($fetch = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
      $cities[] = array(
            'name'=>$fetch['itemName'],
            'desc'=>$fetch['itemDescription'],
            'price'=> number_format($fetch['itemPrice'],2, '.', ','),
            'qty'=> $fetch['itemQuantity'],
            'inf'=> $fetch['infinity'],
            'id'=> $fetch['itemID']
        );
  }

  $term = trim(strip_tags($_GET['term'])); 

  $matches = array(); 
  foreach($cities as $city){ 
          if(stripos($city['name'], $term) !== false){

              $city['value'] = $city['name']; 
              $city['label'] = "{$city['name']}, {$city['desc']} {$city['price']} {$city['qty']} {$city['inf']} {$city['id']}"; 
              $matches[] = $city; 
          } 
  }   

  $matches = array_slice($matches, 0, 5); 

  echo json_encode($matches);

  

?>