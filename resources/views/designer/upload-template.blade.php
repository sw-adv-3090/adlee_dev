<x-layouts.app-layout title="Templates Overview" is-sidebar-open="false" main="true">

    @php
    $sponsor_bg = 'bg-gradient-to-br from-amber-400 to-orange-600';
    $coupon_bg = 'bg-gradient-to-br from-pink-500 to-rose-500';
    @endphp
    <!-- Main Content Wrapper -->
    <main class="main-content w-full pb-8">
        <!-- <div class="card">
            <div class="mt-3 flex items-center justify-between px-4 sm:px-5">
                <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                    {{ __('Upload Template') }}
                </h2>

            </div>


        </div> -->

        <div id="main-editor" class="editor-container">
        <div class="displayFlex">
            <div class="width_70">
                <div class="image-container">
                    <img class="displayImageClass" id="displayImage" src="" alt="Uploaded Image" />
                    <div id="markerContainer"></div>
                </div>
            </div>
            <div class="width_30">
                <div id="draggableContainer"></div>
            </div>
            <!-- <button type="button" class="button previewBtn" onclick="sendPreviewCall()">Preview</button> -->
        </div>
        <div id="main-editor-btn" style="text-align: center;">
            <button type="button" class="button previewBtn" onclick="sendPreviewCall()">Preview</button>
        </div>
    </div>

    <!-- stepper html start form here -->
    <div id="info-wizard" class="info-wizard">
        <h1>Please provide following information before start</h1>
        <div id="multi-step-form-container">
            <!-- Form Steps / Progress Bar -->
            <ul class="form-stepper form-stepper-horizontal text-center mx-auto pl-0">
                <!-- Step 1 -->
                <li class="form-stepper-active text-center form-stepper-list" step="1">
                    <a class="mx-2">
                        <span class="form-stepper-circle">
                            <span>1</span>
                        </span>
                        <div class="label">Select Language</div>
                    </a>
                </li>
                <!-- Step 2 -->
                <li class="form-stepper-unfinished text-center form-stepper-list" step="2">
                    <a class="mx-2">
                        <span class="form-stepper-circle text-muted">
                            <span>2</span>
                        </span>
                        <div class="label text-muted">Template Type</div>
                    </a>
                </li>
                <!-- Step 3 -->
                <li class="form-stepper-unfinished text-center form-stepper-list" step="3">
                    <a class="mx-2">
                        <span class="form-stepper-circle text-muted">
                            <span>3</span>
                        </span>
                        <div class="label text-muted">Upload Template</div>
                    </a>
                </li>
            </ul>
            <!-- Step Wise Form Content -->
            <form id="userAccountSetupForm" name="userAccountSetupForm" enctype="multipart/form-data" method="POST">
                <!-- Step 1 Content -->
                <section id="step-1" class="form-step">
                    <h2 class="font-normal">Language</h2>
                    <!-- Step 1 input fields -->
                    <div class="mt-3">
                        <select name="1" class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent" aria-label="Default select example">
                            <!-- <option disabled selected>
                                Select Language
                            </option> -->
                            <option value="english" selected>
                                English
                            </option>
                            <option value="hebrew">
                                Hebrew
                            </option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <button class="button btn-navigate-form-step" type="button" step_number="2">Next</button>
                    </div>
                </section>
                <!-- Step 2 Content, default hidden on page load. -->
                <section id="step-2" class="form-step d-none">
                    <h2 class="font-normal">Template Category</h2>
                    <!-- Step 2 input fields -->
                    <div class="mt-3">
                        <select name="2" class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent" aria-label="Default select example">
                            <!-- <option disabled selected>
                                Select Templete Category
                            </option> -->
                            <option value="coupon" selected>
                                Coupon Template
                            </option>
                            <option value="sponsor">
                                Sponsorship Template
                            </option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <button class="button btn-navigate-form-step" type="button" step_number="1">Prev</button>
                        <button class="button btn-navigate-form-step" type="button" step_number="3">Next</button>
                    </div>
                </section>
                <!-- Step 3 Content, default hidden on page load. -->
                <section id="step-3" class="form-step d-none">
                    <h2 class="font-normal">Select Template</h2>
                    <!-- Step 3 input fields -->
                    <div class="mt-3">
                        <input class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" name="3" id="formFileLg" type="file" accept="image/*">
                    </div>
                    <div class="mt-3">
                        <button class="button btn-navigate-form-step" type="button" step_number="2">Prev</button>
                        <button class="button submit-btn" type="button" onclick="submitAllData('{{Auth::user()->getAuthIdentifier()}}')">Save</button>
                    </div>
                </section>
            </form>
        </div>

    </div>

    <!-- Modal body -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div id="myModalContent" class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <img id="base64Img" src="" alt="Base64 Image"/>
            <button id='saveBtn' class="saveBtn" onclick="sendSaveCall()">Save  
                <span class="spiner_icon" id="spiner_icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M12,4a8,8,0,0,1,7.89,6.7A1.53,1.53,0,0,0,21.38,12h0a1.5,1.5,0,0,0,1.48-1.75,11,11,0,0,0-21.72,0A1.5,1.5,0,0,0,2.62,12h0a1.53,1.53,0,0,0,1.49-1.3A8,8,0,0,1,12,4Z"><animateTransform attributeName="transform" dur="0.75s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                </span>
            
        </button>
        </div>
    </div>

    <div id="toaster" class="toaster"></div>



    </main>
    <!-- Main Content Wrapper End -->


</x-layouts.app-layout>