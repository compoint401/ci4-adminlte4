<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>
<!--begin::Row-->
<div class="row">
 
<div class="text-center">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                
                <!-- Broken Search Icon Indicator -->
                <div class="mb-4">
                    <svg xmlns="http://w3.org" width="96" height="96" fill="currentColor" class="text-warning bi bi-search-heart" viewBox="0 0 16 16">
                        <path d="M6.5 4.482c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018"/>
                        <path d="M13 6.5a6.47 6.47 0 0 1-1.258 3.844q.06.044.115.098l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1-.1-.115h.002A6.5 6.5 0 1 1 13 6.5M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11"/>
                    </svg>
                </div>

                <!-- Error Code Header -->
                <h1 class="display-1 fw-bold text-body-emphasis mb-2">404 </h1>
                
                <!-- Main Subheading -->
                <h2 class="h4 text-body fw-semibold uppercase tracking-wider mb-3">
                    Page Not Found
                </h2>
                
                <!-- Descriptive Text Block -->
                <p class="text-secondary mb-5 px-md-4">
                    Oops! The page you are looking for might have been removed, 
                    had its name changed, or is temporarily unavailable. 
                    Please check the URL and try again.
                </p>

                <!-- Navigation Action Buttons -->
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                    <a href="/" class="btn btn-primary btn-lg px-4 shadow-sm">
                        Go to Home
                    </a>
                    <button onclick="history.back()" class="btn btn-outline-secondary btn-lg px-4">
                        Go Back
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
<!--end::Row-->


<?= $this->endSection(); ?>

