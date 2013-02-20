<?php foreach ($results['salesHistory'] as $salesHistory) { ?>

 
            <li><p style="font-size:x-small"><?php echo $salesHistory->dataVendita ?> - 
                <?php echo $salesHistory->filialeVendita ?> -  Qta:                    
                <?php echo $salesHistory->quantitaVendita ?> - <strong>&#8364;                  
                <?php echo $salesHistory->prezzoVendita ?></strong></p></li>

<?php } ?>

<?php if (count($results['salesHistory']) == 0) { ?>
            <li><p>Il cliente non ha acquistato l'articolo</p></li>
<?php } ?>