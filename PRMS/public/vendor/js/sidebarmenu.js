//==============================================================
// Auto select left navbar
// ==============================================================
function toggleContent(showId) {
  // Collapse the content of the other elements
  $('.collapse').not('#' + showId).collapse('hide');
  // Show the selected content
  $('#' + showId).collapse('show');
}

$(function () {
  "use strict";
  var url = window.location + "";
  var path = url.replace(
    window.location.protocol + "//" + window.location.host + "/",
    ""
  );
  var element = $("ul#sidebarnav a").filter(function () {
    return this.href === url || this.href === path; // || url.href.indexOf(this.href) === 0;
  });
  element.parentsUntil(".sidebar-nav").each(function (index) {
    if ($(this).is("li") && $(this).children("a").length !== 0) {
      $(this).children("a").addClass("active");
      $(this).parent("ul#sidebarnav").length === 0
        ? $(this).addClass("active")
        : $(this).addClass("selected");
    } else if (!$(this).is("ul") && $(this).children("a").length === 0) {
      $(this).addClass("selected");
    } else if ($(this).is("ul")) {
      $(this).addClass("in");
    }
  });

  element.addClass("active");
  $("#sidebarnav a").on("click", function (e) {
    if (!$(this).hasClass("active")) {
      // Collapse the content of the other elements
      $('.collapse.show').collapse('hide');
      
      // Remove active classes from other links
      $("#sidebarnav a").removeClass("active");
      
      // Add active class to the clicked link
      $(this).addClass("active");
      
      // Show the selected content
      $(this).next(".collapse").collapse('show');
    }
  });
  $("#sidebarnav >li >a.has-arrow").on("click", function (e) {
    e.preventDefault();
  });
});
