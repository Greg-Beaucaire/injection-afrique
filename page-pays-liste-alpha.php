<?php
  define("PAGE_TITLE", "Liste alphabétique des pays d'Afrique");
  require("inc/inc.kickstart.php");
  $coll = collator_create( 'fr_FR' );
?>

<main class="pays-liste">
<?php
  
  $tableau = [];
  $requete = "SELECT * FROM `country`";
  try {
    $etape = $pdo->prepare($requete);
    $etape->execute();
    $nbreResultat = $etape->rowCount();
    if($nbreResultat) {
      $tableau = $etape->fetchAll();
      // Fonction pour trier l'array, https://stackoverflow.com/questions/38171550/trying-to-sort-a-multidimensional-array-by-a-sub-value-with-special-characters
      usort($tableau, function($a, $b) {
        $collator = collator_create('fr');
        $arr = array($a['country_name'], $b['country_name']);
        collator_asort($collator, $arr, Collator::SORT_STRING);
        return array_pop($arr) == $a['country_name'];
      });
    } else {
      echo "<pre>✖️ La requête SQL ne retourne aucun résultat</pre>";
    }
  } catch (PDOException $e) {
    echo "<pre>✖️ Erreur liée à la requête SQL :\n" . $e->getMessage() . "</pre>";
  }

  foreach ($tableau as $pays) {
    echo "<section>";
    //Ajout de htmlentities
    echo "<h1>" . htmlentities($pays["country_name"], ENT_QUOTES) . "</h1>";
    //Ajout de htmlentities
    echo "<h2>" . htmlentities($pays["country_flag"], ENT_QUOTES) . "</h2>";
    echo "<div>" . number_format($pays["country_area"], 0, ',', ' ') . " km²</div>";
    //Ajout de htmlentities
    echo "<div>" . htmlentities($pays["country_capital"], ENT_QUOTES) . "</div>";
    echo "</section>";
  }

?>
</main>

<?php require("inc/inc.footer.php"); ?>