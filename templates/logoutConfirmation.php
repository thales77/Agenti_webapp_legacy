<?php include "templates/include/header.php" ?>

<div data-role="dialog" id="logoutDialog">
    <div data-role="header">
        <h1>Logout</h1>
    </div>
    <div data-role="content">
        <div style="text-align: center;">
            <h2>Uscire</h2>
            <p>voi terminare l' applicazione?</p>
        </div>
        <a href="<?php echo '../index.php'?>?action=logout" data-role="button" data-ajax="false" class="ui-btn-active ui-state-persist">si</a>
        <a href="<?php echo '../index.php'?>?action=" data-role="button" data-rel="back">annulla</a>
    </div>
</div>
<?php include "templates/include/footer.php" ?>