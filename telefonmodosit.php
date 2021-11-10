<?php


    require_once "db.php";
    require_once "telefonok.php";
    $telefonId = $_GET['id'] ?? null;

    if ($telefonId === null){
        header("Location:index.php");
        exit;
    }
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
    $telefon = Telefon::getById($telefonId);

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
            $gyarto = $_POST['gyarto'] ?? '';
            $modell = $_POST['modell'] ?? '';
            $tarhely = $_POST['tarhely'] ?? '';
            $memoria = $_POST['memoria'] ?? '';
            $kiadas = $_POST['datum'] ?? '';
            
            if($gyarto === ""){
                $gyarto_hiba = true;
                $message = "A gyártót meg kell adni!";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }else if(is_numeric($gyarto)){
                $gyarto_hiba = true;
                $message = "A gyártónak szövegnek kell lennie!";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            if($modell === ""){
                $modell_hiba = true;
                $message = "A modellt meg kell adni!";
                echo "<script type='text/javascript'>alert('$message');</script>";
            } else if(is_numeric($modell)){
                $modell_hiba = true;
                $message = "A modellnek szövegnek kell lennie!";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            if($tarhely === ""){
                $tarhely_hiba = true;
                $message = "Az tárhely méretét meg kell adni!";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }else if(!is_numeric($tarhely)){
                $tarhely_hiba = true;
                $message = "A tárhelynek számnak kell lennie!";
                echo "<script type='text/javascript'>alert('$message');</script>";
            } else if($tarhely <1){
                $tarhely_hiba = true;
                $message = "Az tárhely méretének nagyobbnak kell lennie mint 0!";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            
            if($memoria === ""){
                $memoria_hiba = true;
                $message = "Az memória méretét meg kell adni!";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }else if(!is_numeric($memoria)){
                $memoria_hiba = true;
                $message = "A memória méretének számnak kell lennie!";
                echo "<script type='text/javascript'>alert('$message');</script>";
            } else if($memoria <1){
                $memoria_hiba = true;
                $message = "A memória méretének nagyobbnak kell lennie mint 0!";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            
            if($gyarto_hiba || $modell_hiba || $tarhely_hiba || $memoria_hiba){
                $vanhibas = true;
            }else{
                
                $telefon->setgyarto($gyarto);
                $telefon->setmodell($modell);
                $telefon->settarhely($tarhely);
                $telefon->setmemoria($memoria);
                $telefon->setkiadas(new DateTime($kiadas));
            $telefon->update();
            header("Location:index.php");
            }
        }
    
?>
<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="main.js"></script>
    <title>Telefonok</title>
</head>
<body>
    <div class="container">
    <form method="POST" name="form" class="was-validated">
        <div class="row">
            <label for="nev">Gyártó:</label><br>
            <input type="text" id="nev" class=" form-control form-control-lg" name="gyarto" value="<?php echo $telefon->getgyarto() ?>" required>
            <div class="invalid-feedback">Töltsd ki a mezőt.</div>
        </div>
        <div class="row">
            <label for="kapacitas">Modell:</label><br>
            <input type="text" id="kapacitas" class="form-control form-control-lg" name="modell" value="<?php echo $telefon->getmodell()?>" required>
            <div class="invalid-feedback">Töltsd ki a mezőt.</div>
        </div>
        <div class="row">
            <label for="oSebesseg">Tárhely(Gb):</label><br>
            <input type="number" id="oSebesseg" class="form-control form-control-lg" name="tarhely" value="<?php echo $telefon->gettarhely()?>" required>
            <div class="invalid-feedback">Töltsd ki a mezőt.</div>
        </div>
        <div class="row">
            <label for="iSebesseg">Memória(Gb):</label><br>
            <input type="number" id="iSebesseg" class="form-control form-control-lg" name="memoria" value="<?php echo $telefon->getmemoria()?>" required>
            <div class="invalid-feedback">Töltsd ki a mezőt.</div>
        </div>
        <div class="row">
            <label for="kiadasDatuma">Kiadás dátuma:</label><br>
            <input type="date" name="kiadasDatuma" class="form-control form-control-lg" id="kiadas" value="<?php echo $telefon->getkiadas() ->format("Y-m-d")?>" required>
            <div class="invalid-feedback">Töltsd ki a mezőt.</div>
        </div>
        <div class="row">
            <input type="submit" class="btn btn-light text-dark form-control form-control-lg" name="frissit" value="Módosítás">
        </div>
    </form>
    </div>
    <script src="main.js"></script>
</body>
</html>