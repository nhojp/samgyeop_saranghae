<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Samgyeop Saranghae</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    

    <style>
        *{
            font-family: 'Poppins', sans-serif;
        }
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            background-color: black;
            color: white;
            display: flex;
            flex-direction: column;
        }
        .card-img-container {
    position: relative;
    overflow: hidden;
    height: 200px;
}

.card-img-top {
    object-fit: cover;
    width: 100%;
    height: 100%;
}

.card-body {
    position: relative;
}

.card-text-1 {
    opacity: 0;
    max-height: 0;
    transition: opacity 0.3s ease, max-height 0.3s ease;
    overflow: hidden;
}

.card:hover .card-text {
    opacity: 1;
    max-height: 100%; /* Adjust to your preferred height for description visibility */
}
.payment-tab-img {
    width: 100%;
    height: 40px;
}
.menu-img {
    width: 100%;
    height: 100%;
}

    </style>
</head>

<body>