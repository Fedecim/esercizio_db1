<?php
class Db{
    private $utente;
    private $nome_server;
    private $porta;
    private $password;
    private $nome_db;
    private $connessione;

    public function __construct($parametri) 
    {
        $this->utente = $parametri["utente"];
        $this->nome_server = $parametri["nome_server"];
        $this->porta = $parametri["porta"];
        $this->password = $parametri["password"];
        $this->nome_db = $parametri["nome_db"];
        $this->connessione = NULL;
    }

    public function connetti(){
        if(!$this->connessione){
            $conn = mysqli_connect($this->nome_server,$this->utente,$this->password,$this->nome_db,$this->porta);
            if(!$conn){
                throw new Exception("Connessione non riuscita: " . mysqli_connect_error());
            }
            echo "Connessione riuscita!"."<br>";
            $this->connessione = $conn;
        }
    }

    public function delete($tabella,$colonna,$condizione)
    {
        if(!$this->connessione){
            try {
                $this->connetti();
            } catch (Exception $th) {
                echo $th;
            }
        }
        $query = "DELETE FROM ".$tabella." WHERE ".$colonna." = '".$condizione."'";

        if(mysqli_query($this->connessione,$query)){
            if(mysqli_affected_rows($this->connessione) == 0){ // se == 0 non ha cancellato nessuna riga dalla tabella
                return false;
            }
            echo "Cancellazione avvenuta con successo";
        }
        else{
            throw new Exception("Cancellazione non riuscita: " . mysqli_error($this->connessione));
        }
        mysqli_close($this->connessione);
    }
    public function insert($parametri){
        if(!$this->connessione){
            try {
                $this->connetti();
            } catch (Exception $th) {
                echo $th;
            }
        }
        $nomeTab = $parametri["nome_tab"];
        $query = "INSERT INTO ".$nomeTab."(";
        foreach ($parametri["campi"] as $campo) {
            $query.=$campo.",";
        }
        // elimino la ',' rimasta in fondo alla stringa
        $query = substr($query,0,-1);
        $query.=")VALUES(";
        foreach ($parametri["valori"] as $valore) {
            $query.=$valore.",";
        }
        // elimino la ',' rimasta in fondo alla stringa
        $query = substr($query,0,-1);

        $query.=")";
        if(mysqli_query($this->connessione,$query)){

            echo "Record aggiunto al database.";
        }
        else{
            throw new Exception("Cancellazione non riuscita: " . mysqli_error($this->connessione));
        }
        mysqli_close($this->connessione);
    }
    public function select($parametri){
        if(!$this->connessione){
            try {
                $this->connetti();
            } catch (Exception $th) {
                echo $th;
            }
        }
        $campo = $parametri["campo_ricerca"];
        $query = "SELECT ";
        $query.=$parametri["campo_ricerca"]." FROM utenti";
        echo $query."<br>";
        $dati = mysqli_query($this->connessione,$query);
        $risultato_array = array();
        if(mysqli_num_rows($dati) > 0){
            //restiuisci il risultato come un array associativo
            while($riga = mysqli_fetch_assoc($dati)){
                $risultato_array[] = $riga;
            }
            return $risultato_array;
        }
        else
        {
            echo "nessun risultato trovato<br>";
        }
    }
    public function update($parametri){
        echo "SONO IL METODO UPDATE<BR>";
    }
}
?>
