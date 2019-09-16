$(function() {
//should add wow.min.css and wow.min.js which indeed need animate.css
new WOW().init();

});


//smooth scroll on clicking nav links

$(function(){
    //not added any external libraries other than animate.css
    $("a.smooth-scroll").click(function(event){
        event.preventDefault();
        var section_id=$(this).attr("href");
        $('html,body').animate({
            scrollTop:$(section_id).offset().top - 64
            },1250);
    });
});


//for carousel effect we need to add owl.carousel.js and 2 css files default and theme

$(function(){
    $("#faculty-members").owlCarousel({
        items:3,
        autoplay:true,
        loop:true,
        smartSpeed:700,
        autoplayHoverPause:true
    });
});



function openn(evt, cityName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace("active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += "active";
}
