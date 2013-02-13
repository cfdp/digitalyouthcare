(function ($) {
  //add drupal 7 code
  Drupal.behaviors.myfunction = {
    attach: function(context, settings) {
  //end drupal calls
      
// Hide all answers on the FAQ page
      $('.answer').hide();

// Show each answer when it's question is clicked and hide it back again 
      $('.question').toggle(
        function(){
          $(this).parent().addClass('active');
            $(this).parent().children('.answer').slideDown();
        },
        function(){
          $(this).parent().children('.answer').slideUp();
            $(this).parent().removeClass('active');
      });

// Add active class to list items in the recent article block to help style the current article

      $('.view-display-id-block_1 li a.active').parents('li').addClass('active');

// Inject btn class to add new forum topic on the forum page
      $('.page-forum #zone2 ul.links li a').addClass('btn btn-theme btn-large');

// Add active class to tag in the filter by tag section on the knowledge base page, to indicate current active filter
     
       console.log($('.view-id-terms a.active').parents('.views-row').addClass('active'));
    
    }
  }
})(jQuery);
