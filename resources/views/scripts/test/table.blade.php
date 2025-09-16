<script>
    function TableRTM(id = '') {
        this.tableId   = id; 
        this.dateStart = '2000-01-01 00:00:00';
        this.dateEnd   = '2025-08-07 07:31:53';

        this.columns = [
            { data: 'id', name: 'id', visible: false },
            { 
                data: 'date', 
                name: 'date', 
                visible: true,
                render: function (data, type, row, meta) {
                    const dat = data.split('.')[0];
                    return dat;
                } 
            },
            { 
                data: 'record_st', 
                name: 'record_st', 
                visible: true,
                render: function (data, type, row, meta) {
                    const dat = data.split('.')[0];
                    return dat;
                } 
            },
            { 
                data: 'record_en', 
                name: 'record_en', 
                visible: true,
                render: function (data, type, row, meta) {
                    const dat = data.split('.')[0];
                    return dat;
                } 
            },
            { data: 'well_tk'  , name: 'well_tk'  , visible: false },
            { data: 'well_id'  , name: 'well_id'  , visible: false },
            { 
                data: 'stats_sr' , 
                name: 'stats_sr' , 
                visible: true,
                render: function (data, type, row, meta) {
                    var btn;
                    if (data) {
                        btn = `                    
                        <div class="td-groups">
                            <button type="button" class="btn btn-status normal"> 
                                <i class="ti ti-wave-square"></i>
                            </button>
                        </div>`;

                    } else {
                        btn = `
                        <div class="td-groups">
                            <button type="button" class="btn btn-status danger"> 
                                <i class="ti ti-x"></i>
                            </button>
                        </div>`;
                    }

                    return btn;
                }
            },
            { 
                data: 'stats_cr', 
                name: 'stats_cr', 
                visible: true,
                render: function (data, type, row, meta) {
                    var btn;
                    if (data) {
                        btn = `                    
                        <div class="td-groups">
                            <button type="button" class="btn btn-status normal"> 
                                <i class="ti ti-droplet-half-filled"></i>
                            </button>
                        </div>`;

                    } else {
                        btn = `
                        <div class="td-groups">
                            <button type="button" class="btn btn-status danger"> 
                                <i class="ti ti-droplet-off"></i>
                            </button>
                        </div>`;
                    }

                    return btn;
                }
            },
            { 
                data: 'stats_rt' , 
                name: 'stats_rt' , 
                visible: true,
                render: function (data, type, row, meta) {
                    var btn;
                    if (!data) {
                        btn = `                    
                        <div class="td-groups">
                            <button type="button" class="btn btn-status normal"> 
                                <i class="ti ti-wave-square"></i>
                            </button>
                        </div>`;

                    } else {
                        btn = `
                        <div class="td-groups">
                            <button type="button" class="btn btn-status danger"> 
                                <i class="ti ti-trending-up"></i>
                            </button>
                        </div>`;
                    }

                    return btn;
                }
            },
            { 
                data: 'stats_sl' , 
                name: 'stats_sl' , 
                visible: true,
                render: function (data, type, row, meta) {
                    var btn;
                    if (data === 'true') {
                        btn = `
                        <div class="td-groups">
                            <button type="button" class="btn btn-status danger"> 
                                <i class="ti ti-irregular-polyhedron-off"></i>
                            </button>
                        </div>`;

                    } else {
                        btn = `                    
                        <div class="td-groups">
                            <button type="button" class="btn btn-status normal"> 
                                <i class="ti ti-irregular-polyhedron"></i>
                            </button>
                        </div>`;
                    }

                    return btn;
                }
            },
            { 
                data: 'stats_cl', 
                name: 'stats_cl', 
                visible: true,
                render: function (data, type, row, meta) {
                    var btn;
                    if (data) {
                        btn = `                    
                        <div class="td-groups">
                            <button type="button" class="btn btn-status normal"> 
                                <i class="ti ti-wall"></i>
                            </button>
                        </div>`;

                    } else {
                        btn = `
                        <div class="td-groups">
                            <button type="button" class="btn btn-status danger"> 
                                <i class="ti ti-wall-off"></i>
                            </button>
                        </div>`;
                    }

                    return btn;
                }
            },
            { 
                data: 'well_pr', 
                name: 'well_pr', 
                visible: true,
                render: function (data, type, row, meta) {
                    var btn;
                    if (data === 0) {
                        btn = `                    
                        <div class="td-groups">
                            <button type="button" class="btn btn-status normal"> 
                                <i class="ti ti-checks"></i>
                            </button>
                        </div>`;

                    } else if (data === 1) {
                        btn = `
                        <div class="td-groups">
                            <button type="button" class="btn btn-status danger"> 
                                <i class="ti ti-alert-octagon"></i>
                            </button>
                        </div>`;

                    } else {
                        btn = ` 
                        <div class="td-groups">
                            <button type="button" class="btn btn-status warning"> 
                                <i class="ti ti-file-unknown"></i>
                            </button>
                        </div>`;
                    }

                    return btn;
                }
            },
            { data: 'message'  , name: 'message'  , visible: false },
            { 
                data: null, 
                name: 'action', 
                visible: true,
                render: function (data, type, row, meta) {
                    const btn = `
                            <div class="td-groups">
                                <button type="button" class="btn btn-status btn-view-data" data-prediction-dt="${row.date}" data-record-start="${row.record_st}" data-record-end="${row.record_en}"> 
                                    <i class="ti ti-zoom-scan"></i>
                                </button>
                            </div>`;

                    return btn;
                }
            },
        ];
        this.columnDefs = [
            { width: '12%', targets: [1,2,3] },
            { class: 'text-center', targets: [1,2,3] },
            { class: 'd-none d-xl-table-cell', targets: [2,3] }
        ];
        this.dummy = [
            {
                id: 1, date: '2025-09-01T08:00:00.000Z', record_st: '2025-09-01T07:00:00.000Z', record_en: '2025-09-01T08:00:00.000Z',
                well_tk: 'TK001', well_id: 'WELL001', stats_sr: true, stats_cr: false, stats_rt: false, stats_sl: 'false',
                stats_cl: true, well_pr: 0, message: 'Normal operation'
            },
            {
                id: 2, date: '2025-09-02T09:15:00.000Z', record_st: '2025-09-02T08:00:00.000Z', record_en: '2025-09-02T09:00:00.000Z',
                well_tk: 'TK002', well_id: 'WELL002', stats_sr: false, stats_cr: true, stats_rt: true, stats_sl: 'true',
                stats_cl: false, well_pr: 1, message: 'Issue detected'
            },
            {
                id: 3, date: '2025-09-03T10:30:00.000Z', record_st: '2025-09-03T09:30:00.000Z', record_en: '2025-09-03T10:00:00.000Z',
                well_tk: 'TK003', well_id: 'WELL003', stats_sr: true, stats_cr: true, stats_rt: false, stats_sl: 'false',
                stats_cl: true, well_pr: 0, message: 'All systems go'
            },
            {
                id: 4, date: '2025-09-04T11:45:00.000Z', record_st: '2025-09-04T10:45:00.000Z', record_en: '2025-09-04T11:30:00.000Z',
                well_tk: 'TK004', well_id: 'WELL004', stats_sr: false, stats_cr: false, stats_rt: true, stats_sl: 'true',
                stats_cl: false, well_pr: 2, message: 'Unknown error'
            },
            {
                id: 5, date: '2025-09-05T12:00:00.000Z', record_st: '2025-09-05T11:00:00.000Z', record_en: '2025-09-05T12:00:00.000Z',
                well_tk: 'TK005', well_id: 'WELL005', stats_sr: true, stats_cr: false, stats_rt: false, stats_sl: 'false',
                stats_cl: true, well_pr: 0, message: 'Operational'
            },
            {
                id: 6, date: '2025-09-06T13:15:00.000Z', record_st: '2025-09-06T12:15:00.000Z', record_en: '2025-09-06T13:00:00.000Z',
                well_tk: 'TK006', well_id: 'WELL006', stats_sr: true, stats_cr: true, stats_rt: true, stats_sl: 'true',
                stats_cl: false, well_pr: 1, message: 'Multiple alerts'
            },
            {
                id: 7, date: '2025-09-07T14:30:00.000Z', record_st: '2025-09-07T13:30:00.000Z', record_en: '2025-09-07T14:00:00.000Z',
                well_tk: 'TK007', well_id: 'WELL007', stats_sr: false, stats_cr: false, stats_rt: false, stats_sl: 'false',
                stats_cl: true, well_pr: 0, message: 'Idle'
            },
            {
                id: 8, date: '2025-09-08T15:45:00.000Z', record_st: '2025-09-08T14:45:00.000Z', record_en: '2025-09-08T15:30:00.000Z',
                well_tk: 'TK008', well_id: 'WELL008', stats_sr: true, stats_cr: false, stats_rt: true, stats_sl: 'true',
                stats_cl: false, well_pr: 2, message: 'Investigate'
            },
            {
                id: 9, date: '2025-09-09T16:00:00.000Z', record_st: '2025-09-09T15:00:00.000Z', record_en: '2025-09-09T16:00:00.000Z',
                well_tk: 'TK009', well_id: 'WELL009', stats_sr: true, stats_cr: true, stats_rt: false, stats_sl: 'false',
                stats_cl: true, well_pr: 0, message: 'Nominal'
            },
            {
                id: 10, date: '2025-09-10T17:15:00.000Z', record_st: '2025-09-10T16:15:00.000Z', record_en: '2025-09-10T17:00:00.000Z',
                well_tk: 'TK010', well_id: 'WELL010', stats_sr: false, stats_cr: true, stats_rt: true, stats_sl: 'true',
                stats_cl: false, well_pr: 1, message: 'High pressure warning'
            },
            {
                id: 11, date: '2025-09-11T18:30:00.000Z', record_st: '2025-09-11T17:30:00.000Z', record_en: '2025-09-11T18:00:00.000Z',
                well_tk: 'TK011', well_id: 'WELL011', stats_sr: true, stats_cr: false, stats_rt: false, stats_sl: 'false',
                stats_cl: true, well_pr: 0, message: 'Monitoring'
            },
            {
                id: 12, date: '2025-09-12T19:45:00.000Z', record_st: '2025-09-12T18:45:00.000Z', record_en: '2025-09-12T19:30:00.000Z',
                well_tk: 'TK012', well_id: 'WELL012', stats_sr: false, stats_cr: true, stats_rt: false, stats_sl: 'true',
                stats_cl: false, well_pr: 2, message: 'Check sensor'
            },
            {
                id: 13, date: '2025-09-13T20:00:00.000Z', record_st: '2025-09-13T19:00:00.000Z', record_en: '2025-09-13T20:00:00.000Z',
                well_tk: 'TK013', well_id: 'WELL013', stats_sr: true, stats_cr: true, stats_rt: true, stats_sl: 'false',
                stats_cl: true, well_pr: 0, message: 'Stable'
            },
            {
                id: 14, date: '2025-09-14T21:15:00.000Z', record_st: '2025-09-14T20:15:00.000Z', record_en: '2025-09-14T21:00:00.000Z',
                well_tk: 'TK014', well_id: 'WELL014', stats_sr: false, stats_cr: false, stats_rt: true, stats_sl: 'true',
                stats_cl: false, well_pr: 1, message: 'Shut down'
            },
            {
                id: 15, date: '2025-09-15T22:30:00.000Z', record_st: '2025-09-15T21:30:00.000Z', record_en: '2025-09-15T22:00:00.000Z',
                well_tk: 'TK015', well_id: 'WELL015', stats_sr: true, stats_cr: false, stats_rt: false, stats_sl: 'false',
                stats_cl: true, well_pr: 0, message: 'System ready'
            }
        ];
    }

    TableRTM.prototype.initTable = async function () {  
        const table = $(`#${this.tableId}`).DataTable({
            pagingType: 'full',
            paging: true,
            ordering: false,
            searching: false,
            processing: false,
            serverSide: false,
            responsive: false,
            autoWidth: false,
            data: this.dummy,
            columns: this.columns,
            columnDefs: this.columnDefs,
            initComplete: function() {
                this.api().responsive.recalc();
                $(window).trigger('resize');
            },
        });

        $(`#${this.tableId}`).on('processing.dt', function(e, settings, processing) {
            if (processing) {
                $('.dt-processing').addClass('dt-load');

            } else {
                $('.dt-processing').removeClass('dt-load');
            }
        });

        $(document).on('click', '.btn-refresh', function() {
            // table.ajax.reload(null, false);
        });

        $('.page-link[data-dt-idx="0"]').trigger('click');
    }
</script>