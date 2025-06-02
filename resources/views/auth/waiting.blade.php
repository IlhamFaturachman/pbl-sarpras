<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil</title>
    <!-- Bootstrap 5 CDN (opsional jika ingin tampilan rapi) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center mt-5">
        <h2>Pendaftaran Berhasil</h2>
        @if (session('status'))
            <p class="mt-3">{{ session('status') }}</p>
        @endif
        <p>Silakan tunggu verifikasi dari admin untuk dapat login.</p>
    </div>
</body>
</html>
