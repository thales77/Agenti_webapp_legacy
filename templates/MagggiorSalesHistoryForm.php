<?php include "templates/include/header.php" ?>

<div data-role="page" id="maggiorSalesHistory">
    <div data-role="header" data-position="fixed" data-tap-toggle="false"><h1>Maggiori acquisti <?php echo $_SESSION['ragSociale'] ?></h1>
        <a href="<?php echo APP_URL ?>?action=clientDetail&amp;clientId=<?php echo $_SESSION['clientId'] ?>&amp;back=true">Indietro</a>
        <a href="<?php echo TEMPLATE_PATH ?>/logoutConfirmation.php">logout</a></div>

    <div data-role="content">
        
        <div data-role="collapsible" data-collapsed="true">
            <h3>Spiegazione schermata</h3>
            <p>Questa schermata aggrega tutti i acquisti del cliente dal inizio dell'anno scorso
            fino ad oggi per articolo, in ordine di valore. Il valore totale per ogni articolo deve essere superiore €100.</p>
            
        </div>
        
        
        <ul data-role="listview" data-inset="true">
            <?php 
                        
            foreach ($results['salesHistory'] as $salesHistory) { ?>     
            
                        
                <li><p style="font-size:x-small;"> <span style="font-style: italic;"><?php echo $salesHistory->codiceArticolo ?></span>
                        <span style="font-weight: bold"><?php echo $salesHistory->DescArt ?></span></p>
                    <p style="font-size:x-small;">
                        Qta: <?php echo $salesHistory->quantitaVendita ?> - 
                        Prezzo medio: &#8364;<?php echo $salesHistory->prezzoMedio ?></p>
                    <p style="font-size:small;">
                        Valore totale: <span style="color: crimson">&#8364;<?php echo $salesHistory->valoreReale ?></span></p></li>
            
            <?php } ?>
        

        <?php if (count($results['salesHistory']) == 0) { ?>
            <li><p>Il cliente non acquista nulla da almeno l'inizio del <?php echo date('Y')-1?></p></li>
        <?php } ?>
         </ul>
    </div>


</div>


<?php include "templates/include/footer.php" ?>