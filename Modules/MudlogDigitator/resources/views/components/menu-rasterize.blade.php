<div class="row gap-4 gap-md-0 h-100">
    <div class="col-12 h-100">
        <div class="card">
            <div class="card-header">
                <i class="ti ti-live-photo me-1 d-none d-sm-block"></i>
                <div class="container-column">
                    <p class="card-subtitle">Upload mudlog document to be rasterized</p>
                    <p class="card-title">RASTERIZE DOCUMENT</p>
                </div>
            </div>

            <div class="card-body gap-0">
                <div class="d-flex flex-wrap justify-content-start gap-1">
                    <a id="btn-download-raster" class="btn btn-tetiary btn-content">
                        <i class="ti ti-device-floppy"></i>
                        <span>download</span>
                    </a>
                </div>

                <div id="placeholder-upload-raster-document" class="mudlog-upload">
                    <i class="ti ti-apps mb-2"></i>
                    <span>upload mudlog document</span>
                    <small class="text-help"><i>*must be .pdf</i></small>

                    <input type="file" id="input-raster-document" name="input-raster-document" accept=".pdf" class="d-none">
                </div>
            </div>
        </div>
    </div>
</div>