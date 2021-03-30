<?php
define("PAGE_TITLE", "Traitement");
require("inc/inc.kickstart.php");
?>

<main class="pays-creer">
  <?php
  //Ajout d'un check pour vérifier si le form a été envoyé
  if(isset($_POST['submitBtn'])) {
    //TRY / CATCH
    try {
      //Requête préparée
      $requete = "INSERT INTO `country` (`country_name`, `country_flag`, `country_capital`, `country_area`)
                  VALUES (:country_name, :country_flag, :country_capital, :country_area)";
      $prepare = $pdo->prepare($requete);
      $prepare->execute(array(
        ':country_name' => $_POST["country_name"],
        ':country_flag' => $_POST["country_flag"],
        ':country_capital' => $_POST["country_capital"],
        ':country_area' => $_POST["country_area"]
      ));
      $res = $prepare->rowCount();

      if ($res == 1) {
        echo "<h3>Merci !</h3>";
        echo "<p>Voici un récapitulatif de votre contribution :</p>";
        //Ajout de htmlentities
        echo "<ul>"
          . "<li>Nom du pays : " . htmlentities($_POST["country_name"], ENT_QUOTES) . "</li>"
          . "<li>Capitale du pays : " . htmlentities($_POST["country_capital"], ENT_QUOTES) . "</li>"
          . "<li>Drapeau du pays : " . htmlentities($_POST["country_flag"], ENT_QUOTES) . "</li>"
          . "<li>Superficie du pays (en km²) : " . htmlentities($_POST["country_area"], ENT_QUOTES) . "</li>"
          . "<ul>";
        echo "<a href='page-pays-liste-alpha.php'><button>Consulter la liste des pays</button></a>";
      }
    } catch (PDOException $e) {
      exit("❌🙀❌ OOPS :\n" . $e->getMessage());
    }
  } else {
    //header au cas où la condition est pas respectée
    header('Location: page-pays-creer.php');
  }
  ?>
</main>

<?php require("inc/inc.footer.php"); ?>