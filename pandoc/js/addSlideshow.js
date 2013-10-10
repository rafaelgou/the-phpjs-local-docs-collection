/* addSlideshow.js - adds a slideshow for .pics */
function showCaption() { 
  tit = this.title;
  $('#caption').fadeOut('fast', 
      function() { $(this).text(tit); });
  $('#caption').fadeIn('slow');
}
$(document).ready(function() {
  $(".pics").cycle({
      fx:     'fade',
      speed:  1500,
      before: showCaption
      });
  });
