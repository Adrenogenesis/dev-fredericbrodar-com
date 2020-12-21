<?php
session_start();
function http($url, $params=false) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  if($params)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
  return json_decode(curl_exec($ch));
}
if(isset($_GET['logout'])) {
  unset($_SESSION['username']);
  header('Location: /');
  die();
}
if(isset($_SESSION['username'])) {
  echo "<div style='border:1px solid #ff0000; text-align: center; margin: 50px'>";
  echo '<p>Connecté en tant que :</p>';
  echo '<p>' . $_SESSION['username'] . '</p>'; 
  echo '<p><a href="/?logout">Déconnexion</a></p>';
  echo "</div>";
  include 'login.php';
  die();
}
$client_id = 'xxxxxxxxxxxxxx';
$client_secret = 'xxxxxxxxxxxxxxx';
$redirect_uri = 'https://dev.fredericbrodar.com/';
$metadata_url = 'https://dev-169667.okta.com/oauth2/default/.well-known/oauth-authorization-server';
$metadata = http($metadata_url);
if(isset($_GET['code'])) {
  if($_SESSION['state'] != $_GET['state']) {
    die('Authorization server returned an invalid state parameter');
  }
  if(isset($_GET['error'])) {
    die('Authorization server returned an error: '.htmlspecialchars($_GET['error']));
  }
  $response = http($metadata->token_endpoint, [
    'grant_type' => 'authorization_code',
    'code' => $_GET['code'],
    'redirect_uri' => $redirect_uri,
    'client_id' => $client_id,
    'client_secret' => $client_secret,
  ]);
  if(!isset($response->access_token)) {
    die('Error fetching access token');
  }
  $token = http($metadata->introspection_endpoint, [
    'token' => $response->access_token,
    'client_id' => $client_id,
    'client_secret' => $client_secret,
  ]);
  if($token->active == 1) {
    $_SESSION['username'] = $token->username;
    header('Location: /');
    die();
  }
}
if(!isset($_SESSION['username'])) {
  $_SESSION['state'] = bin2hex(random_bytes(5));
  $authorize_url = $metadata->authorization_endpoint.'?'.http_build_query([
    'response_type' => 'code',
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
    'state' => $_SESSION['state'],
    'scope' => 'openid',
  ]);
  #$authorize_url = 'TODO';
  ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Développeur web Bourges, création site internet Bourges</title>
  <meta name="description" content="Développeur web à Bourges(18), Création site internet Bourges, webmaster freelance Bourges(18), site e commerce" >
  <meta name="keywords" content="freelance developpeur web, création site internet, developpeur freelance, développeur web wordpress, site e commerce, solution e commerce, création de site internet, développeur wordpress"/>
    <meta name="referrer" content="always" />
    <meta name='robots' content='noodp'/>
    <link rel="canonical" href="https://dev.fredericbrodar.com/" />
    <meta name="geo.region" content="Centre-Val de Loire" />
    <meta name="geo.position" content="47.1851005554,2.61315989494" />
    <meta name="geo.placename" content="Protonwebmaster" />   
    <META NAME="DC.Title" CONTENT="Développeur web Bourges, création site internet Bourges">
    <META NAME="DC.Description" CONTENT="Développeur web à Bourges(18), Création site internet Bourges, webmaster freelance Bourges(18), site e commerce">
    <META NAME="DC.Date" CONTENT="2020">
    <META NAME="DC.Type" CONTENT="image">
    <META NAME="DC.Format" CONTENT="text/html">
    <META NAME="DC.Identifier" CONTENT="https://dev.fredericbrodar.com/"> 
    <META NAME="DC.Source" CONTENT="Creative Tim - Material Kit Free Bootstrap 4 Ui Kit.">
    <META NAME="DC.Language" CONTENT="fr">
    <META NAME="DC.Rights" CONTENT="Copyright">
    <META NAME="DC.Creator" CONTENT="Brodar, Frédéric">
    <META NAME="DC.Publisher" CONTENT="Brodar, Frédéric">
    <META NAME="DC.Contributor" CONTENT="Brodar, Frédéric">
    <meta name="author" content="Protonwebmaster - webmaster freelance">
    <meta name="publisher" content="BRODAR">
    <link rel="image_src" href="https://fredericbrodar.com/assets/img/logo-protonwebmaster.jpg">
    <meta name="language" content="fr" >
    <meta name="distribution" content="global" >
    <meta name="expires" content="never">
    <meta name="Robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="author" href="protonwebmaster.info@gmail.com">
    <meta name="copyright" content="PROTONWEBMASTER-2020">
    <meta property="og:locale" content="fr_FR" />
      <meta property="og:title" content="Développeur web Bourges, création site internet Bourges">
      <meta property="og:description" content="Développeur web à Bourges(18), Création site internet Bourges, webmaster freelance Bourges(18), site e commerce"/>
      <meta property="og:url" content="https://dev.fredericbrodar.com/">
      <meta property="og:type" content="website" />
      <meta property="og:site_name" content="Protonwebmaster" />
      <meta property="article:author" content="https://www.facebook.com/fredbrodar">  
      <meta property="article:publisher" content="https://www.facebook.com/protonwebmaster/" />
      <meta property="fb:app_id" content="330944807970336"/>
      <meta property="article:published_time" content="2020-10-26">
      <meta property="og:image" content="https://fredericbrodar.com/assets/img/logo-protonwebmaster.jpg">
      <meta property="og:see_also" content="https://twitter.com/@protonwebmaster" />
      <meta property="og:see_also" content="https://www.facebook.com/protonwebmaster" />
      <meta property="og:see_also" content="https://fr.linkedin.com/in/brodarfrederic" />
      <meta property="og:see_also" content="https://github.com/protonwebmaster" />
      <meta property="og:see_also" content="https://protonwebmaster.business.site/" />
      <meta property="og:see_also" content="https://www.protonwebmaster.com/" />
      <meta property="og:see_also" content="https://dev.protonwebmaster.com/" />
      <meta property="og:see_also" content="https://fredericbrodar.com/protongame/" />
      <meta property="og:see_also" content="https://www.instagram.com/protonwebmaster/" />
      <meta property="og:see_also" content="https://www.malt.fr/profile/fredericbrodar/" />
      <meta property="og:see_also" content="https://www.codeur.com/-fredericbojpf/" />
      <meta property="og:see_also" content="https://www.bourges.infoptimum.com/pro/rians/developpement-web-base-de-donnee-sites-internetcyber-securite-consulting-webdesign/protonwebmaster-850.html" />
      <meta property="og:see_also" content="https://www.tidio.com/talk/a4awdc1i2s8kzk0u1horagmyqfznx9v5" />
      <meta name="twitter:card" content="summary">
      <meta name="twitter:site" content="@protonwebmaster">
      <meta name="twitter:title" content="freelance developpeur web - créer son site internet - Frédéric Brodar">
      <meta name="twitter:description" content="Développeur web à Bourges(18), Création site internet Bourges, webmaster freelance Bourges(18), site e commerce">
      <meta name="twitter:creator" content="@protonwebmaster">
      <meta name="twitter:image:src" content="https://www.protonwebmaster.site/imgproton/logo/logo-protonwebmaster-14f3.png">
      <meta name="twitter:domain" content="https://www.protonwebmaster.com/">
      <meta name="twitter:image" content="https://fredericbrodar.com/assets/img/logo-protonwebmaster.jpg">
      <meta name="twitter:url" content="https://twitter.com/protonwebmaster" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="mobile-web-app-capable" content="yes">
      <meta name="prerender-status-code" content="404">
      <meta name="prerender-header" content="Location: https://dev.fredericbrodar.com">
  <!-- Favicons -->
<link rel="apple-touch-icon" sizes="57x57" href="assets/img/icons/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="assets/img/icons/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="assets/img/icons/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="assets/img/icons/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="assets/img/icons/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="assets/img/icons/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="assets/img/icons/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="assets/img/icons/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="assets/img/icons/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="assets/img/icons/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="assets/img/icons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="assets/img/icons/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="assets/img/icons/favicon-16x16.png">
<link rel="dns-prefetch" href="//www.google.com">
<link rel="dns-prefetch" href="//www.protonwebmaster.com">
<link rel="dns-prefetch" href="//dev.protonwebmaster.com">
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="dns-prefetch" href="//cmp.osano.com">
<link rel="dns-prefetch" href="//cdn.jsdelivr.net">
<!--<link rel="manifest" href="/manifest.json">-->
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff"> 
  <link rel="preload" href="assets/vendor/icofont/fonts/icofont.woff2" as="font" type="font/icofont.woff2" crossorigin>
  <link rel="preload" href="assets/vendor/boxicons/fonts/boxicons.woff2" as="font" type="font/boxicons.woff2" crossorigin>
  <link rel="preload" href="assets/vendor/icofont/fonts/icofont.woff" as="font" type="font/icofont.woff" crossorigin>
  <link rel="preload" href="assets/vendor/boxicons/fonts/boxicons.woff" as="font" type="font/boxicons.woff" crossorigin>
  <link rel="subresource" href="assets/css/stylemin.css">
  <link href="assets/css/stylemin.css" rel="stylesheet"> 
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet"> 
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CRoboto:300,300i,400,400i,500,500i,600,600i,700,700i%7CPoppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!-- =======================================================
  version : 171220
  * Template Name: BizLand - v1.0.1
  * Template URL: https://bootstrapmade.com/bizland-bootstrap-business-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  https://getbootstrap.com/docs/4.0/components/
  https://www.cssmatic.com/box-shadow
  https://boxicons.com/
  https://1stwebdesigner.com/php-contact-form-html/
  ======================================================== -->
  <script src='https://www.google.com/recaptcha/api.js' async defer></script>
 <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-172030075-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'xxxxxxx');  
