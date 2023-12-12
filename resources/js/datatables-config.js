const $ = require('jquery');
window.jQuery = $;

require('datatables.net-dt/js/dataTables.dataTables.js');
require('datatables.net-autofill-dt/js/autoFill.dataTables.js');
require('datatables.net-buttons-dt/js/buttons.dataTables.js');
require('datatables.net-buttons/js/dataTables.buttons.js');
require('datatables.net-buttons/js/buttons.colVis.js');
require('datatables.net-buttons/js/buttons.html5.js');
require('datatables.net-buttons/js/buttons.print.js');
require('datatables.net-colreorder-dt/js/colReorder.dataTables.js');
require('datatables.net-fixedcolumns-dt/js/fixedColumns.dataTables.js');
require('datatables.net-fixedheader-dt/js/fixedHeader.dataTables.js');
require('datatables.net-keytable-dt/js/keyTable.dataTables.js');
require('datatables.net-responsive-dt/js/responsive.dataTables.js');
require('datatables.net-rowgroup-dt/js/rowGroup.dataTables.js');
require('datatables.net-rowreorder-dt/js/rowReorder.dataTables.js');
require('datatables.net-scroller-dt/js/scroller.dataTables.js');
require('datatables.net-searchbuilder-dt/js/searchBuilder.dataTables.js');
require('datatables.net-searchpanes-dt/js/searchPanes.dataTables.js');
require('datatables.net-select-dt/js/select.dataTables.js');
require('datatables.net-staterestore-dt/js/stateRestore.dataTables.js');

require('datatables.net-dt/css/jquery.dataTables.css');
require('datatables.net-buttons-dt/css/buttons.dataTables.css');

// Exporta o DataTable para ser utilizado em outros lugares
module.exports = $;