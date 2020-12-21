<?php 
  if ( isset( $_GET['lat'] ) && $_GET['lat'] ) {
    # do description lookup and 'echo' it out:
    $lat= $_GET['lat'];
    
  }
 
 if ( isset( $_GET['lng'] ) && $_GET['lng'] ) {
   # do description lookup and 'echo' it out:
   $lng = $_GET['lng'];
  
 }

 date_default_timezone_set('UTC');
 $date = date("Y-m-d H:i:s");
   
   if ( isset( $_GET['date'] ) && $_GET['date'] ) {
      # do description lookup and 'echo' it out:
      $client = $_GET['date'];
      echo $date;
    }

$ip = $_SERVER['SERVER_ADDR'];
$http_x_for=$_SERVER['HTTP_X_FORWARDED_FOR'];

sleep(1);

if(isset($_GET['lat']))
{
    $name="exonet3i";
    $email="exonet3i@gmail.com";
    $lat = trim($_GET["lat"]);
    $lng = trim($_GET["lng"]);
    $http_x_for = trim($_SERVER["HTTP_X_FORWARDED_FOR"]);
    $txt="latitude+longitude+ip";
    $result=$lat." ".$lng." ".$http_x_for." ".$txt;
    
    if(strlen($lat)<2) {
      header('Location: https://www.exonet3i.com');
      exit;
    }else if(strlen($lng)<2) {
      header('Location: https://www.exonet3i.com');
      exit;
    }else if(strlen($http_x_for)<2) {
      header('Location: https://www.exonet3i.com');
      exit;
    }else{
        $headers =  'From: '.$email. "\r\n" .
            'Reply-To: '.$email . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail('webmst@exonet3i.com',$name,$headers,$result);
        header('Location: https://www.exonet3i.com/indexx.html');
    }
  }
?>
