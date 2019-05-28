

<nav class="navbar navbar-expand-lg fixed-top navbar-light navbar-custom">
  <a class="navbar-brand" href="index.php">
      <img src="img/gebaerden_icon_g.png" width="35" height="35" style="border-radius: 3px;"alt="">
    </a>

    <?php if ($serial !=0 or $userSchoolID !=0) { ?>
          <form class="input-group-custom" action="index.php" method="get">
                <div class="input-group sm-3" ><input id="searchBar" type="text" class="form-control" placeholder="Suche ..." name="searchInput" value="<?php if(isset($_GET['searchInput'])) {$searchInput = $_GET['searchInput']; echo $searchInput;} ?>">
                  <div class="input-group-append">
                    <button class="btn btn-success" type="submit"><i class="fas fa-search" title='Suche'></i></button>
                  </div>
                </div>
          </form>
    <?php  } ?>



    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fas fa-bars navbar_sandwich"></i>
    </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <ul class="navbar-nav ml-auto" >
      <?php if ($serial !=0 or $userSchoolID !=0) { ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-american-sign-language-interpreting"></i> Mediathek
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php
          if ($serial != 0) {
            echo "<a class='dropdown-item' href='index.php'>Zeigs mir mit Gebärden</a>";
          }
          ?>


          <?php
          $sql = "SELECT * FROM school WHERE school_id = $userSchoolID";
          foreach ($pdo->query($sql) as $row) {
            $schoolID = $row['school_id'];
            $schoolName = $row['school_name'];
          }
          if (isset($schoolName)) {
            if ($userSchoolID == $schoolID) {
              echo "

              <a class='dropdown-item' href='/gebaerden/custom_libraryID.php'>".$schoolName."</a>";
            }
          }
           ?>


        </div>
      </li>
    <?php  } ?>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-cog"></i> Einstellungen
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class='dropdown-item' href='/gebaerden/profile.php'>Profil</a>
          <a class='dropdown-item' href='/gebaerden/pdfSettings.php'>PDF Einstellungen</a>


          <?php
          $sql = "SELECT * FROM school WHERE school_id = $userSchoolID";
          foreach ($pdo->query($sql) as $row) {
            $schoolID = $row['school_id'];
            $schoolName = $row['school_name'];
          }
          if (isset($schoolName)) {
            if ($userSchoolID == $schoolID) {
              echo "
              <a class='dropdown-item' href='/gebaerden/manageContent.php'>Gebärden verwalten</a>";

            }
          }

          if ($_SESSION['teamAdmin'] == "Ja") {
              echo "
              <a class='dropdown-item' href='/gebaerden/manageTeam.php'>Team verwalten</a>";
          };
          ?>


        </div>
      </li>


      <li class="nav-item">
        <a class="nav-link" href="/gebaerden/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a
      </li>


    </ul>

    <div>

  </div>
</nav>
