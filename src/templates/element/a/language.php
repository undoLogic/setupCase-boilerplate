<?php
    if($current_language === 'en_US' || $current_language === 'en-US'){
    $switch_to = 'fr_CA';
    $current_language = 'en_US';
}else{
        $switch_to = 'en_US';
    }

?>
<?php $link = $_SERVER['REQUEST_URI'];
$new_link = str_replace($current_language, $switch_to, $link);
?>
<a href="<?= $new_link; ?>"><?= $switch_to; ?></a>


