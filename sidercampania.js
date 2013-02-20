$(document).bind( "mobileinit", function() {
    $.mobile.defaultPageTransition = 'none';
    $.mobile.allowCrossDomainPages = true;
    $.mobile.loadingMessage = "Attendere...";
} );

            

$("#itemDetails").live("pageinit", function() {
    $("#generate").click(function(){  
        console.log("Getting remote list");
        $.mobile.showPageLoadingMsg();
        $.get("index.php?action=storicoPrezzi", {}, function(res) {
            /*
                        var output="<ul>";
                        for (var i in res.salesHistory) {
                            output+="<li><p style='font-size:x-small'>" + res.salesHistory[i].dataVendita + " - "
                                + res.salesHistory[i].filialeVendita + " -  Qta:"
                                + res.salesHistory[i].quantitaVendita + " - <strong>&#8364;"
                                + res.salesHistory[i].prezzoVendita + "</strong></p></li>";
                        }
                        
                        output+="</ul>"; */                                           
                        
            $.mobile.hidePageLoadingMsg();
            $("#history").html(res);
            $("#history").listview("refresh");
        });
                    
    });
                
});
            
            
            
function blockedClientPopup() {   
    setTimeout(function(){
        $('#clientBlocked').popup( {history: false} );
        $('#clientBlocked').popup( 'open');
    },1000);
}

function firstAccessPopup() {   
    setTimeout(function(){
        $('#firstAccess').popup( {history: false, dismissable: false} );
        $('#firstAccess').popup('open');
    },1000);
}