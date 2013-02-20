<?php include "templates/include/header.php" ?>

<div data-role="page" id="itemDetails">
    <div data-role="header" data-position="fixed" data-tap-toggle="false"><h1>Listino <?php echo $_SESSION['ragSociale'] ?></h1>
        <a href="<?php echo APP_URL ?>?action=searchItem&amp;searchTerm=<?php echo $_SESSION['searchTerm'] ?>" data-prefetch>Indietro</a>
        <a href="<?php echo TEMPLATE_PATH ?>/logoutConfirmation.php">logout</a></div>

    <div data-role="content">
        <?php
        if (is_null($results['item']->prezzoProm)) {
            $prezzo = $results['item']->prezzoNetto;
        } else {
            $prezzo = $results['item']->prezzoProm . "<p> Articolo in promozione fino il: " . $results['item']->scadenzaProm . "</p><p>" . $results['item']->descProm . "</p>";
        }
        ?>
        <div data-role="fieldcontain">
            <ul data-role="listview" data-theme="d" data-inset="true">
                <li><p><strong><?php echo $results['item']->codiceArticolo ?> <?php echo $results['item']->descrizione ?></strong></p>
                    <p><?php echo $results['item']->codForn1 ?>  <?php echo $results['item']->codForn2 ?></p>
                    <p><?php echo $results['item']->fornitoreArticolo ?></p></li>
                <li><p><strong>Disponibilità:</strong></p>
                    <p>Casoria:  <strong><?php echo $results['item']->dispCa ?></strong></p>
                    <p>Caserta:  <strong><?php echo $results['item']->dispCe ?></strong></p>
                    <p>Pozzuoli: <strong><?php echo $results['item']->dispPo ?></strong></p></li>
                <li><p>Prezzo lordo: <strong>&#8364;<?php echo $results['item']->prezzoLordo ?></strong></p><p>Sconti applicati: <strong><?php echo $results['item']->sconto1 ?>%  +  <?php echo $results['item']->sconto2 ?>%</strong></p></li>
                <li><p>Prezzo finale: <span style="color:crimson;"><strong>&#8364;<?php echo $prezzo ?></strong></span></p></li> 
            </ul>
        </div>
        <div data-role="fieldcontain">
            <a href="#" id="generate" data-role="button" data-icon="plus" >Storico prezzi applicati a<br /> <?php echo ucwords(strtolower($_SESSION['ragSociale'])) ?> </a>
            
            <ul data-role="listview" data-theme="d" data-inset="true" id="history">
            </ul>
        </div>
    </div>


</div>


<?php include "templates/include/footer.php" ?>