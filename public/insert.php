<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>insert</h1>
    <p>compila il form con i dati per aggiungere record al database</p>
    <form action="/esercizio_db1/private/processa_post.php" method="post">
        <label for="username">username</label>
        <input type="text" name="username" id="username">
        <label for="password">password</label>
        <input type="text" name="password" id="password">
        <label for="email">email</label>
        <input type="text" name="email" id="email">
        <input type="submit" value="invia">
        <input type="hidden" name="insert">
    </form><br>
    <li><a href="index.php">Torna alla homepage</a></li>
</body>
</html>