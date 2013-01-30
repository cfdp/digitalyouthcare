<?php
 
/*
	Theme Name: dyc
	Theme URI: 
	Description: dyc multipurpose Drupal theme
	Version: 1.0
	Author: Worthapost
	Author URI: http://www.worthapost.com
*/
	
// load css files
drupal_add_css(drupal_get_path('theme', 'icompany') .'/css/bootstrap.css',  array(  'group' => 'CSS_THEME', 'weight' => 93));
drupal_add_css(drupal_get_path('theme', 'icompany') .'/style.css',  array(  'group' => 'CSS_THEME', 'weight' => 96));
drupal_add_css(drupal_get_path('theme', 'icompany') .'/css/bootstrap-responsive.css',  array(  'group' => 'CSS_THEME', 'weight' => 99));



// load js files v@1.8.1 jquery
drupal_add_js(drupal_get_path('theme', 'icompany') . '/js/jquery.min.js', array('type' => 'file', 'scope' => 'header', 'group' => 'JS_LIBRARY', 'weight' => 0));

// Misc
drupal_add_js(drupal_get_path('theme', 'icompany') . '/js/bootstrap.js', array('type' => 'file', 'scope' => 'footer', 'group' => 'JS_LIBRARY', 'weight' => 20));
drupal_add_js(drupal_get_path('theme', 'icompany') . '/js/tinynav.js', array('type' => 'file', 'scope' => 'header', 'group' => 'JS_LIBRARY', 'weight' => 40));


// superfish
drupal_add_js(drupal_get_path('theme', 'icompany') . '/js/hoverIntent.js', array('type' => 'file', 'scope' => 'header', 'group' => 'JS_LIBRARY', 'weight' => 25));
drupal_add_js(drupal_get_path('theme', 'icompany') . '/js/superfish.js', array('type' => 'file', 'scope' => 'header', 'group' => 'JS_LIBRARY', 'weight' => 30));
drupal_add_js(drupal_get_path('theme', 'icompany') . '/js/supersubs.js', array('type' => 'file', 'scope' => 'header', 'group' => 'JS_LIBRARY', 'weight' => 35));
drupal_add_css(drupal_get_path('theme', 'icompany') .'/css/superfish.css',  array(  'group' => 'CSS_THEME', 'weight' => 93));

// Google fonts
// Prepare Google font css 




// user box
function dyc_welcome_user(){
	global $user;
	$usr_path = 'user/'.$user->uid;
	$myAccount = drupal_get_path_alias($usr_path);
	$logout = drupal_get_path_alias('user/logout');
	if($user->uid)
	{
		$myAccount = l(t('My account'), $myAccount, array('title' => t('My account')));
		$signout = l(t('Sign out'), $logout);
		$output = $myAccount . ' | ' . $signout;
		return $output;
	}

	return;
}


// Piecemakre content generater and file writer
if(theme_get_setting('slider_type')  == 'piecemaker'){
drupal_add_js(drupal_get_path('theme', 'icompany') . '/sliders/piecemaker/scripts/swfobject/swfobject.js', array('type' => 'file', 'scope' => 'header', 'group' => 'JS_DEFAULT', 'weight' => 25));
}



// main menu preprocess
function dyc_menu_link(array $variables) {
	$element = $variables['element'];
	$sub_menu = '';
	
	if ($element['#below']) {
	  $sub_menu = drupal_render($element['#below']);
	}
	  
	if($variables['element']['#original_link']['menu_name'] == 'main-menu' && $variables['element']['#original_link']['depth'] == 1){
			
		if(array_key_exists('attributes', $variables['element']['#original_link']['options']) && array_key_exists('title', $variables['element']['#original_link']['options']['attributes'])){
			 $item_url = drupal_get_path_alias($element['#href']);
			 $output = l($element['#title'], $element['#href'], $element['#localized_options']) . '<span class="tip hidden-phone hidden-tablet"> <a href="'. $item_url . '">' . $variables['element']['#original_link']['options']['attributes']['title'] .'</a></span>';	
		}
		else {
			$output = l($element['#title'], $element['#href'], $element['#localized_options']) . '<span class="tip hidden-phone hidden-tablet"> </span>';
		}
		
	return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n"; 
	}
	  
	$output = l($element['#title'], $element['#href'], $element['#localized_options']);
	return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}
 
// menus customization
function dyc_menu_tree__main_menu($variables) {
 	return '<ul id="nav" class="sf-menu">' . $variables['tree'] . '</ul>';
}

