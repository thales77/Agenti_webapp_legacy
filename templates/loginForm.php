<?php include "templates/include/header.php" ?>

<div data-role="page" id="loginForm">
    <div data-role="header" data-position="fixed" data-tap-toggle="false"><h1>CRM Agenti</h1></div>
    <div data-role="content">

        <div style="text-align: center;">
            <img src="images/logo.png" width="200" alt="Logo">
        </div>

        <form action="<?php echo APP_URL ?>" method="post" data-transition="fade">

            <input type="hidden" name="action" value="login" />
            <input type="hidden" name="login" value="true" />


                <input type="text" name="username" id="username" placeholder="Utente" required autofocus maxlength="50">



                <input type="password" name="password" id="password" placeholder="Password" required maxlength="30">


                <input type="submit" name="login" value="Login">

        </form>

    </div>

</div>      

<?php include "templates/include/footer.php" ?>