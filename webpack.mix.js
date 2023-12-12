const mix = require('laravel-mix');

mix
    .sass('resources/sass/site.scss', 'public/css')
    .js([
        'node_modules/jquery/dist/jquery.js',
        'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
        'node_modules/@fortawesome/fontawesome-free/js/all.js',
        'node_modules/jquery-mask-plugin/dist/jquery.mask.js',
        'node_modules/jquery-ui-dist/jquery-ui.min.js',
        'resources/js/app.js',
        'resources/js/datatables-config.js',
        // 'resources/js/index.js',
        'resources/js/site.js',
    ], 'public/js/app.js')
    .styles([
        'resources/css/app.css',
        'node_modules/bootstrap/dist/css/bootstrap.css',
        'node_modules/@fortawesome/fontawesome-free/css/all.css',
    ], 'public/css/app.css')

    //DATATABLE LIB
    .js([
        'node_modules/datatables.net-dt/js/dataTables.dataTables.js',
        'node_modules/datatables.net-autofill-dt/js/autoFill.dataTables.js',
        'node_modules/datatables.net-buttons-dt/js/buttons.dataTables.js',
        'node_modules/datatables.net-colreorder-dt/js/colReorder.dataTables.js',
        'node_modules/datatables.net-fixedcolumns-dt/js/fixedColumns.dataTables.js',
        'node_modules/datatables.net-fixedheader-dt/js/fixedHeader.dataTables.js',
        'node_modules/datatables.net-keytable-dt/js/keyTable.dataTables.js',
        'node_modules/datatables.net-responsive-dt/js/responsive.dataTables.js',
        'node_modules/datatables.net-rowgroup-dt/js/rowGroup.dataTables.js',
        'node_modules/datatables.net-rowreorder-dt/js/rowReorder.dataTables.js',
        'node_modules/datatables.net-scroller-dt/js/scroller.dataTables.js',
        'node_modules/datatables.net-searchbuilder-dt/js/searchBuilder.dataTables.js',
        'node_modules/datatables.net-searchpanes-dt/js/searchPanes.dataTables.js',
        'node_modules/datatables.net-select-dt/js/select.dataTables.js',
        'node_modules/datatables.net-staterestore-dt/js/stateRestore.dataTables.js',
    ], 'public/js/datatables.js')
    .styles([
        'node_modules/datatables.net-dt/css/jquery.dataTables.css',
        'node_modules/datatables.net-autofill-dt/css/autoFill.dataTables.css',
        'node_modules/datatables.net-buttons-dt/css/buttons.dataTables.css',
        'node_modules/datatables.net-colreorder-dt/css/colReorder.dataTables.css',
        'node_modules/datatables.net-fixedcolumns-dt/css/fixedColumns.dataTables.css',
        'node_modules/datatables.net-fixedheader-dt/css/fixedHeader.dataTables.css',
        'node_modules/datatables.net-keytable-dt/css/keyTable.dataTables.css',
        'node_modules/datatables.net-responsive-dt/css/responsive.dataTables.css',
        'node_modules/datatables.net-rowgroup-dt/css/rowGroup.dataTables.css',
        'node_modules/datatables.net-rowreorder-dt/css/rowReorder.dataTables.css',
        'node_modules/datatables.net-scroller-dt/css/scroller.dataTables.css',
        'node_modules/datatables.net-searchbuilder-dt/css/searchBuilder.dataTables.css',
        'node_modules/datatables.net-searchpanes-dt/css/searchPanes.dataTables.css',
        'node_modules/datatables.net-select-dt/css/select.dataTables.css',
        'node_modules/datatables.net-staterestore-dt/css/stateRestore.dataTables.css',
    ], 'public/css/datatables.css')

    .copy('resources/img/1.ico', 'public/img/1.ico')
    .sourceMaps();

if (mix.inProduction()) {
    mix.version();
}
