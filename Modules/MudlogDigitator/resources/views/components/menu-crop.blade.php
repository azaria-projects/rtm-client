<div class="row gap-4 gap-md-0 h-100">
    <div class="col-12 h-100">
        <div class="card">
            <div class="card-header">
                <i class="ti ti-scissors me-1 d-none d-sm-block"></i>
                <div class="container-column">
                    <p class="card-subtitle">Upload mudlog document to be cropped</p>
                    <p class="card-title">CROP DOCUMENT</p>
                </div>
            </div>

            <div class="card-body gap-0">
                <div class="d-flex flex-wrap justify-content-start gap-1">
                    <button id="btn-upload-crop" class="btn btn-tetiary btn-content">
                        <i class="ti ti-folder-up"></i>
                        <span>upload document</span>
                    </button>
                    
                    <a id="btn-download-crop" class="btn btn-tetiary btn-content">
                        <i class="ti ti-device-floppy"></i>
                        <span>download</span>
                    </a>
                </div>

                <div id="crop-container" class="mt-3">
                    <canvas id="pdfCanvas" class="d-none"></canvas>
                    <div id="cropRect" class="d-none"></div>
                </div>

                <div id="placeholder-upload-crop-document" class="mudlog-upload">
                    <i class="ti ti-cut mb-2"></i>
                    <span>crop area</span>
                    <small class="text-help"><i>*the file must contain a single .pdf page</i></small>

                    <input type="file" id="input-crop-document" name="input-crop-document" accept=".pdf" class="d-none">
                </div>
            </div>
        </div>
    </div>
</div>