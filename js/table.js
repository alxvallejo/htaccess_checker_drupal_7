jQuery(document).ready(function($) {
    console.log('hey');
    var t = $('#redirects').DataTable();

    // @todo - load saved rows and count them
    var r = 0;

    $('#add-row').on('click', function(e) {
        e.preventDefault();
        t.row.add([
            '<input type="text" id="row-' + r + '-src" name="row-' + r + '-src">',
            '<input type="text" id="row-' + r + '-tgt" name="row-' + r + '-tgt">',
            ''
        ]).draw(false);
        r++;
    });

    // Automatically add a first row of data
    $('#add-row').click();

    /*$('#edit-submit').on('click', function(e) {
        var data = t.$('input').serialize();

        //debugger;
    });*/
})