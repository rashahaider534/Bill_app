@extends('layouts.master')

@section('title')
المنتجات
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
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<h1>المنتجات</h1>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session(' error') }}
    </div>
@endif

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
                    <h4 class="card-title mg-b-0">جدول المنتجات</h4>
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addProductModal">
                        <i class="fas fa-plus"></i> إضافة منتج
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
                                <th>اسم المنتج</th>
                                <th>اسم القسم</th>
                                <th>الوصف</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=0; @endphp
                            @foreach ($products as $product)
                            <tr>
                                @php $i++; @endphp
                                <td>{{$i}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->section->name}}</td>
                                <td>{{$product->description}}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-product-btn"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-section_id="{{ $product->section_id }}"
                                        data-description="{{ $product->description }}"
                                        data-toggle="modal"
                                        data-target="#editProductModal">تعديل</button>

                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST" style="display:inline;">
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

<!-- Modal: إضافة منتج -->
<div class="modal fade scale" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductLabel">إضافة منتج جديد</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('product.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="name">اسم المنتج</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="form-group">
            <label for="section_id">القسم</label>
            <select class="form-control select2" name="section_id" required>
              <option value="">-- اختر القسم --</option>
              @foreach ($sections as $section)
                <option value="{{ $section->id }}">{{ $section->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="description">الوصف</label>
            <textarea class="form-control" name="description" rows="3"></textarea>
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

<!-- Modal: تعديل منتج -->
<div class="modal fade scale" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProductLabel">تعديل المنتج</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editProductForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="form-group">
            <label for="edit_name">اسم المنتج</label>
            <input type="text" class="form-control" name="name" id="edit_name" required>
          </div>
          <div class="form-group">
            <label for="edit_section_id">القسم</label>
            <select class="form-control select2" name="section_id" id="edit_section_id" required>
              @foreach ($sections as $section)
                <option value="{{ $section->id }}">{{ $section->name }}</option>
              @endforeach
            </select>
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

        $('.edit-product-btn').on('click', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var section_id = $(this).data('section_id');
            var description = $(this).data('description');

            $('#edit_name').val(name);
            $('#edit_section_id').val(section_id);
            $('#edit_description').val(description);

            var url = '{{ route("product.update", ":id") }}';
            url = url.replace(':id', id);
            $('#editProductForm').attr('action', url);
        });
    });
</script>
@endsection
