<script>
    function ChartSensors(ranges = 5000, scales = 900000) {
        this.records  = []; 
        this.ranges   = ranges;
        this.scales   = scales;
        this.isNoData = false;

        this.depth    = document.getElementById('chart-depth').getContext('2d');
        this.bitdepth = document.getElementById('chart-bitdepth').getContext('2d');
        this.bvdepth  = document.getElementById('chart-bvdepth').getContext('2d');
        this.blockpos = document.getElementById('chart-blockpos').getContext('2d');
        this.torque   = document.getElementById('chart-torque').getContext('2d');
        this.ropi     = document.getElementById('chart-ropi').getContext('2d');
        this.wob      = document.getElementById('chart-wob').getContext('2d');
        this.stppress = document.getElementById('chart-stppress').getContext('2d');
        this.hkld     = document.getElementById('chart-hkld').getContext('2d');
        this.rpm      = document.getElementById('chart-rpm').getContext('2d');

        this.vDepth    = document.getElementById('chart-v-depth').getContext('2d');
        this.vBitdepth = document.getElementById('chart-v-bitdepth').getContext('2d');
        this.vBvdepth  = document.getElementById('chart-v-bvdepth').getContext('2d');
        this.vBlockpos = document.getElementById('chart-v-blockpos').getContext('2d');
        this.vTorque   = document.getElementById('chart-v-torque').getContext('2d');
        this.vRopi     = document.getElementById('chart-v-ropi').getContext('2d');
        this.vWob      = document.getElementById('chart-v-wob').getContext('2d');
        this.vStppress = document.getElementById('chart-v-stppress').getContext('2d');
        this.vHkld     = document.getElementById('chart-v-hkld').getContext('2d');
        this.vRpm      = document.getElementById('chart-v-rpm').getContext('2d');
    }

    ChartSensors.prototype.getDateRange = function (milisecond = 6000, zone = 'Asia/Jakarta') {
        const endDate    = new Date();
        const startDate  = new Date(endDate.getTime() - milisecond);
        const dateFormat = {
            timeZone: zone,
            hour12: false,
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };

        return {
            'start': new Intl.DateTimeFormat('en-US', dateFormat)
                .format(startDate)
                .replace(/(\d+)\/(\d+)\/(\d+), (\d+:\d+:\d+)/, '$3-$1-$2 $4'),
            'end': new Intl.DateTimeFormat('en-US', dateFormat)
                .format(endDate)
                .replace(/(\d+)\/(\d+)\/(\d+), (\d+:\d+:\d+)/, '$3-$1-$2 $4')
        };
    }

    ChartSensors.prototype.getAdvancedDateRange = function (zone = 'Asia/Jakarta') {
        const currdate   = new Date();
        const endDate    = Math.floor((currdate + this.scales) + this.ranges) - this.ranges;
        const startDate  = endDate - this.scales;
        const dateFormat = {
            timeZone: zone,
            hour12: false,
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };

        return {
            'start': new Intl.DateTimeFormat('en-US', dateFormat)
                .format(startDate)
                .replace(/(\d+)\/(\d+)\/(\d+), (\d+:\d+:\d+)/, '$3-$1-$2 $4'),
            'end': new Intl.DateTimeFormat('en-US', dateFormat)
                .format(endDate)
                .replace(/(\d+)\/(\d+)\/(\d+), (\d+:\d+:\d+)/, '$3-$1-$2 $4')
        };
    }

    ChartSensors.prototype.getWellRecords = async function (range) {
        const params = new URLSearchParams({
            'token': @json($tkn),
            'start': range['start'],
            'end'  : range['end'],
            'name' : @json($nme)
        }).toString();

        const url = `${exbaseurl}/${baseprefix}/well/records?${params}`;
        const res = await get(url).then(data => data).catch(error => error);
        return res.response;
    }

    ChartSensors.prototype.getSpecificChartRecords = async function (range) {
        let records;
        let isNoData;

        const request = await this.getWellRecords(range);
        
        const time     = [], depth      = [], bitdepth = [], bvdepth   = [];
        const torque   = [], ropi       = [], wob      = [], stppress  = [];
        const hookload = [], blockpos   = [], scfm     = [], mudflowin = [];
        const rpm      = [], mudflowout = []; 

        records = request.well_record;
        records.forEach(elmement => {
            time.push(elmement.time)
            rpm.push(parseFloat(elmement.rpm)); 
            wob.push(parseFloat(elmement.woba));
            depth.push(parseFloat(elmement.md));
            ropi.push(parseFloat(elmement.ropi));
            scfm.push(parseFloat(elmement.scfm));
            torque.push(parseFloat(elmement.torqa));
            hookload.push(parseFloat(elmement.hklda)); 
            bvdepth.push(parseFloat(elmement.deptbitv));
            bitdepth.push(parseFloat(elmement.bitdepth));
            stppress.push(parseFloat(elmement.stppress));
            blockpos.push(parseFloat(elmement.blockpos)); 
            mudflowin.push(parseFloat(elmement.mudflowin));
            mudflowout.push(parseFloat(elmement.mudflowout)); 
        });

        return {
            'wob': this.getChartRecordFormat(time, {
                label: 'wob', data: wob, borderColor: 'rgba(105, 0, 166, .75)'
            }),
            'rpm': this.getChartRecordFormat(time, {
                label: 'rpm', data: rpm, borderColor: 'rgba(0, 97, 166, .75)'
            }),
            'ropi': this.getChartRecordFormat(time, {
                label: 'ropi', data: scfm, borderColor: 'rgba(0, 97, 166, .75)'
            }),
            'scfm': this.getChartRecordFormat(time, {
                label: 'scfm', data: scfm, borderColor: 'rgba(0, 97, 166, .75)'
            }),
            'depth': this.getChartRecordFormat(time, {
                label: 'depth', data: depth, borderColor: 'rgba(0, 166, 113, .75)'
            }),
            'torque': this.getChartRecordFormat(time, {
                label: 'torque', data: torque, borderColor: 'rgba(166, 0, 86, .75)'
            }),
            'bvdepth': this.getChartRecordFormat(time, {
                label: 'bvdepth', data: bvdepth, borderColor: 'rgba(0, 166, 158, .75)'
            }),
            'bitdepth': this.getChartRecordFormat(time, {
                label: 'bitdepth', data: bitdepth, borderColor: 'rgba(166, 161, 0, .75)'
            }),
            'stppress': this.getChartRecordFormat(time, {
                label: 'stppress', data: stppress, borderColor: 'rgba(166, 0, 136, .75)'
            }), 
            'hookload': this.getChartRecordFormat(time, {
                label: 'hookload', data: hookload, borderColor: 'rgba(0, 166, 158, .75)'
            }),
            'blockpos': this.getChartRecordFormat(time, {
                label: 'blockpos', data: blockpos, borderColor: 'rgba(195, 112, 155, 0.8)'
            }),
            'mudflowout': this.getChartRecordFormat(time, {
                label: 'mudflowin', data: mudflowin, borderColor: 'rgba(166, 0, 136, .75)'
            }),
            'mudflowin': this.getChartRecordFormat(time, {
                label: 'mudflowin', data: mudflowin, borderColor: 'rgba(166, 0, 136, .75)'
            }),
        }
    }

    ChartSensors.prototype.getChartRecordFormat = function (labels, datasets) {
        return {
            'labels': labels,
            'datasets': [datasets]
        }
    }

    ChartSensors.prototype.getChartRecords = async function(milisecond = 2.5 * 60 * 1000) {
        let records;

        const dateRange = this.getDateRange(milisecond);
        const request   = await this.getWellRecords(dateRange);
        
        const time     = [], depth      = [], bitdepth = [], bvdepth   = [];
        const torque   = [], ropi       = [], wob      = [], stppress  = [];
        const hookload = [], blockpos   = [], scfm     = [], mudflowin = [];
        const rpm      = [], mudflowout = []; 

        if (request.length !== 0) {
            records = request.well_record;
            this.isNoData = false;
        } else {
            records = [{
                'time'      : new Date().toTimeString().slice(0, 8),
                'md'        : 0,
                'bitdepth'  : 0,
                'deptbitv'  : 0,
                'torqa'     : 0,
                'ropi'      : 0,
                'woba'      : 0,
                'stppress'  : 0,
                'rpm'       : 0,
                'hklda'     : 0,
                'blockpos'  : 0,
                'mudflowin' : 0,
                'mudflowout': 0,
                'scfm'      : 0,
            }];
            this.isNoData = true;
        }

        records.forEach(elmement => {
            time.push(elmement.time)
            rpm.push(parseFloat(elmement.rpm)); 
            wob.push(parseFloat(elmement.woba));
            depth.push(parseFloat(elmement.md));
            ropi.push(parseFloat(elmement.ropi));
            scfm.push(parseFloat(elmement.scfm));
            torque.push(parseFloat(elmement.torqa));
            hookload.push(parseFloat(elmement.hklda)); 
            bvdepth.push(parseFloat(elmement.deptbitv));
            bitdepth.push(parseFloat(elmement.bitdepth));
            stppress.push(parseFloat(elmement.stppress));
            blockpos.push(parseFloat(elmement.blockpos)); 
            mudflowin.push(parseFloat(elmement.mudflowin));
            mudflowout.push(parseFloat(elmement.mudflowout)); 
        });

        this.records = {
            'wob': this.getChartRecordFormat(time, {
                label: 'wob', data: wob, borderColor: 'rgba(105, 0, 166, .75)'
            }),
            'rpm': this.getChartRecordFormat(time, {
                label: 'rpm', data: rpm, borderColor: 'rgba(0, 97, 166, .75)'
            }),
            'ropi': this.getChartRecordFormat(time, {
                label: 'ropi', data: scfm, borderColor: 'rgba(0, 97, 166, .75)'
            }),
            'scfm': this.getChartRecordFormat(time, {
                label: 'scfm', data: scfm, borderColor: 'rgba(0, 97, 166, .75)'
            }),
            'depth': this.getChartRecordFormat(time, {
                label: 'depth', data: depth, borderColor: 'rgba(0, 166, 113, .75)'
            }),
            'torque': this.getChartRecordFormat(time, {
                label: 'torque', data: torque, borderColor: 'rgba(166, 0, 86, .75)'
            }),
            'bvdepth': this.getChartRecordFormat(time, {
                label: 'bvdepth', data: bvdepth, borderColor: 'rgba(0, 166, 158, .75)'
            }),
            'bitdepth': this.getChartRecordFormat(time, {
                label: 'bitdepth', data: bitdepth, borderColor: 'rgba(166, 161, 0, .75)'
            }),
            'stppress': this.getChartRecordFormat(time, {
                label: 'stppress', data: stppress, borderColor: 'rgba(166, 0, 136, .75)'
            }), 
            'hookload': this.getChartRecordFormat(time, {
                label: 'hookload', data: hookload, borderColor: 'rgba(0, 166, 158, .75)'
            }),
            'blockpos': this.getChartRecordFormat(time, {
                label: 'blockpos', data: blockpos, borderColor: 'rgba(195, 112, 155, 0.8)'
            }),
            'mudflowout': this.getChartRecordFormat(time, {
                label: 'mudflowin', data: mudflowin, borderColor: 'rgba(166, 0, 136, .75)'
            }),
            'mudflowin': this.getChartRecordFormat(time, {
                label: 'mudflowin', data: mudflowin, borderColor: 'rgba(166, 0, 136, .75)'
            }),
        }
    }

    ChartSensors.prototype.getChartConfig = function (labels, datasets, yWidth = 70) {
        return {
            type: 'line',
            data: { labels: labels, datasets: datasets },
            options: {
                layout: {
                    padding: { left: -7, bottom: -7, top: -7, right: -7 }
                },
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: {
                    y: { 
                        display: true, 
                        beginAtZero: true,
                        ticks: {
                            display: true,
                        },
                        grid: {
                            drawBorder: true,
                            display: true,
                            color: 'rgba(255, 255, 255, .05)',
                            borderColor: 'rgba(255, 255, 255, .05)',
                        },
                        border: {
                            display: false,
                        }, 
                        afterFit: function(axis) { axis.width = yWidth; } 
                    },
                    x: { 
                        display: true, 
                        beginAtZero: true, 
                        border: {
                            display: false,
                        }, 
                        grid: {
                            drawBorder: true,
                            display: true,
                            color: 'rgba(255, 255, 255, .05)',
                            borderColor: 'rgba(255, 255, 255, .05)',
                        },
                    }
                },
                plugins: { 
                    legend: { 
                        display: false,
                        position: 'top',
                        align: 'center' 
                    } 
                }
            }
        }
    }

    ChartSensors.prototype.setCharts = function () {
        this.chartWob      = new Chart(this.wob, this.getChartConfig(this.records['wob'].labels, this.records['wob'].datasets, 0));
        this.chartRpm      = new Chart(this.rpm, this.getChartConfig(this.records['rpm'].labels, this.records['rpm'].datasets, 0));
        this.chartRopi     = new Chart(this.ropi, this.getChartConfig(this.records['ropi'].labels, this.records['ropi'].datasets, 0));
        this.chartDepth    = new Chart(this.depth, this.getChartConfig(this.records['depth'].labels, this.records['depth'].datasets));
        this.chartTorque   = new Chart(this.torque, this.getChartConfig(this.records['torque'].labels, this.records['torque'].datasets, 0));
        this.chartHkld     = new Chart(this.hkld, this.getChartConfig(this.records['hookload'].labels, this.records['hookload'].datasets, 0));
        this.chartBvdepth  = new Chart(this.bvdepth, this.getChartConfig(this.records['bvdepth'].labels, this.records['bvdepth'].datasets, 0));
        this.chartBitdepth = new Chart(this.bitdepth, this.getChartConfig(this.records['bitdepth'].labels, this.records['bitdepth'].datasets, 0));
        this.chartBlockpos = new Chart(this.blockpos, this.getChartConfig(this.records['blockpos'].labels, this.records['blockpos'].datasets, 0));
        this.chartStppress = new Chart(this.stppress, this.getChartConfig(this.records['stppress'].labels, this.records['stppress'].datasets, 0));
        
        this.chartVdepth    = new Chart(this.vDepth, this.getChartConfig([], []));
        this.chartVwob      = new Chart(this.vWob, this.getChartConfig([], [], 0));
        this.chartVrpm      = new Chart(this.vRpm, this.getChartConfig([], [], 0));
        this.chartVhkld     = new Chart(this.vHkld, this.getChartConfig([], [], 0));
        this.chartVropi     = new Chart(this.vRopi, this.getChartConfig([], [], 0));
        this.chartVtorque   = new Chart(this.vTorque, this.getChartConfig([], [], 0));
        this.chartVbvdepth  = new Chart(this.vBvdepth, this.getChartConfig([], [], 0));
        this.chartVbitdepth = new Chart(this.vBitdepth, this.getChartConfig([], [], 0));
        this.chartVblockpos = new Chart(this.vBlockpos, this.getChartConfig([], [], 0));
        this.chartVstppress = new Chart(this.vStppress, this.getChartConfig([], [], 0));
    }

    ChartSensors.prototype.setNewChartData = async function (chart, newData) {
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

    ChartSensors.prototype.setNewChartData1 = async function (chart, newData) {
        chart.data.labels.push(...newData.labels);
        chart.data.datasets.forEach((dataset, i) => {
            console.log('does not executed here');
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

    ChartSensors.prototype.setNewChartUpdate = async function () {
        await this.getChartRecords(60000);
        await Promise.all([
            this.setNewChartData(this.chartWob, this.records['wob']),
            this.setNewChartData(this.chartRpm, this.records['rpm']),
            this.setNewChartData(this.chartHkld, this.records['hookload']),
            this.setNewChartData(this.chartRopi, this.records['ropi']),
            this.setNewChartData(this.chartDepth, this.records['depth']),
            this.setNewChartData(this.chartTorque, this.records['torque']),
            this.setNewChartData(this.chartBvdepth, this.records['bvdepth']),
            this.setNewChartData(this.chartBitdepth, this.records['bitdepth']),
            this.setNewChartData(this.chartBlockpos, this.records['blockpos']),
            this.setNewChartData(this.chartStppress, this.records['stppress']),
        ]);
    }

    ChartSensors.prototype.setNewPredictionChartData = async function (range) {
        const records = await this.getSpecificChartRecords(range);
        
        await this.setNewChartData1(this.chartVdepth, records['depth']);
        await this.setNewChartData1(this.chartVwob, records['wob']);
        await this.setNewChartData1(this.chartVrpm, records['rpm']);
        await this.setNewChartData1(this.chartVhkld, records['hookload']);
        await this.setNewChartData1(this.chartVropi, records['ropi']);
        await this.setNewChartData1(this.chartVtorque, records['torque']);
        await this.setNewChartData1(this.chartVbvdepth, records['bvdepth']);
        await this.setNewChartData1(this.chartVbitdepth, records['bitdepth']);
        await this.setNewChartData1(this.chartVblockpos, records['blockpos']);
        await this.setNewChartData1(this.chartVstppress, records['stppress']);
    }

    ChartSensors.prototype.initCharts = async function () {
        await this.getChartRecords();
        await this.setCharts();

        setInterval(async () => { this.setNewChartUpdate() }, 6000);
    }
</script>