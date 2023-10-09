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
    
    echo '<table border="1">';
    
    // Controllo se l'array è vuoto
    if (!empty($array)) {
        // array_keys restituisce tutte le chiavi di un array associativo
        // se l'array indicizzato non è vuoto uso il primo elemento dell array per recuperare i nomi delle chiavi
        $colonne = array_keys($array[0]);
        
        // Stampo l'intestazione della tabella con le chiavi
        echo '<tr>';
        foreach ($colonne as $colonna) {
            echo '<th>' . $colonna. '</th>';
        }
        echo '</tr>';
        
        // Stampo i dati nella tabella
        foreach ($array as $record) {
            echo '<tr>';
            foreach ($record as $campo) {
                echo '<td>' . $campo . '</td>';
            }
            echo '</tr>';
        }
    } else {
        // Se l'array è vuoto stampo messaggio : nessun risultato trovato
        echo '<p>Nessun risultato trovato</p><br>';
    }
    
    echo '</table>';
    
}
?>