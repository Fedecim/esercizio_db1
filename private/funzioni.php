<?php
//funzione stampa array assoc
function stampa_array($array){
    foreach ($array as $key => $value) 
    {
        if(is_array($value)){
            echo $key." => "."<br>";
            stampa_array($value);
        }
        else
        {
            echo $key.": => ".$value."<br>";
        }
    }
}

function stampa_tab($array){
    echo "<table border= 1px black'>";
    echo "<tr>";
    echo "<th>username</th>";
    echo "<th>email</th>";
    echo "<th>password</th>";
    echo "</tr>";
    foreach ($array as $riga) 
    {
        echo "<tr>";
        echo "<td>".$riga["username"]."</td>";
        echo "<td>".$riga["email"]."</td>";
        echo "<td>".$riga["password"]."</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>