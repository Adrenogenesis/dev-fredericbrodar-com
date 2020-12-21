<?php
require __DIR__ . '/stripe-php/init.php';

\Stripe\Stripe::setApiKey("sk_live_xxxxxxxxxxxxxxxxxx");

  $token  = $_POST['stripeToken'];
  $email  = $_POST['stripeEmail'];

  $customer = \Stripe\Customer::create(array(
      'email' => $email,
      'source'  => $token
  ));

  $charge = \Stripe\Charge::create(array(
      'customer' => $customer->id,
      'amount'   => 229900,
      'currency' => 'eur',
      'description' => 'Chaincode.exe',
      'receipt_email' => $email
  ));

  echo 'Paiement accepté !';
  echo '<br>';
  echo 'Vous devez créer un compte pour télécharger le fichier.';
  echo '<br>';
  echo 'Un lien vous sera envoyé par mail';
  echo '<br>';
  $link_address = 'https://login.fredericbrodar.com';
  echo "<a href='".$link_address."'>Ouvrir un compte</a>";
  ?>
<!-- Event snippet for Website traffic conversion page --> 
<script> gtag('event', 'conversion', {'send_to': 'xxxxxxxxxxxxxxxxxxxxxxxxxxxx'}); </script> 