<?php
    if($current_language === 'en_US' || $current_language === 'en-US'){
        $current_language = 'en_US';
    $switch_to = 'fr_CA';
}else{
        $switch_to = 'en_US';
    }
    echo $current_language;

?>
<?php
//pr($this->request->here());
//pr($this->params['controller']);
//pr($this->request->params());
//pr($_SERVER["REQUEST_URI"] );
//pr($_SERVER["QUERY_STRING"]);
?>





