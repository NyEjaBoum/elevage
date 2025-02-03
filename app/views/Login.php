<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion / Inscription</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 14px 28px rgba(0,0,0,0.08), 0 10px 10px rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
            width: 768px;
            max-width: 100%;
            min-height: 480px;
        }
        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            width: 50%;
            transition: all 0.6s ease-in-out;
        }
        .signin-container {
            left: 0;
            z-index: 2;
            opacity: 0;
            visibility: hidden;
        }
        .login-container {
            left: 0;
            z-index: 1;
            opacity: 1;
            visibility: visible;
        }
        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }
        .overlay {
            background: linear-gradient(to right, #FF5A5F, #FF385C);
            color: white;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }
        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transition: all 0.6s ease-in-out;
        }
        .overlay-right {
            right: 0;
            transform: translateX(0);
        }
        .overlay-left {
            transform: translateX(-20%);
        }
        form {
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            height: 100%;
            text-align: center;
        }
        input {
            background-color: #eee;
            border: none;
            padding: 12px 15px;
            margin: 8px 0;
            width: 100%;
            border-radius: 5px;
        }
        button {
            border-radius: 20px;
            border: 1px solid #FF5A5F;
            background-color: #FF5A5F;
            color: white;
            font-size: 12px;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 80ms ease-in;
            margin-top: 10px;
            cursor: pointer;
        }
        .container.right-panel-active .signin-container {
            transform: translateX(100%);
            opacity: 1;
            visibility: visible;
            z-index: 5;
        }
        .container.right-panel-active .login-container {
            transform: translateX(100%);
            opacity: 0;
            visibility: hidden;
        }
        .container.right-panel-active .overlay-container {
            transform: translateX(-100%);
        }
        .container.right-panel-active .overlay {
            transform: translateX(50%);
        }
        .container.right-panel-active .overlay-left {
            transform: translateX(0);
        }
        .container.right-panel-active .overlay-right {
            transform: translateX(20%);
        }
    </style>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container signin-container">
            <form action="signin" method="POST">
                <h1>Créer un compte</h1>
                <input type="text" placeholder="Nom" name="nom" required>
                <button type="submit">S'inscrire</button>
            </form>
        </div>
        <div class="form-container login-container">
            <form action="login" method="POST">
                <h1>Connexion</h1>
                <input type="text" placeholder="nom" name="nom"  required>
                <button type="submit">Se connecter</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Bon retour !</h1>
                    <p>Pour rester connecté, connectez-vous avec vos informations personnelles</p>
                    <button id="login">Se connecter</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Bonjour !</h1>
                    <p>Inscrivez-vous et commencez votre aventure</p>
                    <button id="signup">S'inscrire</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById('container');
        const loginButton = document.getElementById('login');
        const signupButton = document.getElementById('signup');

        signupButton.addEventListener('click', () => {
            container.classList.add('right-panel-active');
        });

        loginButton.addEventListener('click', () => {
            container.classList.remove('right-panel-active');
        });
    </script>
</body>
</html>