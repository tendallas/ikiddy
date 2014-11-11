jQuery.noConflict();
 
jQuery(document).ready(function(){

/*jQuery("#SliderPrice").slider({ 
  from: 0,
  to: 1000,
  limits: false,
  step: 100,
  skin: "plastic",
  callback: function( value ){ console.dir( this ); }
  });*/
  
  
    jQuery("#contentab .eachtab").hide(); // Initially hide all content
    jQuery("#tabs li:first").attr("id","current"); // Activate first tab
    jQuery("#contentab  .eachtab:first").fadeIn(); // Show first tab content
    
    jQuery('#tabs a').click(function(e) {
        e.preventDefault();
        if (jQuery(this).closest("li").attr("id") == "current"){ //detection for current tab
         return       
        }
        else{             
        jQuery("#contentab  .eachtab").hide(); //Hide all content
        jQuery("#tabs li").attr("id",""); //Reset id's
        jQuery(this).parent().attr("id","current"); // Activate this
        jQuery('#' + jQuery(this).attr('name')).fadeIn(); // Show content for current tab
        }
    });
});