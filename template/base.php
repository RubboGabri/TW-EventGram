<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $templateParams["title"]; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/png" href="img/AppIcon.png"/>
    <link href="css/custom_background.css" rel="stylesheet"/>
</head>
<body class="gradient-background">
    <?php if (isset($templateParams["navbar"])): ?>
        <?php require($templateParams["navbar"]); ?>
    <?php endif; ?>

    <main class="container">
        <?php if (isset($templateParams["main"])): ?>
            <?php require($templateParams["main"]); ?>
        <?php endif; ?>
    </main>

    <script>
    <?php foreach ($_GET as $key => $val): ?>
        const <?php echo $key; ?> = "<?php echo $val; ?>";
    <?php endforeach; ?>
    </script>

    <?php if (isset($templateParams["js"])): ?>
        <?php foreach ($templateParams["js"] as $script): ?>
            <script src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
