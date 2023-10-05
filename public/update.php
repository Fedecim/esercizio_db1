<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>update</h1>
    <p>compila il form con i campi che vuoi modificare e i nuovi valori</p>
    <p>Se i campi/valori sono piu di uno separali con una virgola.</p>
    <p>inserisci la email del contatto che vuoi modificare</p>
    <p>
        esempio : <br>
        campo : email (1 campo) 
        valore: nuovamail@email.com<br><br>
        campi : email,username(2 campi)
        valori: nuova_email@email.com, nuova_username
    </p>
    <form action="/esercizio_db1/private/processa_post.php" method="post">
        <label for="campi">campi</label>
        <input type="text" name="campi" id="campi">
        <label for="valori">valori</label>
        <input type="text" name="valori" id="valori"><br><br>
        <label for="email">email</label>
        <input type="text" name="email" id="email">
        <input type="submit" value="invia">
        <input type="hidden" name="update">
    </form><br>
    <li><a href="index.php">Torna alla homepage</a></li>
</body>
</html>