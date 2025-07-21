@extends('layouts.master')

@section('title')
الاقسام
@endsection

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<style>
    table.dataTable {
        width: 100% !important;
    }

    .modal.scale .modal-content {
        transform: scale(0.9);
        transition: all 0.3s ease-in-out;
    }

    .modal.show .modal-content {
        transform: scale(1);
    }
</style>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الإعدادات</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الأقسام</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<h1>الأقسام</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mg-b-0">جدول الأقسام</h4>
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addSectionModal">
                        <i class="fas fa-plus"></i> إضافة قسم
                    </button>
                </div>
                <p class="tx-12 tx-gray-500 mb-2">مثال على جدول بيانات باستخدام DataTables.</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم القسم</th>
                                <th>الوصف</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=0
                            @endphp
                            @foreach ($sections as $section)
                            <tr>

                                @php
                                    $i=$i+1
                                @endphp
                                <td>{{$i}}</td>
                                <td>{{$section->name}}</td>
                                <td>{{$section->description}}</td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-primary edit-section-btn"
                                        data-id="{{ $section->id }}"
                                        data-name="{{ $section->name }}"
                                        data-description="{{ $section->description }}"
                                        data-toggle="modal"
                                        data-target="#editSectionModal">
                                        تعديل
                                    </button>
                                    <form action="{{ route('section.destroy', $section->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                                    </form>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: إضافة قسم -->
<div class="modal fade scale" id="addSectionModal" tabindex="-1" role="dialog" aria-labelledby="addSectionLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSectionLabel">إضافة قسم جديد</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="{{ route('section.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="name">اسم القسم</label>
            <input type="text" class="form-control" name="name" id="name" required>
          </div>
          <div class="form-group">
            <label for="description">الوصف</label>
            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
          <button type="submit" class="btn btn-primary">حفظ</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: تعديل قسم -->
<div class="modal fade scale" id="editSectionModal" tabindex="-1" role="dialog" aria-labelledby="editSectionLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editSectionLabel">تعديل القسم</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="editSectionForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="form-group">
            <label for="edit_name">اسم القسم</label>
            <input type="text" class="form-control" name="name" id="edit_name" required>
          </div>
          <div class="form-group">
            <label for="edit_description">الوصف</label>
            <textarea class="form-control" name="description" id="edit_description" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
          <button type="submit" class="btn btn-primary">تحديث</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
            responsive: true,
            scrollX: true,
            autoWidth: false,
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/ar.json"
            }
        });

        // إعداد مودال التعديل
        $('.edit-section-btn').on('click', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');

            $('#edit_name').val(name);
            $('#edit_description').val(description);

            // ضبط مسار الفورم مع ID القسم
            var url = '{{ route("section.update", ":id") }}';
            url = url.replace(':id', id);
            $('#editSectionForm').attr('action', url);
        });
    });
</script>
@endsection
