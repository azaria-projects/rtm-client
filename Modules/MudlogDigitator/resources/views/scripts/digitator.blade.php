<script>
    function MudlogDigitator() {
        this.data = null;
    };

    MudlogDigitator.prototype.mergePDF = async function (file) {
        //-- initiate pdflib class
        const { PDFDocument } = PDFLib;

        //-- read file pdf
        const arrayBuffer = await file.arrayBuffer();
        const filePDF     = await PDFDocument.load(arrayBuffer);
        const totalPages  = filePDF.getPageCount();

        //-- create new temporary pdf
        const newFilePDF = await PDFDocument.create();
        const newPages   = await newFilePDF.embedPages(
            Array.from({ length: totalPages }, (_, i) => filePDF.getPage(i))
        );

        //-- get page size [assumming all pages has the same size]
        const firstPageSize   = filePDF.getPage(0).getSize();
        const firstPageWidth  = firstPageSize.width;
        const firstPageHeight = firstPageSize.height;

        //-- add new blank page to the temporary pdf
        const mergedPDFPage = newFilePDF.addPage([
            firstPageWidth, 
            firstPageHeight * totalPages
        ]);

        //-- draw the blank page with all the original page contents
        newPages.forEach((embeddedPage, i) => {
            mergedPDFPage.drawPage(embeddedPage, {
                x: 0,
                y: firstPageHeight * (totalPages - i - 1),
                width: firstPageWidth,
                height: firstPageHeight
            });
        });

        //-- return pdf bytes
        const bytes = await newFilePDF.save();
        return bytes;
    };

    MudlogDigitator.prototype.removeTextOnVectorContent = function (svgString) {
        //-- read svg string as xml
        const parser      = new DOMParser();
        const serializer  = new XMLSerializer();
        const xmlDocument = parser.parseFromString(svgString, 'image/svg+xml');
        
        //-- remove any text elements or elements that contains data-text attribute
        const textNodes = xmlDocument.querySelectorAll('text, [data-text]');
        textNodes.forEach(node => {
            const parent = node.parentElement;
            node.remove();

            if (parent && parent.childNodes.length === 0) {
                parent.remove();
            }
        });

        //-- remove unnecessary groups elements
        const groups = xmlDocument.querySelectorAll('g');
        groups.forEach(group => {
            if (!group.hasChildNodes()) {
                group.remove();
            }
        });

        //-- return string svg
        return serializer.serializeToString(xmlDocument);
    }

    MudlogDigitator.prototype.convertSVGtoPNG = function (svgString, width, height) {
        return new Promise((resolve, reject) => {
            if (!svgString.match(/<svg[^>]*\bwidth=/)) {
                svgString = svgString.replace(
                /<svg/,
                `<svg width="${width}"`
                );
            }

            if (!svgString.match(/<svg[^>]*\bheight=/)) {
                svgString = svgString.replace(
                /<svg/,
                `<svg height="${height}"`
                );
            }

            //-- convert svg to base64
            const base64SVG = btoa(unescape(encodeURIComponent(svgString)));
            const url       = `data:image/svg+xml;base64,${base64SVG}`;

            //-- create new image
            const image       = new Image();
            image.crossOrigin = 'anonymous';

            //-- draw png image on canvas
            image.onload = () => {
                const canvas  = document.createElement('canvas');
                
                canvas.width  = width;
                canvas.height = height;

                const context = canvas.getContext('2d');
                context.fillStyle = 'white';
                context.fillRect(0, 0, canvas.width, canvas.height);
                context.drawImage(image, 0, 0, canvas.width, canvas.height);

                try {
                    const url = canvas.toDataURL('image/png');
                    resolve(url);
                } catch (error) {
                    reject(error)
                }
            }

            image.onerror = () => { reject(new Error('Unable to load SVG!')); };
            image.src = url;
        });
    }

    MudlogDigitator.prototype.rasterizeDocument = async function (file) {
        //-- read file pdf
        const arrayBuffer = await file.arrayBuffer();
        const readTask    = pdfjsLib.getDocument({ data: arrayBuffer });
        const filePDF     = await readTask.promise;
        const page        = await filePDF.getPage(1);

        //-- get svg data
        const serializer   = new XMLSerializer();
        const viewport     = page.getViewport({ scale: 5 });
        const operatorList = await page.getOperatorList();
        const vectorImage  = new pdfjsLib.SVGGraphics(page.commonObjs, page.objs);

        let svgData   = await vectorImage.getSVG(operatorList, viewport);
        let svgString = serializer.serializeToString(svgData);

        //-- remove text from svg
        svgString = this.removeTextOnVectorContent(svgString);
        svgData   = null;

        //-- rasterize svg to png
        const imageUrl = this.convertSVGtoPNG(svgString, viewport.width, viewport.height);
        return imageUrl;
    };

    MudlogDigitator.prototype.detectLineEdges = function (file) {

    };

    MudlogDigitator.prototype.detectMudlogLines = function (file) {
        
    };
</script>