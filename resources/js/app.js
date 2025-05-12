import './bootstrap';
import 'bootstrap';
import 'sortablejs';
import 'apexcharts';
import 'sweetalert2';

import '@fontsource/inria-sans';
import '@fontsource/inria-sans/300.css';
import '@fontsource/inria-sans/400.css';
import '@fontsource/inria-sans/700.css';

import $ from 'jquery';
import toastr from 'toastr';
import tippy from 'tippy.js';
import Swal from 'sweetalert2';
import Sortable from 'sortablejs';

import 'datatables.net-bs5';
import 'datatables.net-buttons-bs5';
import 'datatables.net-buttons/js/buttons.html5.min';
import 'datatables.net-buttons/js/buttons.print.min';
import JSZip from 'jszip';
import pdfMake from 'pdfmake/build/pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';
import DataTable from 'datatables.net-dt';

import { addMinutes } from 'date-fns';
import { formatInTimeZone } from 'date-fns-tz';
import { Chart, registerables } from 'chart.js';
import { OverlayScrollbars } from 'overlayscrollbars';

const baseurl   = import.meta.env.VITE_SERVER_URL;
const exBaseurl = import.meta.env.VITE_EXSERVER_URL;
const prefix    = import.meta.env.VITE_SERVER_PREFIX;
const exPrefix  = import.meta.env.VITE_EXSERVER_PREFIX;

async function get(url = '') {
    try {
        const par = { method: 'GET', headers: { 'Content-Type': 'application/json' }}
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

async function post(url = '', data = {}) {
    try {
        const par = {
            body: data,
            method: 'POST',
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

function getDateRange(milisecond = 6000, zone = 'Asia/Jakarta') {
    const st = new Date();
    const en = new Date(st.getTime() + milisecond);

    return {
        'start' : formatInTimeZone(st, zone, 'yyyy-MM-dd HH:mm:ss'),
        'end'   : formatInTimeZone(en, zone, 'yyyy-MM-dd HH:mm:ss')
    }
}

function resetCookies() {
    document.cookie = 'token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    document.cookie = 'well=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
}

function getCurrentDateTime(wkd = 'long', mnt = 'long') {
    const now = new Date();
    const options = { 
        weekday : wkd, 
        month   : mnt, 
        day     : 'numeric', 
        year    : 'numeric',
        hour    : '2-digit', 
        minute  : '2-digit', 
        second  : '2-digit',
        hour12  : false 
    };

    const formatted = now.toLocaleDateString('en-US', options).replace(',', '');
    document.getElementById('date-time').textContent = formatted;
    setTimeout(() => getCurrentDateTime(wkd, mnt), 1000);
}

function getCurrentDateTimeAlt() {
    const now = new Date();
    
    const year      = now.getFullYear();
    const month     = String(now.getMonth() + 1).padStart(2, '0');
    const day       = String(now.getDate()).padStart(2, '0');
    const hours     = String(now.getHours()).padStart(2, '0');
    const minutes   = String(now.getMinutes()).padStart(2, '0');
    const seconds   = String(now.getSeconds()).padStart(2, '0');

    const formatted = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    document.getElementById('date-time').textContent = formatted;
    
    setTimeout(getCurrentDateTimeAlt, 1000);
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

function getSwalConf(
    status = '', 
    header = '', 
    subheader = '', 
    closetime = 1500, 
    confirmBtn = false
) {
    return {
        theme: 'dark',
        icon: status,
        title: header,
        text: subheader,
        timer: closetime,
        showConfirmButton: confirmBtn,
        didOpen: () => {
            Swal.hideLoading();
        }
    }
};

function getSwalLoadingConf(
    header = '', 
    subheader = ''
) {
    return {
        theme: 'dark',
        title: header,
        text: subheader,
        allowOutsideClick : false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    }
}

function getSwalPromptConf(
    status = '', 
    header = '', 
    subheader = ''
) {
    return {
        theme: 'dark',
        icon: status,
        title: header,
        text: subheader,
        showCancelButton: true,
        confirmButtonText: "Yes",
        buttonsStyling: true,
        customClass: {
          confirmButton: 'btn-swal-confirm',
          cancelButton: 'btn-swal-cancel'   
        }
    }
}

toastr.options = {
    closeButton: false,
    preventDuplicates: false,
    positionClass: 'toast-top-right',
};

Chart.register(...registerables);

window.Chart = Chart;
window.swal  = Swal;
window.JSZip = JSZip;
window.tippy = tippy;
window.toastr = toastr;
window.datatable = DataTable
window.$ = window.jQuery = $;

window.baseurl    = baseurl;
window.exbaseurl  = exBaseurl;
window.baseprefix = prefix;
window.exbaseprefix = exPrefix;

window.get        = get;
window.post       = post;
window.getPayload = getPayload;

window.getDateRange = getDateRange;
window.resetCookies = resetCookies;
window.getCurrentDateTime    = getCurrentDateTime;
window.getCurrentDateTimeAlt = getCurrentDateTimeAlt;

window.getSwalConf        = getSwalConf;
window.getSwalConfLoading = getSwalLoadingConf;
window.getSwalConfPrompt  = getSwalPromptConf;

document.addEventListener("DOMContentLoaded", function () {
    const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
    const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
    const Default = {
        scrollbarTheme: "os-theme-light",
        scrollbarAutoHide: "leave",
        scrollbarClickScroll: true,
    };

    if (sidebarWrapper) {
        OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
                theme: Default.scrollbarTheme,
                autoHide: Default.scrollbarAutoHide,
                clickScroll: Default.scrollbarClickScroll,
            },
        });
    }

    const connectedSortables = document.querySelectorAll(".connectedSortable");
    connectedSortables.forEach((connectedSortable) => {
        let sortable = new Sortable(connectedSortable, {
            group: "shared",
            handle: ".card-header",
        });
    });

    const cardHeaders = document.querySelectorAll(
        ".connectedSortable .card-header"
    );
    cardHeaders.forEach((cardHeader) => {
        cardHeader.style.cursor = "move";
    });
});

