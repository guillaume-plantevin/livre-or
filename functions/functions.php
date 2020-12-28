<?php
    function print_r_pre($array, $name) {
        echo '<pre>';
        echo $name . '<br />';
        print_r($array);
        echo '</pre>';
    }
    function var_dump_pre($array, $name) {
        echo '<pre>';
        echo $name . ':';
        var_dump($array);
        echo '</pre>';
    }
    // trop complique => A SUPPRIMER OU CORRIGER
    function verifyingPassConfInSession($pass, $passConf) {
        if (empty($pass)) {
            $_SESSION['error'] = "Attention: Votre devez rentrer mot de passe et sa confirmation.";
            return FALSE;
        }
        elseif (empty($passConf)) {
            $_SESSION['error'] = "Attention: vous devez répéter votre mot de passe dans la case \"confirmation\".";
            return FALSE;
        }
        elseif ($pass !== $passConf) {
            $_SESSION['error'] = "Attention: vous devex répéter votre mot de passe dans la case \"confirmation\".";
            return FALSE;
        }
        else {
            // $_SESSION['error'] = "Attention: vous devex répéter votre mot de passe dans la case \"confirmation\".";
            return TRUE;
        }
    }