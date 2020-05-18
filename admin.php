<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
$options = json_decode(file_get_contents(__DIR__ . '/options.json'), true);
$_SESSION['login'] = $_POST['login'] ?? $_SESSION['login'] ?? false;
$_SESSION['pass'] = $_POST['pass'] ?? $_SESSION['pass'] ?? false;
?>
<html>
<head></head>
<body>

<?php if ($options['login'] == ($_SESSION['login'] ?? '') && $options['pass'] == ($_SESSION['pass'] ?? '')) {

    if (!empty($_POST['total'])) {
        $options['total'] = $_POST['total'];
        file_put_contents(__DIR__ . '/options.json', json_encode($options));
    }
    ?>
    <form method="post">
        <div>
            <p>
                <label>Total</label>
                <input name="total" type="number" value="<?php echo $options['total']; ?>"/>
            </p>
            <p>
                <button type="submit">Save</button>
            </p>
        </div>
    </form>
<?php } else { ?>

    <form method="post">
        <div style="width: 300px;margin: 10em auto;">
            <p>
                <label>Login</label><br/>
                <input name="login" type="text"/>
            </p>
            <p>
                <label>Password</label><br/>
                <input name="pass" type="password"/>
            </p>
            <p>
                <button type="submit">Submit</button>
            </p>
        </div>

    </form>


<?php } ?>

</body>
</html>


