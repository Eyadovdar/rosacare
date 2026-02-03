<style>
    @media print {
        /* Hide everything by default */
        body * {
            visibility: hidden;
        }

        /* Hide sidebar and navigation */
        .fi-sidebar,
        .fi-sidebar-nav {display: none !important; visibility: hidden !important;}
        .fi-sidebar-header,
        .fi-sidebar-footer,
        aside,
        [data-sidebar],
        nav[aria-label="Sidebar"],
        .fi-topbar,
        .fi-header,
        .fi-header-actions,
        .fi-page-header-actions,
        [data-headlessui-state],
        nav:not([aria-label="Breadcrumbs"]),
        header,
        button[aria-label="Print Report"],
        button[aria-label="Restore"],
        button[aria-label="Force Delete"],
        button[aria-label="Delete"],
        .fi-actions,
        .fi-page-actions,
        .fi-breadcrumbs,
        .fi-page-header,
        .fi-page-header-heading,
        .fi-page-header-subheading {
            display: none !important;
            visibility: hidden !important;
        }

        /* Show only the infolist content */
        .fi-infolist,
        .fi-infolist *,
        .fi-infolist-ctn,
        .fi-infolist-ctn * {
            visibility: visible !important;
        }

        /* Position the infolist at the top */
        .fi-infolist,
        .fi-infolist-ctn {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 20px !important;
        }

        /* Ensure main content takes full width */
        .fi-main,
        .fi-main-content,
        .fi-body,
        .fi-page,
        [data-page],
        main {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        /* Remove sidebar spacing */
        body,
        html {
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Ensure content container is visible */
        .fi-page-content,
        .fi-page-content-wrapper {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Improve print layout */
        body {
            background: white !important;
            color: black !important;
        }

        /* Ensure sections are visible */
        .fi-infolist-ctn {
            page-break-inside: avoid;
        }

        /* Add page breaks where needed */
        .fi-section {
            page-break-inside: avoid;
        }

        /* Print-friendly colors */
        .fi-infolist * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Hide any overlay or backdrop */
        .fi-sidebar-overlay,
        .fi-modal-overlay,
        .backdrop {
            display: none !important;
        }
    }
</style>

