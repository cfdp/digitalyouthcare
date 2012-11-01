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
  }}})(jQuery);