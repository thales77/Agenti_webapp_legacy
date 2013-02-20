<?php include "templates/include/header.php" ?>

<div data-role="page" id="listino">
    <div data-role="header" data-position="fixed" data-tap-toggle="false"><h3>Listino <?php echo $_SESSION['ragSociale'] ?></h3>
        <a href="<?php echo APP_URL ?>?action=clientDetail&amp;clientId=<?php echo $_SESSION['clientId'] ?>&amp;back=true">Indietro</a>
        <a href="<?php echo TEMPLATE_PATH ?>/logoutConfirmation.php">logout</a></div>

    <div data-role="content">

        <form action="<?php echo APP_URL ?>" method="post">
            <input type="hidden" name="action" value="searchItem" />
            <input type="hidden" name="searchItem" value="true" />


                <fieldset data-role="controlgroup">

                    <label for="itemSearchOptions[]">Opzioni ricerca:</label>
                    <select name="itemSearchOptions[]" id="searchOptions" data-native-menu="false" multiple>

                        <option value="">Campo di ricerca...</option>

                        <?php
                        if (!is_null($_SESSION['itemSearchOptions'])) {
                            $options = $_SESSION['itemSearchOptions'];
                        } else {
                            $options = $_POST['itemSearchOptions'];
                        }
                        ?>

                        <option value="descrizione" <?php
                        if (is_null($options))
                            echo "selected"; // Seleziona ragione sociale come predefinito 
                        else if (in_array("descrizione", $options))
                            echo "selected";
                        ?> >Descrizione</option>

                        <option value="codiceSider" <?php if (in_array("codiceSider", $options)) echo "selected"; ?> >Cod. Sider.</option>

                        <option value="codiceForn" <?php if (in_array("codiceForn", $options)) echo "selected"; ?> >Cod. Fornitore</option>
                    </select>

                </fieldset>


                <input type="search" name="searchTerm" id="searchTerm" placeholder="Cerca articolo">

                <input type="submit" name="cerca" value="Cerca">
        </form>

        <input type="hidden" name="authToken" id="authToken" value="<?php echo $_SESSION['authToken'] ?>"/>

        <ul data-role="listview" data-inset="true"> 
            <?php
            foreach ($results['items'] as $item) {
                if (is_null($item->prezzoProm)) {
                    $prezzo = $item->prezzoNetto;
                } else {
                    $prezzo = $item->prezzoProm;
                }
                ?>



                <li><a href="<?php echo APP_URL ?>?action=itemDetail&amp;itemId=<?php echo $item->codiceArticolo ?>">
                        <p style="font-style: italic;"><?php echo $item->codiceArticolo ?></p>
                        <p><?php echo $item->fornitoreArticolo ?> - Art. <?php echo $item->codForn1?></p>
                        <p><strong><?php echo $item->descrizione ?></strong></p>

                        <p class="ui-li-aside" style="color:crimson; font-size:3;"><strong>&#8364;<?php echo $prezzo ?>  </strong></p></a></li> 

            <?php } ?>
        </ul>
        <?php
        if (count($results['items']) == 0) {
            if ($_POST['searchTerm'] != "") {
                echo "<ul data-role='listview' data-inset='true' data-theme='d'>";
                echo "<li style='color:crimson;'>nessun risultato...</li></ul>";
            }
        }
        ?>




    </div>


</div>



<?php include "templates/include/footer.php" ?>