jQuery(document).ready(function($) {

    $('#edit-htaccess-checker-toggle-verbose').live('click', function() {
        if ($('#verbose-container').attr('style', 'display:none !important')) {
            $('#verbose-container').attr('style', 'display:block !important');
        }
        else {
            $('#verbose-container').attr('style', 'display:none !important');
        }
    });

    // below code for datatables
    //console.log('hey');
    //var t = $('#redirects').DataTable();

    // @todo - load saved rows and count them
    //var r = 0;

    /*$('#add-row').on('click', function(e) {
        e.preventDefault();
        t.row.add([
            '<input type="text" id="row-' + r + '-src" name="row-' + r + '-src">',
            '<input type="text" id="row-' + r + '-tgt" name="row-' + r + '-tgt">',
            ''
        ]).draw(false);
        r++;
    });*/

    // Automatically add a first row of data
    //$('#add-row').click();

    /*$('#edit-submit').on('click', function(e) {
        var data = t.$('input').serialize();

        //debugger;
    });*/
})