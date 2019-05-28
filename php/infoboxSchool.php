<?php


$sql = "SELECT * FROM school WHERE school_id = $userSchoolID";
foreach ($pdo->query($sql) as $row) {
  $schoolID = $row['school_id'];
  $schoolName = $row['school_name'];
}

echo ("<h3><i class='fas fa-school'></i> Meine Schule</h3>");

//Schule ist eingetragen; Schulinfo und abmelde Button erscheint
if (isset($schoolName)) {
  echo "Eingetragene Schule: <br><b>".$schoolName."</b>";
  ?>
  <form action='php/quitSchool.php'>
    <button type='submit' class='custom_button red' onclick="return confirm('Sind Sie sicher?')"><i class='fas fa-sign-out-alt'></i> Schule verlassen</button>
  </form>
<?php
}


//Falls keine Schule angemeldet ist.
if (!isset($schoolName)) {
  $sql = "SELECT * FROM user WHERE id = $userid";
  foreach ($pdo->query($sql) as $row) {
    $requestedSchool = $row['grantedAccess'];
  }


if ($requestedSchool != 0){
  echo ("
      <p class='left'>
        Ihre Anfrage wird nun von einem Team-Administrator Ihrer Schule bearbeitet. Sie erhalten eine Mail, sobald Sie freigegeben wurden.
      </p>");
} else {

  echo ("
      <p class='left'>
        Sie sind bei keiner Schule angemeldet.
        Wenn Ihre Schule bereits einen Zugang hat, wählen Sie sie bitte hier aus.
      </p>
    <br>
      <form id='addSchool' action='php/addSchool.php' method='post'>

      <select name='schoolId' class='custom_input browser-default custom-select' required>;
      <optgroup label='Eingetragene Schulen'>

    ");


        $sql = "SELECT * FROM school ORDER BY school_name";
        foreach ($pdo->query($sql) as $row) {
          $schoolLicense = $row['zeigsmirmitgebaerden'];
          if ($schoolLicense != 0){
            echo "<option value='".$row['school_id']."'>";
            echo $row['school_name']." (Schullizenz)";
            echo "</option>";
          } else {
            echo "<option value='".$row['school_id']."'>";
            echo $row['school_name'];
            echo "</option>";

          }
        }


      echo "
      </optgroup>
      <optgroup label='Neu'>
        <option value='new' selected>Neue Schule anmelden</option>
      </optgroup>
      </select>
        <br>
        <input type='submit' class='custom_button' value='Anfrage stellen'></input>
      </form>";

    if(isset($_SESSION['schoolError'])) {echo ($_SESSION['schoolError']);}

    echo ("
    <p class='left'>
      Mit einem Zugang für Ihre Schule können Sie individuelle Gebärden selbstständig hochladen und diese mit Ihren Kolleg*innen teilen.<br>
      Falls Ihre Schule eine Lizenz für <i>Zeigs mir mit Gebärden</i> hat, wird Ihnen der Zugang zu der Mediathek automatisch mit freigeschaltet.<br>

    </p>

</div>

  ");
}
};





?>
