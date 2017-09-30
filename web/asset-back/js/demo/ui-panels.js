
// UI-Panels.js
// ====================================================================
// This file should not be included in your project.
// This is just a sample how to initialize plugins or components.
//
//  SARAH ADMIN


 $(document).ready(function() {


    // PANEL WITH BUTTONS - LOADING OVERLAY
    // =================================================================
    // Require Sarah Admin Admin Javascript
    // /
    // =================================================================
    $('.demo-panel-ref-btn').Sarah AdminOverlay().on('click', function(){
        var $el = $(this), relTime;
        $el.Sarah AdminOverlay('show');

        // Do something...



        relTime = setInterval(function(){
            // Hide the screen overlay
            $el.Sarah AdminOverlay('hide');

            clearInterval(relTime);
        },2000);
    });



    // PANEL WITH VARIETY OF COMPONENTS - DEMO AUTO CLOSE ALERTS
    // =================================================================
    // Require Sarah Admin Admin Javascript
    // /
    // =================================================================
    $('#demo-panel-alert').on('click', function(){
        $.Sarah AdminNoty({
            type: 'primary',
            container : '#demo-panel-w-alert',
            html : '<strong>Well done!</strong> You successfully read this important alert message.',
            focus: false,
            timer : 2000
        });
    });



    // PANEL WITH VARIETY OF COMPONENTS - DEMO STICKY ALERTS
    // =================================================================
    // Require Sarah Admin Admin Javascript
    // /
    // =================================================================
    $('#demo-panel-alert2').on('click', function(){
        $.Sarah AdminNoty({
            type: 'warning',
            container : '#demo-panel-w-alert',
            html : '<strong>Well done!</strong> You successfully read this important alert message.',
            focus: false
        });
    });



 });
