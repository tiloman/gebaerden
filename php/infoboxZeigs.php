<?php

if ($userSerial != 0) {
   $sql = "SELECT * FROM license WHERE serial = $userSerial";
   foreach ($pdo->query($sql) as $row) {
     $licensedSerial = $row['serial'];
     $licensedTo = $row['licensedto'];
    }
  }

  if (isset($licensedSerial)) {
  if ($userSerial == $licensedSerial) {
    echo "<h3><i class='fas fa-american-sign-language-interpreting'></i> Zeigs mir mit Gebärden</h3>";
    echo ("Die Seriennummer ist lizensiert für: <br>");
    echo ("<b>".$licensedTo."</b>");
  }
  }else {
  echo ("
        <h3><i class='fas fa-american-sign-language-interpreting'></i> Zeigs mir mit Gebärden</h3>
            <p class='left'>
              Wenn Sie eine Einzellizenz für Zeigs mir mit Gebärden besitzen, können Sie die Lizenz hier freischalten. Wenn Ihre Schule bereits hier registriert ist, informieren Sie sich über eine evtl. bestehende Schullizenz.
            </p>
          <br>
            <form id='addSchool' action='php/addSerial.php' method='post'>
              <input type='text' name='userLicense' class='custom_input' placeholder='Seriennummer' required></input>
              <br>
              <input type='submit' class='custom_button' value='Freischalten'></input>
            </form>");

         if($_GET['error'] == 1){
          echo "<div class='notification'>Die eingegebene Seriennummer ist leider falsch.</div>";
        }
  }







?>
