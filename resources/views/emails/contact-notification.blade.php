<!DOCTYPE html>
<html>

<head>
    <title>New Contact Message</title>
</head>

<body>
    <h1>New Contact Message</h1>
    <p>You have received a new contact message:</p>
    <p><strong>Name:</strong> {{ $contactMessage->name }}</p>
    <p><strong>Email:</strong> {{ $contactMessage->email }}</p>
    <p><strong>Message:</strong> {{ $contactMessage->message }}</p>
    <p>This message was sent on {{ $contactMessage->created_at->format('d F Y H:i') }}.</p>
</body>

</html>
