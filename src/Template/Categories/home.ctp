<?php
use App\Controller\CategoriesController;
?>

<style>
  @font-face {
    font-family: "PoorRichard";
    src: local('☺'), url('/font/poor-richard.ttf') format('truetype');
  }
  @font-face {
    font-family: "Kunstler";
    src: local('☺'), url('/font/kunstler.ttf') format('truetype');
  }

  .topper{
    height: 45%;
  }
  .the-fancy-content{
    color: #bbbbbb;
    font-family: "Kunstler";
    font-size: 9vw;
        
    align-items: center;
    justify-content: center;
    display: flex;
  }
  .the-fancy-content p{
  }  
</style>

<div class="topper">&nbsp;</div>
<div class="the-fancy-content">
  <p>...Skomakarens barn har inga skor...</p>
</div>
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