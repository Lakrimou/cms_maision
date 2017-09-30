$(document).ready(function() {
    var panels = $('.vote-results');
    var panelsButton = $('.dropdown-results');
    panels.hide();

    //Click dropdown
    panelsButton.click(function() {
        //get data-for attribute
        var dataFor = $(this).attr('data-for');
        var idFor = $(dataFor);

        //current button
        var currentButton = $(this);
        idFor.slideToggle(400, function() {
            //Completed slidetoggle
            if(idFor.is(':visible'))
            {
                currentButton.html('Hide Results');
            }
            else
            {
                currentButton.html('View Results');
            }
        })
    });
});

/*======================Navigation bouton modal=================*/

$('.chambres-booking').click(function (e) { $('.nav-tabs li a[href="#chambres-booking"]').tab('show');});

$('.see-services').click(function (e) { $('.nav-tabs li a[href="#services-booking"]').tab('show');
});
$('.events-modal').click(function (e) { $('.nav-tabs li a[href="#evenements-booking"]').tab('show');
});
$('.actualites-booking').click(function (e) { $('.nav-tabs li a[href="#actualites-booking"]').tab('show');
});


/*======================Navigation bouton modal=================*/
