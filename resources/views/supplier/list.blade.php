@extends('layouts.app')
@section('content')
<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Suppliers List</h1>
                    </div>
                </div>
                <!--end::Toolbar container-->
            </div>

            <!--end::Toolbar-->
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="loader" class="loader-container">
                    <div class="loader"></div>
                </div>
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-4">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="text" id="customSearchInput" data-kt-customer-table-filter="search" class="form-control form-control-sm w-250px ps-12" placeholder="Search Supplier" />
                                </div>

                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                    <a href="{{ route('supplier.create') }}"><button type="button" class="btn btn-sm fw-bold btn-primary"><i class="ki-duotone ki-plus fs-2"></i>Add Supplier</button></a>
                                    <!--end::Add customer-->
                                </div>
                                <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                                    <div class="fw-bold me-5">
                                        <span class="me-2" data-kt-user-table-select="selected_count">10</span>Selected
                                    </div>
                                    <button type="button" class="btn btn-sm fw-bold btn-danger" data-kt-user-table-select="delete_selected" onclick="deleteSelectedSuppliers()">Delete Selected</button>
                                </div>
                            </div>

                            <!--end::Toolbar-->
                            <!--begin::Group actions-->

                            <!--end::Group actions-->

                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body py-0">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5 mt-0 header-sticky" id="kt_suppliers_table">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-10px pe-2 sorting_disabled">
                                            <div class="form-check form-check-sm form-check-custom  me-3">
                                                <input class="form-check-input select-all-checkbox header-checkbox" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_suppliers_table .select-all-checkbox" />
                                                <label class="form-check-label" for="kt_suppliers_table .form-check-input"></label>
                                            </div>
                                        </th>
                                        <th class="min-w-125px">Supplier Name</th>
                                        <th class="min-w-125px">Company name</th>
                                        <th class="min-w-125px">Email Address</th>
                                        <th class="min-w-100px">Contact No</th>
                                        <th class="min-w-50px">Status</th>
                                        <th class="min-w-100px text-end"><span class="pe-7">Actions</span></th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
                <!--end::Content container-->
            </div>
            <!--end::Content-->
        </div>
    </div>
</div>
@push('scripts')

