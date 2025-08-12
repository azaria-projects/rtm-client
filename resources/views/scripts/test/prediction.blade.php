<script>
    function StuckPrediction() {
        status      = false, 
        rpm         = true,
        stall       = false,
        torque      = false,
        cleanbit    = true,
        circulation = true,
        this.date   = '' 
    }

    StuckPrediction.prototype.getNotificationComponents = function (
        status      = false,
        rpm         = true,
        stall       = false,
        torque      = false,
        cleanbit    = true,
        circulation = true,
        date        = ''
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
        var wdc = status ? 'potential stuck!' : 'normal condition!';
        
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
                    <div class="notif-pills pill-rpm ${rcs}">
                        <i class="ti ${ric}"></i>
                        <span class="notif-warning">${rdc}</span>
                    </div>
                    <div class="notif-pills pill-stall ${scs}">
                        <i class="ti ${sic}"></i>
                        <span class="notif-warning">${sdc}</span>
                    </div>
                    <div class="notif-pills pill-torq ${tcs}">
                        <i class="ti ${tic}"></i>
                        <span class="notif-warning">${tdc}</span>
                    </div>
                    <div class="notif-pills pill-cleanbit ${ccs}">
                        <i class="ti ${cic}"></i>
                        <span class="notif-warning">${cdc}</span>
                    </div>
                    <div class="notif-pills pill-circulation ${ncs}">
                        <i class="ti ${nic}"></i>
                        <span class="notif-warning">${ndc}</span>
                    </div>
                </div>
            </div>
        `;
    }

    StuckPrediction.prototype.getPredictionLog = async function () {
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

    StuckPrediction.prototype.getNotification = function () {
        const container = document.getElementById('prediction-notification');
        const components = this.getNotificationComponents(
            Math.random() < 0.8, 
            Math.random() < 0.5, 
            Math.random() < 0.5, 
            Math.random() < 0.5, 
            Math.random() < 0.5, 
            Math.random() < 0.5, 
            'test data'
        );

        if (container.children.length >= 10) {
            container.firstElementChild.remove();
        }

        container.insertAdjacentHTML('beforeend', components);

        const childs        = container.lastElementChild;
        container.scrollTop = container.scrollHeight;
    }

    StuckPrediction.prototype.initNotification = async function () {
        this.getNotification();
        setInterval(async () => { this.getNotification() }, 1.5 * 60 * 1000);
    }    
</script>