</script>
<!-- Global site tag (gtag.js) - Google Ads: 862161917 
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-862161917"></script> 
<script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-862161917'); </script> --> 
</head>
<body itemscope="" itemtype="http://schema.org/WebPage"  onload="render()">
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v8.0&appId=330944807970336&autoLogAppEvents=1" nonce="yJq8NMGr"></script>
  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-none d-lg-flex align-items-center fixed-top">
    <div class="container d-flex">
      <div class="contact-info mr-auto">
        <i class="icofont-phone"></i> +33 0659910270
      </div>
      <div class="social-links">
        <a href="https://twitter.com/protonwebmaster" itemprop="url" class="twitter"><i class="icofont-twitter"></i></a>
        <a href="https://www.facebook.com/protonwebmaster"  itemprop="url" class="facebook"><i class="icofont-facebook"></i></a>
        <a href="https://www.instagram.com/protonwebmaster/" itemprop="url" class="instagram"><i class="icofont-instagram"></i></a>
        <a href="live:exonet3i" class="skype"><i class="icofont-skype"></i></a>
        <a href="https://fr.linkedin.com/in/brodarfrederic" itemprop="url" class="linkedin"><i class="icofont-linkedin"></i></a>
      </div>
    </div>
  </div>
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">
    <!-- <h1 class="logo mr-auto"><a href="https://www.protonwebmaster.com">Protonwebmaster<span>.</span></a></h1> -->
      <!-- Uncomment below if you prefer to use an image logo -->
       <a href="https://www.fredericbrodar.com/" class="logo mr-auto"><img itemprop="image" class="logomain" src="assets/img/logo.jpg" alt="logo protonwebmaster"></a>
      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="active"><a href="">Accueil</a></li>
          <li><a href="#about">Présentation</a></li>
          <li><a href="#services">Prestations</a></li>
          <li><a href="#portfolio">Portfolio</a></li>
          <li><a href="#tech">Applications</a></li>
          <li class="drop-down"><a href="https://www.protonwebmaster.com" itemprop="url">Protonwebmaster</a>
            <ul>
              <li><a href="https://www.bourges.infoptimum.com/pro/rians/developpement-web-base-de-donnee-sites-internetcyber-securite-consulting-webdesign/protonwebmaster-850.html" itemprop="url">Infoptimum</a></li>
              <li class="drop-down"><a href="">Références</a>
                <ul>
                  <li><a href="https://github.com/protonwebmaster" itemprop="url">Github</a></li>
                  <li><a href="https://fredericbrodar.com/" itemprop="url">Freelance</a></li>
                  <li><a href="https://www.malt.fr/profile/fredericbrodar" itemprop="url">Malt</a></li>
                  <li><a href="https://www.codeur.com/-fredericbojpf" itemprop="url">Codeur.com</a></li>
                  <li><a href="https://stackexchange.com/users/4723020/hexphp111" itemprop="url">StackOverflow</a></li>
                 </ul>
              </li>
              <li><a href="https://dev.fredericbrodar.com/wp/wordpress/" itemprop="url">Annuaire des entreprises.</a></li>
              <li><a href="https://protonwebmaster.business.site/" itemprop="url">Google site</a></li>
              <li><a href="https://dev.protonwebmaster.com/" itemprop="url">Développeur</a></li>
              <li><a href="https://www.exonet3i.com/" itemprop="url">Blog</a></li>              
            </ul>
          </li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </nav><!-- .nav-menu -->
    </div>
  </header><!-- End Header -->
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container" data-aos="zoom-out" data-aos-delay="100">
      <h1 itemprop="name">Frédéric Brodar - <span itemprop="description" style="text-shadow: 2px 2px black;"><a href="https://www.protonwebmaster.com" itemprop="url">Développeur Web</a></span>
      </h1>
      <h2>Besoin d'un developpeur freelance ? Un graphiste site internet.</h2>
      <p>Je vous propose des solutions complètes de développement axées sur vos objectifs. <a href="pdf/plaquette-protonwemaster.pdf"><i class="bx bx-download"></i></a></p>
      <p><strong>Créez votre compte dès maintenant</strong> pour une étude et une gestion personnalisée de votre projet sur internet. <a class="picto-item" href="tel:+33659910270" aria-label="Tél:0659910270"><i class="bx bxs-phone"></i></a></p>
      <div class="d-flex">
          <div class="connect">  
          <div class="row">
             <div class="col-sm">
                       Connexion Okta
                  </div>
                      <div class="col-sm">
                           <?php                              
                              echo '<p><a href="'.$authorize_url.'"><img style="width: 75px; height: 75px;" src="assets/img/okta.png" alt="okta" /></a></p>';
                            }
                            ?>
                     </div>
                 </div>
           </div>
         </div>
    </div>
  </section><!-- End Hero -->
  <main id="main">
    <!-- ======= Featured Services Section ======= -->
    <section id="featured-services" class="featured-services">
