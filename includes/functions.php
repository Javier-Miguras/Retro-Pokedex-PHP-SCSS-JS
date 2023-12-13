<?php

require 'app.php';

function includeTemplate($name){
    include TEMPLATES_URL . "/{$name}.php";
}
