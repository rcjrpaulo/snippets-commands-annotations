MainApp.prototype.ghostLogin = function () {
    $(document).on('keydown', ".select2-search__field", function(event){
        if (event.keyCode == 13 && event.ctrlKey) {
            setTimeout(function() {
            const url = $('#employee-info div div a:eq(0)').attr('href');
            window.location.replace(url);
        }, 500);
    }
});       
                
                
                