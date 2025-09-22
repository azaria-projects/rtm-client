@push('scripts-body')
    <script>
        let digitator;

        function addXCalibration() {
            const div = document.getElementById('input-calibration-x-container');
            const cnt = div.childElementCount + 1;
            const elm = document.createElement('div');

            elm.classList.add('row', 'mx-0');
            elm.innerHTML = `
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 ps-md-0">
                    <div class="mb-3">
                        <label for="input-cal-color-${cnt}" class="form-label"><i class="ti ti-color-swatch me-1"></i> Color ${cnt}</label>
                        <input id="input-cal-color-${cnt}" name="input-cal-color-${cnt}" type="text" class="form-control" aria-label="input-cal-color-${cnt}" placeholder="hex color">
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-3 ps-md-0">
                    <div class="mb-3">
                        <label for="input-cal-sensor-${cnt}" class="form-label"><i class="ti ti-chart-column me-1"></i> Sensor ${cnt}</label>
                        <input id="input-cal-sensor-${cnt}" name="input-cal-sensor-${cnt}" type="text" class="form-control" aria-label="input-cal-sensor-${cnt}" placeholder="sensor">
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-3 ps-md-0">
                    <div class="mb-3">
                        <label for="input-cal-min-${cnt}" class="form-label"><i class="ti ti-table-shortcut me-1"></i> Min Val. ${cnt}</label>
                        <input id="input-cal-min-${cnt}" name="input-cal-min-1" value="0" type="number" class="form-control" aria-label="input-cal-min-${cnt}">
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-3 ps-md-0 pe-md-0">
                    <div class="mb-3">
                        <label for="input-cal-max-${cnt}" class="form-label"><i class="ti ti-table-down me-1"></i> Max Val. ${cnt}</label>
                        <input id="input-cal-max-${cnt}" name="input-cal-max-${cnt}" value="0" type="number" class="form-control" aria-label="input-cal-max-${cnt}">
                    </div>
                </div>
            `;

            div.appendChild(elm);
        }

        function removeXCalibration() {
            const div = document.getElementById('input-calibration-x-container');
            const cnt = div.childElementCount;
            if (cnt !== 1) {
                div.removeChild(div.lastChild);
            }
        }

        async function downloadCroppedDocument() {
            const { PDFDocument } = PDFLib;
            
            const canvas = document.getElementById('pdfCanvas');
            const cropRect = document.getElementById('cropRect');
            const inputFileCrop = document.getElementById('input-crop-document');

            const canvasRect = canvas.getBoundingClientRect();
            const cropRectRect = cropRect.getBoundingClientRect();

            const arrayBuffer = await inputFileCrop.files[0].arrayBuffer();
            const srcPdf = await PDFDocument.load(arrayBuffer);

            const firstPage = srcPdf.getPage(0);
            const { width: originalPdfWidth, height: originalPdfHeight } = firstPage.getSize();

            const scaleX = originalPdfWidth / canvas.width;
            const scaleY = originalPdfHeight / canvas.height;

            const cropLeft = cropRectRect.left - canvasRect.left;
            const cropTop = cropRectRect.top - canvasRect.top;

            const cropX = cropLeft * scaleX;
            const cropY = (canvas.height - (cropTop + cropRect.offsetHeight)) * scaleY;
            const cropWidth = cropRect.offsetWidth * scaleX;
            const cropHeight = cropRect.offsetHeight * scaleY;

            console.log('PDF crop box:', {
                x: cropX,
                y: cropY,
                width: cropWidth,
                height: cropHeight
            });

            const newPdf = await PDFDocument.create();
            const [copiedPage] = await newPdf.copyPages(srcPdf, [0]);
            const page = copiedPage;

            const embedded = await newPdf.embedPage(page);
            const newPage = newPdf.addPage([cropWidth, cropHeight]);
            newPage.drawPage(embedded, {
                x: -cropX,
                y: -cropY,
                width: originalPdfWidth,
                height: originalPdfHeight
            });

            const pdfBytes = await newPdf.save();

            const blob = new Blob([pdfBytes], { type: 'application/pdf' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'cropped.pdf';
            a.click();
            URL.revokeObjectURL(url);
        }

        document.addEventListener('DOMContentLoaded', async function () {
            let cropListeners = false;
            digitator = new MudlogDigitator();

            //-- calibration buttons
            const btnAddXCalibration    = document.getElementById('btn-add-x-calibration');
            const btnRemoveXCalibration = document.getElementById('btn-remove-x-calibration');

            //-- download buttons
            const btnDownloadCrop = document.getElementById('btn-download-crop');
            
            //-- upload buttons
            const btnUploadFileCrop   = document.getElementById('btn-upload-crop');
            const btnUploadFileMerge  = document.getElementById('placeholder-upload-merge-document');
            const btnUploadFileRaster = document.getElementById('placeholder-upload-raster-document');

            //-- upload inputs
            const inputFileCrop   = document.getElementById('input-crop-document');
            const inputFileMerge  = document.getElementById('input-merge-document');
            const inputFileRaster = document.getElementById('input-raster-document');

            getCurrentDateTimeAlt();

            btnAddXCalibration.addEventListener('click', function () {
                addXCalibration();
            });

            btnRemoveXCalibration.addEventListener('click', function () {
                removeXCalibration();
            });

            //-- upload button listeners
            btnUploadFileCrop.addEventListener('click', function () {
                inputFileCrop.click();
            });

            btnUploadFileMerge.addEventListener('click', function () {
                inputFileMerge.click();
            });

            btnUploadFileRaster.addEventListener('click', function () {
                inputFileRaster.click();
            });

            inputFileCrop.addEventListener('change', async function () {
                const file = this.files[0];
                if (!file) return;

                swal.fire(getSwalConfLoading('Adjusting', 'adjusting crop area please wait!'));

                const cropRect  = document.getElementById('cropRect');
                const canvas    = document.getElementById('pdfCanvas');
                const context   = canvas.getContext('2d');
                const container = document.getElementById('crop-container');

                const arrayBuffer = await file.arrayBuffer();
                const pdf         = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
                const numPages    = pdf.numPages;

                const viewPage         = await pdf.getPage(1);
                const originalViewport = viewPage.getViewport({ scale: 1 });
                const originalWidth    = originalViewport.width;

                canvas.width = container.clientWidth;
                const scale = canvas.width / originalWidth;

                let totalHeight = 0;
                const pageViewports = [];

                for (let i = 1; i <= numPages; i++) {
                    const page = await pdf.getPage(i);
                    const viewport = page.getViewport({ scale });
                    pageViewports.push(viewport);
                    totalHeight += viewport.height;
                }

                canvas.height = totalHeight;
                
                let offsetY = 0;
                for (let i = 1; i <= numPages; i++) {
                    const page = await pdf.getPage(i);
                    const viewport = pageViewports[i - 1];
                    await page.render({
                        canvasContext: context,
                        viewport,
                        transform: [1, 0, 0, 1, 0, offsetY]
                    }).promise;
                    offsetY += viewport.height;
                }

                cropRect.style.left    = '0px';
                cropRect.style.top     = '0px';
                cropRect.style.width   = `${canvas.width}px`;
                cropRect.style.height  = `${canvas.height}px`;
                cropRect.style.display = 'block';

                canvas.style.height    = `${canvas.height}px`;

                canvas.classList.remove('d-none');
                cropRect.classList.remove('d-none');

                document.getElementById('placeholder-upload-crop-document').classList.add('d-none');
                swal.fire(getSwalConf('success', 'Crop Box Created', 'document is ready to crop!'));

                if (!cropListeners) {
                    let isDragging = false;
                    let isResizing = false;
                    let edge = null;
                    let startX, startY, startLeft, startTop, startWidth, startHeight;

                    const detectEdge = (e) => {
                        const rect = cropRect.getBoundingClientRect();
                        const offset = 10;
                        if (Math.abs(e.clientX - rect.left) < offset) return 'left';
                        if (Math.abs(e.clientX - rect.right) < offset) return 'right';
                        if (Math.abs(e.clientY - rect.top) < offset) return 'top';
                        if (Math.abs(e.clientY - rect.bottom) < offset) return 'bottom';
                        return null;
                    };

                    cropRect.addEventListener('mousedown', (e) => {
                        edge = detectEdge(e);
                        isDragging = !edge;
                        isResizing = !!edge;
                        startX = e.clientX;
                        startY = e.clientY;
                        startLeft = cropRect.offsetLeft;
                        startTop = cropRect.offsetTop;
                        startWidth = cropRect.offsetWidth;
                        startHeight = cropRect.offsetHeight;
                    });

                    document.addEventListener('mousemove', (e) => {
                        if (!isDragging && !isResizing) return;

                        if (isDragging) {
                            const dx = e.clientX - startX;
                            const dy = e.clientY - startY;
                            let newLeft = Math.max(0, Math.min(startLeft + dx, canvas.width - cropRect.offsetWidth));
                            let newTop = Math.max(0, Math.min(startTop + dy, canvas.height - cropRect.offsetHeight));
                            cropRect.style.left = newLeft + 'px';
                            cropRect.style.top = newTop + 'px';
                        }

                        if (isResizing && edge) {
                            const dx = e.clientX - startX;
                            const dy = e.clientY - startY;
                            let newLeft = startLeft, newTop = startTop, newWidth = startWidth, newHeight = startHeight;
                            if (edge === 'left') { newLeft = startLeft + dx; newWidth = startWidth - dx; }
                            if (edge === 'right') { newWidth = startWidth + dx; }
                            if (edge === 'top') { newTop = startTop + dy; newHeight = startHeight - dy; }
                            if (edge === 'bottom') { newHeight = startHeight + dy; }
                            if (newWidth > 10 && newLeft >= 0 && newLeft + newWidth <= canvas.width) {
                                cropRect.style.left = newLeft + 'px';
                                cropRect.style.width = newWidth + 'px';
                            }
                            if (newHeight > 10 && newTop >= 0 && newTop + newHeight <= canvas.height) {
                                cropRect.style.top = newTop + 'px';
                                cropRect.style.height = newHeight + 'px';
                            }
                        }
                    });

                    document.addEventListener('mouseup', () => {
                        isDragging = false;
                        isResizing = false;
                        edge = null;
                    });

                    cropListeners = true;
                }
            });

            inputFileMerge.addEventListener('change', async function () {
                const file = this.files[0];
                if (!file) { return; }

                swal.fire(getSwalConfLoading('Merging', 'merging document, please wait!'));

                const bytes = await digitator.mergePDF(file);
                const blob  = new Blob([bytes], { type: 'application/pdf' });
                const url   = URL.createObjectURL(blob);
                const link  = document.getElementById('btn-download-merge');

                link.href = url;

                swal.fire(getSwalConf( 'success', 'Merged!', 'document pdf has been merged!'));
            });

            inputFileRaster.addEventListener('change', async function () {
                const file = this.files[0];
                if (!file) { return; }

                swal.fire(getSwalConfLoading('Converting', 'rasterizing document to image, please wait!'));

                const imageUrl = await digitator.rasterizeDocument(file);
                const link     = document.getElementById('btn-download-raster');
                
                link.href     = imageUrl;
                link.download = 'rasterized.png';
                
                swal.fire(getSwalConf('success', 'document rasterized!', 'rasterizing document has been completed!'));
            });

            btnDownloadCrop.addEventListener('click', async function () {
                await downloadCroppedDocument()
            });
        });
    </script>

    <script>
        function draw(canvas, context, scale, offset, img) {
            context.setTransform(1, 0, 0, 1, 0, 0);
            context.clearRect(0, 0, canvas.width, canvas.height);
            context.setTransform(scale, 0, 0, scale, offset.x, offset.y);
            context.drawImage(img, 0, 0, 600, img.height, 0, 0, 600 * scale, img.height * scale);
        }


        function getImageCoords(canvas, scale, offset, clientX, clientY) {
            const rect = canvas.getBoundingClientRect();

            const canvasX = clientX - rect.left;
            const canvasY = clientY - rect.top;

            const x = Math.floor((canvasX - offset.x) / scale);
            const y = Math.floor((canvasY - offset.y) / scale);

            return { x, y };
        }

        function getPixelColor(imgData, x, y) {
            if (!imgData) return null;
            
            if (x < 0 || y < 0 || x >= imgData.width || y >= imgData.height) return null;
            
            const idx = (y * imgData.width + x) * 4;

            return {
                r: imgData.data[idx],
                g: imgData.data[idx + 1],
                b: imgData.data[idx + 2],
                a: imgData.data[idx + 3]
            };
        }

        function rgbToHex({r, g, b}) {
            const toHex = n => n.toString(16).padStart(2, '0').toUpperCase();
            return `#${toHex(r)}${toHex(g)}${toHex(b)}`;
        }

        document.addEventListener('DOMContentLoaded', async function () {
            const btnUploadFileMudlog = document.getElementById('placeholder-upload-mudlog-document');

            const mudlogUpload  = document.getElementById('input-mudlog-document');
            const mudlogCanvas  = document.getElementById('mudlog-detection-canvas');
            const mudlogContext = mudlogCanvas.getContext('2d');
            const mudlogTooltip = document.getElementById('mudlog-detection-tooltip');

            let imgData;
            let tooltipResetTimeout;

            let img         = new Image();
            let scale       = 1;
            let offset      = { x: 0, y: 0 };
            let isDraggingg = false;
            let dragStart   = { x: 0, y: 0 };
            let mode        = 'detect'; 

            btnUploadFileMudlog.addEventListener('click', function () {
                mudlogUpload.click();
            });

            mudlogUpload.addEventListener('change', e => {
                const file   = e.target.files[0];
                const reader = new FileReader();
                
                if (!file) return;

                reader.onload = e => {
                    img.onload = () => {
                        scale  = 1;   // Set initial scale
                        offset = { x: 0, y: 0 };   // Set initial offset

                        // Set canvas width and height to fit the first 600px of the image
                        mudlogCanvas.width  = 600 * scale;
                        mudlogCanvas.height = img.height * scale;

                        // Now, draw the image (only the first 600px width)
                        draw(mudlogCanvas, mudlogContext, scale, offset, img);

                        // Get image data after the first 600px has been drawn
                        mudlogContext.setTransform(1, 0, 0, 1, 0, 0);
                        mudlogContext.clearRect(0, 0, mudlogCanvas.width, mudlogCanvas.height);
                        mudlogContext.drawImage(img, 0, 0, 600, img.height, 0, 0, 600 * scale, img.height * scale);
                        imgData = mudlogContext.getImageData(0, 0, 600, img.height);  // Get image data for the cropped portion

                        // Redraw if needed
                        draw(mudlogCanvas, mudlogContext, scale, offset, img);
                    };
                    
                    img.src = e.target.result;
                };

                reader.readAsDataURL(file);

                const link    = document.getElementById('btn-download-file');
                
                link.href     = 'depth_result_example.csv';
                link.download = 'depth_result_example.csv';

                document.getElementById('placeholder-upload-mudlog-document').classList.add('d-none');
                document.getElementById('mudlog-detection-canvas').classList.remove('d-none');
            });

            mudlogCanvas.addEventListener('mousemove', e => {
                if (mode !== 'detect') {
                    mudlogTooltip.style.display = 'none';
                    return;
                }

                const rect = mudlogCanvas.getBoundingClientRect();
                const canvasX = e.clientX - rect.left;
                const canvasY = e.clientY - rect.top;

                const { x, y } = getImageCoords(mudlogCanvas, scale, offset, e.clientX, e.clientY);
                const color = getPixelColor(imgData, x, y);

                if (!color) {
                    mudlogTooltip.style.display = 'none';
                    return;
                }

                const hex = rgbToHex(color);
                mudlogTooltip.style.left    = (e.clientX + 10) + 'px';
                mudlogTooltip.style.top     = (e.clientY + 10) + 'px';
                mudlogTooltip.style.color   = (color.r + color.g + color.b > 400) ? '#000' : '#fff';
                mudlogTooltip.textContent   = hex;
                mudlogTooltip.style.display = 'block';
                mudlogTooltip.style.backgroundColor = hex;

                draw(mudlogCanvas, mudlogContext, scale, offset, img);

                mudlogContext.save();
                mudlogContext.setTransform(scale, 0, 0, scale, offset.x, offset.y);
                mudlogContext.setLineDash([2, 4]);
                mudlogContext.strokeStyle = 'rgba(255, 0, 0, 0.8)';
                mudlogContext.lineWidth = 1 / scale;

                mudlogContext.beginPath();
                mudlogContext.moveTo(x + 0.5, 0);
                mudlogContext.lineTo(x + 0.5, img.height);
                mudlogContext.stroke();
                mudlogContext.beginPath();
                mudlogContext.moveTo(0, y + 0.5);
                mudlogContext.lineTo(img.width, y + 0.5);
                mudlogContext.stroke();

                mudlogContext.restore();

                console.log({
                    clientX: e.clientX,
                    clientY: e.clientY,
                    imageX: x,
                    imageY: y
                });
            });

            mudlogCanvas.addEventListener('mouseleave', () => {
                mudlogTooltip.style.display = 'none';
            });

            mudlogCanvas.addEventListener('click', async e => {
                if (mode !== 'detect') return;

                const { x, y } = getImageCoords(mudlogCanvas ,scale, offset, e.clientX, e.clientY);
                const color    = getPixelColor(imgData, x, y);

                console.log(color);

                if (!color) return;

                const hex = rgbToHex(color);

                try {
                    await navigator.clipboard.writeText(hex);

                    const originalText  = mudlogTooltip.textContent;
                    mudlogTooltip.textContent = 'copied!';

                    if (tooltipResetTimeout) clearTimeout(tooltipResetTimeout);

                    tooltipResetTimeout = setTimeout(() => {
                        mudlogTooltip.textContent = originalText;
                    }, 1000);

                } catch (err) {
                    console.error('Failed to copy color to clipboard', err);
                }
            });

            mudlogCanvas.addEventListener('mousedown', e => {
                if (mode !== 'zoom') return;

                isDragging = true;
                dragStart  = { x: e.clientX - offset.x, y: e.clientY - offset.y };
                mudlogCanvas.style.cursor = 'grabbing';
            });

            mudlogCanvas.addEventListener('mouseup', e => {
                if (mode !== 'zoom') return;

                isDragging = false;
                mudlogCanvas.style.cursor = 'crosshair';
            });

            mudlogCanvas.addEventListener('mouseout', e => {
                if (mode !== 'zoom') return;

                isDragging = false;
                mudlogCanvas.style.cursor = 'crosshair';
            });

            mudlogCanvas.addEventListener('mousemove', e => {
                if (mode !== 'zoom') return;
                if (!isDragging) return;

                offset.x = e.clientX - dragStart.x;
                offset.y = e.clientY - dragStart.y;
                
                draw(mudlogCanvas, mudlogContext, scale, offset, img);
            });
        });
    </script>
@endpush