$(window).load(function(){
    width_brand=0;
    $('.brand .carusel').jCarouselLite({
        btnNext: '.brand .next',
        btnPrev: '.brand .prev',
        visible: 9
    });
    $('.brandsc .carusel').jCarouselLite({
        btnNext: '.brandc .next',
        btnPrev: '.brandc .prev',
        visible: 7,
        width: 870
    });
    $('.brandsc li').each(function(){
        width_brand+=$(this).outerWidth(true);
    });

    $('.brandsc ul').css('width',width_brand);

    $('.brandsc li').each(function(){
        width_brand+=$(this).outerWidth(true);
    });
    $('.brandsc ul').css('width',width_brand);
    $('.brandsc .carusel').css('width', 870);

});
$(document).ready(function(){
	$("div.altText p:first-child").nextAll().hide();
	$("div.altText p:first-child").after('<a class="open">Подробнее...</a>');
	$(".altText a.open").click(function() {
		$(this).empty();
		$("div.altText p:first-child").nextAll().show(1000);
		return false;
	});
});