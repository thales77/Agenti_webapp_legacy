<?php include "templates/include/header.php" ?>

<div data-role="page" id="logDetail">
    <div data-role="header" data-position="fixed" data-tap-toggle="false"><h1>Log</h1>
        <a href="<?php echo TEMPLATE_PATH ?>/logoutConfirmation.php" class="ui-btn-right">logout</a></div>

    <div data-role="content">
                
        <ul data-role="listview" data-inset="true">
            <?php 
                        
            foreach ($results['log'] as $logEntry) { ?>     
            
                        
                <li><p style="font-size:x-small;"> <span style="font-style: italic;"><?php echo $logEntry->logTimestamp ?></span>
                        <span style="font-weight: bold"><?php echo $logEntry->logIp ?></span></p>
                    <p style="font-size:x-small;">
                       <?php echo $logEntry->logDescr ?></p></li>            
            <?php } ?>
        

        <?php if (count($results['log']) == 0) { ?>
            <li><p>Non c'è nessun record per oggi <?php echo date('d/m/Y')?></p></li></ul>
        <?php } ?>
    </div>
    
<div data-role="footer" data-position="fixed" data-id="nav" data-tap-toggle="false">
        <div data-role="navbar">
            <ul>
                <li><a href="<?php echo APP_URL?>?action=goHome">Home</a></li>
                <li><a href="<?php echo APP_URL?>?action=searchClient" data-prefetch>Clienti</a></li>
                <li><a href="<?php echo APP_URL?>?action=getLog" class="ui-btn-active ui-state-persist">Admin</a></li>
            </ul>
        </div>
    </div>

</div>


<?php include "templates/include/footer.php" ?>