<?php include "templates/include/header.php" ?>

<div data-role="page" id="clientSalesHistory">
    <div data-role="header" data-position="fixed" data-tap-toggle="false"><h1>Ultimi acquisti <?php echo $_SESSION['ragSociale'] ?></h1>
        <a href="<?php echo APP_URL ?>?action=clientDetail&amp;clientId=<?php echo $_SESSION['clientId'] ?>&amp;back=true">Indietro</a>
        <a href="<?php echo TEMPLATE_PATH ?>/logoutConfirmation.php">logout</a></div>

    <div data-role="content">

        <div data-role="collapsible" data-collapsed="true">
            <h3>Spiegazione schermata</h3>
            <p style="font-size:small;">Questa schermata presenta tutti i acquisti dell' cliente negli ultimi sei mesi in ordine cronologico</p>

        </div>

        <ul data-role="listview" data-inset="true">
            <?php
            $mesi = array('zero', 'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre');   //translate month names in italian    
            $prevMonth = "";
            $curMonth = "";

            foreach ($results['salesHistory'] as $salesHistory) {
                ?>     

                <!-- this block generate a list separator for every month change in the <ul>-->
            <?php $curMonth = date("n", strtotime($salesHistory->dataVendita));
                  $curYear = date("Y", strtotime($salesHistory->dataVendita));
            if($prevMonth!=$curMonth){ ?>
                <!--list separator <li> -->
                <li data-role="list-divider"><?php echo $mesi[$curMonth] . " " . $curYear ?></li> 
                <?php } ?>
                <?php $prevMonth=$curMonth ?>
                
                <li><p style="font-size:x-small"><?php echo $salesHistory->dataVendita ?> - 
                        <span style="font-style: italic;"><?php echo $salesHistory->codiceArticolo ?></span>
                        <?php echo $salesHistory->DescArt ?></p><p><strong>Qta: 
                        <?php echo $salesHistory->quantitaVendita ?> - Prezzo: &#8364;                  
                            <?php echo $salesHistory->prezzoVendita ?></strong></p></li>

            <?php } ?>
        

        <?php if (count($results['salesHistory']) == 0) { ?>
            <li><p>Il cliente non acquista nulla da almeno sei mesi</p></li>
        <?php } ?>
        </ul>
    </div>


</div>


<?php include "templates/include/footer.php" ?>