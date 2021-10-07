<?php
// index.php

$error = '';
$city = '';
$date = '';
$time = '';
$mrn = '';
$decision = '';
$dispatcher = '';


function clean_text($string)
{
 $string = trim($string);
 $string = stripslashes($string);
 $string = htmlspecialchars($string);
 return $string;
}

if(isset($_POST["submit"]))
{
    // Jeśli nie wybrano miasta
    if(!empty($_POST["Miasto"]))
    {
     $selected = $_POST['Miasto'];
      $city = "$selected";
    }
    else
    {
      $error .= '<p><label class="text-danger">Nie wybrałeś/aś miasta</label></p>';
    }

 // Jeśli nie wybrano daty
 if(empty($_POST["date"]))
 {
  $error .= '<p><label class="text-danger">Nie wprowadziłeś/aś daty</label></p>';
 }
 else
 {
  $date = clean_text($_POST["date"]);
 }

 // Jeśli nie wpisano godziny
 if(empty($_POST["time"]))
 {
  $error .= '<p><label class="text-danger">Nie wprowadziłeś/aś godziny</label></p>';
 }
 else
 {
  $time = clean_text($_POST["time"]);
 }
//  Sprawdź czy wprowadzono MRN
 if(empty($_POST["mrn"]))
 {
  $error .= '<p><label class="text-danger">MRN jest wymagany</label></p>';
 }
 else
 {
  $mrn = clean_text($_POST["mrn"]);
 }

 // Jeśli nie wybrano decyzji
 if(!empty($_POST["Decyzja"]))
 {
  $selected = $_POST['Decyzja'];
   $decision = "$selected";
 }
 else
 {
  $error .= '<p><label class="text-danger">Nie wybrałeś/aś decyzji</label></p>';
 }

 // Jeśli nie wybrano dyspozytora
 if(!empty($_POST["Dyspozytor"]))
 {
  $selected = $_POST['Dyspozytor'];
   $dispatcher = "$selected";
 }
 else
 {
  $error .= '<p><label class="text-danger">Nie wybrałeś/aś dyspozytora</label></p>';
 }


 if($error == '')
 {
  $file_open = fopen("contact_data.csv", "a");
  $no_rows = count(file("contact_data.csv"));
  if($no_rows > 1)
  {
   $no_rows = ($no_rows - 1) + 1;
  }
  $form_data = array(
   'sr_no'  => $no_rows,
   'city'  => $city,
   'date'  => $date,
   'time' => $time,
   'mrn' => $mrn,
   'decision' => $decision,
   'dispatcher' => $dispatcher
  );
  fputcsv($file_open, $form_data);
  $error = '<label class="text-success">Zgłoszenie zapisane</label>';
  $city = '';
  $date = '';
  $time = '';
  $mrn = '';
  $decision = '';
  $dispatcher = '';
 }
}

