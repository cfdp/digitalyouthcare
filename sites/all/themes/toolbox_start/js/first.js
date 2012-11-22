(function($) {
Drupal.behaviors.myBehavior = {
  attach: function (context, settings) {

//$("#forum tbody tr").addClass("go_bold");
 
 if ($("#forum .icon").hasClass("forum-status-new"))  {
     ($("#forum tbody tr:has(.forum-status-new)").addClass("go_bold"));
 }
 
if ($("#forum .icon div").hasClass("topic-status-new"))  {
     ($("#forum tbody tr:has(.topic-status-new)").addClass("go_bold"));
 }     
 
//if ($("article header p").hasClass("submitted_header")) {
 //       ($("article header:has(.submitted_header)").hide());}

//$("#main #content #page-title").prependTo("article:has(.field-name-taxonomy-forums) header");

$("article header .submitted .permalink").hide();
$("article .field-name-taxonomy-forums").hide();
//$("article header .submitted").appendTo("article header h3");
  }}})(jQuery);