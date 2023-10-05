<?php
require "db.php";
require "funzioni.php";

$param = array(
    "utente"=>"root",
    "password"=>"",
    "porta"=>"3306",
    "nome_server"=>"127.0.0.1",
    "nome_db" => "utenti"
);

$db = new DB($param);

// DELETE
if(isset($_POST["delete"]) && isset($_POST["email"])){
    $email = $_POST["email"];
    try {
        // connessione al database con dati passati al costruttore dell oggetto $db
        echo $db->connetti();
    } catch (Exception $th) {
        echo $th;
    }
    $tab = "utenti"; // nome della tabella
    $colonna = "email"; // nome della colonna
    $condizione = $email; //
    try {
        if(!$db->delete($tab,$colonna,$condizione)){// delete restituisce false se non cancella nessuna riga (condizione non trovata)
            echo "Nessun risultato per email : ".$email."<br>";
        }
    } catch (Exception $th) {
        echo $th;
    } 
}
// INSERT
if(isset($_POST["insert"]) && isset($_POST["email"])){
    // aggiungo apici inizio e fine stringa (i tre campi sono di tipo stringa per il dbms)
    //$username .= "'".$_POST["username"]."'";
    //$password = "'".$_POST["password"]."'";
    $email = "'".$_POST["email"]."'";
    $campi = [];
    $valori = [];
    $campi[] = "email";
    $valori[] = $email;
    if(!empty($_POST["username"])){
        $campi[] = "username";
        $valori[] = $_POST["username"];
    }
    if(!empty($_POST["password"])){
        $campi[] = "password";
        $valori[] = $_POST["password"];
    }
    // array contenente dati per la query insert
    $param = array(
        "nome_tab"=>"utenti",
        "email" => $email,
        "campi"=>$campi,
        "valori"=>$valori
    );
    stampa_array($param);
    // il metodo connetti restiuisce un eccezione
    try {
        // connessione al database con dati passati al costruttore dell oggetto $db
        echo $db->connetti();
    } catch (Exception $th) {
        echo $th;
    }
    try {
        $db->insert($param);
    } catch (Exception $th) {
        echo $th;
    }
}

// SELECT
if(isset($_POST["select"])){
    // inizializzo array con i campi
    if(isset($_POST["campo_ricerca"]) && !empty($_POST["campo_ricerca"]))
    {
        $campi = $_POST["campo_ricerca"];
    }
    // controllo se campo ricerca ha piu valori separati da virgola
    $colonne = [];
    if(strpos($campi,',') !== false){
        $colonne = explode(",",$campi);
    }
    else
    {
        $colonne[] = $campi;
    }
    if(!empty($_POST["col_cond"]) && !empty($_POST["condizione"])){
        $col_cond = $_POST["col_cond"];
        $condizione = "'".$_POST["condizione"]."'";
    }
    else
    {
        $col_cond = "";
        $condizione = "";
    }
    // preparo array con dati 
    $param = array(
        "nome_tab" => "utenti",
        "colonne" => $colonne,
        "col_cond" => $col_cond,
        "condizione" => $condizione
    );
    /*try {
        // connessione al database con dati passati al costruttore dell oggetto $db
        echo $db->connetti();
    } catch (Exception $th) {
        echo $th;
    }*/
    try {
        $dati = $db->select($param);
    } catch (Exception $th) {
        echo $th;
    }
    stampa_tab($dati);
}

// UPDATE
// UPDATE utenti SET username = 'nuovaUsername' WHERE email='utente2@email.com';
// nometabella, colonna da modificare, valore da inserire WHERE colonna_condizione = condizione
if(isset($_POST["update"]) && isset($_POST["campi"]) && isset($_POST["valori"])){
    $campi = $_POST["campi"]; // rappresentano i campi da modificare (dopo il SET)
    $valori = $_POST["valori"]; // rappresenta i valori da assegnare i campi (nuovi valori dopo modifica)
    $nome_tab = "utenti"; // nome della tabella
    $col_cond = "email"; // colonna condizione (dopo WHERE)
    $condizione = "'".$_POST["email"]."'"; // condizione
    $campi_array = [];
    $valori_array = [];
    // i valori di campi e valori sono delle stringhe con i valori separati da , (se sono + di uno)
    if(strpos($campi,',') !== false){ // campi / valori multipli
        $campi_array = explode(",",$campi);
        $valori_array = explode(",",$valori);
    }
    else // campo e valore singoli
    {
        $valori = "'".$valori."'";
        $campi_array[] = $campi;
        $valori_array[] = $valori;
    }
    if(count($campi_array) != count($valori_array)){
        throw new Exception("Errore: i valori e i campi devono essere di numero uguale<br>");
    }
    // preparo l'array con i dati arrivati dal form
    $param = array(
        "campi"=>$campi_array,
        "valori"=>$valori_array,
        "nome_tab"=>$nome_tab,
        "col_cond"=>$col_cond,
        "condizione"=>$condizione
    );
    if(!$db->update($param)){
        echo "Modifica non riuscita"; 
    }
}
?>