// Custom breadcrumb
function dyc_breadcrumb($breadcrumb) {
	    
    $bc = $breadcrumb['breadcrumb'];
	if (!empty($bc)) {
		return implode(' / ', $bc) ;
	}
}

 
// Preprocess Page
function dyc_preprocess_page(&$variables) {
  if (isset($variables['secondary_menu'])) {
    $variables['secondary_nav'] = theme('links__system_secondary_menu', array(
      'links' => $variables['secondary_menu'],
      'attributes' => array(
        'class' => array('links', 'inline', 'secondary-menu'),
      ),
      'heading' => array(
        'text' => t('Secondary menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $variables['secondary_nav'] = FALSE;
  }
}


// Customized tabs
function dyc_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="btn-group tabs">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="btn-group">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }

  return $output;
}

function dyc_menu_local_task($variables) {
  $link = $variables['element']['#link'];
  $link_text = $link['title'];

  if (!empty($variables['element']['#active'])) {
    // Add text to indicate active tab for non-visual users.
    $active = '<span class="element-invisible">' . t('(active tab)') . '</span>';

    // If the link does not contain HTML already, check_plain() it now.
    // After we set 'html'=TRUE the link will not be sanitized by l().
    if (empty($link['localized_options']['html'])) {
      $link['title'] = check_plain($link['title']);
    }
    $link['localized_options']['html'] = TRUE;
    $link_text = t('!local-task-title!active', array('!local-task-title' => $link['title'], '!active' => $active));
  }

  return '<li' . (!empty($variables['element']['#active']) ? ' class="active btn"' : ' class="btn"') . '>' . l($link_text, $link['href'], $link['localized_options']) . "</li>\n";
}

// customize node submitted text
function dyc_preprocess_node(&$variables) {
  $print_task = t('Print this page');
  // Extract the organisation id using the user id provided in $variables
  $user_id = (int)$variables["uid"];
  $user_profile = user_load($user_id);
  $organisation_id=$user_profile->field_profile_organisation['und'][0]['target_id'];
  // Call the function that extracts the organisation name based on the organisation id
  $org_name = dyc_call_organisation_name($organisation_id);
  
  if ($variables['submitted']) {
    $variables['submitted'] = t('<span class="icon-calendar"></span> on 
                                !datetime &nbsp; <span class=" icon-user"></span> 
                                !username !organisation
                                <a class="hidden-phone hidden-tablet node-print pull-right" style="line-height:10px;"  data-original-title="!print_text" data-placement="top" rel="tooltip" href="javascript:window.print()">
                                <span class="icon-print"></span></a>', 
                                array('!username' => $variables['name'], '!datetime' => $variables['date'],
                                        '!print_text' => $print_task,
                                        '!organisation'=> "<a href=/node/".$organisation_id." title=\"View organisation.\"> - ".$org_name."</a>"));
  }
 
 
  //customize readmore, comments and comment add    
  if(array_key_exists('content', $variables) && array_key_exists('links', $variables['content']) && array_key_exists('comment', $variables['content']['links']) && array_key_exists('comment-new-comments', $variables['content']['links']['comment']['#links'])){
    $variables['content']['links']['comment']['#links']['comment-new-comments']['attributes']['class'] = array('btn',  'btn-small');
  }

  if(array_key_exists('content', $variables) && array_key_exists('links', $variables['content']) && array_key_exists('comment', $variables['content']['links']) && array_key_exists('comment-comments', $variables['content']['links']['comment']['#links'])){
  	$variables['content']['links']['comment']['#links']['comment-comments']['title'] = '<span class="icon-comment"></span> &nbsp;' . $variables['content']['links']['comment']['#links']['comment-comments']['title'] ;
    $variables['content']['links']['comment']['#links']['comment-comments']['attributes']['class'] = array('btn',  'btn-small');
  }
  
  if(array_key_exists('content', $variables) && array_key_exists('links', $variables['content']) && array_key_exists('comment', $variables['content']['links']) && array_key_exists('comment-add', $variables['content']['links']['comment']['#links'])){
 	$variables['content']['links']['comment']['#links']['comment-add']['html'] = 1;
 	$variables['content']['links']['comment']['#links']['comment-add']['title']  = '<span class="icon-plus"></span> &nbsp;' . $variables['content']['links']['comment']['#links']['comment-add']['title']  ;   
    $variables['content']['links']['comment']['#links']['comment-add']['attributes']['class'] = array('btn', 'btn-small');
  }
  
  if(array_key_exists('content', $variables) && array_key_exists('links', $variables['content']) && array_key_exists('node', $variables['content']['links']) && array_key_exists('node-readmore', $variables['content']['links']['node']['#links'])){
    $variables['content']['links']['node']['#links']['node-readmore']['attributes']['class'] = array('btn', 'btn-theme', 'btn-small');
  }
  
	
}
// Returns the organisation id using the organisation title
  function dyc_call_organisation_name($id) {
  $node_title = node_load($id);  
  return $node_title->title;
  }
  
  
//shortcodes
function dyc_preprocess_field(&$variables) {
	
	if(array_key_exists('element', $variables) && array_key_exists("#field_name", $variables['element'])){
		if($variables['element']['#field_name'] == 'body'){
			if(array_key_exists('items', $variables)  && array_key_exists('0', $variables['items'])  && array_key_exists('#markup', $variables['items']['0'])){
				
				$string = $variables['items']['0']['#markup'];	
				
				// replace	
				$string = str_replace('[row]', '<div class="row-fluid">', $string);
				$string = str_replace('[/row]', '</div>', $string);
				
				$string = str_replace('[one]', '<div class="span12">', $string);
				$string = str_replace('[/one]', '</div>', $string);
					 
				$string = str_replace('[oneHalf]', '<div class="span6">', $string);
				$string = str_replace('[/oneHalf]', '</div>', $string);
				
				$string = str_replace('[oneThird]', '<div class="span4">', $string);
				$string = str_replace('[/oneThird]', '</div>', $string);
				
				$string = str_replace('[oneFourth]', '<div class="span3">', $string);
				$string = str_replace('[/oneFourth]', '</div>', $string);
				
				$string = str_replace('[oneFifth]', '<div class="span2">', $string);
				$string = str_replace('[/oneFifth]', '</div>', $string);
				
				$string = str_replace('[oneSixth]', '<div class="span2">', $string);
				$string = str_replace('[/oneSixth]', '</div>', $string);
				
				$string = str_replace('[twoThird]', '<div class="span8">', $string);
				$string = str_replace('[/twoThird]', '</div>', $string);
				
				$string = str_replace('[threeFourth]', '<div class="span9">', $string);
				$string = str_replace('[/threeFourth]', '</div>', $string);
				
				$string = str_replace('[fiveSixth]', '<div class="span10">', $string);
				$string = str_replace('[/fiveSixth]', '</div>', $string);
				
				$string = str_replace('[color]', '<span class="color">', $string);
				$string = str_replace('[/color]', '</span>', $string);
				
				$string = str_replace('[h1 bordered]', '<h1 class="bordered">', $string);
				$string = str_replace('[/h1]', '</h1>', $string);
				
				$string = str_replace('[h2 bordered]', '<h2 class="bordered">', $string);
				$string = str_replace('[/h2]', '</h2>', $string);
				
				$string = str_replace('[h3 bordered]', '<h3 class="bordered">', $string);
				$string = str_replace('[/h3]', '</h3>', $string);
				$variables['items']['0']['#markup'] = $string;
			}
		}
	}
	
 
}

// customize comment submitted text
function dyc_preprocess_comment(&$variables) {
    $created = $variables['created'];
    $author = $variables['author'];
    $variables['submitted'] = t("on !date by !author", array('!date' => $created, '!author' => $author));
}


function dyc_preprocess_table(&$variables){
	$variables['attributes']['class'] = array(' table table-striped ');
}

function dyc_preprocess_button(&$variables) {
  $variables['element']['#attributes']['class'][] = ' btn ';
}

function dyc_preprocess_simplenews_block(&$vars){
	$vars['form']['mail']['#title'] = '';
	$vars['form']['mail']['#attributes'] = array('placeholder' => 'E-mail…');
	$vars['form']['mail']['#size'] = 27;
}

//status messages
function dyc_status_messages($variables) {
  $display = $variables['display'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'), 
    'error' => t('Error message'), 
    'warning' => t('Warning message'),
  );
  foreach (drupal_get_messages($display) as $type => $messages) {
	switch ($type) {
		case 'status':
			$alert_type = '  alert-success alert-block ';
			break;
		case 'warning':
			$alert_type = '  alert-block ';
			break;
		case 'error':
			$alert_type = '  alert-error alert-block ';
			break;
		default:
			$alert_type = '  alert-block ';
			break;
	}
	
    $output .= "<div class=\" alert $alert_type\">\n <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>\n";
    if (!empty($status_heading[$type])) {
      $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
    }
    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . "</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= $messages[0];
    }
    $output .= "</div>\n";
  }
  return $output;
}