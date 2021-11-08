<?php include('../vendor/autoload.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example form</title>
</head>
<body>
    <form action="dispatcher.php" method="post">
        <input type="text" name="name" id="" value="<?php dold('name') ?>">
        <input type="email" name="email" id="" value="<?php dold('email') ?>">
        <button type="submit">Submit</button>
    </form>

    <?php if(session('success')){ ?>
        <script>
            alert("<?php echo(session('message')); ?>");
        </script>
    <?php } else if(session('error')) { ?>
        <script>
            alert("<?php echo(session('message')); ?>");
        </script>
    <?php } ?>
</body>
</html>