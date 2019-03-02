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
    body{
      overflow-y:scroll;
    }
    
    #simplicity-top-bar{
      transition: all 400ms ease;
      opacity: 1;
      max-height: 500px; /* big number */
      /* TODO: Not working, flex: 1 1 auto aint working with changing height or max-height here! */
      
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
      /*align-items: initial;*/
    }
    .button.login, .button.logout{
    }
    .simplicity-footer{
      transition: all 400ms ease;
      padding: 20px;
      height: 60px;
      font-style: italic;
      font-size: 16px;
    }
    .simplicity-footer.is_closed{
      opacity: 0.2;
      padding: 10px;
      height: 40px;
      font-size: 13px;
    }
    .simplicity-footer.is_closed:hover{
      opacity: 1;
    }
    
    .simplicity-footer .cell{
      align-items: baseline;
    }
    
@media print, screen and (max-width: 40em){ /* Mobile */
    .simplicity-footer{
      font-size: 3vw;
    }
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
      <footer class="simplicity-footer is_closed">
        <div class="grid-container fluid">
          <div class="grid-x grid-margin-x">
          	<div class="cell auto">
              Powered by&nbsp;<a href="https://simplicity.madskullcreations.com" target="_blank">Simplicity CMS</a>&nbsp;- Simple yet powerful
          	</div>
            
            <?php
              // Start page need no login button.
              if($userIsLoggedIn)
              {
            ?>
            <div class="cell small-1">
            <?php
              echo '<a class="button logout" title="'.__("Logout").'" href="/users/logout">'.__("Logout").'</a>';
            ?>
            </div>
            <?php
              }
            ?>
          </div>
        </div>
      </footer>
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
      $("#hackisch-block").height(h * 0.8);
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
  
  <?= $this->Html->script('prism') ?>
</body>
</html>
