<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification compte </title>
</head>
<body>
    <h1>Bonjour, {{ $utilisateur->nom }}</h1>
    <p>Merci de vous être inscrit. Veuillez cliquer sur le bouton ci-dessous pour valider votre adresse e-mail :</p>
    <a href="{{ $url }}" style="background-color: blue; color: white; padding: 10px 20px; text-decoration: none;">Valider mon e-mail</a>
</body>
</html>