?>
<!DOCTYPE html>
<html lang="pl">
 <head>
  <meta charset="utf-8">
  <link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
  <title>Raport dyspozytora</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
 <style>
    body {
      background-image: url('background.png');
      background-repeat: no-repeat;
      background-size: cover;     
      max-height: 100vh;
}
</style>

  <br />
  <div class="container">
   <div class="col-md-6" style="margin:0 auto; float:none;">

    <form method="post">
     <h3 style="text-align: center; color: #00539f; font-weight: bold; margin-top: 20%; padding: 10%;">RAPORT DYSPOZYTORA</h3>
     <br />

     <?php echo $error; ?>

    <!-- City -->
     <div class="form-group">
      <label>Miasto</label>
      <br>
      <select name="Miasto" class="form-control" type="text">
        <option value="" disabled selected>Wybierz miasto</option>
        <option value="Białystok">Białystok</option>
        <option value="Bielsko-B">Bielsko-B</option>
        <option value="Bydgoszcz">Bydgoszcz</option>
        <option value="Kielce">Kielce</option>
        <option value="Kraków">Kraków</option>
        <option value="Łódź">Łódź</option>
        <option value="Lublin">Lublin</option>
        <option value="Poznań">Poznań</option>
        <option value="Szczecin">Szczecin</option>
        <option value="Śląsk">Śląsk</option>
        <option value="Trójmiasto">Trójmiasto</option>
        <option value="Wrocław">Wrocław</option>
        <option value="Pozostałe">Pozostałe</option>
      </select>
     </div>


    <!-- Date -->
     <div class="form-group">
      <label>Data</label>
      <input type="date" name="date" class="form-control" min="1890-01-01" max="2200-12-31" placeholder="Wybierz datę" value="<?php echo $date; ?>" />
     </div>

    <!-- Time -->
     <div class="form-group">
      <label>Godzina</label>
      <input type="time" name="time" class="form-control" placeholder="Wprowadź godzinę" value="<?php echo $time; ?>" />
     </div>

    <!-- MRN -->
     <div class="form-group">
      <label>MRN</label>
      <input type="number" name="mrn" class="form-control" placeholder="Wprowadź MRN" value="<?php echo $mrn; ?>" />
     </div>


    <!-- Decision -->
    <div class="form-group">
      <label>Decyzja</label>
      <br>
      <select name="Decyzja" class="form-control" type="text" value="<?php echo $decision; ?>"> 
        <option value="" disabled selected>Wybierz decyzję</option>
        <option>999</option>
        <option>CM- porada telefoniczna</option>
        <option>CM (internista)</option>
        <option>CM (pediatra)</option>
        <option>CM (chirurg, dziecko)</option>
        <option>CM (chirurg, dorosły)</option>
        <option>CM (ortopeda, dziecko)</option>
        <option>CM (ortopeda, dorosły)</option>
        <option>CM (okulista, dziecko)</option>
        <option>CM (okulista, dorosły)</option>
        <option>CM (ginekolog, dorosły)</option>
        <option>CM (ginekolog, dziecko)</option>
        <option>CM (neurolog, dorosły)</option>
        <option>CM (neurolog, dziecko)</option>
        <option>CM (laryngolog, dorosły)</option>
        <option>CM (laryngolog, dziecko)</option>
        <option>TPM</option>
        <option>KD</option>
        <option>NPL (internista)</option>
        <option>NPL (pediatra)</option>
        <option>SP (internista)</option>
        <option>SP (pediatra)</option>
        <option>SP (chirurg, dziecko)</option>
        <option>SP (chirurg, dorosły)</option>
        <option>SP (ortopeda, dziecko)</option>
        <option>SP (ortopeda, dorosły)</option>
        <option>SP (okulista, dziecko)</option>
        <option>SP (okulista, dorosły)</option>
        <option>SP (ginekolog, dorosły)</option>
        <option>SP (ginekolog, dziecko)</option>
        <option>SP (neurolog, dorosły)</option>
        <option>SP (neurolog, dziecko)</option>
        <option>SP (laryngolog, dorosły)</option>
        <option>SP (laryngolog, dziecko)</option>
        <option>CM MAIL (internista)</option>
        <option>CM MAIL (pediatra)</option>
        <option>CM MAIL (chirurg, dziecko)</option>
        <option>CM MAIL (chirurg, dorosły)</option>
        <option>CM MAIL (ortopeda, dziecko)</option>
        <option>CM MAIL (ortopeda, dorosły)</option>
        <option>CM MAIL (okulista, dziecko)</option>
        <option>CM MAIL (okulista, dorosły)</option>
        <option>CM MAIL (ginekolog, dorosły)</option>
        <option>CM MAIL (ginekolog, dziecko)</option>
        <option>CM MAIL (neurolog, dorosły)</option>
        <option>CM MAIL (neurolog, dziecko)</option>
        <option>CM MAIL (laryngolog, dorosły)</option>
        <option>CM MAIL (laryngolog, dziecko)</option>
        <option>CC FORM (internista)</option>
        <option>CC FORM (pediatra)</option>
        <option>CC FORM (chirurg, dziecko)</option>
        <option>CC FORM (chirurg, dorosły)</option>
        <option>CC FORM (ortopeda, dziecko)</option>
        <option>CC FORM (ortopeda, dorosły)</option>
        <option>CC FORM (okulista, dziecko)</option>
        <option>CC FORM (okulista, dorosły)</option>
        <option>CC FORM (ginekolog, dorosły)</option>
        <option>CC FORM (ginekolog, dziecko)</option>
        <option>CC FORM (neurolog, dorosły)</option>
        <option>CC FORM (neurolog, dziecko)</option>
        <option>CC FORM (laryngolog, dorosły)</option>
        <option>CC FORM (laryngolog, dziecko)</option>
        <option>CC</option>
        <option>NET</option>
        <option>HL WAWA</option>
        <option>Pogotowie stomatologiczne</option>
      </select>
     </div>


    <!-- Dispatcher name -->
     <div class="form-group">
      <label>Dyspozytor</label>
      <br>
      <select name="Dyspozytor" class="form-control" type="text">
        <option value="" disabled selected>Wybierz dyspozytora</option>
        <option>Dispatcher1</option>
        <option>Dispatcher2</option>
        <option>Dispatcher3</option>
        <option>Dispatcher4</option>
        <option>Dispatcher5</option>
        <option>Dispatcher6</option>
        <option>Dispatcher7</option>
        <option>Dispatcher8</option>
      </select>
     </div>



     <div class="form-group" align="center">
      <input style="font-weight: bold; line-height: inherit; background: #00539f; border: none; letter-spacing: 1px" type="submit" name="submit" class="btn btn-info" value="Zapisz" />
     </div>
    </form>
   </div>

  </div>
 </body>
</html>
