<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>select</h1>
    <p>compila il form per richiedere e visualizzare dati dal database</p>
    <p>In campo ricerca inserisci i dati che vuoi ottenere se sono piu di 1 separali da una virgola
        se vuoi ottenere tutti i campi non inserire nulla
        es: 
        campo ricerca : email
        campo ricerca : email,username
    </p>
    <p>
    Aggiungi una Condizione (Opzionale)
    Se vuoi filtrare i risultati basandoti su una condizione specifica, compila i campi "Campo Condizione" e "Valore Condizione".
    </p>
    <form action="/esercizio_db1/private/processa_post.php" method="post">
        <label for="campo_ricerca">campo ricerca</label>
        <input type="text" name="campo_ricerca" id="campo_ricerca" placeholder="*">
        <label for="col_cond">campo condizione</label>
        <input type="text" name="col_cond" id="col_cond">
        <label for="valore_cond">valore condizione</label>
        <input type="text" name="condizione" id="condizione">
        <input type="submit" value="invia">
        <input type="hidden" name="select">
    </form><br>
    <li><a href="index.php">Torna alla homepage</a></li>
</body>
</html>