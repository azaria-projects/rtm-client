<div class="row gap-4 gap-md-0 h-100">
    <div class="col-12 col-sm 12 col-md-6 h-100">
        <div class="card">
            <div class="card-header">
                <i class="ti ti-text-scan-2 me-1 d-none d-sm-block"></i>
                <div class="container-column">
                    <p class="card-subtitle">Upload mudlog document to be digitized</p>
                    <p class="card-title">MUDLOG DOCUMENT</p>
                </div>
            </div>

            <div class="card-body gap-0">
                <div class="d-flex flex-wrap justify-content-start gap-1">
                    <button id="btn-color" class="btn btn-tetiary btn-content">
                        <i class="ti ti-test-pipe"></i>
                        <span>color</span>
                    </button>

                    <a id="btn-download-file" class="btn btn-tetiary btn-content">
                        <i class="ti ti-device-floppy"></i>
                        <span>download</span>
                    </a>
                </div>

                <div id="placeholder-upload-mudlog-document" class="mudlog-upload">
                    <i class="ti ti-apps mb-2"></i>
                    <span>upload mudlog document</span>
                    <small class="text-help"><i>*must be .png or other image format</i></small>

                    <input type="file" id="input-mudlog-document" name="input-mudlog-document" accept=".png" class="d-none">
                </div>

                <div id="mudlog-detection-area" class="mt-3">
                    <canvas id="mudlog-detection-canvas" class="d-none"></canvas>
                    <div id="mudlog-detection-tooltip"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm 12 col-md-6 h-100">
        <div id="manual-calibration-container">
            <div id="y-calibration" class="card" style="height: fit-content;">
                <div class="card-header">
                    <i class="ti ti-chart-cohort me-1 d-none d-sm-block"></i>
                    <div class="container-column">
                        <p class="card-subtitle">calibrate depth data</p>
                        <p class="card-title">Y CALIBRATIONS</p>
                    </div>
                </div>

                <div class="card-body gap-0">
                    <div class="row mx-0">
                        <div class="col-12 col-sm-12 col-md-6 col-xl-4 ps-md-0 mb-3">
                            <label for="select-depth-unit" class="form-label"><i class="ti ti-dimensions me-1"></i> Depth Unit</label>
                            <select id="select-depth-unit" class="form-select select2" aria-label="select-depth-unit" aria-label="select-depth-unit">
                                <option value="feet">Feet</option>
                            </select>  
                        </div>

                        <div class="col-12 col-sm-12 col-md-6 col-xl-4 ps-md-0 mb-3">
                            <label for="select-depth-file-type" class="form-label"><i class="ti ti-files me-1"></i> File Type</label>
                            <select id="select-depth-file-type" class="form-select select2" aria-label="select-depth-file-type">
                                <option value="csv">CSV</option>
                                <option value="ascii">ASCII</option>
                            </select>
                        </div>

                        
                        <div class="col-12 col-sm-12 col-md-6 col-xl-4 ps-md-0 pe-md-0 mb-3">
                            <label for="input-depth-interval" class="form-label"><i class="ti ti-keyframe-align-center me-1"></i> Depth Interval</label>
                            <input id="input-depth-interval" name="input-depth-interval" type="number" class="form-control" value="1" aria-label="input-depth-interval">  
                        </div>
                    </div>

                    <div class="row mx-0 px-0">
                        <div class="col-12 col-sm-12 col-md-6 ps-md-0 mb-3 mb-md-0">
                            <label for="input-depth-start" class="form-label"><i class="ti ti-arrow-big-down-lines me-1"></i> Start Depth</label>
                            <input id="input-depth-start" name="input-depth-start" type="number" class="form-control" value="0" aria-label="input-depth-start">
                        </div>
                        
                        <div class="col-12 col-sm-12 col-md-6 pe-md-0 mb-3 ps-md-0 mb-md-0">
                            <label for="input-depth-end" class="form-label"><i class="ti ti-window-minimize me-1"></i> End Depth</label>
                            <input id="input-depth-end" name="input-depth-end" type="number" class="form-control" value="0" aria-label="input-depth-end">
                        </div>
                    </div>
                </div>
            </div>

            <div id="x-calibration" class="card">
                <div class="card-header">
                    <i class="ti ti-bleach-no-chlorine me-1 d-none d-sm-block"></i>
                    <div class="container-column">
                        <p class="card-subtitle">calibrate x values</p>
                        <p class="card-title">X CALIBRATIONS</p>
                    </div>
                </div>

                <div class="card-body gap-0">
                    <div id="input-calibration-x-container" class="calibration-container">
                        @for ($i = 1; $i < 4; $i++)
                            <div class="row mx-0">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-3 ps-md-0">
                                    <div class="mb-3">
                                        <label for="input-cal-color-{{ $i }}" class="form-label"><i class="ti ti-color-swatch me-1"></i> Color {{ $i }}</label>
                                        <input id="input-cal-color-{{ $i }}" name="input-cal-color-{{ $i }}" type="text" class="form-control" aria-label="input-cal-sensor-{{ $i }}" placeholder="hex color">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 col-lg-3 ps-md-0">
                                    <div class="mb-3">
                                        <label for="input-cal-sensor-{{ $i }}" class="form-label"><i class="ti ti-chart-column me-1"></i> Sensor {{ $i }}</label>
                                        <input id="input-cal-sensor-{{ $i }}" name="input-cal-sensor-{{ $i }}" type="text" class="form-control" aria-label="input-cal-sensor-{{ $i }}" placeholder="sensor">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 col-lg-3 ps-md-0">
                                    <div class="mb-3">
                                        <label for="input-cal-min-{{ $i }}" class="form-label"><i class="ti ti-table-shortcut me-1"></i> Min Val. {{ $i }}</label>
                                        <input id="input-cal-min-{{ $i }}" name="input-cal-min-{{ $i }}" value="0" type="number" class="form-control" aria-label="input-cal-min-{{ $i }}">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 col-lg-3 ps-md-0 pe-md-0">
                                    <div class="mb-3">
                                        <label for="input-cal-max-{{ $i }}" class="form-label"><i class="ti ti-table-down me-1"></i> Max Val. {{ $i }}</label>
                                        <input id="input-cal-max-{{ $i }}" name="input-cal-max-{{ $i }}" value="0" type="number" class="form-control" aria-label="input-cal-max-{{ $i }}">
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>

                    <div class="btn-content-container mt-3">
                        <button id="btn-add-x-calibration" class="btn btn-secondary btn-content">
                            <i class="ti ti-table-plus"></i>
                            <span>add Calibration</span>
                        </button>
                        
                        <button id="btn-remove-x-calibration" class="btn btn-danger btn-content">
                            <i class="ti ti-table-minus"></i>
                            <span>remove Calibration</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>