<!-- particles.js container -->
<div id="particles-js"></div>
      <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
            <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
              <div class="icon"><i class="bx bx-code-curly"></i></div>
              <h4 class="title"><a href="">Développement</a></h4>
              <p class="description"></p>
<!-- modal -->	
    <div class="info">
        <div class="buttons">
            <p>
                <a href="" data-modal="#modal" class="modal__trigger">Création site internet. Développement d'application web : Bootstrap, Materialize, ReactJs, React-native.</a>
            </p>
        </div>        
    </div>
    <!-- end modal -->	
        </div>
          </div>
          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
            <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
              <div class="icon"><i class="bx bx-data"></i></div>
              <h4 class="title"><a href="">Base de donnée</a></h4>
              <p class="description"></p>
              <!-- modal 1 -->	
    <div class="info">
        <div class="buttons">
            <p>
                <a href="" data-modal="#modal1" class="modal__trigger">Création et configuration base de donnée : Mysql.</a>
            </p>
        </div>        
    </div>
    <!-- end modal 1 -->	
            </div>
          </div>
          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
            <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
              <div class="icon"><i class="bx bx-cloud"></i></div>
              <h4 class="title"><a href="">Cloud</a></h4>
              <p class="description"></p>
              <!-- modal 2 -->	
    <div class="info">
        <div class="buttons">
            <p>
                <a href="" data-modal="#modal2" class="modal__trigger">développer un site web dans le cloud ( DevOps ) : Netlify, Okteto.</a>
            </p>
        </div>        
    </div>
    <!-- end modal 2 -->	
            </div>
          </div>
          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
            <div class="icon-box" data-aos="fade-up" data-aos-delay="400">
              <div class="icon"><i class="bx bx-brain"></i></div>
              <h4 class="title"><a href="">Consulting</a></h4>
              <p class="description"></p>
              <!-- modal 3 -->	
    <div class="info">
        <div class="buttons">
            <p>
                <a href="" data-modal="#modal3" class="modal__trigger">Développement de votre image numérique.</a>
            </p>
        </div>        
    </div>
    <!-- end modal 3 -->	
            </div>
          </div>
        </div>
      </div>
<!-- Modal -->
<div id="modal" class="modal modal__bg" role="dialog" aria-hidden="true">
    <div class="modal__dialog">
        <div class="modal__content">
            <h3>Application Web</h3>
            <p>Réalisation de site internet vitrine, dynamique et e-commerce. Interface utilisateur sécurisée: Authentification unique (SSO) et multi-facteurs ( MFA ).
            Système de paiement carte Visa et Paypal.
            </p>            
            <!-- modal close button -->
            <a href="" class="modal__close demo-close">
                <svg class="" viewBox="0 0 24 24"><path d="M19 6.41l-1.41-1.41-5.59 5.59-5.59-5.59-1.41 1.41 5.59 5.59-5.59 5.59 1.41 1.41 5.59-5.59 5.59 5.59 1.41-1.41-5.59-5.59z"/><path d="M0 0h24v24h-24z" fill="none"/></svg>
            </a>            
        </div>
    </div>
</div>
<!-- Modal -->
<!-- Modal 1 -->
<div id="modal1" class="modal modal__bg" role="dialog" aria-hidden="true">
    <div class="modal__dialog">
        <div class="modal__content">
            <h3>Intéraction</h3>
            <p>Support d'authenfication avec la base de donnée. Connexion et gestionnaire de connexion php pdo mysql.</p>            
            <!-- modal close button -->
            <a href="" class="modal__close demo-close">
                <svg class="" viewBox="0 0 24 24"><path d="M19 6.41l-1.41-1.41-5.59 5.59-5.59-5.59-1.41 1.41 5.59 5.59-5.59 5.59 1.41 1.41 5.59-5.59 5.59 5.59 1.41-1.41-5.59-5.59z"/><path d="M0 0h24v24h-24z" fill="none"/></svg>
            </a>            
        </div>
    </div>
