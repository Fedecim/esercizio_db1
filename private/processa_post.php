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
if(isset($_POST["insert"])){
    // aggiungo apici inizio e fine stringa (altrimenti errore tipo dbms)
    $username .= "'".$_POST["username"]."'";
    $password = "'".$_POST["password"]."'";
    $email = "'".$_POST["email"]."'";
    // array contenente dati per la query insert
    $param = array(
        "nome_tab" => "utenti",
        "campi"=>["username","password","email"],
        "valori"=>[$username,$password,$email]
    );
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
        $param["campo_ricerca"] = $_POST["campo_ricerca"];
    }
    try {
        // connessione al database con dati passati al costruttore dell oggetto $db
        echo $db->connetti();
    } catch (Exception $th) {
        echo $th;
    }
    try {
        $dati = $db->select($param);
    } catch (Exception $th) {
        echo $th;
    }
    stampa_tab($dati);
}
?>