var coll = document.getElementsByClassName("collapsible-header");
var view_img = document.getElementsByClassName("collapsible_body");
var viewmetacom = true;
var viewVideos = true;


for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    var array_nmbr = this;
    //closeAllActiveHeaders(array_nmbr); //schließt alle anderen Aktiven Header.
    this.classList.toggle("active");


//Gebärden Fotos
    array_nmbr.nextElementSibling.innerHTML += "<div class='collapsible_body_content'><img class='img_gebaerden' src='/gebaerden/files/"+this.innerHTML+".png'></div>";

if (viewVideos == true) {
//Gebärden Video, prüfen ob es das gibt und wenn ja posten
    if (doesFileExist('files/video/'+this.innerHTML+'_video.m4v') == true) {
    array_nmbr.nextElementSibling.innerHTML += "<div class='collapsible_body_content'><video class='video_gebaerden' controls preload='metadata'><source src='files/video/"+this.innerHTML+"_video.m4v#t=0.1' type='video/mp4'>Your browser does not support the video tag.</video></div>";
    }
  }
if (viewmetacom == true) {
  //Kleinschreibung des ersten Buchstabens des Strings für Metacom Symbole
  //und prüfen ob die Datei exisitert
      var array_nmbr_lc = array_nmbr.innerHTML.substring(0,1).toLowerCase() + array_nmbr.innerHTML.substring(1).toLowerCase();
      if (doesFileExist('/gebaerden/files/metacom/'+array_nmbr_lc+'.png') == true) {
        array_nmbr.nextElementSibling.innerHTML += "<div class='collapsible_body_content'><img class='img_metacom' src='/gebaerden/files/metacom/"+array_nmbr_lc+".png'></div>";
      }

  //Großschreibung des ersten Buchstabens des Strings für Metacom Symbole und
  //Prüfen, ob die Datei in Großschreibung existiert und wenn ja, dann schreiben

      var array_nmbr_uc = array_nmbr.innerHTML.substring(0,1).toUpperCase() + array_nmbr.innerHTML.substring(1).toLowerCase();
      if (doesFileExist('/gebaerden/files/metacom/'+array_nmbr_uc+'.png') == true) {
        array_nmbr.nextElementSibling.innerHTML += "<div class='collapsible_body_content'><img class='img_metacom' src='/gebaerden/files/metacom/"+array_nmbr_uc+".png'></div>";
      }
}

//show pdf export symbol
if (this.classList.value == "collapsible-header active"){

array_nmbr.innerHTML = array_nmbr.innerHTML + "<a class='a_white' target='_blank' href='html2pdf.php?" +this.innerHTML + "' method='post'><i class='far fa-file-pdf' style='float:right'></i></a>";



  }else {
    array_nmbr.innerHTML = array_nmbr.innerText;
  }


//Ein- und ausklappen von collabsible body
    var collapsible_body = this.nextElementSibling;
    var collapsible_body_content = this.nextElementSibling.children;


    if (collapsible_body.style.maxHeight){
      collapsible_body.style.maxHeight = null;
      collapsible_body_content[0].style.opacity = null;
      collapsible_body_content[1].style.opacity = null;
      collapsible_body_content[2].style.opacity = null;

    } else {
      collapsible_body.style.maxHeight = "1000px";//"100%";collapsible_body.scrollHeight + "px";
      //collapsible_body_content.style.maxHeight = collapsible_body_content.scrollHeight + "px"; //90%"90%";
      collapsible_body_content[0].style.opacity = "1"
      collapsible_body_content[1].style.opacity = "1"
      collapsible_body_content[2].style.opacity = "1"

    }

  });
}



//Pfürung ob es die Datei gibt
function doesFileExist(urlToFile) {
    var img = new XMLHttpRequest();
    img.open('HEAD', urlToFile, false);
    img.send();

    if (img.status == "404") {
        return false;
    } else {
        return true;
    }
}

//Beim Focus der Suche soll nach oben gescrollt werden und alle aktive Header geschlossen werden
var searchBar = document.getElementById('searchBar');
searchBar.addEventListener("focus", closeAllActiveHeaders);
searchBar.addEventListener("focus", scrollToTopOnFocus);


function scrollToTopOnFocus() {
  document.body.scrollTop = document.documentElement.scrollTop = 0;
  }

function closeAllActiveHeaders(array_nmbr) {
  for (y= 0; y < coll.length; y++){
    view_img[y].style.maxHeight = null;
    coll[y].classList.remove("active");
    }
}

//Suche mit JQuery
  $(document).ready(function(){
    $("#searchBar").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#wordsList li").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });




//Metacom Symbole ausblenden und einblenden
function hideMetacom(){
  if (viewmetacom === true) {
  viewmetacom = false;
  document.getElementById("viewMetacom").innerHTML = "<i class='far fa-image' title='Metacom Bilder ausgeblendet'></i> ";
    document.getElementById("viewMetacom").style.opacity = "0.5";

} else {
  viewmetacom = true;
  document.getElementById("viewMetacom").innerHTML = "<i class='fas fa-image' title='Metacom Bilder eingeblendet'></i> ";
    document.getElementById("viewMetacom").style.opacity = "1";
  }
}



//Videos ausblenden
function hideVideos(){
  if (viewVideos === true) {
  viewVideos = false;
  document.getElementById("viewVideos").innerHTML = "<i class='fas fa-video' title='Videos ausgeblendet'></i> ";
  document.getElementById("viewVideos").style.opacity = "0.5";
  } else {
  viewVideos = true;
  document.getElementById("viewVideos").innerHTML = "<i class='fas fa-video-slash' title='Videos eingeblendet'></i> ";
  document.getElementById("viewVideos").style.opacity = "1";
  }
  }


//Responsvie Navigation
function responsiveNav() {
  var x = document.getElementById("myTopnav");
  // document.body.scrollTop = document.documentElement.scrollTop = 0;

  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}



document.getElementById("searchBar").value = findGetParameter("searchInput")


  function findGetParameter(parameterName) {
      var result = null,
          tmp = [];
      location.search
          .substr(1)
          .split("&")
          .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
          });
      return result;
  }