</div>
<!-- Modal 1 -->
<!-- Modal 2 -->
<div id="modal2" class="modal modal__bg" role="dialog" aria-hidden="true">
    <div class="modal__dialog">
        <div class="modal__content">
            <h3>Collaboration</h3>
            <p>Déploiement en continu d'application. Test et versioning git. 
               Méthode de collaboration qui privilégie les échanges réguliers, cela permet une grande flexibilité dans les différentes étapes de conception d'un projet.</p>            
            <!-- modal close button -->
            <a href="" class="modal__close demo-close">
                <svg class="" viewBox="0 0 24 24"><path d="M19 6.41l-1.41-1.41-5.59 5.59-5.59-5.59-1.41 1.41 5.59 5.59-5.59 5.59 1.41 1.41 5.59-5.59 5.59 5.59 1.41-1.41-5.59-5.59z"/><path d="M0 0h24v24h-24z" fill="none"/></svg>
            </a>            
        </div>
    </div>
</div>
<!-- Modal 2 -->
<!-- Modal 3 -->
<div id="modal3" class="modal modal__bg" role="dialog" aria-hidden="true">
    <div class="modal__dialog">
        <div class="modal__content">
            <h3>Web Conseil</h3>
            <p>Etude de l'environnement de votre entreprise, pour développer son image sur le Web. Avec un référencement de qualité et une conception graphique personalisée.
              Réalisation de diagnostic des besoins "Cloud". Conseil et proposition sur les orientations dans les technologies du Web.
            </p>            
            <!-- modal close button -->
            <a href="" class="modal__close demo-close">
                <svg class="" viewBox="0 0 24 24"><path d="M19 6.41l-1.41-1.41-5.59 5.59-5.59-5.59-1.41 1.41 5.59 5.59-5.59 5.59 1.41 1.41 5.59-5.59 5.59 5.59 1.41-1.41-5.59-5.59z"/><path d="M0 0h24v24h-24z" fill="none"/></svg>
            </a>            
        </div>
    </div>
