var coll = document.getElementsByClassName("collapsible-header");
var view_img = document.getElementsByClassName("collapsible_body");
var viewmetacom = true;
var viewVideos = true;

var videopath = "custom/videos/";
var imgpath = "custom/";
var metacompath = "files/metacom/";

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    var array_nmbr = this;
    closeAllActiveHeaders(array_nmbr); //schließt alle anderen Aktiven Header.
    this.classList.toggle("active");


//Gebärden Fotos
    array_nmbr.nextElementSibling.innerHTML = "<div class='collapsible_body_content'><img class='img_gebaerden' src='img.php?img="+this.innerText+"'></div>";

if (viewVideos == true) {
//Gebärden Video, prüfen ob es das gibt und wenn ja posten
    if (doesFileExist(videopath+this.innerText+'_video.mp4') == true) {
    array_nmbr.nextElementSibling.innerHTML += "<div class='collapsible_body_content'><video class='video_gebaerden' controls preload='metadata'><source src='video.php?video="+this.innerText+"_video.mp4#t=0.5' type='video/mp4'>Your browser does not support the video tag.</video></div>";
    }
  }
if (viewmetacom == true) {
  //Kleinschreibung des ersten Buchstabens des Strings für Metacom Symbole
  //und prüfen ob die Datei exisitert
      var array_nmbr_lc = array_nmbr.innerText.substring(0,1).toLowerCase() + array_nmbr.innerText.substring(1).toLowerCase();
      if (doesFileExist(metacompath+array_nmbr_lc+'.png') == true) {
        array_nmbr.nextElementSibling.innerHTML += "<div class='collapsible_body_content'><img class='img_metacom' src='metacom.php?img="+array_nmbr_lc+"'></div>";
      }

  //Großschreibung des ersten Buchstabens des Strings für Metacom Symbole und
  //Prüfen, ob die Datei in Großschreibung existiert und wenn ja, dann schreiben
      //
      // var array_nmbr_uc = array_nmbr.innerText.substring(0,1).toUpperCase() + array_nmbr.innerText.substring(1).toLowerCase();
      // if (doesFileExist('/gebaerden/files/metacom/'+array_nmbr_uc+'.png') == true) {
      //   array_nmbr.nextElementSibling.innerHTML += "<div class='collapsible_body_content'><img class='img_metacom' src='/gebaerden/files/metacom/"+array_nmbr_uc+".png'></div>";
      // }
}

let encodedWord = encodeURI(this.innerText);

//show pdf export symbol
array_nmbr.nextElementSibling.innerHTML += "<div class='collapsible_body_pdf'><a class='a_white' target='_blank' href='html2pdf.php?word=" +encodedWord + "&path="+imgpath+"' method='post'> PDF generieren <i class='far fa-file-pdf'></i></a></div>";




//Ein- und ausklappen von collabsible body
    var collapsible_body = this.nextElementSibling;
    var collapsible_body_content = this.nextElementSibling.children;


    if (collapsible_body.style.maxHeight){
      collapsible_body.style.maxHeight = null;
      for (y=0; y < collapsible_body_content.length; y++) {
        collapsible_body_content[y].style.opacity = null;
      }


    } else {
      collapsible_body.style.maxHeight = "1400px";
      //collapsible_body_content.style.maxHeight = collapsible_body_content.scrollHeight + "px"; //90%"90%";
      for (y=0; y < collapsible_body_content.length; y++) {
        collapsible_body_content[y].style.opacity = "1";
      }

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
  document.getElementById("viewMetacom").innerHTML = "<img src='img/metacom.png' height='20px' title='Metacom ausgeblendet' style='filter: grayscale(1)'> Metacom";
    document.getElementById("viewMetacom").style.opacity = "0.5";

} else {
  viewmetacom = true;
  document.getElementById("viewMetacom").innerHTML = "<img src='img/metacom.png' height='20px' title='Metacom eingeblendet'> Metacom";
    document.getElementById("viewMetacom").style.opacity = "1";
  }
}



//Videos ausblenden
function hideVideos(){
  if (viewVideos === true) {
  viewVideos = false;
  document.getElementById("viewVideos").innerHTML = "<i class='fas fa-video-slash' title='Videos ausgeblendet'></i> Videos";
  document.getElementById("viewVideos").style.opacity = "0.5";
  } else {
  viewVideos = true;
  document.getElementById("viewVideos").innerHTML = "<i class='fas fa-video' title='Videos eingeblendet'></i> Videos";
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
