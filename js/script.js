var coll = document.getElementsByClassName("collapsible-header");
var coll_body = document.getElementsByClassName("collapsible_body");
var viewMetacom = true;
var viewVideos = true;

var videoPath = "files/video";
var imgPath = "files/";
var metacomPath = "files/metacom/";
var imgMime = "png";
var videoMime = "m4v";
var phpVideoLoader = 'php/zeigLoadVideo.php';


for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    if(this.classList.contains("active") == false) {closeAllActiveHeaders(this);} //schließt alle anderen Aktiven Header.
    this.classList.toggle("active");
    this.scrollIntoViewIfNeeded(); //scrollt den Bildschirm hoch

    //Wort in klein- und großschreibung
    var selectedWord_uc = this.innerText.substring(0,1).toUpperCase() + this.innerText.substring(1).toLowerCase();
    var selectedWord_lc = this.innerText.substring(0,1).toLowerCase() + this.innerText.substring(1).toLowerCase();


    let encodedWord = encodeURI(this.innerText);


    var c = this.nextElementSibling.children;
      for (i=0; i< c.length; i++) {
        if (c[i].classList.contains("img")){
          c[i].innerHTML = "<img class='img_gebaerden' src='php/img.php?img="+this.innerText+"&path="+imgPath+"&mime="+imgMime+"'>";
        }
        if (c[i].classList.contains("metacomLC") && viewMetacom === true){
            c[i].innerHTML = "<img class='img_metacom' src='php/metacom.php?img="+selectedWord_lc+"&path="+metacomPath+"'>";
        } else if (c[i].classList.contains("metacomUC") && viewMetacom === true){
              c[i].innerHTML = "<img class='img_metacom' src='php/metacom.php?img="+selectedWord_uc+"&path="+metacomPath+"'>";
            }
        if (c[i].classList.contains("video") && viewVideos === true){
            c[i].innerHTML = "<video class='video_gebaerden' controls preload='metadata'><source src='"+phpVideoLoader+"?video="+this.innerText+"_video."+videoMime+"#t=0.5&path="+videoPath+"' type='video/mp4'>Your browser does not support the video tag.</video>";
          }
      }


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


//Beim Focus der Suche soll nach oben gescrollt werden und alle aktive Header geschlossen werden
var searchBar = document.getElementById('searchBar');
searchBar.addEventListener("focus", closeAllActiveHeaders);
searchBar.addEventListener("focus", scrollToTopOnFocus);


function scrollToTopOnFocus() {
  document.body.scrollTop = document.documentElement.scrollTop = 0;
  }

function closeAllActiveHeaders() {
  for (y= 0; y < coll.length; y++){
    coll_body[y].style.maxHeight = null;
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

//Suche mit JQuery nach laden der Seite (einmalig falls man von anderer seite kommt)
  $(document).ready(function(){
        var value = $("#searchBar").val().toLowerCase();
        $("#wordsList li").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });





//Metacom Symbole ausblenden und einblenden
function hideMetacom(){
  if (viewMetacom === true) {
  viewMetacom = false;
  document.getElementById("viewMetacom").innerHTML = "<img src='img/metacom.png' height='20px' title='Metacom ausgeblendet' style='filter: grayscale(1)'> Metacom";
    document.getElementById("viewMetacom").style.opacity = "0.5";

} else {
  viewMetacom = true;
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
