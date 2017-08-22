<?php
function generateRandompassword() {
    $alphabets = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@#$%^*()_+{}[]:;,./<>";
    $password = "";
    $alphaLength = strlen($alphabets) - 1; 

    $number = rand(6, 12);

    for ($i = 0; $i < $number; $i++) {
        $n = rand(0, $alphaLength);
        $password .= $alphabets[$n];
    }
    return $password; //convert array into a string
}
?>