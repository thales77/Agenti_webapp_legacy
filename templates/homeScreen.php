<?php include "templates/include/header.php" ?>

<div data-role="page" id="home">
    <div data-role="header" data-position="fixed" data-tap-toggle="false"><h1>CRM Agenti</h1>
        <a href="<?php echo TEMPLATE_PATH ?>/logoutConfirmation.php" class="ui-btn-right">logout</a></div>
    <div data-role="content">

        <div style="text-align: center;">
            <img src="images/logo.png" width="200" alt="Logo">
        </div>

        <div style="text-align: center;">
            <h2>Ciao <?php echo ucfirst($_SESSION['userId']); ?></h2>
        </div>

        <div data-role="collapsible" data-collapsed="true" data-theme="b">
            <h3>Nuova funzione di ricerca</h3>
            <p>E disponibile la nuova funzione di ricerca clienti per <span style="color:crimson;">comune</span>.
               Adesso è possibile effettuare una ricerca clienti, inserendo il nome del comune di appartenenza desiderato
               e selezionando l'opzione "comune" dal menu di ricerca. Per domande, contattare il sig. Boikos</p>
        </div>

    </div>

   <div data-role="popup" id="firstAccess" class="ui-content" data-overlay-theme="a">

        <h3>Per effetuare il primo accesso deve cambiare la sua password.</h3>
        <p>La password deve essere alfanumerica, con lunghezza tra 8 e 20 caratteri.</p>

        <form method="POST" action="<?php echo APP_URL ?>?action=changePassword" name="changePasswordForm">

            <label for="password" class="ui-hidden-accessible">Nuova password:</label> <input name="password" type="password" value="" placeholder="Nuova password"  id="password"  required maxlength="20">
            <label for="confirmpw" class="ui-hidden-accessible">Ripeti:</label> <input name="confirmpw" type="password" value="" placeholder="Ripeti" id="confirmpw" required maxlength="20">
            <div data-role="fieldcontain"><input type="submit" class="button" name="submit" value="Avanti" /></div>

        </form>

    </div>



    <div data-role="footer" data-position="fixed" data-id="nav" data-tap-toggle="false" >
        <div data-role="navbar">
            <ul>
                <li><a href="<?php echo APP_URL ?>?action=goHome" class="ui-btn-active ui-state-persist">Home</a></li>
                <li><a href="<?php echo APP_URL ?>?action=searchClient" data-prefetch>Clienti</a></li>

                <?php
                if ($_SESSION['userType'] == 'admin'){
                    echo "<li><a href='" . APP_URL . "?action=getLog'>Admin</a></li>";
                    }
                if ($_SESSION['firstAccess'] == 1) {
                echo "<script type='text/javascript'>firstAccessPopup();</script>";
            }
                ?> 

            </ul>
        </div>
    </div>
</div>

<?php include "templates/include/footer.php" ?>