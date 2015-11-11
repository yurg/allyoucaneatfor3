<?php 

# Bootstrap Civi

require_once('civicrm.settings.php'); 
require_once 'CRM/Core/Config.php';
$config = CRM_Core_Config::singleton();

#### Get Memberships 
    $mems = civicrm_api3('Membership', 'get', array(
      'return' => "id,contact_id",
      'options' => array('limit' => 0),
    ));

/*
### REsponse 
    {
        "is_error": 0,
        "version": 3,
        "count": 1,
        "id": 1270,
        "values": {
            "1270": {
                "id": "1270",
                "contact_id": "409400"
            }
        }
    }

    */ 


 ### Get Contributions 
     $conts = civicrm_api3('Contribution', 'get', array(
      'return' => "id,contact_id",
            'options' => array('limit' => 0),
  #    'contact_id' => 409400,
    ));

    /*

  ## Response ##  
    {
        "is_error": 0,
        "version": 3,
        "count": 1,
        "id": 1514,
        "values": {
            "1514": {
                "contact_id": "409400",
                "contribution_id": "1514",
                "id": "1514"
            }
        }
    }

    */   

foreach ($mems['values'] as $mem) { 
  $m[$mem['id']] = $mem['contact_id'];
}

foreach ($conts['values'] as $cont) { 
    $c[$cont['id']] = $cont['contact_id'];
 
}


$result = array();
  foreach($m as $mk => $mv) {
   foreach($c as $ck => $cv) {
       if ($mv == $cv) {
         $result[$mk] = $ck;   
   }
 }
}


#### Create payment
$i = 0; 
foreach($result as $rmem => $rcon) {
$done = civicrm_api3('MembershipPayment', 'create', array(
      'membership_id' => $rmem,
      'contribution_id' => $rcon,
 ));
$i++;
 echo $i .PHP_EOL;
}
print 'Done, total records: ' .  $i;

