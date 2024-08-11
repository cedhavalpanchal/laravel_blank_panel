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
                            <h1
                                class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                                Category List</h1>
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
                                        <input type="text" id="customSearchInput" data-kt-customer-table-filter="search"
                                            class="form-control form-control-sm w-250px ps-12"
                                            placeholder="Search Category" />
                                    </div>

                                    <!--end::Search-->
                                </div>
                                <!--begin::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Toolbar-->
                                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                        <a href="{{ route('category.create') }}"><button type="button"
                                                class="btn btn-sm fw-bold btn-primary"><i
                                                    class="ki-duotone ki-plus fs-2"></i>Add Category</button></a>
                                        <!--end::Add customer-->
                                    </div>
                                    <div class="d-flex justify-content-end align-items-center d-none"
                                        data-kt-user-table-toolbar="selected">
                                        <div class="fw-bold me-5">
                                            <span class="me-2"
                                                data-kt-user-table-select="selected_count">10</span>Selected
                                        </div>
                                        <button type="button" class="btn btn-sm fw-bold btn-danger"
                                            data-kt-user-table-select="delete_selected"
                                            onclick="deleteSelectedSuppliers()">Delete Selected</button>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body py-0">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mt-0 header-sticky"
                                    id="datatable">
                                    <thead>
                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="w-10px pe-2 sorting_disabled">
                                                <div class="form-check form-check-sm form-check-custom  me-3">
                                                    <input class="form-check-input select-all-checkbox header-checkbox"
                                                        type="checkbox" data-kt-check="true"
                                                        data-kt-check-target="#datatable .select-all-checkbox" />
                                                    <label class="form-check-label"
                                                        for="datatable .form-check-input"></label>
                                                </div>
                                            </th>
                                            <th class="min-w-125px">Parent Category</th>
                                            <th class="min-w-125px">Category Name</th>
                                            <th class="min-w-125px">Slug</th>
                                            <th class="min-w-125px">Created At</th>
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
                dataTable = $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    bLengthChange: true, // thought this line could hide the LengthMenu
                    bInfo: true,
                    order : [
                        [4, 'desc']
                    ],
                    ajax: "{{ route('category.index') }}", // Update the route to your actual controller route
                    columns: [{
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                var checkbox =
                                    '<div class="form-check form-check-sm form-check-custom">' +
                                    '<input class="form-check-input select-all-checkbox delete-checkbox" type="checkbox" value="' +
                                    row.id + '"/>' +
                                    '</div>';
                                return checkbox;
                            }
                        },
                        {
                            data: 'parent_id',
                            name: 'parent_id',
                            render: function(data, type, row) {
                                return data ? row.parent.category : 'N/A';
                            }
                        },
                        {
                            data: 'category',
                            name: 'category'
                        },
                        {
                            data: 'slug',
                            name: 'slug'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                // Add your custom actions here
                                var actionsColumn =
                                    '<ul class="list-inline m-0 text-end pe-2 d-flex justify-content-end">' +
                                    '<li class="list-inline-item">' +
                                    '<button class="btn btn btn-secondary btn-sm edit-btn btn-sm edit-btn" type="button" onclick="editSupplier(' +
                                    row.id + ')" title="Edit"><i class="fa fa-edit p-0"></i></button>' +
                                    '</li>' +
                                    '<li class="list-inline-item">' +
                                    '<button class="btn btn-secondary btn-sm delete-btn" type="button" onclick="deleteSupplier(' +
                                    row.id +
                                    ')" title="Delete"><i class="fa fa-trash p-0"></i></button>' +
                                    '</li>';

                                actionsColumn += '</ul>';

                                return actionsColumn;
                            }
                        }
                    ],
                });


                $('#customSearchInput').on('keyup', function() {
                    dataTable.search($(this).val()).draw();
                });

                $(document).on("change", ".select-all-checkbox", function() {
                    var selectedCount = $(".delete-checkbox:checked").length;

                    // Update the selected rows count in the second div
                    $(".d-flex.justify-content-end.align-items-center[data-kt-user-table-toolbar='selected'] [data-kt-user-table-select='selected_count']")
                        .text(selectedCount);

                    if (selectedCount > 0) {
                        $(".d-flex.justify-content-end.align-items-center[data-kt-user-table-toolbar='selected']")
                            .removeClass("d-none");
                        $(".d-flex.justify-content-end[data-kt-customer-table-toolbar='base']").addClass(
                            "d-none");
                    } else {
                        $(".d-flex.justify-content-end.align-items-center[data-kt-user-table-toolbar='selected']")
                            .addClass("d-none");
                        $(".d-flex.justify-content-end[data-kt-customer-table-toolbar='base']").removeClass(
                            "d-none");
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
                const editSupplierRoute = "{{ route('category.edit', ['id' => ':id']) }}".replace(':id', id);
                window.location = editSupplierRoute;
            }

            function deleteSupplier(id) {
                const csrfToken = "{{ csrf_token() }}";
                Swal.fire({
                    title: 'Confirm',
                    text: 'Do you want to delete this category?',
                    icon: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-sm btn-primary', // Add your class name for the confirm button
                        cancelButton: 'btn btn-sm me-2' // Add your class name for the cancel button
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User confirmed, proceed with the delete operation
                        $.ajax({
                            url: "{{ route('category.delete', ':id') }}".replace(':id', id),
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(response) {
                                dataTable.ajax.reload();

                                $(".d-flex.justify-content-end.align-items-center[data-kt-user-table-toolbar='selected']")
                                    .addClass("d-none");
                                $(".d-flex.justify-content-end[data-kt-customer-table-toolbar='base']")
                                    .removeClass("d-none");
                                $('.select-all-checkbox').prop('checked', false);

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Category deleted successfully!',
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
                        title: 'Please select at least one category to delete!',
                    });
                } else {
                    // Some checkboxes are selected, proceed with delete
                    Swal.fire({
                        title: 'Confirm',
                        text: 'Do you want to delete the selected category(s)?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes'
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
                                url: "{{ route('category.bulkDelete') }}", // Replace with your actual bulk delete route
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
                                        title: 'Selected category(s) deleted successfully!',
                                    });
                                    $(".d-flex.justify-content-end.align-items-center[data-kt-user-table-toolbar='selected']")
                                        .addClass("d-none");
                                    $(".d-flex.justify-content-end[data-kt-customer-table-toolbar='base']")
                                        .removeClass("d-none");
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
