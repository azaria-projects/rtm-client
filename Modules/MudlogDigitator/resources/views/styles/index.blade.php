@push('styles')
    <style>
        #crop-container { 
            width: 100%; 
            position: relative; 
        }

        #pdfCanvas { 
            border: 1px solid #ccc; 
        }

        #cropRect { 
            position: absolute; 
            border: 2px dashed red; 
            box-sizing: border-box; 
            cursor: move; 
        }

        #mudlog-detection-canvas {
            width: 100%;
        }

        #mudlog-detection-tooltip {
            position: fixed;
            pointer-events: none;
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 4px 8px;
            font-size: 12px;
            border-radius: 4px;
            user-select: none;
            display: none;
            z-index: 10000;
        }

        #mudlog-detection-area {
            max-height: 600px;
            overflow-y: scroll;
        }

        .app-main {
            /* height: 86vh; */
            overflow-y: scroll;
            padding: var(--system-size-lg) 12px !important;
        }

        .app-footer {
            background-color: transparent !important;
            
            display: flex;
            justify-content: center;
        }

        .mudlog-upload {
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: center;

            height: 100%;
            cursor: pointer;
            margin-top: 16px;
            border-radius: 8px;
            background-color: #2B2B2B;

            i.ti {
                font-size: 2rem;    
            }
        }

        .calibration-container {
            max-height: 260px;
            display: flex;
            overflow-y: scroll;
            flex-direction: column;
        }

        .btn-content-container {
            display: flex;
            gap: 8px;
            margin-top: auto;
            justify-content: end; 
        }

        #y-calibration {
            height: fit-content;
            max-height: 31vh;

            .card-body {
                overflow-y: scroll;
            }
        }

        #x-calibration {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;  

            .card-body {
                display: flex;
                flex-direction: column;
                gap: 0;
            
                flex-grow: 1;
                min-height: 0;
            }
        }

        @media(max-width: 576px) {
            .filler {
                display: block;
            }

            .app-main {
                height: 76vh !important;
                overflow: scroll !important;
            }

            #y-calibration {
                height: fit-content;
                max-height: fit-content;

                .row div {
                    padding-left: 0px;
                    padding-right: 0px;
                }
            }

            #x-calibration {
                height: fit-content;
                max-height: unset;
                min-height: unset;
                margin-bottom: 32px !important;

                .row div {
                    padding-left: 0px;
                    padding-right: 0px;
                }

                .btn-content-container {
                    flex-direction: column;
                    
                    button {
                        width: 100% !important;
                        justify-content: center;
                    }
                }
            }
        } 

        #manual-calibration-container {
            display: flex;
            flex-direction: column;
            gap: 24px;
            flex-grow: 1;
            min-height: 0;
            height: 100%;
        }
    </style>
@endpush