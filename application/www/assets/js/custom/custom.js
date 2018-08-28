/**
============================================
 ===  CUSCTOM JAVASCRITP TABLE CONTENT  ====
============================================

 1.0  Variables
 2.0  Clicks outside the modals close
 3.0  Avoid default event when modal closes
 4.0  Quotes Animations
 5.0  SlideToggle in About section
 6.0  Off-canvas menu
 7.0  Get url path

 ============================================
 ===  END  ====
 ============================================ */

/* ----------------------------------------------------------------------------
* VARIABLES
* ------------------------------------------------------------------------- */

var $ = jQuery;

var socialModal = document.getElementById('js-social-modal');
var quotesModal = document.getElementById('js-quotes-modal');
var nameModal = document.getElementById('js-name-modal');
var photoModal = document.getElementById('js-photo-modal');
var coverModal = document.getElementById('js-cover-modal');
var modalLinks = document.querySelectorAll('.js-modal-link');

var quotesText = [];
var quotes = document.getElementsByClassName('quotes');
var counter = 0;
var quotesDiv = document.getElementById('quotesDisplay');
var inst = setInterval(change, 5000);

var longText = document.getElementById("js-read-more");
var readMoreBtn = document.getElementById('readMoreBtn');

var browserWidth 	= window.innerWidth;
var phoneWidth 	= 414;

/* ----------------------------------------------------------------------------
 * When the user clicks anywhere outside of the modal, close it
 * ------------------------------------------------------------------------- */

window.onclick = function(event) {
  if (event.target == socialModal ||
    event.target == quotesModal ||
    event.target == photoModal ||
    event.target == coverModal ||
    event.target == nameModal) {

    var ask = confirm("If you continue, you will lose your changes.");

    if (ask == true) {
      socialModal.style.display = "none";
      quotesModal.style.display = "none";
      nameModal.style.display = "none";
      photoModal.style.display = "none";
      coverModal.style.display = "none";
    }
  }
};

/* ----------------------------------------------------------------------------
*  Avoid the modal link to jump back to top of page '#'
* ------------------------------------------------------------------------- */

Array.prototype.forEach.call(
  modalLinks,
  function(el, i) {
    el.addEventListener('click', function(e) {
      e.preventDefault();
  });
});

/* ----------------------------------------------------------------------------
*  Script to animate the quotes underneath the title
* ------------------------------------------------------------------------- */

for (var i = 0; i < quotes.length; i++) {
  quotesText.push(quotes[i].textContent);
}

function change() {
  quotesDiv.innerHTML = quotesText[counter];
  counter++;
  if (counter >= quotesText.length) {
    counter = 0;
    // clearInterval(inst); // uncomment this if you want to stop refreshing after one cycle
  }
}

/* ----------------------------------------------------------------------------
*  SlideToggle in the about me section
* ------------------------------------------------------------------------- */

$(readMoreBtn).click(function() {
  var link = $(this);
  $(longText).slideToggle(400, function() {
    if ($(this).is(':visible')) {
      link.text('Read Less');
    } else {
      link.text('Read More');
    }
  });
});

/* ----------------------------------------------------------------------------
*  Off-canvas menu administration panel for meta
*  source: https://www.w3schools.com/howto/howto_js_off-canvas.asp
* ------------------------------------------------------------------------- */

function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}

/* ----------------------------------------------------------------------------
*  Get the url path after / Not used at the moment
* ------------------------------------------------------------------------- */

function getLastPart(url) {
  var parts = url.split("/");
  return (url.lastIndexOf('/') !== url.length - 1 ?
    parts[parts.length - 1] :
    parts[parts.length - 2]);
}
