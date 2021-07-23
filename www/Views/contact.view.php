<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Formulaire de contact</title>
</head>
<body>
<h1>Vous avez des idées ?</h1>
<?php if (!empty($msg)) {
    echo "<h2>$msg</h2>";
} ?>
<form method="POST">
    <label for="name">Nom: <input type="text" name="name" id="name"></label><br><br>
    <label for="email">E-mail: <input type="email" name="email" id="email"></label><br><br>
    <label for="message">Message: <textarea name="message" id="message" rows="8" cols="20"></textarea></label><br><br>
    <input type="submit" value="Envoyer">
</form>
</body>
</html>