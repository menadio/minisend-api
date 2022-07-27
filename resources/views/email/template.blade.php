<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minisend</title>
</head>

<body>
    @if ($email->emailBody->body === strip_tags($email->emailBody->body))
        {{ str_replace('&nbsp', 'nl2br', $email->emailBody->body) }}
    @else
        {!! $email->emailBody->body !!}
    @endif
</body>

</html>