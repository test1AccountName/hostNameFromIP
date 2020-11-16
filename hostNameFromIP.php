﻿<?php include("./exit.php"); ?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex" />
    <link href="style.css" rel="stylesheet" media="all" type="text/css">
    <link rel="icon" href="/Images/favicon.ico" />
    <style>
      input:invalid 
      {
        border: 2px dashed red;
      }

      input:valid 
      {
        border: 1px solid black;
      }

      p.ip_by_default
      {
        font-size: small;
      }
    </style>
  </head>
  <body>
    <form name="form">
      <label><b>Trouvez le 'hostname' correspondant à une adresse IPv4</b></label>
      <br>
      <br>
      <label>Entrez une adresse ip :
        <p class=ip_by_default>(par défaut, c'est celle du client de ce serveur)</p>
      </label>
      <input name="ip" value="<?echo $_SERVER['REMOTE_ADDR'] ?>" pattern="([0-9][0-9][0-9]\.|[0-9][0-9]\.|[0-9]\.){3}([0-9][0-9][0-9]|[0-9][0-9]|[0-9]){1}" required>
      <button>Envoyez</button>
      <br>
      <br>
      <a href="/FichiersTexte/hostNameFromIP.txt">
        <p class=src>source php de la page</p>
      </a>
    </form>
    <script>
    // Après une sélection grâce à l'expression régulière, il reste à vérifier que l'adresse ip est bien composée de 4 chiffres entre 0 et 255. 
    // -> pour réaliser cela, utilisation d'un "écouteur" de l'évènement "submit" sur la balise <form>.

    var form  = document.getElementsByTagName('form')[0];
   
    form.addEventListener("submit", function () {
      if(!validateNumber(document.form.ip.value)) {
        document.form.ip.value='';
        window.alert ("Ici, les 4 chiffres doivent être entre 0 et 255.");
      }
    });

    function validateNumber (ip) {
      var ip_valide = true;
      var count;
      for (count = 0; count < 4; count++) {
        if(ip.split('.')[count] < 0 || ip.split('.')[count] > 255) ip_valide = false;
      }
      return ip_valide;
    }
    <?php
     // Si on est passé par le formulaire, alors la variable '$ip' a été définie (isset($ip) renvoie true).
     if (isset($ip)) {
       // A ce stade, grâce à l'expression régulière et à l'écouteur d'évènement, $ip est forcément une adresse ip bien formée.
       $phrase = "Le hostname de " . $ip . " est : ";
       $phrase .= gethostbyaddr($ip) . "\\nselon gethostbyaddr() de PHP Version " . phpversion();
       echo ("window.alert(\"$phrase\")"); 
       // Le contenu de la variable '$phrase' (contenant entre autre le hostname de l'adresse ip du formulaire) est fourni en
       //paramètre à la fonction JavaScript window.alert().  
     }
    php?> 
    document.form.ip.select();
    </script>
  </body>
</html>
