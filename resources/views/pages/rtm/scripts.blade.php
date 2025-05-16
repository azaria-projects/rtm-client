@push('scripts-body')
    <script>
        var noData = false;

        async function init() {
            getCurrentDateTimeAlt();
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
                'count'     : 1,
                'well_name' : nme
            }).toString();

            const bse = `${baseurl}/${baseprefix}/log`;
            const url = `${bse}?${par}`;
            const res = await get(url).then(data => data).catch(error => error);
            return res.response;
        }

        async function getSidebarData(mil = 0) {
            var dat;
            const req = await fetchRecords(getDateRange(mil));
            if (req.length !== 0) {
                const rcd = req.well_record.at(-1);
                dat = [
                    parseInt(rcd.md) ?? 0,
                    parseFloat(rcd.deptbitv) ?? 0,
                    parseFloat(rcd.bitdepth) ?? 0,
                    parseFloat(rcd.blockpos) ?? 0,
                    parseFloat(rcd.rpm) ?? 0,
                    parseFloat(rcd.woba) ?? 0,
                    parseFloat(rcd.ropi) ?? 0,
                    parseFloat(rcd.hklda) ?? 0,
                    parseFloat(rcd.torqa) ?? 0,
                    parseFloat(rcd.stppress) ?? 0,
                    parseFloat(rcd.scfm) ?? 0,
                    parseFloat(rcd.mudflowin) ?? 0,
                    parseFloat(rcd.mudflowout) ?? 0
                ]
            } else {
                dat = new Array(13).fill(0);
            }

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
            var dat;
            var cmp;

            const req = await fetchPredictionLog();

            if (req.length > 0) {
                dat = req[0];
                cmp = getNotificationComponent(
                    dat.well_pr === 1 ? true : false,
                    dat.stats_sr,
                    dat.stats_sl,
                    dat.stats_rt,
                    dat.stats_cl,
                    dat.stats_cr,
                    dat.date.split('+')[0].split('.')[0]
                );
            } else {
                cmp = getNotificationComponent(false, true, false, false, true, true, 'no data');
            }

            const trg = document.getElementById('prediction-notification');
            if (trg.children.length >= 10) {
                trg.firstElementChild.remove();
            }

            trg.insertAdjacentHTML('beforeend', cmp);

            const chd = trg.lastElementChild;
            trg.scrollTop = trg.scrollHeight;

        }

        async function getRecords(mil = 0) {
            const rng = getDateRange(mil);
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

            const cc1 = {
                'labels': tme,
                'datasets': [
                    {label: 'depth', data: dph, borderColor: 'rgba(0, 166, 113, .75)'},
                    {label: 'bit-depth', data: bvd, borderColor: 'rgba(0, 97, 166, .75)'},
                    {label: 'bv-depth', data: btd, borderColor: 'rgba(166, 161, 0, .75)'}
                ],
            };

            const cc2 = {
                'labels': tme,
                'datasets': [
                    {label: 'torque', data: trq, borderColor: 'rgba(166, 0, 86, .75)'},
                    {label: 'ropi', data: rpi, borderColor: 'rgba(0, 97, 166, .75)'},
                    {label: 'wob', data: wob, borderColor: 'rgba(105, 0, 166, .75)'}
                ],
            };

            const cc3 = {
                'labels': tme,
                'datasets': [
                    {label: 'stppress', data: prs, borderColor: 'rgba(166, 0, 136, .75)'},
                    {label: 'rpm', data: rpm, borderColor: 'rgba(0, 97, 166, .75)'},
                    {label: 'hkld', data: hkl, borderColor: 'rgba(0, 166, 158, .75)'},
                    {label: 'block-pos', data: bps, borderColor: 'rgba(0, 166, 89, .75)'}
                ],
            };

           return [cc1, cc2, cc3];
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
                        y: { display: true, beginAtZero: true, afterFit: function(axis) { axis.width = 100; } },
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
            var sdc = !stall ? 'no stall formation' : 'stall formation!';

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
            init();

            const ct1 = document.getElementById('chart1').getContext('2d');
            const ct2 = document.getElementById('chart2').getContext('2d');
            const ct3 = document.getElementById('chart3').getContext('2d');

            const rcd = await getRecords(2.5 * 60 * 1000);
            const sdb = await getSidebarData(60000);
            const plg = await setPredictionNotification();

            const cr1 = new Chart(ct1, getChartConfig(rcd[0].labels, rcd[0].datasets));
            const cr2 = new Chart(ct2, getChartConfig(rcd[1].labels, rcd[1].datasets));
            const cr3 = new Chart(ct3, getChartConfig(rcd[2].labels, rcd[2].datasets));

            setInterval(async () => { 
                const ndt = await getRecords(60000);

                await setNewChartData(cr1, ndt[0]);
                await setNewChartData(cr2, ndt[1]);
                await setNewChartData(cr3, ndt[2]);

                await getSidebarData(60000);
            }, 6000);

            setInterval(async () => { await setPredictionNotification(); }, 1.5 * 60 * 1000);;

            document.querySelectorAll('.chart-filter-1').forEach(cf => {
                cf.addEventListener('click', function() {
                    const lb = this.getAttribute('data-chart');
                    const ix = cr1.data.datasets.findIndex(ds => ds.label === lb);

                    if (ix !== -1) {
                        if (cr1.getDatasetMeta(ix).hidden == true) {
                            cr1.getDatasetMeta(ix).hidden = false;
                        } else {
                            cr1.getDatasetMeta(ix).hidden = true;
                        }
                        
                        cr1.update();
                    }
                });
            });

            document.querySelectorAll('.chart-filter-2').forEach(cf => {
                cf.addEventListener('click', function() {
                    const lb = this.getAttribute('data-chart');
                    const ix = cr2.data.datasets.findIndex(ds => ds.label === lb);

                    if (ix !== -1) {
                        if (cr2.getDatasetMeta(ix).hidden == true) {
                            cr2.getDatasetMeta(ix).hidden = false;
                        } else {
                            cr2.getDatasetMeta(ix).hidden = true;
                        }
                        
                        cr2.update();
                    }
                });
            });

            document.querySelectorAll('.chart-filter-3').forEach(cf => {
                cf.addEventListener('click', function() {
                    const lb = this.getAttribute('data-chart');
                    const ix = cr3.data.datasets.findIndex(ds => ds.label === lb);

                    if (ix !== -1) {
                        if (cr3.getDatasetMeta(ix).hidden == true) {
                            cr3.getDatasetMeta(ix).hidden = false;
                        } else {
                            cr3.getDatasetMeta(ix).hidden = true;
                        }
                        
                        cr3.update();
                    }

                    document.getElementById('reset-click').click()
                });
            });

            document.querySelectorAll('.icon-filter').forEach(ic => {
                ic.addEventListener('click', function() {
                    const lb = this.getAttribute('data-chart');
                    if (lb !== undefined || lb !== null) {
                        if (this.classList.contains('disabled')) {
                            this.classList.remove('disabled');
                        } else {
                            this.classList.add('disabled')
                        }
                    }
                });
            });

            document.getElementById("loading-cover").remove();
        });
    </script>
@endpush