<script>
    $(document).ready(function() {
        // Initialize DataTable
        dataTable = $('#kt_suppliers_table').DataTable({
            processing: true,
            serverSide: true,
            bLengthChange: true, // thought this line could hide the LengthMenu
            bInfo: true,
            columnDefs: [{
                    targets: [0],
                    orderable: false,
                } // Disable ordering for the checkbox column
            ],
            ajax: "{{ route('suppliers.index') }}", // Update the route to your actual controller route
            columns: [{
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        var checkbox = '<div class="form-check form-check-sm form-check-custom">' +
                            '<input class="form-check-input select-all-checkbox delete-checkbox" type="checkbox" value="' + row.id + '"/>' +
                            '</div>';
                        return checkbox;
                    }
                },
                {
                    data: 'supplier_name',
                    name: 'supplier_name'
                },
                {
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'decrypted_email',
                    name: 'decrypted_email'
                },
                {
                    data: 'contact_number',
                    name: 'contact_number'
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        console.log("sfgfdx", row.status);

                        var isChecked = row.status == 1 ? 'checked' : '';
                        var initialClass = row.status == 1 ? 'initial-on' : 'initial-off';

                        var statusSwitch = '<div class="form-check form-check-solid form-switch form-check-custom fv-row">' +
                            '<input id="statusCheckbox_' + row.id + '" class="form-check-input h-20px w-30px status-toggle ' + (row.status == 1 ? 'initial-on' : 'initial-off') + '" data-supplier-id="' + row.id + '" type="checkbox" ' + (row.status == 1 ? 'checked' : '') + '>' +
                            '<label class="form-check-label" for="statusCheckbox_' + row.id + '"></label>' +
                            '</div>';

                        return statusSwitch;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        // Check if email icon should be shown
                        var showEmailIcon = row.email_icon_condition;

                        // Add your custom actions here
                        var actionsColumn = '<ul class="list-inline m-0 text-end pe-2 d-flex justify-content-end">' +
                            '<li class="list-inline-item">' +
                            '<button class="btn btn btn-secondary btn-sm edit-btn btn-sm edit-btn" type="button" onclick="editSupplier(' + row.id + ')" title="Edit"><i class="fa fa-edit p-0"></i></button>' +
                            '</li>' +
                            '<li class="list-inline-item">' +
                            '<button class="btn btn-secondary btn-sm delete-btn" type="button" onclick="deleteSupplier(' + row.id + ')" title="Delete"><i class="fa fa-trash p-0"></i></button>' +
                            '</li>';

                        // Add the email icon button conditionally
                        if (showEmailIcon == false) {
                            actionsColumn += '<li class="list-inline-item">' +
                                '<button class="btn btn-secondary btn-sm password-btn" type="button" onclick="sendPasswordLink(' + row.id + ')" title="Send Email"><i class="fa fa-envelope p-0"></i></button>' +
                                '</li>';
                        }

                        actionsColumn += '</ul>';

                        return actionsColumn;
                    }
                }
            ],
        });

        $(document).on('change', '.status-toggle', function() {
            const statusCheckbox = $(this);
            const supplierId = statusCheckbox.data('supplierId');
            const status = statusCheckbox.prop('checked') ? 1 : 0; // Assuming 1 is active and 0 is inactive
            const csrfToken = "{{ csrf_token() }}";

            // Show Swal confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to change the status of this supplier!',
                 customClass: {
                    confirmButton: 'btn btn-sm btn-primary', // Add your class name for the confirm button
                    cancelButton: 'btn btn-sm me-2'    // Add your class name for the cancel button
                  },
                icon: 'warning',
                showCancelButton: true,
                // confirmButtonColor: '#3085d6',
                // cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with the status update
                    $.ajax({
                        url: "{{ route('supplier.updateStatus') }}", // Update the route to your actual controller route
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            supplierId: supplierId,
                            status: status
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                            }).then(() => {
                                location.reload(); // Reload the page after successful status update
                            });
                        },
                        error: function(xhr) {
                            console.log(xhr)
                            Swal.fire({
                                icon: 'error',
                                title: 'Error updating supplier status',
                                text: xhr.responseJSON.error || 'Something went wrong!',
                            }).then(() => {
                                // Reset the checkbox to its previous state
                                statusCheckbox.prop('checked', !statusCheckbox.prop('checked'));
                            });
                        }
                    });
                } else {
                    // Reset the checkbox to its previous state
                    statusCheckbox.prop('checked', !statusCheckbox.prop('checked'));
                }
            });
        });

        $('#customSearchInput').on('keyup', function() {
            dataTable.search($(this).val()).draw();
        });

        $(document).on("change", ".select-all-checkbox", function() {
            var selectedCount = $(".delete-checkbox:checked").length;

            // Update the selected rows count in the second div
            $(".d-flex.justify-content-end.align-items-center[data-kt-user-table-toolbar='selected'] [data-kt-user-table-select='selected_count']").text(selectedCount);

            if (selectedCount > 0) {
                $(".d-flex.justify-content-end.align-items-center[data-kt-user-table-toolbar='selected']").removeClass("d-none");
                $(".d-flex.justify-content-end[data-kt-customer-table-toolbar='base']").addClass("d-none");
            } else {
                $(".d-flex.justify-content-end.align-items-center[data-kt-user-table-toolbar='selected']").addClass("d-none");
                $(".d-flex.justify-content-end[data-kt-customer-table-toolbar='base']").removeClass("d-none");
            }
        });

        $(document).on('change', '.delete-checkbox', function() {
            var allCheckboxes = $('.delete-checkbox');
            var selectedCount = $(".delete-checkbox:checked").length;
            if (allCheckboxes.length == selectedCount) {
                $('.header-checkbox').prop('checked', true)
            } else if (allCheckboxes.length != selectedCount) {
                $('.header-checkbox').prop('checked', false)
            }

        });
    });

    function editSupplier(id) {
        const editSupplierRoute = "{{ route('supplier.edit', ['id' => ':id']) }}".replace(':id', id);
        window.location = editSupplierRoute;
    }

    function deleteSupplier(id) {
        const csrfToken = "{{ csrf_token() }}";
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this supplier!',
            icon: 'warning',
             customClass: {
                confirmButton: 'btn btn-sm btn-primary', // Add your class name for the confirm button
                cancelButton: 'btn btn-sm me-2'    // Add your class name for the cancel button
              },
            showCancelButton: true,
            // confirmButtonColor: '#d33',
            // cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, proceed with the delete operation
                $.ajax({
                    url: "{{ route('suppliers.destroy', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        dataTable.ajax.reload();


                        $(".d-flex.justify-content-end.align-items-center[data-kt-user-table-toolbar='selected']").addClass("d-none");
                        $(".d-flex.justify-content-end[data-kt-customer-table-toolbar='base']").removeClass("d-none");
                        $('.select-all-checkbox').prop('checked', false);


                        Swal.fire({
                            icon: 'success',
                            title: 'Supplier deleted successfully!',
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error deleting supplier',
                            text: xhr.responseJSON.message || 'Something went wrong!',
                        });
                    }
                });
            }
        });
    }

    function deleteSelectedSuppliers() {
        // Check if any checkboxes are selected
        if ($('.delete-checkbox:checked').length === 0) {
            // No checkboxes selected, show SweetAlert toast
            Swal.fire({
                icon: 'warning',
                title: 'Please select at least one supplier to delete!',
            });
        } else {
            // Some checkboxes are selected, proceed with delete
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover the selected supplier(s)!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, proceed with the delete operation
                    const csrfToken = "{{ csrf_token() }}";

                    const selectedIds = [];

                    // Iterate over all checkboxes and gather selected IDs
                    $('.delete-checkbox:checked').each(function() {
                        selectedIds.push($(this).val());
                    });

                    $.ajax({
                        url: "{{ route('suppliers.bulkDelete') }}", // Replace with your actual bulk delete route
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            ids: selectedIds
                        },
                        success: function(response) {
                            dataTable.ajax.reload();

                            Swal.fire({
                                icon: 'success',
                                title: 'Selected supplier(s) deleted successfully!',
                            });
                            $(".d-flex.justify-content-end.align-items-center[data-kt-user-table-toolbar='selected']").addClass("d-none");
                            $(".d-flex.justify-content-end[data-kt-customer-table-toolbar='base']").removeClass("d-none");
                            $('.select-all-checkbox').prop('checked', false);
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error deleting selected supplier(s)',
                                text: xhr.responseJSON.message || 'Something went wrong!',
                            });
                        }
                    });
                }
            });
        }
    }

    function sendPasswordLink(id) {
        const csrfToken = "{{ csrf_token() }}";

        $('#loader').show();

        $.ajax({
            url: "{{ route('suppliers.resendPasswordLink', ':id') }}".replace(':id', id),
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                $('#loader').hide();
                dataTable.ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: response.message,
                });
            },
            error: function(xhr) {
                $('#loader').hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Error deleting supplier',
                    text: xhr.responseJSON.message || 'Something went wrong!',
                });
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        function setTableHeight() {
            var windowHeight = $(window).height();
            var topHeader = $('#kt_app_header_container').height();
            var topTitleHeader = $('#kt_app_toolbar').height();
            var listFilter = $('.card-header').height();
            var tableHeader = $('table tr th').height();
            var calcHeight = windowHeight - (topHeader + topTitleHeader + listFilter + tableHeader + 115);
            $('.table-responsive').height(calcHeight);
        }

        // Call the function initially
        setTableHeight();

        // Call the function whenever the window is resized
        $(window).resize(function() {
            setTableHeight();
        });
    });
</script>


@endpush
@endsection