</div>
<!-- Modal 3 -->
    </section><!-- End Featured Services Section -->
    <!-- ======= About Section ======= -->
    <section id="about" class="about section-bg">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
         <a href="https://www.protonwebmaster.com" itemprop="url"><h2>Protonwebmaster</h2></a>
          <h3>Un projet ? Des <span>Solutions !</span></h3>
          <p>Pour commencer. Une évaluation réelle de vos besoins, avec une expertise et un prévisionnel de votre budget.</p>
          <div class="solution">
                    <ul>
                        <li>
                        Définition de l'objectif avec une présentation technique et fonctionnelle.
                        </li>
                        <li>
                        Elaboration du cahier des charges, et de la charte graphique.
                        </li>
                        <li>
                        L'expression des besoins et les vulnérabilités de sécurité.
                        </li>
                        <li>
                        Le choix de la méthode de travail : Méthode <a href="https://www.planzone.fr/blog/quest-ce-que-la-methodologie-agile" itemprop="url">Agile</a>.
                        </li>
                   </ul>
              </div>
              <div class="promo">
              <h4>Votre site internet à <strong style="color: red;">-60%</strong></h4>
              <a href="https://fredericbrodar.com/protongame/"><img src="assets/img/promotion.png" alt="promotion"></a>
              <p>Un site internet professionnel full-responsive, d'une valeur de 849€, avec un nom de domaine gratuit, connexion sécurisée ssl. Formulaire de contact et référencement inclus.</p>
              </div>
        </div>
        <div class="row">
          <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="100">
           <a href="https://www.protonwebmaster.com/" itemprop="url"><img src="assets/img/protonwebmaster.jpg" class="img-fluid" alt="protonwebmaster"></a>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 content d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <h3>Présentez-moi votre projet dès maintenant !</h3>
            <button id="btn" type="button" class="btn btn-warning" onclick="window.location.href = 'https://www.tidio.com/talk/a4awdc1i2s8kzk0u1horagmyqfznx9v5';">
            Discution en direct</button>
          <div class="space"></div>
            <p class="font-italic">
              En tant que développeur, je mets a votre disposition ma créativité, ainsi que des ressources infinies. Télécharger ici la plaquette.  <a href="pdf/plaquette-protonwemaster.pdf"><i class="bx bx-download"></i></a>
            </p>
            <ul>
              <!--https://iconify.design/icon-sets/bx/-->
              <li>
                <i class="bx bx-atom"></i>
                 <div>
                  <h5>Site internet vitrine</h5>
                  <p>Avec bootstrap, Materialize et ReactJs.</p>
                </div>
              </li>
              <li>
                <i class="bx bx-cart-alt"></i>
                <div>
                  <h5>CMS et E-commerce</h5>
                  <p>WordPress et Prestashop.</p>
                </div>
              </li>
              <li>
              <i class="bx bx-mobile"></i>
              <div>
               <h5>Application mobile</h5>
               <p>Avec React-native.</p>
             </div>
           </li>
            </ul>
            <p>
              De la conception a la realisation, une collaboration constante.
            </p>
          </div>
        </div>
      </div>
    </section><!-- End About Section -->
    <!-- ======= Portfolio Details Section ======= -->
    <section class="portfolio-details">
      <div class="container">
        <div class="portfolio-details-container">
          <div class="owl-carousel portfolio-details-carousel">
            <img style="width: 800px; height: auto; box-shadow: 6px 6px 4px 1px rgba(0,0,0,0.75);" src="assets/img/portfolio/dev-min.jpg" class="img-fluid" alt="développement web">
            <img style="width: 800px; height: auto; box-shadow: 6px 6px 4px 1px rgba(0,0,0,0.75);" src="https://www.pyvotal.com/wp-content/uploads/2015/11/okta.jpg" class="img-fluid" alt="okta">
            <img style="width: 800px; height: auto; box-shadow: 6px 6px 4px 1px rgba(0,0,0,0.75);" src="https://point-banque.fr/wp-content/uploads/2019/09/Stripe.jpg" class="img-fluid" alt="stripe">
          </div>
          <div class="portfolio-info">
            <h3>La réalisation d'un projet avec des ressources de choix.</h3>
            <ul>
              <li><strong>Méthode de conception</strong>: Développement Web.</li>
              <li><strong>Gestion des identités, GIA</strong>: Okta.</li>
              <li><strong>Solution de paiement</strong>: Stripe.</li>
            </ul>
          </div>
        </div>
        <div class="portfolio-description">
          <h2>Rigueur et précision, pour un résultat optimal.</h2>
          <p>
            Des solutions web qui donnent un impact positif sur les résultats avec un retour sur investissement rapide. "Évolutivité et flexibilité au service de grands noms et de grandes idées", Okta. 
          </p>
        </div>
      </div>
    </section><!-- End Portfolio Details Section -->
    <!--https://icofont.com/icons-->    
    <!-- ======= Services Section =======https://iconify.design/icon-sets/bx/ -->
    <section id="services" class="services">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Services</h2>
          <h3>Tout les <span>Services</span> qu'il vous faut.</h3>
          <p>  </p>
        </div>
        <div class="row">
          <div id="clg4" class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-cog"></i></div>
              <h4><a href="">Maintenance site internet</a></h4>
              <p>Mise à jour des publications et du code. Test de performance et contrôle du référencement et de la connexion sécurisée SSL ( https ). Mise en conformité RGPD. Administration et maintenance ( Linux )</p>
            </div>
          </div>
          <div id="clg4a" class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-error"></i></div>
              <h4><a href="">Tests de vulnérabilité</a></h4>
              <p>Recherche des failles Xss et Csrf avec un rapport complet. Audit de sécurité personalisé. Résolution des erreurs et bugs SSL dans les navigateurs web. 
              ( lorsqu’un serveur présente une chaîne de certificats invalide ou incomplète ).</p>
            </div>
          </div>
          <div id="clg4b" class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="300">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-desktop"></i></div>
              <h4><a href="">Dépannage informatique</a></h4>
              <p>Windows et Linux, sauvegarde du système dans le cloud. Recherche poussée de malware et nettoyage intégral de votre PC : Logiciel et matériel.</p>
            </div>
          </div>
          <div id="clg4c" class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-photo-album"></i></div>
              <h4><a href="">Désign graphique</a></h4>
              <p>Création de Logo, carte de visite, flyers, retouche photos et effets spéciaux, photomontage et 3D. Haute définition, avec une grande diversité des extensions.</p>
            </div>
          </div>
          <div id="clg4d" class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="200">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-at"></i></div>
              <h4><a href="">Réseaux sociaux</a></h4>
              <p>Mise en place d'une campagne Facebook ( Gestion des publicité ), avec une page Professionnelle.</p>
            </div>
          </div>
          <div id="clg4e" class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="300">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-award"></i></div>
              <h4><a href="">Formation WordPress et gestion de site internet.</a></h4>
              <p>Utilisation globale de WordPress: Interface administrateur, gestion des plugins, publication et mise à jour. Module e-commerce pour vendre des produits physiques et/ou virtuels</p>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Services Section -->
    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">
      <div class="container" data-aos="zoom-in">
        <div class="owl-carousel testimonials-carousel">
          <div itemscope itemtype="http://schema.org/Person" class="testimonial-item">
            <a href="https://www.linkedin.com/in/brodarfrederic/" itemprop="url"><img itemprop="image" src="assets/img/testimonials/brodar-frederic.jpg" class="testimonial-img" alt="brodar frédéric"></a>
                <h3 itemprop="name">Brodar Frederic</h3>
            <h4 itemprop="jobTitle">Ceo &amp; Webmaster</h4>
            <p>
              <i class="bx bxs-quote-alt-left quote-icon-left"></i>
              Je réalise des produits et des expériences numériques qui ont un impact durable pour votre entreprise, et je fusionne imagination et technologie pour vous aider à développer votre activité sur Internet.<i class="bx bxs-quote-alt-right quote-icon-right"></i>
            </p>
          </div> 
        </div>
      </div>
    </section><!-- End Testimonials Section -->
    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Portfolio</h2>
          <h3><span>Portfolio</span></h3>
          <p>Quelques exemples d'application web.</p>
        </div>
        <div class="row" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">Tout</li>
              <li data-filter=".filter-app">Application web</li>
              <li data-filter=".filter-card">Site vitrine et e-commerce</li>
              <li data-filter=".filter-web">Site WordPress</li>
            </ul>
          </div>
        </div>
        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <img src="assets/img/portfolio/simulateur.jpg" class="img-fluid" alt="simulateur de barbe">
            <div class="portfolio-info">
              <h4>Simulateur de barbe</h4>
              <p>Php, js, mysql et json</p>
              <a href="assets/img/portfolio/simulateur.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="Simulateur"><i class="bx bx-plus"></i></a>
              <a href="https://info.exonet3i.com/directweb/camw2-7u/BDD/index.php" class="details-link" title="Plus"><i class="bx bx-link"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <img src="assets/img/portfolio/annuaire.jpg" class="img-fluid" alt="annuaire d'entreprise">
            <div class="portfolio-info">
              <h4>Annuaire d'entreprise</h4>
              <p>WordPress</p>
              <a href="assets/img/portfolio/annuaire.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="Annuaire"><i class="bx bx-plus"></i></a>
              <a href="https://dev.fredericbrodar.com/wp/wordpress/" class="details-link" title="Plus"><i class="bx bx-link"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <img src="assets/img/portfolio/facebook-analytics-min.png" class="img-fluid" alt="facebook">
            <div class="portfolio-info">
              <h4>S.E.O.</h4>
              <p>Facebook analytics</p>
              <a href="assets/img/portfolio/facebook-analytics-min.png" data-gall="portfolioGallery" class="venobox preview-link" title="Facebook analytics"><i class="bx bx-plus"></i></a>
              <a href="https://www.protonwebmaster.com/prestations-page" class="details-link" title="Plus"><i class="bx bx-link"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <img src="assets/img/portfolio/lespatineaux.jpg" class="img-fluid" alt="Les Patineaux">
            <div class="portfolio-info">
              <h4>Site vitrine</h4>
              <p>Html/css, php</p>
              <a href="assets/img/portfolio/lespatineaux.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="Site vitrine"><i class="bx bx-plus"></i></a>
              <a href="http://www.lespatineaux.com/" class="details-link" title="Plus"><i class="bx bx-link"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <img src="assets/img/portfolio/crypto.jpg" class="img-fluid" alt="site crypto">
            <div class="portfolio-info">
              <h4>Crypto</h4>
              <p>Site Wordpress</p>
              <a href="assets/img/portfolio/crypto.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="crypto"><i class="bx bx-plus"></i></a>
              <a href="https://www.fredericbrodar.com/" class="details-link" title="Plus"><i class="bx bx-link"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <img src="assets/img/portfolio/webhook-2-min.jpg" class="img-fluid" alt="webhook">
            <div class="portfolio-info">
              <h4>Webhook</h4>
              <p>Test et contrôle d'application.</p>
              <a href="assets/img/portfolio/webhook-2-min.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="Webhook"><i class="bx bx-plus"></i></a>
              <a href="https://www.protonwebmaster.com/prestations-page" class="details-link" title="Plus"><i class="bx bx-link"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <img src="assets/img/portfolio/chezmarie.jpg" class="img-fluid" alt="chezmarie site vitrine">
            <div class="portfolio-info">
              <h4>Site vitrine</h4>
              <p>Html/css et googleapis</p>
              <a href="assets/img/portfolio/chezmarie.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="site vitrine"><i class="bx bx-plus"></i></a>
              <a href="https://www.protonwebmaster.fr" class="details-link" title="Plus"><i class="bx bx-link"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <img src="assets/img/portfolio/prestashop.jpg" class="img-fluid" alt="prestashop e commerce">
            <div class="portfolio-info">
              <h4>E-commerce</h4>
              <p>Prestashop</p>
              <a href="assets/img/portfolio/prestashop.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="Prestashop"><i class="bx bx-plus"></i></a>
              <a href="https://dev.fredericbrodar.com/mstore/" class="details-link" title="Plus"><i class="bx bx-link"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <img src="assets/img/portfolio/blog.jpg" class="img-fluid" alt="blog wordpress">
            <div class="portfolio-info">
              <h4>Blog</h4>
              <p>WordPress</p>
              <a href="assets/img/portfolio/portfolio-9.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="Blog"><i class="bx bx-plus"></i></a>
              <a href="http://info.exonet3i.com/wp/wordpress/" class="details-link" title="Plus"><i class="bx bx-link"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Portfolio Section -->
    <section>
    <div class="container" data-aos="fade-up">
            <div class="section-title">
                    <div class="bio">                       
                            <h2> Développeur web, Graphiste et Webdesigner.</h2>                         
                            <p>J'ai adopté une nouvelle méthode de collaboration, pour privilégier des échanges réguliers, cela permet une grande flexibilité dans les différentes étapes de conception d'un projet.
                            Webmaster depuis 2015, mes atouts sont la polyvalence et adaptabilité pour les nouvelles technologies. </p>
                            <h3>Je mets à votre disposition :</h3>
                                <div class="biol">                            
                                    <ul>
                                    <li>- Ma créativité, ainsi que des ressources infinies avec WordPress, Bootstrap et Materialize.</li>
                                    <li>- Une solution complète de vente en ligne avec un système de paiement sécurisé avec Prestashop ou Magento.</li>
                                    <li>- Un projet de création graphique à l'image de votre activité.</li>
                                    </ul>
                                 </div>
                            <p>Administrateur système Linux, pour les configuration serveur Apache Ssl ou Nginx, messagerie avec smtp et sms, test de vulnérabilités et détection en matières de sécurité des applications.</p>
                    </div>
                          <h2>Actualité</h2>
                              <h3><span>Les partenaires</span></h3>
                                   <div class="actualite">
                                       <h4>Infoptimum Bourges</h4>
                                       <p>Annuaire des professionnels - Bourges et Département du Cher. Un <a href="https://www.bourges.infoptimum.com/pro/rians/developpement-web-base-de-donnee-sites-internetcyber-securite-consulting-webdesign/protonwebmaster-850.html" itemprop="url">mini-site</a> 
                                       vraiment sympathique est mis en place pour présenter de façon très pratique votre entreprise.
                                       </p>
                                  </div>
                                  <div id="tech" class="techno">
                                  <h2>Les nouveaux produits</h2>
                        <h3>Technologie blockchain chaincode hyperledger</h3>
              <div class="blockchain">
                  <a href="assets/img/chaincode3-min.jpg"><img class="hyper" src="assets/img/blockchain-proton.png" alt="chaincode"></a>
                  <p>
                  <a href="https://www.hyperledger.org/use/fabric" itemprop="url" >Hyperledger Fabric</a> est une implémentation de blockchain pour les entreprises.
                  </p>
                  <p>
                  <a href="https://hyperledger-fabric.readthedocs.io/en/release-1.4/chaincode.html" itemprop="url">Chaincode</a> implémente des fonctionnalités de niveau supérieur en plus du grand livre de la <a href="https://blockchainfrance.net/decouvrir-la-blockchain/c-est-quoi-la-blockchain/">blockchain</a>. Il existe deux types de code de chaîne, tous deux sous le contrôle d'un pair. 
                  Le code chaîne système fait partie du processus Peer. Le code de chaîne normal est un conteneur séparé géré par l'homologue. Cette application fonctionne avec Docker sous Windows 10 Professionnel.
                  </p>
                  <div class="prixblk">
                     Prix : 99,00€ TTC
                  </div>
              </div>
                    <div class="stripe">
                                 <form action="paiement.php" method="POST">
                                  <script
                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                    data-key="pk_live_xxxxxxxxxxxxxxxx"
                                    data-amount="99"
                                    data-name="Blockchain"
                                    data-description="Chaincode.exe"
                                    data-image="https://fredericbrodar.com/assets/blockchain/chaincode.png"
                                    data-locale="auto"
                                    data-currency="eur"
                                    data-label="Télécharger" >
                                  </script>
                                </form>  
                                <div id="auth"></div>    
                         </div>
                                   <p>Réalisez une Blockchain pour votre entreprise avec une simulation rapide Chaincode et Docker !</p>
                          </div>                         
                          <div class="techno">
                                 <h3><span>Connexion sans mot de passe,</span> plus sécurisée et à moindre coûts.</h3>
                                 <div class="magic"> 
                                      <p><span style="color:red;">Exemple :</span> Un liens est envoyé au destinataire pour vérification, l'utilisateur obtiens alors une connexion sécurisée.</p>
                                      <p>Supprimez les mots de passe pour améliorer le taux de conversion !</p>                                       
                      <div id="app">Connexion...</div>
                    </div>
                    <p>Envoi fiable et rapide des e-mails avec basculement. Au lieu du mots de passe, la sécurité des utilisateurs est soutenue par des <a href="https://docs.magic.link/security#e2e-tls-encryption">modules de cryptographie</a>
                     à courbe elliptique et de la sécurité matérielle.</p>
                    <p>Plug-n-Play même si vous disposez d'une solution d'authentification existante. Permettez aux utilisateurs de se connecter via des appareils de bureau, mobiles ou FIDO.</p>
                    <span style="font-size: small;">Classement possible dans le dossier Spam.</span>
            </div>
            <div class="techno">
            <h3><span>Accès sécurisé SSO et MFA.</span> Gestion des identités avec <a href="https://auth0.com/fr/">Auth0</a></h3>
            <div class="magic"> 
                  <p>Je vous apporte les garanties pour une sécurité maximale avec une configuration personnalisée des connexions universelles, SSO, MFA et Gestion des utilisateurs, selon vos besoins spécifiques.<br>
                       Dont voici un exemple en ligne : <a href="auth0/sts/">Connexion Auth0</a></p>
                       <p>L'authentification unique (en anglais Single Sign-On : SSO) est une méthode permettant à un utilisateur d'accéder à plusieurs applications informatiques (ou sites web sécurisés) en ne procédant qu'à une seule authentification.</p>
                      <p>Multi-factor authentication ( MFA ) est une méthode d'authentification électronique dans laquelle un utilisateur d'ordinateur n'a accès à un site Web ou à une application qu'après avoir présenté avec succès deux ou plusieurs éléments de preuve (ou facteurs) à un mécanisme d'authentification (Wikipédia).</p>
                       <br>
                            <a href="auth0/sts/profile.php"><img style="max-width: 100%;" src="assets/img/sso-fr.png" alt="sso"></a>
                     </div>
              </div>
        </div>    
    </div>
    </section>
    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq section-bg">
      <div class="container" data-aos="fade-up">
