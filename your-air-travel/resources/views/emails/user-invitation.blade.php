<!DOCTYPE html>
<html>
<head>
    <title>Welkom bij YourAirTravel</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <h2>Hallo {{ $user->name }},</h2>

    <p>Je bent uitgenodigd als beheerder voor het YourAirTravel dashboard!</p>

    <p>Klik op de onderstaande link om je eigen, veilige wachtwoord in te stellen en direct in te loggen. <br>
    <em>Let op: deze veiligheidslink verloopt na exact 24 uur!</em></p>

    <p>
        <a href="{{ $inviteUrl }}" style="background-color: #2596be; color: white; padding: 10px 20px; text-decoration: none; font-weight: bold; border-radius: 5px; display: inline-block; margin-top: 10px;">
            Wachtwoord Instellen
        </a>
    </p>

    <p>Groetjes,<br>Team YourAirTravel</p>
</body>
</html>
