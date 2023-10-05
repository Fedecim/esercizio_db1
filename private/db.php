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

    public function delete($tabella,$colonna,$condizione){
        // DELETE FROM table_name WHERE some_column = some_value 
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
        // INSERT INTO table_name (column1, column2, column3,...)VALUES (value1, value2, value3,...)
        $nomeTab = $parametri["nome_tab"];
        $colonne = $parametri["campi"];
        $valori = $parametri["valori"];
        // colonne and valori must be the same dimension (number of elements)
        if(!$this->connessione){
            try {
                $this->connetti();
            } catch (Exception $th) {
                echo $th;
            }
        }
        $query = "INSERT INTO ".$nomeTab."(";
        foreach ($colonne as $colonna) {
            $query.=$colonna.",";
        }
        // elimino la ',' rimasta in fondo alla stringa
        $query = substr($query,0,-1);
        $query.=")VALUES(";
        foreach ($valori as $valore) {
            $query.=$valore.",";
        }
        // elimino la ',' rimasta in fondo alla stringa
        $query = substr($query,0,-1);
        $query.=")";

        echo $query;

        if(mysqli_query($this->connessione,$query)){

            echo "Record aggiunto al database.";
        }
        else{
            throw new Exception("Inserimento dati non riuscito: " . mysqli_error($this->connessione));
        }
        mysqli_close($this->connessione);
    }
    public function select($parametri){
        // SELECT column_name(s) FROM table_name WHERE column_name operator value  
        $colonne = $parametri["colonne"];
        $nome_tab = $parametri["nome_tab"];
        $col_cond = $parametri["col_cond"];
        $condizione = $parametri["condizione"];
        if(!$this->connessione){
            try {
                $this->connetti();
            } catch (Exception $th) {
                echo $th;
            }
        }
        $query = "SELECT ";
        $campi = [];
        foreach ($colonne as $colonna) {
            $query.=$colonna.",";
        }
        $query = substr($query,0,-1);
        $query.=" FROM ".$nome_tab;
        // controllo se esiste la condizione (nel caso aggiungere where alla query)
        if($condizione !== ""){
            $query.=" WHERE ".$col_cond."=".$condizione;
        }
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
        /*
        query = UPDATE nome_tab SET colonna = nuovo_valore WHERE colonna = condizione
        esempio :
        $sql = "UPDATE MyGuests SET lastname='Doe' WHERE id=2";
        */
        $nome_tab = $parametri["nome_tab"];
        $campi = $parametri["campi"];
        $valori = $parametri["valori"];
        $col_cond = $parametri["col_cond"];
        $condizione = $parametri["condizione"];
        // tento connessione 
        if(!$this->connessione){
            try {
                $this->connetti();
            } catch (Exception $th) {
                echo $th;
            }
        }
        // preparo la query
        // preparo la query update
        $query = "UPDATE ".$nome_tab." SET ";
        for ($i=0; $i < count($valori) ; $i++) { 
            $query.=$campi[$i]." = ".$valori[$i].",";
        }
        // elimino la ',' rimasta in fondo alla stringa
        $query = substr($query,0,-1);
        $query.=" WHERE ".$col_cond." = ".$condizione;
        echo $query;
        // lancio la query
        if(mysqli_query($this->connessione,$query)){
            if(mysqli_affected_rows($this->connessione) == 0){
                return false;
            }
            echo "Modifica avvenuta con successo.<br>";
        }
        else{
            throw new Exception("Modifica non riuscita: " . mysqli_error($this->connessione));
        }
        mysqli_close($this->connessione);
    }
}
?>
