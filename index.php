<?php
$pageRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) &&($_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0' ||  $_SERVER['HTTP_CACHE_CONTROL'] == 'no-cache'); 
require_once 'db.php';
require_once 'telefonok.php';
$gyarto_hiba = false;
$modell_hiba = false;
$tarhely_hiba = false;
$memoria_hiba = false;
$kiadas_hiba=false;
$vanhibas=false;

$gyarto_error = "";
$modell_error = "";
$tarhely_error = "";
$memoria_error = "";
$kiadas_error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $deleteId = $_POST['deleteId'] ?? '';
    if($deleteId !== ''){
        Telefon::torol($deleteId);
    }else if(isset($_POST['felvesz'])) {
        $gyarto = $_POST['gyarto'] ?? '';
        $modell = $_POST['modell'] ?? '';
        $tarhely = $_POST['tarhely'] ?? '';
        $memoria = $_POST['memoria'] ?? '';
        $kiadas = $_POST['datum'] ?? '';
        
        if($gyarto === ""){
            $gyarto_hiba = true;
            $gyarto_error = "A gyártót meg kell adni!";
        }else if(is_numeric($gyarto)){
            $gyarto_hiba = true;
            $gyarto_error = "A gyártónak szövegnek kell lennie!";
        }
        if($modell === ""){
            $modell_hiba = true;
            $modell_error="A modellt meg kell adni!";
        } else if(is_numeric($modell)){
            $modell_hiba = true;
            $modell_error = "A modellnek szövegnek kell lennie!";
        }
        if($tarhely === ""){
            $tarhely_hiba = true;
            $tarhely_error="Az tárhely méretét meg kell adni!";
        }else if(!is_numeric($tarhely)){
            $tarhely_hiba = true;
            $tarhely_error = "A tárhelynek számnak kell lennie!";
        } else if($tarhely <1){
            $tarhely_hiba = true;
            $tarhely_error = "Az tárhely méretének nagyobbnak kell lennie mint 0!";
        }
        
        if($memoria === ""){
            $memoria_hiba = true;
            $memoria_error="Az memória méretét meg kell adni!";
        }else if(!is_numeric($memoria)){
            $memoria_hiba = true;
            $memoria_error = "A memória méretének számnak kell lennie!";
        } else if($memoria <1){
            $memoria_hiba = true;
            $memoria_error = "A memória méretének nagyobbnak kell lennie mint 0!";
        }
        if($kiadas === ""){
            $kiadas_hiba = true;
            $kiadas_error="A kiadási dátumot meg kell adni!";
        }
        if($gyarto_hiba || $modell_hiba || $tarhely_hiba || $memoria_hiba || $kiadas_hiba){
            $vanhibas = true;
        }else if(!$vanhibas){
            $telefon = new Telefon($gyarto, $modell, $tarhely, $memoria, new DateTime($kiadas));
            $telefon->uj();
        }
    }
}


$telefonok = Telefon::osszes();


?><!DOCTYPE html>
<html>
    <head lang="hu">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <title>Telefonok</title>
        <script src="main.js"></script>
    </head>
    <body>
<div class="container">
    <form method="POST"  name="form" class="was-validated" onsubmit=validateForm()>

      <label for="nev">Gyártó:</label>
      <input type="text" class="form-control" id="gyarto" name="gyarto"  required>
      <div class="invalid-feedback">Töltsd ki a mezőt.</div>
      <?php if($gyarto_hiba){echo($gyarto_error."<br>");}?>


      <label for="modell">Modell:</label>
      <input type="text" class="form-control" id="modell" name="modell"   required>
      <div class="invalid-feedback">Töltsd ki a mezőt.</div>
      <?php if($modell_hiba){echo($modell_error."<br>");}?>


      <label for="tarhely">Tárhely mérete(Gb):</label>
      <input type="number" class="form-control" id="tarhely" name="tarhely" required>
      <div class="invalid-feedback">Töltsd ki a mezőt.</div>
      <?php if($tarhely_hiba){echo($tarhely_error."<br>");}?>


      <label for="memoria">Memória mérete(Gb):</label>
      <input type="number" class="form-control" id="memoria" name="memoria"   required>
      <div class="invalid-feedback">Töltsd ki a mezőt.</div>
      <?php if($memoria_hiba){echo($memoria_error."<br>");}?>


      <label for="datum">Kiadás dátuma::</label>
      <input type="date" class="form-control" id="datum" name="datum"  required>
      <div class="invalid-feedback">Töltsd ki a mezőt.</div>
      <?php if($kiadas_hiba){echo($kiadas_error."<br>");}?>

      <button type="submit" class="btn btn-primary" name="felvesz">Felvétel</button>
  </form>
</div>


<?php
    echo "<div class='container'>";
    echo "<div class='row'>";
    
        foreach ($telefonok as $telefon) {
            echo "<div class='col-4'>";
            echo "<div class='card'>";
            echo "<div class='card-header'>Nev: ".$telefon->getgyarto()." ".$telefon->getmodell()."</div>";
            echo "<div class='card-body'>";
            echo "<p>Tárhely mérete: ".$telefon->gettarhely()." gb</p>";
            echo "<p>Memória mérete: ".$telefon->getmemoria()." gb</p>";
            echo "<p>Kiadás dátuma: ".$telefon->getkiadas()->format("Y-m-d")."</p>";
            echo "</div>";
            echo "<div class='footer bg-secondary'>";
            echo "<form method='POST'>";
            echo "<input type='hidden'  name='deleteId' value='" . $telefon->getId() . "'>";
            echo "<button type='submit' class='btn btn-dark'> Törlés</button>";
            echo "</form>";
            echo "<a class='btn btn-dark' href='telefonmodosit.php?id=". $telefon->getId() . "'>Szerkesztés</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    ?>
    </div>    
    </body>
</html>