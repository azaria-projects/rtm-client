@push('scripts-body')
    <script>
        async function init() {
            getCurrentDateTimeAlt();
        }

        async function fetchRecords(rng) {
            const tkn = @json($tkn);
            const nme = @json($nme);
            const pyd = {
                'token': tkn,
                'start': rng['start'],
                'end'  : rng['end'],
                'name' : nme
            };

            const par = new URLSearchParams(pyd).toString();
            const bse = `${exbaseurl}/${baseprefix}/well/records`;
            const url = `${bse}?${par}`;

            const res = await get(url, pyd).then(data => data).catch(error => error);
            return res.response;
        }

        async function getRecords(mil = 0) {
            const req = await fetchRecords(getDateRange(mil));
            const rcd = req.well_record;

            //-- chart data
            const tme = [];
            const dph = [], btd = [], bvd = [];
            const trq = [], rpi = [], wob = [];
            const prs = [], rpm = [], hkl = [], bps = [];

            //-- others data
            const sfm = [], fli = [], flo = [];

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

            const cc1 = {
                'labels': tme,
                'datasets': [
                    {label: 'depth', data: dph, borderColor: '#00A671'},
                    {label: 'bit-depth', data: bvd, borderColor: '#0061A6'},
                    {label: 'bv-depth', data: btd, borderColor: '#A6A100'}
                ],
            };

            const cc2 = {
                'labels': tme,
                'datasets': [
                    {label: 'torque', data: trq, borderColor: '#A60056'},
                    {label: 'ropi', data: rpi, borderColor: '#0061A6'},
                    {label: 'wob', data: wob, borderColor: '#6900A6'}
                ],
            };

            const cc3 = {
                'labels': tme,
                'datasets': [
                    {label: 'stppress', data: prs, borderColor: '#A60088'},
                    {label: 'rpm', data: rpm, borderColor: '#0061A6'},
                    {label: 'hkld', data: hkl, borderColor: '#00A69E'},
                    {label: 'block-pos', data: bps, borderColor: '#00A659'}
                ],
            };

           return [cc1, cc2, cc3];
        }

        async function setChartData(cr1, cr2, cr3) {
            const rcd = await getRecords(6000);
            const [cc1, cc2, cc3] = rcd;

            cr1.data.labels = [...cr1.data.labels.slice(1), cc1.labels.at(-1)];
            cr1.data.datasets.forEach((dataset, index) => {
                dataset.data = [...dataset.data.slice(1), cc1.datasets[index].data.at(-1)];
            });

            cr2.data.labels = [...cr2.data.labels.slice(1), cc2.labels.at(-1)];
            cr2.data.datasets.forEach((dataset, index) => {
                dataset.data = [...dataset.data.slice(1), cc2.datasets[index].data.at(-1)];
            });

            cr3.data.labels = [...cr3.data.labels.slice(1), cc3.labels.at(-1)];
            cr3.data.datasets.forEach((dataset, index) => {
                dataset.data = [...dataset.data.slice(1), cc3.datasets[index].data.at(-1)];
            });

            const maxDataPoints = 60;
            [cr1, cr2, cr3].forEach(chart => {
                if (chart.data.labels.length > maxDataPoints) {
                    chart.data.labels.shift();
                    chart.data.datasets.forEach(dataset => dataset.data.shift());
                }
            });

            cr1.update(); cr2.update(); cr3.update();
        }

        function getChartConfig(labels, datasets, index = 'y') {
            return {
                type: 'line',
                data: { labels: labels, datasets: datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: index,
                    scales: {
                        y: { display: true, afterFit: function(axis) { axis.width = 100; } },
                        x: { display: true }
                    },
                    plugins: { legend: { display: false } }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', async function() {
            init();

            const ct1 = document.getElementById('chart1').getContext('2d');
            const ct2 = document.getElementById('chart2').getContext('2d');
            const ct3 = document.getElementById('chart3').getContext('2d');

            const rcd = await getRecords(5 * 60 * 1000);
            const sdb = await getSidebarData();

            const cr1 = new Chart(ct1, getChartConfig(rcd[0].labels, rcd[0].datasets));
            const cr2 = new Chart(ct2, getChartConfig(rcd[1].labels, rcd[1].datasets));
            const cr3 = new Chart(ct3, getChartConfig(rcd[2].labels, rcd[2].datasets));

            setInterval(async () => { await setChartData(cr1, cr2, cr3); }, 6000);

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
        });
    </script>
@endpush
