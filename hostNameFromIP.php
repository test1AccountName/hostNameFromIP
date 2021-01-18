﻿﻿﻿<?php include("./exit.php"); ?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex" />
    <link href="style.css" rel="stylesheet" media="all" type="text/css">
    <link rel="icon" href="/Images/favicon.ico" />
    <style>
      body {
        display: flex;
        height: 650px;
      }
      
      #form { 
        background-color: #d0bcbc;
        border: 1px solid purple;
        margin: auto;
      }
      
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
    <div id="form">
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
    </div>
  <script>
    /* 
    La validation des données se fait en deux étapes :
       a - grâce à l'expression régulière de la balise html <input> lors de la saisie des données (vérification de type),
       b - grâce à l'écouteur d'événement : vérification de valeur. Est-ce que les 4 chiffres sont compris entre 0 et 255 ?. 
     -> pour réaliser b, l'écouteur va se déclencher avec l'évènement "submit" de la balise html <form>.
    */
    var form  = document.getElementsByTagName('form')[0];
   
    form.addEventListener("submit", function (event) {
      if(!validatedIP(document.form.ip.value)) {
        event.preventDefault();
        /*document.form.ip.value='';*/
        window.alert ("Ici, les 4 chiffres doivent être entre 0 et 255.");
      }
    });

    function validatedIP (ip) {
      // Au départ, toutes les adresses IP sont valides.
      var ip_valide = true;
      
      //On effectue notre test sur les 3 parties numériques (à chaque '.') de l'adresse IP.
      var count;
      
      //Si pour chaque partie numérique, 0 < partie numérique ou partie numérique > 255, alors cette adresse IP n'est pas valide. 
      // ip.split('.')[count] correspond à un élément du tableau de découpage de ip.
      for (count = 0; count < 4; count++) {
        if(ip.split('.')[count] < 0 || ip.split('.')[count] > 255) ip_valide = false;
      }
      
      //Le retour sera par défaut la valeur de 'ip_valide' à moins que cette valeur soit modifiée par la boucle for.
      return ip_valide;
    }
    <?php
     // Si on est passé par le formulaire, alors la variable '$ip' a été définie (isset($ip) renvoie true).
     if (isset($ip)) {
       // A ce stade, grâce à l'expression régulière et à l'écouteur d'évènement, $ip est forcément une adresse ip bien formée.
       $phrase = "Le hostname de " . $ip . " est : ";
       $phrase .= gethostbyaddr($ip) . "\\nselon la fonction gethostbyaddr() de PHP Version " . phpversion();
       echo ("window.alert(\"$phrase\")"); 
       // Le contenu de la variable '$phrase' (contenant entre autre le hostname de l'adresse ip du formulaire) est fourni en
       //paramètre à la fonction JavaScript window.alert().  
     }
    php?> 
    document.form.ip.select();
    </script>
  </body>
</html>