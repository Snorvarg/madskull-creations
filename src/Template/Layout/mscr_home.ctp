<?php 

/* Madskull Creations start-page layout.
 * 
 */


$this->start('simplicity_top_menu');
	echo $this->Menu->GetSimpleMenu($homeTree, 'simplicity_top_menu', 'dropdown menu header-subnav', 'simplicity menu');
$this->end();
$this->start('simplicity_side_menu');
	echo '<h4>Menu</h4>';
  
  if($userIsLoggedIn)
  {
?>
  <div style="margin-bottom: 30px;">
    <h6><?= __('Administrator') ?></h6>
    <?= $this->Menu->GetAccordionMenu($sideMenuTreeAdmin); ?>
  </div>
<?php
  }
$this->end();
$this->start('simplicity_page_name');
	// A bit odd, but to use a utility, we must give full path. 
	echo Cake\Utility\Inflector::camelize($categoryElement->cat_lang[0]->title);
$this->end();

?>

<?php
  // Argh, this is creating an js-object, do something about it!
  $catUrlTitles = 'var catUrlTitles = {';
  
  // debug($urlTitlesForCategory);
  if(isset($urlTitlesForCategory) && count($urlTitlesForCategory) > 0)
  {
    $count = count($urlTitlesForCategory);
    $i = 0;
    foreach($urlTitlesForCategory as $lang => $title)
    {
      $catUrlTitles .= $lang.':"'.$title.'"';
      
      if($i < $count - 1)
        $catUrlTitles .= ',';
      
      $i++;
    }
  }
  $catUrlTitles .= '};';
  
  $urlPath = "";
  if(isset($urlTitles) && count($urlTitles) > 0)
  {
    $urlPath = "/".implode('/', $urlTitles)."/";
  }
?>

<!DOCTYPE html>
<html>
<head>
  <?= $this->element('GoogleStats'); ?>
  
  <?= $this->Html->charset() ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?= $this->fetch('simplicity_site_title').': '.$this->fetch('simplicity_page_name') ?>
  </title>
  <?= $this->Html->meta('icon') ?>
  
  <?= $this->Html->css('zurb/foundation.css') ?>
  <?= $this->Html->css('prism.css') ?>
  <?= $this->Html->css('simplicity.css?version='.rand(0, 10000).'') ?>
  
  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
  <?= $this->fetch('script') ?>
  
  <?= $this->Html->script('jquery.min.js') ?>
</head>
<body>
  <style>
    #simplicity-top-bar{
      transition: all 400ms ease;
      opacity: 1;
      max-height: 500px; /* big number */
      
      background-color: black;
      color: white;
    }
    #simplicity-top-bar.is_closed{
      overflow: hidden;
      max-height: 45px;
      opacity: 0.2;
    }
    #simplicity-top-bar img, #simplicity-top-bar select, .site-title, .site-description, .top-menu-bar{
      transition: all 600ms ease;
    }
    #simplicity-top-bar:hover, #simplicity-top-bar:active{
      opacity: 1;
    }
    
    .top-menu-bar{
      overflow: hidden;
      max-height: 500px;
    }
    .is_closed .top-menu-bar{
      max-height: 0;
    }
    .open-close-navigation{
      float: left;
      margin: 10px;
    }
    .open-close-navigation:focus{
      outline: none;
    }
    
    .is_closed .language-selector{
      max-height: 26px;
      font-size: 0.6rem;
    }
    .is_closed .site-logo{
      max-width: 36px;
      margin-top: 2px;
    }
    .is_closed .site-title, .is_closed .site-description{
      opacity: 0;
    }
    .is_closed .site-title-description{
    }
    .button.login, .button.logout{
    }
  </style>
	<div id="simplicity-wrapper">
    <div id="simplicity-inner-wrapper">
      <nav role="navigation" id="simplicity-top-bar" class="is_closed">
        <button class="menu-icon open-close-navigation" title="<?= __('Toggle menu') ?>" onclick="ToggleMenu();"></button>
        <div class="control-box">
          <?php
            echo '<select class="language-selector" id="LanguageSelector" onchange="LanguageSelected();" title="'.__("Select your language").'">';
            foreach($availableLanguages as $key => $name)
            {
              $selected = '';
              if($key == $selectedLanguage)
              {
                $selected = 'selected';
              }
              
              echo '<option value="'.$key.'" '.$selected.'>'.$name.'</option>';
            }
            echo '</select>';
          ?>
        </div>
        <div class="grid-container">
          <div class="grid-x site-title-description">
            <div class="cell small-4 medium-3 large-2">
              <?php 
                $img = $this->Html->image('MadskullCreations.png', ['class' => 'site-logo']);
                echo $this->Html->link($img, '/', ['escape' => false]); 
              ?>
            </div>
            <div class="cell shrink">
              <h2 class="site-title"><?= $this->fetch('simplicity_site_title'); ?></h2>
              <h5 class="site-description" ><?= $this->fetch('simplicity_site_description'); ?></h5>          
            </div>
            <div class="cell auto">
              &nbsp;
            </div>
          </div>
        </div>
        <div class="grid-container top-menu-bar">
          <div class="grid-x">
            <div class="cell small-12 ">
              <?= $this->fetch('simplicity_top_menu') ?>
            </div>
          </div>
        </div>
      </nav>
      
      <div id="simplicity-content">
        <?= $this->Flash->render() ?>
        
        <?php
          if($userIsLoggedIn)
          {
        ?>
        <div class="cell small-3">
          <?= $this->fetch('simplicity_side_menu') ?>
        </div>
        <?php
          }
        ?>
        
        <div id="hackisch-block" style="height: 0; overflow: hidden; transition: all 600ms ease;">
          <?= $this->fetch('content') ?>
        </div>
      </div>
    </div>
  </div>
      
