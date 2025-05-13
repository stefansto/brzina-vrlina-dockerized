$(document).ready(function(){
    let navigacija = false;
    $('#navbarCollapse').hide();
    $('#navDugme').click(function(){
        if(navigacija){
            $('#navbarCollapse').hide();
            navigacija = false;
        } else {
            $('#navbarCollapse').show();
            navigacija = true;
        }
    })
})