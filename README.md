## Ejemplos ##

### Formulario ###

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

Note que se coloca el autoload porque con esto tenemos acceso a la función __session()__
que nos permite acceder a las variables de sesión colocadas en el despachador ya sea
para recuperar errores u otros mensajes, además de la función __dold()__ que sirve para
recuperar los campos del formulario y evitar que vuelvan vacios. Esta función llama a __echo()__ por lo que si se quiere solo el valor debe llamar a __old()__.

### Despachador ###
    <?php 

    use Facades\Mail;
    use Facades\Database;
    use Facades\Session;
    use Facades\Template;
    use Facades\ReCaptcha;

    require_once(__DIR__ .'/../vendor/autoload.php');

    Session::saveOlds();

    try{

        $recaptcha = ReCaptcha::default()
                        ->error(function(){
                            throw new \Exception("Error ReCaptcha", 1);
                        })
                        ->check($_POST['input_recaptcha'], $_SERVER['REMOTE_ADDR']);


        $responseHTML = Template::render('mail.php', [ 'email' => $_POST['email'] ]);

        Mail::default("Mensaje de prueba")
            ->setTo($_POST['email'])
            ->setBody($responseHTML, 'text/html')
            ->send();

        Database::default()
            ->setTable('records')
            ->insert([
                'name' => $_POST['name'],
                'email' => $_POST['email']
            ]);
    }
    catch(\Exception $e){
        session('error', true);
        session('message', 'Ha ocurrido un error');
        back();
    }

    session('success', true);
    session('message', 'exito');
    back();

Se hace uso de las fachadas, como __Mail__ que devuelve un objeto que extiende de 
__Swift_Mailer__ por lo que puede revisar la documentación correspondiente [AQUI](https://swiftmailer.symfony.com/docs/introduction.html).

Para la fachada __Template__ tiene un único méthodo estático que funciona para recuperar
el contenido del archivo pasándole las variables mediante un array relacional como la función __view()__ de Laravel.

Para __Database__ se usa la siguiente libreria [Nette Database](https://doc.nette.org/en/3.1/database).

Para la fachada de __Session__ documentación pendiente.

Para __Template__ utiliza el motor de Symfony __Twig__ por lo que puedes ver su documentación [AQUI](https://twig.symfony.com/).

Para ReCaptcha utiliza casi los mismo métodos que la libreria de [Google ReCaptcha](https://packagist.org/packages/google/recaptcha) pero con unas modificaciones para que se pueda encadenar también la callback para error y éxito.