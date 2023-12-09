<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
    <link rel="stylesheet" href="{{asset('assets/bootstrap/dist/css/bootstrap.min.css')}}">
</head>
<body>
    <div class="container p-5">
        <a href="{{route('users.index')}}" class="btn btn-warning mb-2">Retour</a>

        <div class="">
            <div class="card">
                <div class="card-body">
                    Utilisateur ajouté avec succès
                </div>
                <div class="card-footer">
                    <h2>Information de l'utilisateur ajouté :</h2>
                    <table>
                        <tr>
                            <td>Nom</td>
                            <td>: <strong>{{$user->nom}}</strong></td>
                        </tr>
                        <tr>
                            <td>Prénom</td>
                            <td>: <strong>{{$user->prenom}}</strong></td>
                        </tr>
                        <tr>
                            <td>Adresse email</td>
                            <td>: <strong>{{$user->email}}</strong></td>
                        </tr>
                        <tr>
                            <td>Mot de passe</td>
                            <td>: <strong>{{$mdp}}</strong></td>
                        </tr>
                    </table>
                    
                        <ul>
                            <li>Ce mot de passe est générer automatiquement, copier le mot de passe.</li>
                            <li>Cliquer le bouton envoyer pour lui envoyer un email en mentionnant le mot de passe dans le mail.</li>
                        </ul>
                        <div class="text-center">
                            <a href="mailto:{{$user->email}}" class="btn btn-info">Envoyer un mail</a>
                            <a href="{{route('users.edit', $user->id)}}" class="btn btn-primary">Lui affecter un rôle</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>