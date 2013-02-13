<?php
?>
<div class="<?php print $classes . ' ' . $zebra; ?>"<?php print $attributes; ?>>

  <div class="clearfix">

   

  <?php if ($new): ?>
    <span class="new"><?php print drupal_ucfirst($new) ?></span>
  <?php endif; ?>

  

    <?php print render($title_prefix); ?>
    <h3<?php print $title_attributes; ?>><?php print $title ?></h3>
    <?php print render($title_suffix); ?>
	<?php if ($submitted): ?><div class="comment-submitted">
            <?php 
              // Loads the user profile array by using the user id provided in $variables
              $user_id = (int)$variables['elements']['#comment']->uid;
              $user_profile = user_load($user_id); 

              // Checks if the user is anonymous or if the user has any organisation set 
              if ( ( (string)$user_profile->uid == "0" ) or ( $user_profile->field_profile_organisation == null )) {
                // prints the username and date
                print $submitted;
              }
              else {
                // Extracts the organisation id by using the user id provided in $variables
                $organisation_id = $user_profile->field_profile_organisation['und'][0]['target_id'];
                // Call the function that extracts the organisation name based on the organisation id
                $org_name = dyc_call_organisation_name($organisation_id); 

                // prints the username,date and the user's organisation           
                print ($submitted."<a href=/node/".$organisation_id." title=\"View organisation.\"> - ".$org_name."</a>");
              }
            ?></div>

  <?php endif; ?>

    
    <div class="content"<?php print $content_attributes; ?>>
    
    
    <div class="comment-meta clearfix">
    	 <?php if ($picture): ?><div class="hidden-phone"> <?php print $picture ?></div><?php endif; ?>
    </div>
    	
      <?php hide($content['links']); print render($content); ?>
      <?php if ($signature): ?>
      <div class="clearfix">
        <div>—</div>
        <?php print $signature ?>
      </div>
      <?php endif; ?>
       
    </div>
  </div>
	
  <div class="comments-links">
  <?php print render($content['links']) ?>
  </div>
</div>