<?php // Zurb Foundation js really have to be at the bottom of the html file, otherwise it wont initialize correctly. ?>
  <?= $this->Html->script('zurb/foundation.min.js') ?>
  
  <script>
    var urlPath = "<?= $urlPath ?>";
    // console.log(urlPath);
    
    <?= $catUrlTitles ?>
    // console.log(catUrlTitles);
      
    $(document).foundation();
    
    $('.site-logo').attr('draggable', false);
    
    function ToggleMenu()
    {
      $("#simplicity-top-bar").toggleClass("is_closed");
      $(".simplicity-footer").toggleClass("is_closed");
    }
    
    $(function(){
      var h = $("#simplicity-content").height();
      $("#hackisch-block").height(h * 0.7);
    });
    
<?php
if($userIsAuthor)
{
  // An author is redirected to create page if it does not yet exist in the selected language.
  // (this will make sure it keep the page_id.)
?>
    function LanguageSelected()
    {
      var selLang = $("#LanguageSelector option:selected").val();
            
      if(catUrlTitles.hasOwnProperty(selLang))
      {
        // Page exists in the selected language.
        GotoTranslatedPage(selLang);
      }
      else
      {
        // Page does not exist in the selected language.
        var path = '/categories/add_new_language/<?= $categoryElement->id ?>/' + selLang; 
        window.location.replace(path);
      }
    }
<?php
}
else
{
  // Not logged in users are redirected to the given language as normal.
  // TODO: More correct would be to redirect to standard language if page does not exist. 
  //    (Now it shows an empty page, or redirect to home.)
  // TODO: Language dropdown should be visible only in view-mode, not edit or in admin pages.
?>
    function LanguageSelected()
    {
      var selLang = $("#LanguageSelector option:selected").val();
      GotoTranslatedPage(selLang);
    }
<?php
}
?>
    function GotoTranslatedPage(selLang)
    {
      var path = urlPath + catUrlTitles[selLang] + "?lang=" + selLang; 
      // var path = window.location.pathname + "?lang=" + selLang;
      // alert(path);      
     
      window.location.replace(path);
      
      // alert(window.location.href);
      // alert(window.location.pathname);
    }
  </script>
  
  <script>
    // Experimental drag screen behaviour.
    // TODO: It should not activate if selecting text or anything else is happening.
    var isDraggingScreen = false;
    var mouseDown = false;
    var timeOfMouseDown = -1;
    var timeOfFirstMouseMove = -1;
    var clickY = 0;
    
    // Note: aint working, since selectstart triggers on _any_ element below mouse cursor, not just text.
    // ..so it fires as soon as mouse is down, even before moving it.
    // Note: Analyzing the selected element could do the trick, allowing text selection for example, cancelling
    //  everything else. Half-assed solution though..
    // 
    // document.addEventListener('selectstart', disableSelectWhenDraggingScreen);
    
    $(document)
      .mousedown(function(e){
        isDraggingScreen = false;
        mouseDown = true;
        
        var d = new Date();
        timeOfMouseDown = d.getTime();
        
        clickY = e.pageY;
      })
      .mousemove(function(e){
        if(mouseDown)
        {
          if(timeOfFirstMouseMove == -1)
          {
            var d = new Date();
            timeOfFirstMouseMove = d.getTime();
          }
          
          if(isDraggingScreen)
          {
            updateScrollPos(e);
          }
          else
          {
            var diff = timeOfFirstMouseMove - timeOfMouseDown;
            
            if(diff < 300)
            {
              isDraggingScreen = true;
              $('html').css('cursor', 'row-resize');
       
              // Cancel any ongoing selections. (not working)
              // e.cancelBubble = true;
              // if (document.selection)
              // {
              // console.log("yeah");
                  // document.selection.empty(); // works in IE (7/8/9/10)
              // }
              // else if (window.getSelection)
              // {
              // console.log("yo");
                  // window.getSelection().collapseToStart(); // works in chrome/safari/opera/FF
              // }
       
              // Turn off select text and draggability.
              // document.addEventListener('selectstart', disableSelect);
            }
            else
            {
              // Normal select by dragging applies.
              $('html').css('cursor', 'crosshair');
            }
          }
        }
      })
      .mouseup(function(){
        $('html').css('cursor', 'default');
        isDraggingScreen = false;
        mouseDown = false;
        timeOfMouseDown = -1;
        timeOfFirstMouseMove = -1;
        
        // document.removeEventListener('selectstart', disableSelect);
      });
      
    function updateScrollPos(e)
    {
      $(window).scrollTop($(window).scrollTop() + (clickY - e.pageY));
    }      
    function disableSelectWhenDraggingScreen(e)
    {
      console.log(e);
      
      // e.srcElement contains the element selected.
      // e.innerText contains any text the element contains, not defined if no text.
      // e.srcElement.nodeType == 3
      
      if(timeOfFirstMouseMove == -1)
      {
        console.log("stop 1");
        e.preventDefault();
      }

      if(isDraggingScreen)
      {
        console.log("stop 2");
        e.preventDefault();
      }
    }
  </script>  
  
  <?= $this->Html->script('prism') ?>
</body>
</html>
