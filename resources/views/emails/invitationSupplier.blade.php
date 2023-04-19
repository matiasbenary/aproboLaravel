<!DOCTYPE html>
<html>

<head>
    <title>Ejemplo de correo electrónico</title>
</head>

<body>
    <h1>Ejemplo de correo electrónico</h1>
    {{ $entity->business_name }}
    <a href="{{ "register?code={$entity->invitation_token}" }}">registrate<a>
            <p>Este es un ejemplo de correo electrónico enviado desde Laravel.</p>
</body>

</html>
