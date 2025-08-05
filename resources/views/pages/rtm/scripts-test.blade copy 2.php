@push('scripts-body')
    <script>
        var noData = false;
        var crr;
        var dst; //-- for filter 
        var den; //-- for filter 

        async function initJqueryCodes() {
            const tbp = getPredictionTable();

            $('.page-link[data-dt-idx="0"]').trigger('click');

            tbp.on('processing.dt', function(e, settings, processing) {
                if (processing) {
                    $('.dt-processing').addClass('dt-load');
                } else {
                    $('.dt-processing').removeClass('dt-load');
                }
            });

            $('#filter-date').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                locale: {
                    format: 'YYYY-MM-DD HH:mm:ss'
                },
                autoApply: false
            }, function(start, end, label) {
                dst = start.format('YYYY-MM-DD HH:mm:ss');
                den = end.format('YYYY-MM-DD HH:mm:ss');
                
                $('.btn-refresh').click();
            });

            $(document).on('click', '.btn-refresh', function() {
                tbp.ajax.reload(null, false);
            });
        }

        function getChartCanvas() {
            const ctd0 = document.getElementById('chart-depth').getContext('2d');
            const ctd1 = document.getElementById('chart-bitdepth').getContext('2d');
            const ctd2 = document.getElementById('chart-bvdepth').getContext('2d');
            const ctd3 = document.getElementById('chart-blockpos').getContext('2d');
            const ctd4 = document.getElementById('chart-torque').getContext('2d');
            const ctd5 = document.getElementById('chart-ropi').getContext('2d');
            const ctd6 = document.getElementById('chart-wob').getContext('2d');
            const ctd7 = document.getElementById('chart-stppress').getContext('2d');
            const ctd8 = document.getElementById('chart-hkld').getContext('2d');
            const ctd9 = document.getElementById('chart-rpm').getContext('2d');

            const cvd0 = document.getElementById('chart-v-depth').getContext('2d');
            const cvd1 = document.getElementById('chart-v-bitdepth').getContext('2d');
            const cvd2 = document.getElementById('chart-v-bvdepth').getContext('2d');
            const cvd3 = document.getElementById('chart-v-blockpos').getContext('2d');
            const cvd4 = document.getElementById('chart-v-torque').getContext('2d');
            const cvd5 = document.getElementById('chart-v-ropi').getContext('2d');
            const cvd6 = document.getElementById('chart-v-wob').getContext('2d');
            const cvd7 = document.getElementById('chart-v-stppress').getContext('2d');
            const cvd8 = document.getElementById('chart-v-hkld').getContext('2d');
            const cvd9 = document.getElementById('chart-v-rpm').getContext('2d');

            const lbl0 = document.getElementById('chart-labels').getContext('2d');

            return [
                ctd0, ctd1, ctd2, ctd3, ctd4, ctd5, ctd6, ctd7, ctd8, ctd9, 
                cvd0, cvd1, cvd2, cvd3, cvd4, cvd5, cvd6, cvd7, cvd8, cvd9,
                lbl0
            ];
        }

        function getChartContext(ctd = [], rcd = []) {
            const crd0 = new Chart(ctd[0], getChartConfig(rcd[0].labels, rcd[0].datasets)); // depth
            const crd1 = new Chart(ctd[1], getChartConfig(rcd[1].labels, rcd[1].datasets)); // bitdepth
            const crd2 = new Chart(ctd[2], getChartConfig(rcd[2].labels, rcd[2].datasets)); // bvdepth
            const crd3 = new Chart(ctd[3], getChartConfig(rcd[3].labels, rcd[3].datasets)); // blockpos
            const crd4 = new Chart(ctd[4], getChartConfig(rcd[4].labels, rcd[4].datasets)); // torque
            const crd5 = new Chart(ctd[5], getChartConfig(rcd[5].labels, rcd[5].datasets)); // ropi
            const crd6 = new Chart(ctd[6], getChartConfig(rcd[6].labels, rcd[6].datasets)); // wob
            const crd7 = new Chart(ctd[7], getChartConfig(rcd[7].labels, rcd[7].datasets)); // stppress
            const crd8 = new Chart(ctd[8], getChartConfig(rcd[8].labels, rcd[8].datasets)); // hkld
            const crd9 = new Chart(ctd[9], getChartConfig(rcd[9].labels, rcd[9].datasets)); // rpm

            const crv0 = new Chart(ctd[10], []);
            const crv1 = new Chart(ctd[11], []);
            const crv2 = new Chart(ctd[12], []);
            const crv3 = new Chart(ctd[13], []);
            const crv4 = new Chart(ctd[14], []);
            const crv5 = new Chart(ctd[15], []);
            const crv6 = new Chart(ctd[16], []);
            const crv7 = new Chart(ctd[17], []);
            const crv8 = new Chart(ctd[18], []);
            const crv9 = new Chart(ctd[19], []);

            const cbl0 = new Chart(ctd[20], getChartConfig(rcd[10].labels, rcd[10].datasets));

            return [
                crd0, crd1, crd2, crd3, crd4, crd5, crd6, crd7, crd8, crd9,
                crv0, crv1, crv2, crv3, crv4, crv5, crv6, crv7, crv8, crv9,
                cbl0
            ];
        }

        async function initVanilaCodes() {
            getCurrentDateTimeAlt();

            const ctd = getChartCanvas();
            const tmp = await getRandomData();
            const rcd = await getRecords(tmp);
            const sdb = await getSidebarData(tmp);
            const crd = getChartContext(ctd, rcd);
            // const plg = await setPredictionNotification();

            $(document).on('click', '.btn-view-data', async function() {
                const sp = document.getElementById('view-data-spinner');
                const tx = document.getElementById('subtitle-prediction');

                if (sp.classList.contains('d-none')) {
                    sp.classList.remove('d-none');
                }

                const pr = $(this).data('prediction-dt').split('.')[0];
                const st = $(this).data('record-start');
                const en = $(this).data('record-end');

                const ndt = await getSpecificRecords(st, en);

                await setNewPredictionChartData(cr4, ndt[0]);
                await setNewPredictionChartData(cr5, ndt[1]);
                await setNewPredictionChartData(cr6, ndt[2]);

                tx.innerText = `Data used to perform prediction at ${pr}`; 

                if (!sp.classList.contains('d-none')) {
                    sp.classList.add('d-none');
                }
            });

            setInterval(async () => { 
                const rnd = await getRandomData();
                const ndt = await getRecords(rnd);

                await setNewChartData(crd[0],  ndt[0]);
                await setNewChartData(crd[1],  ndt[1]);
                await setNewChartData(crd[2],  ndt[2]);
                await setNewChartData(crd[3],  ndt[3]);
                await setNewChartData(crd[4],  ndt[4]);
                await setNewChartData(crd[5],  ndt[5]);
                await setNewChartData(crd[6],  ndt[6]);
                await setNewChartData(crd[7],  ndt[7]);
                await setNewChartData(crd[8],  ndt[8]);
                await setNewChartData(crd[9],  ndt[9]);
                await setNewChartData(crd[10], ndt[10]);

                await getSidebarData(rnd);
            }, 1000);

            // setInterval(async () => { await setPredictionNotification(); }, 1.5 * 60 * 1000);
            // updateYAxisLabel(crd[10], true);

            const sml = window.matchMedia('(max-width: 576px)');
            updateYAxisLabel(crd[0], !sml.matches);
            updateYAxisLabel(crd[1], !sml.matches);
            updateYAxisLabel(crd[2], !sml.matches);
            updateYAxisLabel(crd[3], !sml.matches);
            updateYAxisLabel(crd[4], !sml.matches);
            updateYAxisLabel(crd[5], !sml.matches);
            updateYAxisLabel(crd[6], !sml.matches);
            updateYAxisLabel(crd[7], !sml.matches);
            updateYAxisLabel(crd[8], !sml.matches);
            updateYAxisLabel(crd[9], !sml.matches);

            sml.addEventListener('change', (e) => {
                updateYAxisLabel(crd[0], !e.matches);
                updateYAxisLabel(crd[1], !e.matches);
                updateYAxisLabel(crd[2], !e.matches);
                updateYAxisLabel(crd[3], !e.matches);
                updateYAxisLabel(crd[4], !e.matches);
                updateYAxisLabel(crd[5], !e.matches);
                updateYAxisLabel(crd[6], !e.matches);
                updateYAxisLabel(crd[7], !e.matches);
                updateYAxisLabel(crd[8], !e.matches);
                updateYAxisLabel(crd[9], !e.matches);
            });
        }

        async function fetchRecords(rng) {
            const tkn = @json($tkn);
            const nme = @json($nme);
            const par = new URLSearchParams({
                'token': tkn,
                'start': rng['start'],
                'end'  : rng['end'],
                'name' : nme
            }).toString();

            const bse = `${exbaseurl}/${baseprefix}/well/records`;
            const url = `${bse}?${par}`;
            const res = await get(url).then(data => data).catch(error => error);
            return res.response;
        }

        async function fetchPredictionLog() {
            const nme = @json($nme);
            const par = new URLSearchParams({
                'count' : 1,
                'name'  : nme
            }).toString();

            const bse = `${baseurl}/${baseprefix}/log`;
            const url = `${bse}?${par}`;
            const res = await get(url).then(data => data).catch(error => error);
            return res.response.data;
        }

        async function getSidebarData(rcd = []) {
            const dat = [
                parseFloat(rcd.dph) ?? 0,
                parseFloat(rcd.btd) ?? 0,
                parseFloat(rcd.dph) ?? 0,
                parseFloat(rcd.bps) ?? 0,
                parseFloat(rcd.rpm) ?? 0,
                parseFloat(rcd.wob) ?? 0,
                parseFloat(rcd.rpi) ?? 0,
                parseFloat(rcd.hkl) ?? 0,
                parseFloat(rcd.trq) ?? 0,
                parseFloat(rcd.prs) ?? 0,
                parseFloat(rcd.sfm) ?? 0,
                parseFloat(rcd.fli) ?? 0,
                parseFloat(rcd.fli) ?? 0
            ];

            setSidebarDataStatus(dat);

            document.getElementById('value-depth').innerHTML      = dat[0];
            document.getElementById('value-bv-depth').innerHTML   = dat[1];
            document.getElementById('value-bit-depth').innerHTML  = dat[2];
            document.getElementById('value-block-pos.').innerHTML = dat[3];
            document.getElementById('value-rpm').innerHTML        = dat[4];
            document.getElementById('value-wob').innerHTML        = dat[5];
            document.getElementById('value-ropi').innerHTML       = dat[6];
            document.getElementById('value-hkld').innerHTML       = dat[7];
            document.getElementById('value-torque').innerHTML     = dat[8];
            document.getElementById('value-stpress').innerHTML    = dat[9];
            document.getElementById('value-scfm').innerHTML       = dat[10];
            document.getElementById('value-flow-in').innerHTML    = dat[11];
            document.getElementById('value-flow-out').innerHTML   = dat[12];
        }

        async function setPredictionNotification() {
            const cmp = getNotificationComponent(
                Math.random() < 0.8, 
                Math.random() < 0.5, 
                Math.random() < 0.5, 
                Math.random() < 0.5, 
                Math.random() < 0.5, 
                Math.random() < 0.5, 
                'TEST DATA');
            const trg = document.getElementById('prediction-notification');

            if (trg.children.length >= 10) {
                trg.firstElementChild.remove();
            }

            trg.insertAdjacentHTML('beforeend', cmp);

            const chd = trg.lastElementChild;
            trg.scrollTop = trg.scrollHeight;

        }

        async function getRecords(dat = []) {
            //-- chart data
            const tme = [];
            const dph = [], btd = [], bvd = [];
            const trq = [], rpi = [], wob = [];
            const prs = [], rpm = [], hkl = [], bps = [];

            //-- others data
            const sfm = [], fli = [], flo = [];
            const cur = new Date().toTimeString().slice(0, 8);

            const lbl = [];

            tme.push(cur);
            dph.push(dat.dph); 
            btd.push(dat.btd); 
            bvd.push(dat.bvd);
            trq.push(dat.trq); 
            rpi.push(dat.rpi); 
            wob.push(dat.wob);
            prs.push(dat.prs); 
            rpm.push(dat.rpm); 
            hkl.push(dat.hkl); 
            bps.push(dat.bps);
            fli.push(dat.fli); 
            flo.push(dat.flo); 
            sfm.push(dat.sfm);
            lbl.push(dat.lbl);

            noData = true;

            const a_dph = {
                'labels': tme,
                'datasets': [ {label: 'depth', data: dph, borderColor: 'rgba(195, 112, 155, 0.8)'} ],
            };

            const a_btd = {
                'labels': tme,
                'datasets': [ {label: 'bit-depth', data: btd, borderColor: 'rgba(0, 97, 166, .75)'} ],
            };

            const a_bvd = {
                'labels': tme,
                'datasets': [ {label: 'bv-depth', data: bvd, borderColor: 'rgba(166, 161, 0, .75)'} ],
            };

            const a_trq = {
                'labels': tme,
                'datasets': [ {label: 'torque', data: trq, borderColor: 'rgba(166, 0, 86, .75)'} ],
            };

            const a_rpi = {
                'labels': tme,
                'datasets': [ {label: 'ropi', data: rpi, borderColor: 'rgba(0, 97, 166, .75)'} ],
            };

            const a_wob = {
                'labels': tme,
                'datasets': [ {label: 'wob', data: wob, borderColor: 'rgba(105, 0, 166, .75)'} ],
            };

            const a_prs = {
                'labels': tme,
                'datasets': [ {label: 'stppress', data: prs, borderColor: 'rgba(166, 0, 136, .75)'} ],
            };

            const a_rpm = {
                'labels': tme,
                'datasets': [ {label: 'rpm', data: rpm, borderColor: 'rgba(0, 97, 166, .75)'} ],
            };

            const a_hkl = {
                'labels': tme,
                'datasets': [ {label: 'hkld', data: hkl, borderColor: 'rgba(0, 166, 158, .75)'} ],
            };

            const a_bps = {
                'labels': tme,
                'datasets': [ {label: 'block-pos', data: bps, borderColor: 'rgba(0, 166, 89, .75)'} ],
            };

            const a_lbl = {
                'labels': tme,
                'datasets': [ {label: 'lbl', data: lbl, hidden: false, borderColor: 'rgba(0, 166, 89, .75)'} ],
            };

           return [a_dph, a_btd, a_bvd, a_trq, a_rpi, a_wob, a_prs, a_rpm, a_hkl, a_bps, a_lbl];
        }

        async function getSpecificRecords(start, end) {
            const rng = {'start': start, 'end': end};
            const req = await fetchRecords(rng);

            //-- chart data
            const tme = [];
            const dph = [], btd = [], bvd = [];
            const trq = [], rpi = [], wob = [];
            const prs = [], rpm = [], hkl = [], bps = [];

            //-- others data
            const sfm = [], fli = [], flo = [];

            if (req.length !== 0) {
                const rcd = req.well_record;
                rcd.forEach(elm => {
                    const md       = parseFloat(elm.md);
                    const bvdepth  = parseFloat(elm.deptbitv);
                    const bitdepth = parseFloat(elm.bitdepth);

                    const woba   = parseFloat(elm.woba);
                    const ropi   = parseFloat(elm.ropi);
                    const torque = parseFloat(elm.torqa);
                    
                    const rpma     = parseFloat(elm.rpm);
                    const hklda    = parseFloat(elm.hklda);
                    const blockpos = parseFloat(elm.blockpos);
                    const stppress = parseFloat(elm.stppress);

                    const scfm       = parseFloat(elm.scfm);
                    const mudflowin  = parseFloat(elm.mudflowin);
                    const mudflowout = parseFloat(elm.mudflowout);

                    tme.push(elm.time)
                    dph.push(md); btd.push(bitdepth); bvd.push(bvdepth);
                    trq.push(torque); rpi.push(ropi); wob.push(woba);
                    prs.push(stppress); rpm.push(rpma); hkl.push(hklda); bps.push(blockpos);
                    
                    fli.push(mudflowin); flo.push(mudflowout); sfm.push(scfm);
                });

                noData = false;
            } else {
                const current = new Date().toTimeString().slice(0, 8);

                tme.push(current);
                dph.push(0); btd.push(0); bvd.push(0);
                trq.push(0); rpi.push(0); wob.push(0);
                prs.push(0); rpm.push(0); hkl.push(0); bps.push(0);
                
                fli.push(0); flo.push(0); sfm.push(0);

                noData = true;
            }

            const cc4 = {
                'labels': tme,
                'datasets': [
                    {label: 'depth', data: dph, borderColor: 'rgba(0, 166, 113, .75)'},
                    {label: 'bit-depth', data: bvd, borderColor: 'rgba(0, 97, 166, .75)'},
                    {label: 'bv-depth', data: btd, borderColor: 'rgba(166, 161, 0, .75)'}
                ],
            };

            const cc5 = {
                'labels': tme,
                'datasets': [
                    {label: 'torque', data: trq, borderColor: 'rgba(166, 0, 86, .75)'},
                    {label: 'ropi', data: rpi, borderColor: 'rgba(0, 97, 166, .75)'},
                    {label: 'wob', data: wob, borderColor: 'rgba(105, 0, 166, .75)'}
                ],
            };

            const cc6 = {
                'labels': tme,
                'datasets': [
                    {label: 'stppress', data: prs, borderColor: 'rgba(166, 0, 136, .75)'},
                    {label: 'rpm', data: rpm, borderColor: 'rgba(0, 97, 166, .75)'},
                    {label: 'hkld', data: hkl, borderColor: 'rgba(0, 166, 158, .75)'},
                    {label: 'block-pos', data: bps, borderColor: 'rgba(0, 166, 89, .75)'}
                ],
            }; 

           return [cc4, cc5, cc6];
        }

        async function getRandomData() {
            return {
                'dph': Math.floor(Math.random() * 2000), 
                'btd': Math.floor(Math.random() * 2000), 
                'bvd': Math.floor(Math.random() * 2000),
                'trq': Math.floor(Math.random() * 50), 
                'rpi': Math.floor(Math.random() * 200), 
                'wob': Math.floor(Math.random() * 50),
                'prs': Math.floor(Math.random() * 2000), 
                'rpm': Math.floor(Math.random() * 500), 
                'hkl': Math.floor(Math.random() * 200), 
                'bps': Math.floor(Math.random() * 50),
                'fli': Math.floor(Math.random() * 2000), 
                'flo': Math.floor(Math.random() * 2000), 
                'sfm': Math.floor(Math.random() * 2000),
                'lbl': Math.floor(Math.random()),
            };
        }

        function updateYAxisLabel(crt = Chart(), sts = false) {
            crt.options.scales.y = {
                display: true,
                beginAtZero: true,
                afterFit: function(axis) {
                    axis.width = !sts ? 70 : 0;
                }
            };
            crt.update();
        }

        function getPredictionTable() {
            const tbl = $('#table-notification').DataTable({
                pagingType: 'full',
                paging: true,
                ordering: false,
                searching: false,
                processing: true,
                serverSide: true,
                responsive: false,
                autoWidth: false,
                ajax: function(data, callback, settings) {
                    callback({
                        draw: data.draw,
                        recordsTotal: 0,
                        recordsFiltered: 0,
                        data: []
                    });
                },
                columns: [
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
                ],
                columnDefs: [
                    { width: '12%', targets: [1,2,3] },
                    { class: 'text-center', targets: [1,2,3] },
                    { class: 'd-none d-xl-table-cell', targets: [2,3] }
                ],
                initComplete: function() {
                    this.api().responsive.recalc();
                    $(window).trigger('resize');
                },
            });

            return tbl;
        }

        function setNewChartData(chart, newData) {
            chart.data.labels.push(...newData.labels);
            chart.data.datasets.forEach((dataset, i) => {
                dataset.data.push(...newData.datasets[i].data);
            });

            const uniqueLabels  = [];
            const uniqueIndices = [];
            const seenLabels    = new Set();

            chart.data.labels.forEach((label, index) => {
                if (!seenLabels.has(label)) {
                    seenLabels.add(label);
                    uniqueLabels.push(label);
                    uniqueIndices.push(index);
                }
            });

            chart.data.labels = uniqueLabels;
            chart.data.datasets.forEach(dataset => {
                dataset.data = uniqueIndices.map(index => dataset.data[index]);
            });

            if (chart.data.labels.length > 30) {
                const excess = chart.data.labels.length - 30;
                chart.data.labels.splice(0, excess);
                chart.data.datasets.forEach(d => d.data.splice(0, excess));
            }

            chart.update();
        }

        function setNewPredictionChartData(chart, newData) {
            chart.data.labels = newData.labels;
            chart.data.datasets = newData.datasets;

            if (chart.data.labels.length > 60) {
                const excess = chart.data.labels.length - 60;
                chart.data.labels.splice(0, excess);
                chart.data.datasets.forEach(d => d.data.splice(0, excess));
            }

            chart.update();
        }

        function setSidebarDataStatus(data, nor = '#0086A6', abn = '#A21C1E', inc = '#262626') {
            if (data.length !== 13) {
                return;
            }

            //-- check depth
            if (data[0] === 0) {
                document.getElementById('label-depth').style.backgroundColor = inc;
            } else {
                document.getElementById('label-depth').style.backgroundColor = nor;
            }

            //-- check bit depth
            if (data[1] === 0) {
                document.getElementById('label-bv-depth').style.backgroundColor = inc;
            } else {
                document.getElementById('label-bv-depth').style.backgroundColor = nor;
            }

            //-- check bv depth
            if (data[2] === 0) {
                document.getElementById('label-bit-depth').style.backgroundColor = inc;
            } else {
                document.getElementById('label-bit-depth').style.backgroundColor = nor;
            }

            //-- check blockpos
            if (data[3] === 0) {
                document.getElementById('label-block-pos.').style.backgroundColor = inc;
            } else if (data[3] > 50) {
                document.getElementById('label-block-pos.').style.backgroundColor = abn;
            } else {
                document.getElementById('label-block-pos.').style.backgroundColor = nor;
            }

            //-- check rpm
            if (data[4] === 0) {
                document.getElementById('label-rpm').style.backgroundColor = inc;
            } else if (data[4] > 1000) {
                document.getElementById('label-rpm').style.backgroundColor = abn;
            } else {
                document.getElementById('label-rpm').style.backgroundColor = nor;
            }

            //-- check wob
            if (data[5] === 0) {
                document.getElementById('label-wob').style.backgroundColor = inc;
            } else if (data[5] > 100) {
                document.getElementById('label-wob').style.backgroundColor = abn;
            } else {
                document.getElementById('label-wob').style.backgroundColor = nor;
            }

            //-- check ropi
            if (data[6] === 0) {
                document.getElementById('label-ropi').style.backgroundColor = inc;
            } else if (data[6] > 1000) {
                document.getElementById('label-ropi').style.backgroundColor = abn;
            } else {
                document.getElementById('label-ropi').style.backgroundColor = nor;
            }

            //-- check hkld
            if (data[7] === 0) {
                document.getElementById('label-hkld').style.backgroundColor = inc;
            } else if (data[7] > 300) {
                document.getElementById('label-hkld').style.backgroundColor = abn;
            } else {
                document.getElementById('label-hkld').style.backgroundColor = nor;
            }

            //-- check torque
            if (data[8] === 0) {
                document.getElementById('label-torque').style.backgroundColor = inc;
            } else if (data[8] > 30) {
                document.getElementById('label-torque').style.backgroundColor = abn;
            } else {
                document.getElementById('label-torque').style.backgroundColor = nor;
            }

            //-- check stpress
            if (data[9] === 0) {
                document.getElementById('label-stpress').style.backgroundColor = inc;
            } else if (data[9] > 3000) {
                document.getElementById('label-stpress').style.backgroundColor = abn;
            } else {
                document.getElementById('label-stpress').style.backgroundColor = nor;
            }

            //-- check scfm
            if (data[10] === 0) {
                document.getElementById('label-scfm').style.backgroundColor = inc;
            } else if (data[10] > 5000) {
                document.getElementById('label-scfm').style.backgroundColor = abn;
            } else {
                document.getElementById('label-scfm').style.backgroundColor = nor;
            }

            //-- check flowin
            if (data[11] === 0) {
                document.getElementById('label-flow-in').style.backgroundColor = inc;
            } else if (data[11] > 3000) {
                document.getElementById('label-flow-in').style.backgroundColor = abn;
            } else {
                document.getElementById('label-flow-in').style.backgroundColor = nor;
            }

            //-- check flowout
            if (data[12] === 0) {
                document.getElementById('label-flow-out').style.backgroundColor = inc;
            } else if (data[12] > 3000) {
                document.getElementById('label-flow-out').style.backgroundColor = abn;
            } else {
                document.getElementById('label-flow-out').style.backgroundColor = nor;
            }
        }

        function getChartConfig(labels, datasets, index = 'y') {
            return {
                type: 'line',
                data: { labels: labels, datasets: datasets },
                options: {
                    layout: {
                        padding: { left: -7, bottom: -7, top: -7, right: -7 }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: index,
                    scales: {
                        y: { display: false, beginAtZero: true, afterFit: function(axis) { axis.width = 0; } },
                        x: { display: true, beginAtZero: true, }
                    },
                    plugins: { legend: { display: false } }
                }
            }
        }

        function getNotificationComponent(
            status = false, 
            rpm = true,
            stall = false,
            torque = false,
            cleanbit = true,
            circulation = true,
            date = '' 
        ) {

            //-- status       => is it potential stuck?        TRUE if yes, FALSE if no
            //-- rpm          => is rpm normal?                TRUE if yes, FALSE if no
            //-- stall        => is there any stall?           TRUE if yes, FALSE if no 
            //-- torque       => is there any abnormal torque? TRUE if yes, FALSE if no
            //-- circulation  => is there any circulation?     TRUE if yes, FALSE if no
            //-- cleanbit     => is bit string clean?          TRUE if yes, FALSE if no

            //-- well prediction
            var wcs = status ? 'danger' : '';
            var wst = status ? 'warning' : 'normal';
            var wic = status ? 'ti-bell-exclamation' : 'ti-checks';
            var wdc = status 
                        ? 'potential stuck!' 
                        : 'normal condition!';
            
            //-- rpm status
            var rcs = !rpm ? 'danger' : '';
            var ric = rpm ? 'ti-wave-square' : 'ti-x';
            var rdc = rpm ? 'normal rpm' : 'no rpm!';

            //-- stall status
            var scs = stall ? 'danger' : '';
            var sic = !stall ? 'ti-irregular-polyhedron' : 'ti-irregular-polyhedron-off';
            var sdc = stall ? 'stall formation!' : 'no stall formation';

            //-- torque status
            var tcs = torque ? 'danger' : '';
            var tic = !torque ? 'ti-wave-square' : 'ti-trending-up';
            var tdc = !torque ? 'normal torque' : 'rising torque!';

            //-- cleanbit status
            var ccs = !cleanbit ? 'danger' : '';
            var cic = cleanbit ? 'ti-wall' : 'ti-wall-off';
            var cdc = cleanbit ? 'clean bit string' : 'cutting on bit string!';

            //-- circulation status
            var ncs = !circulation ? 'danger' : '';
            var nic = circulation ? 'ti-droplet-half-filled' : 'ti-droplet-off';
            var ndc = circulation ? 'circulation exist' : 'no circulation!';

            return `
                <div class="notif-container ${wcs}">
                    <div class="notif-header">
                        <i class="ti ${wic}"></i>
                        <div class="notif-texts">
                            <span class="notif-status">${wst}</span>
                            <small class="notif-desc">
                                <span class="notif-date">${date}</span> | <span class="notif-pred">${wdc}</span>
                            </small>
                        </div>
                    </div>
                
                    <div class="notif-body">
                        <div class="notif-pills ${rcs}">
                            <i class="ti ${ric}"></i>
                            <span class="notif-warning">${rdc}</span>
                        </div>
                        <div class="notif-pills ${scs}">
                            <i class="ti ${sic}"></i>
                            <span class="notif-warning">${sdc}</span>
                        </div>
                        <div class="notif-pills ${tcs}">
                            <i class="ti ${tic}"></i>
                            <span class="notif-warning">${tdc}</span>
                        </div>
                        <div class="notif-pills ${ccs}">
                            <i class="ti ${cic}"></i>
                            <span class="notif-warning">${cdc}</span>
                        </div>
                        <div class="notif-pills ${ncs}">
                            <i class="ti ${nic}"></i>
                            <span class="notif-warning">${ndc}</span>
                        </div>
                    </div>
                </div>
            `;
        }

        document.addEventListener('DOMContentLoaded', async function() {
            dst = '2000-01-01 00:00:00';
            den = getToday();

            //-- run all jquery related code
            await initJqueryCodes();

            //-- run all vanila code
            await initVanilaCodes();

            document.getElementById("loading-cover").remove();
        });
    </script>
@endpush