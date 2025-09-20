import './bootstrap';
import 'bootstrap';

import toastr from 'toastr';

const baseurl   = import.meta.env.VITE_SERVER_URL;
const exBaseurl = import.meta.env.VITE_EXSERVER_URL;
const prefix    = import.meta.env.VITE_SERVER_PREFIX;
const exPrefix  = import.meta.env.VITE_EXSERVER_PREFIX;

async function get(url = '') {
    try {
        const par = { method: 'GET', headers: { 'Content-Type': 'application/json', 'Cache-Control': 'no-store' }}
        const res = await fetch(url, par);
        const dat = await res.json();

        // console.log(url);
        // console.log(dat);

        return {
            status   : res.ok,
            response : dat.response,
            message  : dat.message
        };

    } catch (err) {
        console.log(err)
    }
}

async function post(url = '', data = {}) {
    try {
        const par = {
            body: data,
            method: 'POST',
            signal: AbortSignal.timeout(5000),
            headers: { 'Content-Type': 'application/json' }
        }

        const res = await fetch(url, par);
        const dat = await res.json();
        return {
            status   : res.ok,
            response : dat.response,
            message  : dat.message
        };

    } catch (err) {
        console.log(err)
    }
}

function getPayload(forms = []) {
    const dat = {};

    Array.from(forms).forEach(element => {
        if (!element.name) return;

        if (element.type === 'checkbox') {
            dat[element.name] = element.checked;
            return;
        } 

        if (element.type === 'file') {
            dat[element.name] = element.files;
            return;
        }

        if (element.type === 'radio' & element.checked) {
            dat[element.name] = element.value;
            return;
        }

        dat[element.name] = element.value;
    });
    
    return JSON.stringify(dat);
}

toastr.options = {
    closeButton: false,
    preventDuplicates: false,
    positionClass: 'toast-top-right',
};

window.toastr = toastr;

window.baseurl    = baseurl;
window.exbaseurl  = exBaseurl;
window.baseprefix = prefix;
window.exbaseprefix = exPrefix;

window.get        = get;
window.post       = post;
window.getPayload = getPayload;