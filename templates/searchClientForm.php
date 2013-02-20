<?php include "templates/include/header.php" ?>

<div data-role="page" id="clienti">
    <div data-role="header" data-position="fixed" data-tap-toggle="false"><h1>Clienti</h1>
        <a href="<?php echo TEMPLATE_PATH ?>/logoutConfirmation.php" class="ui-btn-right">logout</a></div>

    <div data-role="content">

        <form action="<?php echo APP_URL ?>" method="post">
            <input type="hidden" name="action" value="searchClient" />
            <input type="hidden" name="searchClient" value="true" />


                <fieldset data-role="controlgroup">
                    
                    <label for="clientSearchOptions[]">Opzioni ricerca:</label>
                    <select name="clientSearchOptions[]" id="searchOptions" data-native-menu="false" multiple>
                        
                        <option value="">Campo di ricerca...</option>
                        
                        <option value="ragioneSociale" <?php if (is_null($_POST['clientSearchOptions'])) echo "selected"; // Seleziona ragione sociale come predefinito
                        else if (in_array("ragioneSociale", $_POST['clientSearchOptions'])) echo "selected"; ?> >Rag. sociale</option> <!-- Mantenere le opzioni selezionate -->
                        
                        <option value="codiceCliente" <?php if (in_array("codiceCliente", $_POST['clientSearchOptions'])) echo "selected"; ?> >Cod. cliente</option>
                        
                        <option value="comune" <?php if (in_array("comune", $_POST['clientSearchOptions'])) echo "selected"; ?> >Comune</option>
                       
                        <option value="partitaIva"<?php if (in_array("partitaIva", $_POST['clientSearchOptions'])) echo "selected"; ?> >Part. IVA</option>
                    
                    </select>

                </fieldset>


                <input type="search" name="searchTerm" id="searchTerm" placeholder="Cerca cliente">
            

                <input type="submit" name="cerca" value="Cerca">

        </form>

        <input type="hidden" name="authToken" id="authToken" value="<?php echo $_SESSION['authToken'] ?>"/>

        <ul data-role="listview" data-inset="true">
            <?php foreach ($results['clients'] as $client) { ?>

                <li><a href="<?php echo APP_URL ?>?action=clientDetail&amp;clientId=<?php echo $client->codice ?>">
                        <p style="font-style: italic;"><?php echo $client->codice ?> </p>
                        <p><strong><?php echo $client->ragSociale ?></strong></p>
                        <p><?php echo $client->indirizzo . ", " . $client->comune ?> </p>
                    </a>
                </li>

            <?php } ?>
        </ul>

        <?php
        if (count($results['clients']) == 0) {
            if ($_POST['searchTerm'] != "") {
                echo "<ul data-role='listview' data-inset='true' data-theme='d'>";
                echo "<li style='color:crimson;'>nessun risultato...</li></ul>";
            }
        }
        ?>  
    </div> 

    <div data-role="footer" data-position="fixed" data-id="nav" data-tap-toggle="false">
        <div data-role="navbar">
            <ul>
                <li><a href="<?php echo APP_URL ?>?action=goHome">Home</a></li>
                <li><a href="<?php echo APP_URL ?>?action=searchClient" class="ui-btn-active ui-state-persist">Clienti</a></li>

                <?php
                if ($_SESSION['userType'] == 'admin'){
                    echo "<li><a href='" . APP_URL . "?action=getLog'>Admin</a></li>";
                    }
                ?> 
            </ul>
        </div>
    </div>

</div>

<?php include "templates/include/footer.php" ?>