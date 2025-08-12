<script>
    let Charts;
    let PredictionNotif;
    let TablePrediction;

    document.addEventListener('DOMContentLoaded', async function() {
        getCurrentDateTimeAlt();

        Charts = new ChartSensors();
        PredictionNotif = new StuckPrediction();
        TablePrediction = new TableRTM('table-predictions');
        
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

        $('select[id=filter-range]').select2({
            placeholder: 'select range',
            allowClear: true,
            data: [
                {id: '3600000', text: '1 Hour'},
                {id: '7200000', text: '2 Hours'},
                {id: '10800000', text: '3 Hours'},
                {id: '21600000', text: '6 Hours'},
                {id: '43200000', text: '12 Hours'},
                {id: '86400000', text: '24 Hours'},
            ],
        });

        $('select[id=filter-scales]').select2({
            placeholder: 'select scale',
            allowClear: true,
            data: [
                {id: '300000', text: '5 Minutes'},
                {id: '600000', text: '10 Minutes'},
                {id: '900000', text: '15 Minutes'},
                {id: '1800000', text: '30 Minutes'},
                {id: '3600000', text: '1 Hour'},
                {id: '7200000', text: '2 Hour'},
                {id: '10800000', text: '3 Hour'},
            ],
        });

        $(document).on('click', '.btn-view-data', async function() {
            const spinner = document.getElementById('view-data-spinner');
            if (spinner.classList.contains('d-none')) {
                spinner.classList.remove('d-none');
            }

            const prediction = $(this).data('prediction-dt').split('.')[0];
            const startData  = $(this).data('record-start');
            const endData    = $(this).data('record-end');
            const records    = await Charts.setNewPredictionChartData({'start': startData, 'end': endData});
            
            if (!spinner.classList.contains('d-none')) {
                spinner.classList.add('d-none');
            }
        });
        
        $('#filter-range').val(null).trigger('change');
        $('#filter-scales').val(null).trigger('change');

        await Charts.initCharts();
        await TablePrediction.initTable();
        await PredictionNotif.initNotification();
    });
</script>