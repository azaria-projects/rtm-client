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
    }

    TableRTM.prototype.initTable = async function () {
        const table = $(`#${this.tableId}`).DataTable({
            pagingType: 'full',
            paging: true,
            ordering: false,
            searching: false,
            processing: true,
            serverSide: true,
            responsive: false,
            autoWidth: false,
            ajax: function(data, callback, settings) {
                const bse = `${baseurl}/${baseprefix}/log`;
                const pge = Math.floor(data.start / data.length) + 1;
                const nme = @json($nme);
                const par = new URLSearchParams({
                    'name' : nme,
                    'count': data.length,
                    'page' : pge,
                    'start': '2000-01-01 00:00:00',
                    'end'  : '2025-08-07 07:31:53'
                }).toString();

                $.ajax({
                    url: `${bse}?${par}`,
                    success: function(json) {
                        callback({
                            draw: data.draw,
                            recordsTotal: json.response.total,
                            recordsFiltered: json.response.total,
                            data: json.response.data
                        });
                    }
                });
            },
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
            table.ajax.reload(null, false);
        });

        $('.page-link[data-dt-idx="0"]').trigger('click');
    }
</script>