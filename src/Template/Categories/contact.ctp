<?php
use App\Controller\CategoriesController;

?>

<div>
	<?= $categoryElement->cat_lang[0]->content ?>
</div>

<?php
// Using zurbs data-abide.
echo $this->Form->create(null, ['id' => 'contactForm', 'data-abide' => '', 'novalidate' => true]);

?>
<div data-abide-error class="sr-only callout large alert" style="display: none;">
  <?= __('There was a problem submitting your form. Please check the error message below each input field.'); ?>
</div>

<?= $this->Form->input('name', ['title' => __('Name')]); ?>
<label class="form-error" data-form-error-for="name"><?= __('Please fill in your name'); ?></label>

<?= $this->Form->input('email', ['title' => __('Email')]); ?>
<label class="form-error" data-form-error-for="email"><?= __('This must be a valid email address'); ?></label>

<?= $this->Form->input('message', ['title' => __('Message'), 'type' => 'textarea', 'required' => 'required', 'maxlength' => 512, 'data-validator' => 'min_length', 'min_len' => 15]); ?>
<label class="form-error" data-form-error-for="message"><?= __('The message must be at least 15 characters'); ?></label>

<!--input type="text" name="recaptchaToken" id="recaptchaToken" style="display:none;"></input-->

<?php
// TODO: Översätt fälten till svenska, läs vidare om det!

// echo $this->Form->button(__('Submit'), ['class' => 'button top-margin', 'onclick' => 'return flomp();']);
echo $this->Form->button(__('Submit'), ['class' => 'button top-margin']);
echo $this->Form->end();
?>
<div id="html_element" onclick="flomp();"></div>

<?php
	if($userIsAuthor)
	{
    echo $this->element('AuthorControl', [
      'userIsAuthor' => $userIsAuthor, 
      'categoryElementId' => $categoryElement->id,
      'selectedLanguage' => $selectedLanguage, 
      'missingLanguages' => $missingLanguages
      ]);
  }
?>

<script>
  $(function(){
    <?php
      // Hack abide slightly by changing the error message for the form elements and show it.
      foreach($errors as $key => $messages)
      {
        $message = reset($messages);
        
        if(strlen($message) > 0)
        {
          // Replace default error message and show it.
    ?>
    // console.log($("label[data-form-error-for='<?= $key ?>']"));
    $("label[data-form-error-for='<?= $key ?>']").text("<?= $message ?>").addClass("is-visible");

    <?php
        }
        else
        {
          // No message, just show the default error message.
    ?>
    $("label[data-form-error-for='<?= $key ?>']").addClass("is-visible");

    <?php
        }
      }
    ?>
  });
</script>

<script src="https://www.google.com/recaptcha/api.js?render=6LdVfpYUAAAAAM33HRdtP6tU_FSZpFlrA0VTO740" async defer></script>
<script>
var flomp = function(){
  var token = $("#recaptchaToken").text();
  console.log(grecaptcha.getResponse(token)); 
}

var getRecaptchaResponse = function()
{
  var token = $("#recaptchaToken").text();

// not working... "FEL för webbplatsägare: Ogiltig webbplatsnyckel"  
// ...för det är för v2!!
  // grecaptcha.render('html_element', {
    // 'sitekey' : '6LdVfpYUAAAAAM33HRdtP6tU_FSZpFlrA0VTO740'
  // });
  
  //return false;
}
$(function(){
  grecaptcha.ready(function() {
    grecaptcha.execute('6LdVfpYUAAAAAM33HRdtP6tU_FSZpFlrA0VTO740', {action: 'social'}).then(function(token) {
      // This happens on page load.
      // console.log(token);
      $("#recaptchaToken").text(token);
      
      // TODO! Gör en ajax callback till din egen server, läs mer här:
      // https://developers.google.com/recaptcha/docs/verify
      // 
      // Frontend integration: (Har jag gjort, men LÄS 3-stegs-listan) :)
      // https://developers.google.com/recaptcha/docs/v3
      
    });
  });
});
</script>
