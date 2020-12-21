<?php
 if(isset($_POST['email'])) { 
	 	 ?> 
<?php } ?>
<?php
 // Pour que le mail s'envoie correctement
 function clean_string($string) {  
 
      $bad = array("content-type","bcc:","to:","cc:","href");
 
      return str_replace($bad,"",$string);
     }
?>
<!doctype html>
<head>
<meta charset="utf-8">
<title>contact</title>
</head>
<body>
	<section>
<div id="article">  
	          <h1>Récapitulatif de votre message</h1> 
	<div class="texte" >
   <br/>
<?php
require_once('recaptchalib.php');
     //si il y a bien une adresse mail
 if(isset($_POST['email'])) {
	 	 if(isset($_POST['sujet'])) {
	 	 $sujet =  $_POST['sujet'];
	}	 
	if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
        if(!$captcha){
          echo '<h2>Attention ! Veuillez cochez le captcha.</h2>';
          exit;
        }
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
		$responseData = json_decode($response);
		var_dump($responseData);
       if ($responseData->success==false)
        {
          return '<h2>Votre adresse ip a été enregistrée !</h2>';
        }else {
		 	 $sujet = "Vous avez demandé à être contacté.";
	}
  // informations pour nous dire que le mail provient de notre site
  $headers = 'From: test@exonet3i.com' . "\r\n" .
			'Reply-To: test@exonet3i.com' . "\r\n";
  //email du destinataire
 $to = 'test@exonet3i.com';
  //construction du message
 $email_message = "Name: ".clean_string($_POST['name'])."\n";
 $email_message .= "Phone: ".clean_string($_POST['phone'])."\n";
 $email_message .= "Email: ".clean_string($_POST['email'])."\n";
 $email_message .= "Message: ".clean_string($_POST['message'])."\n";
 $email_message = wordwrap($email_message, 70, "\r\n");  //70 caractères par ligne maximum
 
 //la fonction mail envoie le message puis retourne un booléen, si c'est "true" c'est que le message est bien envoyé, on peut afficher le récaputilatif
 if(@mail($to, $sujet, $email_message, $headers)) {
	
	echo "<p>Le message a bien été envoyé.</p>"; 
	echo "<p>Name : ".$_POST['name']."</p>"; 
	echo "<p>Phone : ".$_POST['phone']."</p>"; 
	echo "<p>Email : ".$_POST['email']."</p>"; 
	echo "<p>Message : <br />".wordwrap($_POST['message'], 70, "<br />\n", true)." </p>"; ?>
    
       <script type="text/javascript">
	document.write("<p>Cette fenetre fait " + largeur + " px de large</p>");
	document.write("<p>Le formulaire a été soumis à "+h+":"+m+":"+s);
	</script>
	<?php
		}  
		else {
	 	 die("Désolé, votre message n'a pas pu être envoyé notre serveur mail est encombré. Veuillez réessayer plus tard<");
			}
}
else {
	 die("Désolé, . Veuillez réessayer plus tard");
 }
 ?>  
   </div>
</div>
</div>
</section>
<script>
      setTimeout(function () {
       window.location.href = "indexx.html"; 
    }, 3000); 
</script>
</body>
</html>