<div class="section-title">
    <h4>Les prestations</h4>
        <div class="row">
            <div class="col-sm">
                  <div class="devl">
                         <h5>Développement web</h5>
                             <ul>
                                  <li>Création site vitrine.</li>
                                  <li>Création et maintenance site dynamique: Php/Mysql.</li>
                                  <li>CMS: Wordpress & Joomla.</li>
                                  <li>Installation & configuration site E-commerce: Prestashop, Woocommerce, Hikashop.</li>
                                  <li>Création de site web responsive & mobile first - Bootstrap, Materialize.</li>
                                  <li>Tests de sécurité et investigation xss, csrf, dos.</li>
                                  <li>Connexion sécurisée: Ssl Apache.</li>
                                  <li>Gestion des connexions sécurisées, authentification unique (SSO), l'authentification multi-facteurs.</li>                                 
                             </ul>
                  </div>
            </div>
            <div class="col-sm">
                  <div class="devl">
                          <h5>Création graphique</h5>
                              <ul>
                                  <li>Logo</li>
                                  <li>Flyer</li>
                                  <li>Carte de visite</li>
                                  <li>Photo-montage</li>
                                  <li>Réalisation 3D</li>
                                  <li>Analyse et recherche d'image.</li>
                            </ul>
                 </div>
            </div>
            <div class="col-sm">
                  <div class="devl">
                          <h5>Réseaux sociaux</h5>
                             <ul>
                                  <li>Page Facebook</li>
                                  <li>Page Linkedin</li>
                            </ul>
                  </div>
            </div>
        </div>
   </div>
   <div class="section-title">
          <h2>F.A.Q</h2>
          <h3>Foire aux <span>questions</span></h3>
          <p>Comment commencer ?</p>
        </div>
        <ul class="faq-list" data-aos="fade-up" data-aos-delay="100">
          <li>
            <a data-toggle="collapse" class="" href="#faq1">J'ai un projet de création de site internet spécifique pour mon entreprise, comment procède t'on ?<i class="icofont-simple-up"></i></a>
            <div id="faq1" class="collapse show" data-parent=".faq-list">
              <p>
                Le choix de la méthode de travail qui s'impose désormais pour toutes applications web est la méthode Agile. Les différentes étapes de la conception sont concertée et évaluée entre moi et le client. Au début 
                 l'application se présente sous un état dit "fonctionnel" seulement, ensuite les divers éléments viennent s'intégrer au fur et à mesure des étapes, le budget est re-défini. Le projet devient alors évolutif. 
              </p>
            </div>
          </li>
          <li>
            <a data-toggle="collapse" href="#faq2" class="collapsed">Comment se calcule le coût de mon projet ? <i class="icofont-simple-up"></i></a>
            <div id="faq2" class="collapse" data-parent=".faq-list">
              <p>
                Trois options s'offrent à vous : Un abonnement mensuel, au forfait soit par l'intermédiaire d'un devis ou fixe, et par la méthode décrite dans la précédente réponse.
              </p>
            </div>
          </li>
          <li>
            <a data-toggle="collapse" href="#faq3" class="collapsed">Quelles sont les différentes options de réalisation d'une application web ? <i class="icofont-simple-up"></i></a>
            <div id="faq3" class="collapse" data-parent=".faq-list">
              <p>
                WordPress ou Joomla, qui sont des CMS ou ( Système de gestion de contenu ), cela offre la possibilité de mettre en ligne le contenu de différents documents la structuration des contenus d’un site, les classifiant sous différentes catégories comme la FAQ, les blogs, les forums de discussion…
                Un site dynamique : Bootstrap ou Materialize, beaucoup plus personnalisable, mais plus rudimentaire aussi. Un site e-commerce avec Prestashop. 
              </p>
            </div>
          </li>
         </ul>
      </div>
    </section><!-- End Frequently Asked Questions Section -->
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Contact et <a href="#footer">Newsletter.</a></h2>
          <h3><span>Contactez-moi</span></h3>
          <p>Pour toute demande concernant mes prestations, pour un devis ou pour un rendez-vous, une réponse vous sera apportée rapidement.</p>
        </div>
        <div class="row" data-aos="fade-up" data-aos-delay="100"> 
          <div class="col-lg-3 col-md-6">
            <div class="info-box  mb-4">
              <i class="bx bx-buildings"></i>
              <h3>Bureaux</h3> 
              <p>3 Rond Point Jacques Coeur</p>
              <p>18220 - RIANS</p>            
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="info-box  mb-4">
              <i class="bx bx-phone-call"></i>
              <h3>Tél</h3>
              <p><a href="tel:+33644633004">+33 06.59.91.02.70</a></p>
            </div>
          </div>
        </div>
        <div class="row" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-6 ">
           <a href="https://www.protonwebmaster.com" itemprop="url"><img class="responsive" src="assets/img/protonweb.jpg" itemprop="image" alt="protonwebmaster"></a>
          </div>
          <div class="col-lg-6">
            <form id="comment_form" action="forms/mail1.php" method="post" class="php-email-form">
              <div class="form-row">
                <div class="col form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Nom" maxlength="10" data-rule="minlen:4" onkeydown="return alphaOnly(event)" data-msg="Veuillez entrer au moins 4 lettres" required/>
                  <div class="validate"></div>
                </div>
                <div class="col form-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email" data-rule="email" data-msg="Veuillez entrer un email valide" required/>
                  <div class="validate"></div>
                </div>
                <div class="col form-group">
                  <input type="tel" class="form-control" name="phone" placeholder="Telephone" data-rule="tel" maxlength="10" data-msg="Veuillez entrer un numero de telephone valide" onkeypress="return isNumberKey(event)" />
                  <div class="validate"></div>
                </div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Sujet" data-rule="minlen:4" maxlength="50" data-msg="Veuillez entrer au moins 8 lettres" required />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="message" rows="3" data-rule="required" data-msg="Veuillez ecrire un message" placeholder="Message (200 )" maxlength="200"></textarea>
                <div class="validate"></div>
              </div>
              <div class="mb-3">
                <div class="loading">En cour...</div>
                <div class="sent-message"></div>
                 </div>
                 <div class="g-recaptcha" data-sitekey="6LdH4sgZAAAAAN5RCMaR7Tb6Ib5FGEvRUscinKbv"></div>
                      <div class="text-center"><button type="submit" value="Send">Envoyer</button></div>   
              </form>                   
              </div>            
          </div>
        </div>     
    </section><!-- End Contact Section -->
  </main><!-- End #main -->
  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
          </div>
        </div>
      </div>
    </div>
    <div class="footer-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>Protonwebmaster<span>.</span></h3>
              <p>BRODAR Frédéric<br>
              3 Rond Point Jacques Coeur<br>
              18220  RIANS</p>                 
              <strong>Téléphone:</strong> 06.59.91.02.70<br> 
              <div class="logoct">
            <a href="https://booking.myrezapp.com/fr/online/booking/minisite/10718/protonwebmaster" itemprop="url"><img itemprop="activateur" class="logoproton" src="assets/img/marque-Activateur-France-Num-min.jpg" alt="France Num"></a>  
            </div>                
            </div>
          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Exemples</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="https://www.protonwebmaster.site/redirect/annuaire.php" itemprop="url">Annuaire d'entreprise</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="https://www.fredericbrodar.com/" itemprop="url">Site WordPress</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="http://sms.exonet3i.com/fr/" itemprop="url">Joomla</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="https://dev.fredericbrodar.com/mstore/" itemprop="url">Site Prestashop</a></li>
            </ul>
          </div>
          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Liens utiles</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="mentions-légales.html" itemprop="url">Mentions légales</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="https://www.protonwebmaster.com/legale-page">C.G.U.</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="pdf/cgv-protonwebmaster-2020.pdf">C.G.V.</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
            </ul>
          </div>
          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Réseau social</h4>
            <p></p>
            <div class="social-links mt-3">
              <a href="https://twitter.com/protonwebmaster" itemprop="url" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="https://www.facebook.com/protonwebmaster/" itemprop="url" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="https://www.instagram.com/protonwebmaster/" itemprop="url" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="skype:live:exonet3i?call" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="https://www.linkedin.com/in/brodarfrederic/" itemprop="url" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
            <div class="logoct">
            <a href="https://www.protonwebmaster.com" itemprop="url"><img itemprop="logo" class="logoproton" src="assets/img/logo-protonwebmaster.jpg" alt="logo"></a>  
            </div>         
          </div>
        </div>
      </div>
    </div>
    <div class="container py-4">
      <div class="copyright">
        &copy; Copyright <strong><span>Protonwebmaster 2020</span></strong>. Tous droits réservés.
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/bizland-bootstrap-business-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> - Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a>       
      </div>
    </div>
  </footer><!-- End Footer -->
         <!-- Magic SDK https://magic.link/-->
         <script src="https://cdn.jsdelivr.net/npm/magic-sdk/dist/magic.js"></script>
      <script>
      /* Initialize Magic Instance */
  const magic = new Magic("pk_test_485D2B9100C4911C");   
      /* Implement Render Function */
