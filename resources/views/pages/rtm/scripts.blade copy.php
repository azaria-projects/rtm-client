@push('scripts-body')
    <script>
        async function init() {
            getCurrentDateTimeAlt();
        }

        async function getRecordData(rng = {}) {
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

        function getChartConfig(labels = {}, datasets = {}, index = 'y') {
            return {
                type: 'line',
                data: { labels: labels, datasets: datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: index,
                    scales: {
                        y: { 
                            display: true,
                            afterFit: function(axis) {
                                axis.width = 100; 
                            },
                        },
                        x: { display: true }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            }
        }

        function displayRecordData(mil = 0, data = {}) {
            const req = await getRecordData(getDateRange(mil));
            const rcd = req.well_record;

            //-- chart data
            const dph = [], btd = [], bvd = [];
            const trq = [], rpi = [], wob = [];
            const prs = [], rpm = [], hkl = [], bps = [];

            //-- others data
            const sfm = [], fli = [], const flo = [];

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
                
                dph.push(md); btd.push(bitdepth); bvd.push(bvdepth);
                trq.push(torque); rpi.push(ropi); wob.push(woba);
                prs.push(stppress); rpm.push(rpma); hkl.push(hklda); bps.push(blockpos);
                
                fli.push(mudflowin); flo.push(mudflowout); sfm.push(scfm);
            });


        }

        document.addEventListener('DOMContentLoaded', async function() {
            init();

            const ct1 = document.getElementById('chart1').getContext('2d');
            const ct2 = document.getElementById('chart2').getContext('2d');
            const ct3 = document.getElementById('chart3').getContext('2d');

            const cr1 = new Chart(ct1, getChart1Conf());
            const cr2 = new Chart(ct2, getChart2Conf());
            const cr3 = new Chart(ct3, getChart3Conf());

            function getChart1Conf() {
                return {
                    type: 'line',
                    data: {
                        labels: Array.from({length: 60}, (_,i) => i+1),
                        datasets: [
                            {label: 'depth', data: Array(60).fill(0), borderColor: '#00A671'},
                            {label: 'bit-depth', data: Array(60).fill(0), borderColor: '#0061A6'},
                            {label: 'bv-depth', data: Array(60).fill(0), borderColor: '#A6A100'}
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y',
                        scales: {
                            y: { 
                                display: true,
                                afterFit: function(axis) {
                                    axis.width = 100; 
                                },
                            },
                            x: { display: true }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                }
            }

            function getChart2Conf() {
                return {
                    type: 'line',
                    data: {
                        labels: Array.from({length: 60}, (_,i) => i+1),
                        datasets: [
                            {label: 'torque', data: Array(60).fill(0), borderColor: '#A60056'},
                            {label: 'ropi', data: Array(60).fill(0), borderColor: '#0061A6'},
                            {label: 'wob', data: Array(60).fill(0), borderColor: '#6900A6'}
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y',
                        scales: {
                            y: { 
                                display: true,
                                afterFit: function(axis) {
                                    axis.width = 100; 
                                },
                            },
                            x: { display: true }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                }
            }

            function getChart3Conf() {
                return {
                    type: 'line',
                    data: {
                        labels: Array.from({length: 60}, (_,i) => i+1),
                        datasets: [
                            {label: 'stppress', data: Array(60).fill(0), borderColor: '#A60088'},
                            {label: 'rpm', data: Array(60).fill(0), borderColor: '#0061A6'},
                            {label: 'hkld', data: Array(60).fill(0), borderColor: '#00A69E'},
                            {label: 'block-pos', data: Array(60).fill(0), borderColor: '#00A659'}
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y',
                        scales: {
                            y: { 
                                display: true,
                                afterFit: function(axis) {
                                    axis.width = 100; 
                                },
                            },
                            x: { display: true }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                }
            }

            async function updateChart1Data(cd = '') {
                cr1.data.labels = [...cr1.data.labels.slice(1), cd];
                cr1.data.datasets.forEach((dataset, index) => {
                    const newValue = index === 0 ? Math.random() * 100 :
                                index === 1 ? Math.random() * 80 + 20 :
                                index === 2 ? Math.random() * 60 + 40 :
                                Math.random() * 20 + 80;
                    
                    dataset.data = [...dataset.data.slice(1), newValue];
                });

                cr1.update();
            }

            async function updateChart2Data(cd = '') {
                cr2.data.labels = [...cr2.data.labels.slice(1), cd];
                cr2.data.datasets.forEach((dataset, index) => {
                    const newValue = index === 0 ? Math.random() * 100 :
                                index === 1 ? Math.random() * 80 + 20 :
                                index === 2 ? Math.random() * 60 + 40 :
                                Math.random() * 20 + 80;
                    
                    dataset.data = [...dataset.data.slice(1), newValue];
                });

                cr2.update();
            }

            async function updateChart3Data(cd = '') {
                cr3.data.labels = [...cr3.data.labels.slice(1), cd];
                cr3.data.datasets.forEach((dataset, index) => {
                    const newValue = index === 0 ? Math.random() * 100 :
                                index === 1 ? Math.random() * 80 + 20 :
                                index === 2 ? Math.random() * 60 + 40 :
                                Math.random() * 20 + 80;
                    
                    dataset.data = [...dataset.data.slice(1), newValue];
                });

                cr3.update();
            }

            setInterval(() => {
                const nw = new Date().toLocaleTimeString('en-GB');
                
                updateChart1Data(nw);
                updateChart2Data(nw);
                updateChart3Data(nw);

            }, 1000);

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
