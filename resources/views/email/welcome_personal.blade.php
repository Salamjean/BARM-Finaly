<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Personnel BARM</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 300;
        }
        .content {
            padding: 40px 30px;
        }
        .welcome-text {
            font-size: 18px;
            margin-bottom: 30px;
            color: #555;
        }
        .credentials-box {
            background-color: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 25px;
            margin: 25px 0;
        }
        .credential-item {
            margin-bottom: 15px;
        }
        .credential-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 5px;
            display: block;
        }
        .credential-value {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 10px 15px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            color: #212529;
            word-break: break-all;
        }
        .login-button {
            display: inline-block;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 20px;
            transition: transform 0.2s;
        }
        .login-button:hover {
            transform: translateY(-2px);
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .important-note {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            .container {
                margin: 0;
            }
            .header, .content, .footer {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bienvenue sur BARM</h1>
            <p>Vos accès personnel ont été créés</p>
        </div>
        
        <div class="content">
            <div class="welcome-text">
                Bonjour <strong>{{ $user->firstname }} {{ $user->lastname }}</strong>,
                <br><br>
                Votre compte personnel a été créé avec succès. Voici vos informations de connexion :
            </div>
            
            <div class="credentials-box">
                <div class="credential-item">
                    <span class="credential-label">Nom d'utilisateur :</span>
                    <div class="credential-value">{{ $user->username }}</div>
                </div>
                
                <div class="credential-item">
                    <span class="credential-label">Mot de passe :</span>
                    <div class="credential-value">{{ $password }}</div>
                </div>
            </div>
            
            <div class="important-note">
                <strong>⚠️ Important :</strong> Veuillez changer votre mot de passe lors de votre première connexion pour des raisons de sécurité.
            </div>
            
            <div style="text-align: center;">
                <a href="{{ url('/login') }}" class="login-button">
                    Se connecter maintenant
                </a>
            </div>
        </div>
        
        <div class="footer">
            <p>Cet email a été envoyé automatiquement. Ne répondez pas à cet email.</p>
            <p>© {{ date('Y') }} BARM - Tous droits réservés</p>
        </div>
    </div>
</body>
</html>