const render = async () => {
  const isLoggedIn = await magic.user.isLoggedIn();
  /* Show login form if user is not logged in */
  let html = `
    <h6>Créer un compte ou connectez-vous</h6>
    <form onsubmit="handleLogin(event)">
      <input type="email" name="email" required="required" placeholder="Entrer votre email" />
      <button type="submit">Envoyer</button>
    </form>
  `;
  if (isLoggedIn) {
    /* Get user metadata including email */
    const userMetadata = await magic.user.getMetadata();
    html = `
      <h6>Utilisateur courant: ${userMetadata.email}</h6>
      <p>Etat de la connexion : Connecté</p>
      <button onclick="handleLogout()">Déconnexion</button>
    `;
  }
  document.getElementById("app").innerHTML = html;
};
      /* Implement Login Handler */
const handleLogin = async e => {
  e.preventDefault();
  const email = new FormData(e.target).get("email");
  if (email) {
    /* One-liner login */
    await magic.auth.loginWithMagicLink({ email });
    render();
  }
};
      /* Implement Logout Handler */ 
const handleLogout = async () => {
  await magic.user.logout();
  render();
};
 </script>  
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>  
  <!-- Vendor JS Files -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets/vendor/counterup/counterup.min.js"></script>
  <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/venobox/venobox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>  
  <!-- Template Main JS File -->
  <script src="assets/js/main_min.js"></script>
  <script  src="assets/js/modal_min.js"></script>
  <script>
    function alphaOnly(event) {
        var key = event.keyCode;
        return ((key >= 65 && key <= 90) || key == 8);
    };
</script>
<!---Nombres seulement-->
<script>
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
<!-- scripts particlejs -->
<script src="assets/js/particles.min.js"></script>
<script src="assets/js/app_min.js"></script>
</body>
</html>