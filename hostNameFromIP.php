<?php include("./exit.php");?>
<!DOCTYPE html>
    <title>Trouvez le 'hostname' correspondant à une adresse IPv4</title>
    <meta charset="utf-8">
    <meta name="robots" content="noindex" />
    <link rel="icon" href="/Images/favicon.ico" />
    <style>
      /* La mise en page */
      body {
        display: flex;
        height: 650px;
      }
      #form { 
        display: flex;
        flex-direction: column; /* axe principal : vertical : 1 elt par ligne */
        align-items: flex-start;    /* On place tous les éléments le plus à droite sur leur ligne respective.  */
        background-color: #d0bcbc;
        border: 1px solid purple;
        margin: auto;
      }
      
      /* Le formulaire et ses champs */
      input:invalid 
      {
        border: 2px dashed red;
      }
      input:valid 
      {
        border: 1px solid black;
      }    
      .ip_by_default
      {
        font-size: small;
        margin-top: 0;
      }
      .erreur
      {
        color: red;
      }
      .valide
      {
        color: green;
      }
      .titre:nth-child(1) /* Par cette redéfinition, le 1° élément sera centré horizontalement sur sa ligne. */
      {
        align-self: center;
      }
              
      /* Redéfinition des liens */
      a:hover {
        text-decoration: underline;
      }       
      a:link {
        color: #000099;
        text-decoration: none;
      }
      p.src {
       font-size: small;
       margin-bottom: 0;
      }
    </style>
  </head>
  <body>
    <form id="form">
      <div class="titre">
        <label><b>Trouvez le 'hostname' correspondant à une adresse IPv4</b></label>
        <br>
        <br>
      </div>
      <div id="entete_ip">
        <label>Entrez une adresse ip :</label>
        <p class="ip_by_default">(par défaut, c'est celle du client de ce serveur)</p>
      </div>
      <div id="corps_ip">
        <input id="ip" name="ip_php" value="<?echo $_SERVER['REMOTE_ADDR'] ?>" pattern="([0-9][0-9][0-9]\.|[0-9][0-9]\.|[0-9]\.){3}([0-9][0-9][0-9]|[0-9][0-9]|[0-9]){1}" required>
        <button>Envoyez</button>
      </div>
      <div id="validation_ip_et_fin">
        <div id="retour" class="valide"></div>
        <br>
        <br>
        <a href="/FichiersTexte/hostNameFromIP.txt">
          <p class="src">source php de la page</p>
        </a>
      </div>  
    </form>
    <script>
      const retour = document.getElementById("retour");
      /**
      La validation des données se fait en deux étapes :
         a - grâce à l'expression régulière de la balise html <input> lors de la saisie des données (vérification de type),
         b - grâce à l'écouteur d'événement : vérification de valeur. Est-ce que les 4 chiffres sont compris entre 0 et 255 ?. 
       -> pour réaliser b, l'écouteur va se déclencher avec l'évènement "submit" de la balise html <form>.
      **/
      var form  = document.getElementsByTagName('form')[0];
   
      form.addEventListener("submit", function (event) {
        if(!validatedIP(document.getElementById("ip").value)) {
          retour.classList.replace("valide", "erreur");
          retour.innerHTML = "Ici, les 4 nombres constituant l'adresse ip doivent être entre 0 et 255.";
          event.preventDefault();
        } else {
          retour.classList.replace("erreur", "valide");
        }
        document.getElementById("ip").select();
        /** 
        Décommenter la ligne suivante pour n'exécuter que le code javascript
        event.preventDefault(); 
        **/
      });

      function validatedIP (ip) {
        // Au départ, toutes les adresses IP sont valides puis cela évolue au cours de la fonction.
        var ip_valide = true;
        //ip.split('.')[count] correspond à un élément du tableau de découpage de ip.
        for (count = 0; count < 4; count++) {
          if(ip.split('.')[count] < 0 || ip.split('.')[count] > 255) ip_valide = false;
        }
        return ip_valide;
      }
      <?php
        // A ce stade, grâce à l'expression régulière et à l'écouteur d'évènement, $ip_php a été validée.
        $phrase = "Le hostname de " . $ip_php . " est : ";
        $phrase .= gethostbyaddr($ip_php);
        echo ("retour.innerHTML = \"$phrase\";\n"); 
      php?>
    </script>
  </body>
</html>
