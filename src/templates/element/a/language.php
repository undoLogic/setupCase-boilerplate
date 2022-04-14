<?php
    if($current_language === 'en_US' || $current_language === 'en-US'){
        $current_language = 'en_US';
    $switch_to = 'fr_CA';
}else{
        $switch_to = 'en_US';
    }



?>
<a href="#" onclick="switchLanguage('<?= $current_language; ?>', '<?= $current_controller; ?>', '<?= $current_action; ?>');"><?= $switch_to; ?></a>
<?php

?>
<script>
    function switchLanguage(current_language, controller, action) {
        //alert(action);
        if(current_language === 'en_US' || current_language === 'en-US'){
            current_language = 'en_US';
            var switch_to = 'fr_CA';
        }else{
            switch_to = 'en_US';
            current_language = 'fr_CA';
        }
        window.location.href=<?= $webroot;?>+switch_to+"/"+controller+"/"+action+"/";

    }
</script>





