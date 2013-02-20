<?php include "templates/include/header.php" ?>

<div data-role="page" id="clientDetail">
    <div data-role="header" data-position="fixed" data-tap-toggle="false"><h1><?php echo $results['client']->ragSociale ?></h1>
        <a href="<?php echo APP_URL ?>?action=searchClient" data-prefetch>Indietro</a>
        <a href="<?php echo TEMPLATE_PATH ?>/logoutConfirmation.php">logout</a></div>

    <div data-role="content"> 

        <div data-role="collapsible" data-collapsed="true">
            <h3>Scheda anagrafica cliente</h3>
            <ul  data-role="listview" data-theme="d" data-inset="true">
                <li><h3><?php echo $results['client']->codice . " " . $results['client']->ragSociale ?></h3></li>

                <?php $fulladdress = str_replace(chr(39), ' ', ($results['client']->indirizzo . ", " . $results['client']->cap . ", " . $results['client']->comune . ", " . $results['client']->provincia . ", " . "Italia")); //replace the ' (apostrophe) character which cause problems?> 

                <li><a href="http://maps.google.com/?q=<?php echo $fulladdress ?>"><p><?php echo ucwords(strtolower($results['client']->indirizzo . "</p><p> " . $results['client']->cap . ", " . $results['client']->comune . ", " . $results['client']->provincia)) ?></p></a></li>

                <li><p><?php echo "P.Iva: " . $results['client']->parIva ?></p></li>

                <li><p><?php echo "Categoria: " . $results['client']->categoriaSconto ?></p></li>

                <?php if (!is_null($results['client']->noTelefono)) { ?>
                    <li><a href="tel:<?php echo $results['client']->noTelefono ?>"><p><?php echo "Tel: " . $results['client']->noTelefono ?></p></a></li> <?php } ?>

                <?php if (!is_null($results['client']->noCell)) { ?>    
                    <li><a href="tel:<?php echo $results['client']->noCell ?>"><p><?php echo "Cell: " . $results['client']->noCell ?></p></a></li> <?php } ?>

                <?php if (!is_null($results['client']->noFax)) { ?>    
                    <li><p><?php echo "Fax: " . $results['client']->noFax ?></p></li> <?php } ?>

                <?php if (!is_null($results['client']->email)) { ?>       
                    <li><a href="mailto:<?php echo $results['client']->email ?>"><p><?php echo $results['client']->email ?></p></a></li> <?php } ?>

                <li><p><?php echo "Fatturato " . date('Y') . ": &#8364;" . $results['client']->fattCorrente ?></p>
                    <p><?php echo "Fatturato " . (date('Y') - 1) . ": &#8364;" . $results['client']->fattPrecedente ?></p></li>
                <li><p><?php echo "Saldo Professional: &#8364;" . $results['client']->saldoProfessional ?></p>
                    <p><?php echo "Saldo Service: &#8364;" . $results['client']->SaldoService ?></p>
                    <p>Saldo spa: n/d</p></li>
                <li><p><?php
            echo "Stato cliente: ";
            if ($results['client']->stato == 0) {
                echo "Attivo";
            } else if ($results['client']->stato == -1) {
                echo "<strong>In contenzioso</strong>";
                $clientState = "'Contenzioso'";
                echo "<script type='text/javascript'>blockedClientPopup();</script>";
            } else if ($results['client']->stato == -2) {
                echo "<strong><span style='color: crimson'>Bloccato</span></strong>";
                $clientState = "'Bloccato'";
                echo "<script type='text/javascript'>blockedClientPopup();</script>";
            }
                ?></p></li>
            </ul>

        </div> 

        <a href="<?php APP_URL ?>?action=searchItem&amp;clientId=<?php echo $results['client']->codice ?>&amp;fasciaSconto=<?php echo $results['client']->categoriaSconto ?>" data-role='button' data-icon="search" data-prefetch>Listino</a>
        <a href="<?php APP_URL ?>?action=ultimiAcquisti&amp;clientId=<?php echo $results['client']->codice ?>" data-role="button" data-icon="info">Storico acquisti</a>
        <a href="<?php APP_URL ?>?action=aqcuistiMaggiori&amp;clientId=<?php echo $results['client']->codice ?>" data-role="button" data-icon="info">Spese più importanti</a>
        <a href="<?php APP_URL ?>?action=matNonAqcuist&amp;clientId=<?php echo $results['client']->codice ?>" data-role="button" data-icon="info" class="ui-disabled" >Materiale non acquistato</a>

        <div data-role="popup" id="clientBlocked" class="ui-content" data-overlay-theme="a">
            <a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-left">Close</a>
            <h3 style="text-align: center">Attenzione!</h3>
            <p>Il cliente risulta <span style="color: crimson"><?php echo $clientState ?></span>, contattare l'amministrazione.</p>
        </div>

    </div>
</div>

<?php include "templates/include/footer.php" ?>