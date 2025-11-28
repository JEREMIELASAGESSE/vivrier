<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/login.css">
    <title>AUTHENTIFICATION</title>
</head>

<body>
    <form method="POST" action="authenticate.php">
        <h1><strong>Identifiez Vous !</strong></h1>
        <input type="text" name="user" placeholder="Utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
    </form>
    <script>
        document.querySelector("form").addEventListener("submit", function(e) {
            const username = document.querySelector("input[name='user']").value.trim();
            const password = document.querySelector("input[name='password']").value;

            // Vérification basique
            if (username.length < 3) {
                alert("Le nom d'utilisateur doit contenir au moins 3 caractères.");
                e.preventDefault();
                return;
            }

            if (password.length < 6) {
                alert("Le mot de passe doit contenir au moins 6 caractères.");
                e.preventDefault();
                return;
            }

            // Empêcher les caractères dangereux
            const regex = /[<>]/;
            if (regex.test(username) || regex.test(password)) {
                alert("Les caractères < et > sont interdits.");
                e.preventDefault();
            }
        });
    </script>

</body>

</html>