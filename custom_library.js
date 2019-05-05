var coll = document.getElementsByClassName("collapsible-header");
var view_img = document.getElementsByClassName("collapsible_body");



//Beim Focus der Suche soll nach oben gescrollt werden und alle aktive Header geschlossen werden
var searchBar = document.getElementById('searchBar');
searchBar.addEventListener("focus", scrollToTopOnFocus);
searchBar.addEventListener("focus", removeContent);

// var activeWord = document.getElementById('active_Word');
// searchBar.addEventListener("click", toggleActive);

function toggleActive() {
  var activeWord = document.getElementById("active_Word");
  var collapsible_body_content = activeWord.nextElementSibling;

  collapsible_body_content.classList.toggle("active");
}

function scrollToTopOnFocus() {
  document.body.scrollTop = document.documentElement.scrollTop = 0;
  }



function removeContent() {
  var contentBox = document.getElementsByClassName("collapsible_body");
  for (y= 0; y < coll.length; y++){
    coll[y].classList.remove("active");
    while (contentBox[y].hasChildNodes() ) {
        contentBox[y].removeChild(contentBox[y].firstChild);
      }
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
