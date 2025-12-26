<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Patient</title>
</head>
<body>
    <h1>AI Analysis for {{ $patient->name }}</h1>
    <p><strong>Result:</strong> {{ $result['label'] }}</p>
    <p><strong>Confidence Level:</strong> {{ number_format($result['confidence'] * 100, 2) }}%</p>
</body>
</html>
