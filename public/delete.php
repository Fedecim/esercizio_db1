<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>delete</h1>
    <p>compila il form con l indirizzo email del record che vuoi eliminare</p>
    <form action="/esercizio_db1/private/processa_post.php" method="post">
        <label for="email">email</label>
        <input type="text" name="email" id="email">
        <input type="submit" value="invia">
        <input type="hidden" name="delete">
    </form><br>
    <li><a href="index.php">Torna alla homepage</a></li>
</body>
</html>