<script>
    function SidebarData() {
        this.isNoData   = false;

        this.md         = 0;
        this.scfm       = 0;
        this.rpm        = 0;
        this.woba       = 0;
        this.ropi       = 0;
        this.hklda      = 0;
        this.torqa      = 0;
        this.stppress   = 0;
        this.deptbitv   = 0;
        this.bitdepth   = 0;
        this.blockpos   = 0;
        this.mudflowin  = 0;
        this.mudflowout = 0;
    }

    SidebarData.prototype.getDateRange = function (milisecond = 6000, zone = 'Asia/Jakarta') {
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

    SidebarData.prototype.getWellRecords = async function (range) {
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

    SidebarData.prototype.getSidebarData = async function (milisecond = 6000) {
        let data;

        const ranges  = this.getDateRange(milisecond)
        const request = await this.getWellRecords(ranges);

        if (request.length !== 0) {
            data            = request.well_record.at(-1);

            this.md         = parseInt(data.md) ?? 0;
            this.rpm        = parseFloat(data.rpm) ?? 0;
            this.ropi       = parseFloat(data.ropi) ?? 0;
            this.scfm       = parseFloat(data.scfm) ?? 0;
            this.woba       = parseFloat(data.woba) ?? 0;
            this.hklda      = parseFloat(data.hklda) ?? 0;
            this.torqa      = parseFloat(data.torqa) ?? 0;
            this.stppress   = parseFloat(data.stppress) ?? 0;
            this.deptbitv   = parseFloat(data.deptbitv) ?? 0;
            this.blockpos   = parseFloat(data.blockpos) ?? 0; 
            this.bitdepth   = parseFloat(data.bitdepth) ?? 0;
            this.mudflowin  = parseFloat(data.mudflowin) ?? 0;
            this.mudflowout = parseFloat(data.mudflowout) ?? 0;
        } else {
            this.md         = 0;
            this.rpm        = 0;
            this.ropi       = 0;
            this.scfm       = 0;
            this.woba       = 0;
            this.hklda      = 0;
            this.torqa      = 0;
            this.stppress   = 0;
            this.deptbitv   = 0;
            this.blockpos   = 0;
            this.bitdepth   = 0;
            this.mudflowin  = 0;
            this.mudflowout = 0;
        }

        this.setDataStatus();
        this.setDataValueUpdate();
    }

    SidebarData.prototype.setDataValueUpdate = async function () {
        document.getElementById('value-depth').innerHTML      = this.md;
        document.getElementById('value-rpm').innerHTML        = this.rpm;
        document.getElementById('value-wob').innerHTML        = this.woba;
        document.getElementById('value-ropi').innerHTML       = this.ropi;
        document.getElementById('value-scfm').innerHTML       = this.scfm;
        document.getElementById('value-torque').innerHTML     = this.torqa;
        document.getElementById('value-hkld').innerHTML       = this.hklda;
        document.getElementById('value-stppress').innerHTML   = this.stppress;
        document.getElementById('value-bv-depth').innerHTML   = this.deptbitv;
        document.getElementById('value-bit-depth').innerHTML  = this.bitdepth;
        document.getElementById('value-block-pos').innerHTML  = this.blockpos;
        document.getElementById('value-flow-in').innerHTML    = this.mudflowin;
        document.getElementById('value-flow-out').innerHTML   = this.mudflowout;
    }

    SidebarData.prototype.setDataStatus = function () {
        const normal = '#0086A6';
        const abnornal = '#A21C1E'; 
        const inactive = '#262626';

        document.getElementById('label-rpm').style.backgroundColor = this.rpm === 0 ?  inactive : normal;
        document.getElementById('label-wob').style.backgroundColor = this.woba === 0 ?  inactive : normal;
        document.getElementById('label-depth').style.backgroundColor = this.md === 0 ?  inactive : normal;
        document.getElementById('label-scfm').style.backgroundColor = this.scfm === 0 ?  inactive : normal;
        document.getElementById('label-ropi').style.backgroundColor = this.ropi === 0 ?  inactive : normal;
        document.getElementById('label-hkld').style.backgroundColor = this.hklda === 0 ?  inactive : normal;
        document.getElementById('label-torque').style.backgroundColor = this.torqa === 0 ?  inactive : normal;
        document.getElementById('label-flow-in').style.backgroundColor = this.mudflowin === 0 ?  inactive : normal;
        document.getElementById('label-stppress').style.backgroundColor = this.stppress === 0 ?  inactive : normal;
        document.getElementById('label-bv-depth').style.backgroundColor = this.deptbitv === 0 ?  inactive : normal;
        document.getElementById('label-bit-depth').style.backgroundColor = this.bitdepth === 0 ?  inactive : normal;
        document.getElementById('label-block-pos').style.backgroundColor = this.blockpos === 0 ?  inactive : normal;
        document.getElementById('label-flow-out').style.backgroundColor = this.mudflowout === 0 ?  inactive : normal;

        if (this.blockpos > 50) {
            document.getElementById('label-block-pos').style.backgroundColor = abnornal;
        }

        if (this.rpm > 1000) {
            document.getElementById('label-rpm').style.backgroundColor = abnornal;
        }

        if (this.wob > 100) {
            document.getElementById('label-wob').style.backgroundColor = abnornal;
        }

        if (this.ropi > 1000) {
            document.getElementById('label-ropi').style.backgroundColor = abnornal;
        }

        if (this.hookload > 300) {
            document.getElementById('label-hkld').style.backgroundColor = abnornal;
        }

        if (this.torque > 30) {
            document.getElementById('label-torque').style.backgroundColor = abnornal;
        }

        if (this.stppress > 3000) {
            document.getElementById('label-stppress').style.backgroundColor = abnornal;
        }

        if (this.scfm > 5000) {
            document.getElementById('label-scfm').style.backgroundColor = abnornal;
        }

        if (this.mudflowin > 3000) {
            document.getElementById('label-flow-in').style.backgroundColor = abnornal;
        }

        if (this.mudflowout > 3000) {
            document.getElementById('label-flow-out').style.backgroundColor = abnornal;
        }
    }

    SidebarData.prototype.initSidebar = async function () {
        await this.getSidebarData();

        setInterval(async () => { await this.getSidebarData() }, 6000);
    }

    document.addEventListener('DOMContentLoaded', async function() {
        const LeftSidebar = new SidebarData();
        await LeftSidebar.initSidebar();
    });
</script>