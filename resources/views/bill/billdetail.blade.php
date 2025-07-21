@extends('layouts.master')
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">فواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل
                    الفاتورة</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-lg-12 col-md-12">
                <div class="card" id="basic-alert">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">Basic Style Tabs</h6>
                            <p class="text-muted card-sub-title">It is Very Easy to Customize and it uses in your website
                                application.</p>
                        </div>
                        <div class="text-wrap">
                            <div class="example">
                                <div class="panel panel-primary tabs-style-1">
                                    <div class=" tab-menu-heading">
                                        <div class="tabs-menu1">
                                            <!-- Tabs -->
                                            <ul class="nav panel-tabs main-nav-line">
                                                <li class="nav-item"><a href="#tab1" class="nav-link active"
                                                        data-toggle="tab">الفاتورة</a></li>
                                                <li class="nav-item"><a href="#tab2" class="nav-link" data-toggle="tab">
                                                        تفاصيل الفاتورة</a></li>
                                                <li class="nav-item"><a href="#tab3" class="nav-link"
                                                        data-toggle="tab">مرفقات</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab1">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="example1" class="table key-buttons text-md-nowrap"
                                                            data-page-length='50'style="text-align: center">
                                                            <thead>
                                                                <tr>
                                                                    <th class="border-bottom-0">#</th>
                                                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                                                    <th class="border-bottom-0">تاريخ القاتورة</th>
                                                                    <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                                                    <th class="border-bottom-0">المنتج</th>
                                                                    <th class="border-bottom-0">القسم</th>
                                                                    <th class="border-bottom-0">الخصم</th>
                                                                    <th class="border-bottom-0">نسبة الضريبة</th>
                                                                    <th class="border-bottom-0">قيمة الضريبة</th>
                                                                    <th class="border-bottom-0">الاجمالي</th>
                                                                    <th class="border-bottom-0">الحالة</th>
                                                                    <th class="border-bottom-0">ملاحظات</th>
                                                                    <th class="border-bottom-0">العمليات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>{{ $bill->id }}</td>
                                                                    <td>{{ $bill->bill_number }} </td>
                                                                    <td>{{ $bill->bill_Date }}</td>
                                                                    <td>{{ $bill->Due_date }}</td>
                                                                    <td>{{ $bill->product }}</td>
                                                                    <td>{{ $bill->section->name }}
                                                                    </td>
                                                                    <td>{{ $bill->Discount }}</td>
                                                                    <td>{{ $bill->Rate_VAT }}</td>
                                                                    <td>{{ $bill->Value_VAT }}</td>
                                                                    <td>{{ $bill->Total }}</td>
                                                                    <td>
                                                                        @if ($bill->Value_Status == 1)
                                                                            <span
                                                                                class="text-success">{{ $bill->Status }}</span>
                                                                        @elseif($bill->Value_Status == 2)
                                                                            <span
                                                                                class="text-danger">{{ $bill->Status }}</span>
                                                                        @else
                                                                            <span
                                                                                class="text-warning">{{ $bill->Status }}</span>
                                                                        @endif

                                                                    </td>

                                                                    <td>{{ $bill->note }}</td>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab2">
                                                <table id="example1" class="table key-buttons text-md-nowrap"
                                                    data-page-length='50'style="text-align: center">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-bottom-0">#</th>
                                                            <th class="border-bottom-0">رقم الفاتورة</th>
                                                            <th class="border-bottom-0">المنتج </th>
                                                            <th class="border-bottom-0">القسم </th>
                                                            <th class="border-bottom-0">الحالة</th>
                                                            <th class="border-bottom-0">قيمة الحالة</th>
                                                            <th class="border-bottom-0">تاريخ الدفع</th>
                                                            <th class="border-bottom-0">الملاحظات </th>
                                                            <th class="border-bottom-0">المستخدم </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($billdetails as $billdetail)
                                                            <tr>
                                                                <td>{{ $billdetail->id }}</td>

                                                                <td>{{ $billdetail->bill_number }} </td>
                                                                <td>{{ $billdetail->product }}</td>
                                                                <td>{{ $billdetail->Section }}</td>
                                                                <td>
                                                                    @if ($billdetail->Value_Status == 1)
                                                                        <span
                                                                            class="text-success">{{ $billdetail->Status }}</span>
                                                                    @elseif($billdetail->Value_Status == 2)
                                                                        <span
                                                                            class="text-danger">{{ $billdetail->Status }}</span>
                                                                    @else
                                                                        <span
                                                                            class="text-warning">{{ $billdetail->Status }}</span>
                                                                    @endif

                                                                </td>
                                                                <td>{{ $billdetail->Value_status }}
                                                                </td>
                                                                <td>{{ $billdetail->Payment_Date }}</td>
                                                                <td>{{ $billdetail->note }}</td>
                                                                <td>{{ $billdetail->user }}</td>
                                                        @endforeach
                                                    </tbody>

                                                </table>
                                            </div>
                                            <div class="tab-pane" id="tab3">
                                                <!--المرفقات-->
                                                <div class="card card-statistics">
                                                    {{-- @can('اضافة مرفق') --}}
                                                        <div class="card-body">
                                                            <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                            <h5 class="card-title">اضافة مرفقات</h5>
                                                            <form method="post" action="{{ url('/billAttachments') }}"
                                                                enctype="multipart/form-data">
                                                                {{ csrf_field() }}
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="customFile" name="file_name" required>
                                                                    <input type="hidden" id="customFile" name="bill_number"
                                                                        value="{$attachments->bill_number}">
                                                                    <input type="hidden" id="bill_id" name="bill_id"
                                                                        value="{$attachments->bill_id}">
                                                                    <label class="custom-file-label" for="customFile">حدد
                                                                        المرفق</label>
                                                                </div><br><br>
                                                                <button type="submit" class="btn btn-primary btn-sm "
                                                                    name="uploadedFile">تاكيد</button>
                                                            </form>
                                                        </div>
                                                    {{-- @endcan --}}
                                                    <br>
                                                    <div class="table-responsive mt-15">
                                                        <table class="table center-aligned-table mb-0 table table-hover"
                                                            style="text-align:center">
                                                            <thead>
                                                                <tr class="text-dark">
                                                                    <th scope="col">م</th>
                                                                    <th scope="col">اسم الملف</th>
                                                                    <th scope="col">قام بالاضافة</th>
                                                                    <th scope="col">تاريخ الاضافة</th>
                                                                    <th scope="col">العمليات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i = 0; ?>
                                                                @foreach ($attachments as $attachment)
                                                                    <?php $i++; ?>
                                                                    <tr>
                                                                        <td>{{ $i }}</td>
                                                                        <td>{{ $attachment->file_name }}</td>
                                                                        <td>{{ $attachment->Created_by }}</td>
                                                                        <td>{{ $attachment->created_at }}</td>
                                                                        <td colspan="2">


                                                                            <a class="btn btn-outline-success btn-sm"
                                                                                href="{{ url('View_file') }}/{{ $attachment->bill_number }}/{{ $attachment->file_name }}"
                                                                                role="button"><i
                                                                                    class="fas fa-eye"></i>&nbsp;
                                                                                عرض</a>

                                                                            <a class="btn btn-outline-info btn-sm"
                                                                                href="{{ url('download') }}/{{ $attachment->bill_number }}/{{ $attachment->file_name }}"
                                                                                role="button"><i
                                                                                    class="fas fa-download"></i>&nbsp;
                                                                                تحميل</a>

                                                                            <button class="btn btn-outline-danger btn-sm"
                                                                                data-toggle="modal"
                                                                                data-file_name="{{ $attachment->file_name }}"
                                                                                data-bill_number="{{ $attachment->bill_number }}"
                                                                                data-id="{{ $attachment->id }}"
                                                                                data-target="#delete_file">حذف</button>


                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- row closed -->
                                    </div>
                                    <!-- Container closed -->
                                </div>
                                <!-- main-content closed -->
                                <!-- delete -->
                                <div class="modal fade" id="delete_file" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('delete_file') }}" method="post">
                                                @csrf
                                                {{-- {{ csrf_field() }} --}}
                                                <div class="modal-body">
                                                    <p class="text-center">
                                                    <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                                                    </p>

                                                    <input type="hidden" name="id" id="id" value="">
                                                    <input type="hidden" name="file_name" id="file_name"
                                                        value="">
                                                    <input type="hidden" name="bill_number" id="bill_number"
                                                        value="">

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">الغاء</button>
                                                    <button type="submit" class="btn btn-danger">تاكيد</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Container closed -->
                        </div>
                        <!-- main-content closed -->
                    @endsection
                    @section('js')
                        <!--Internal  Datepicker js -->
                        <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
                        <!-- Internal Select2 js-->
                        <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
                        <!-- Internal Jquery.mCustomScrollbar js-->
                        <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
                        <!-- Internal Input tags js-->
                        <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
                        <!--- Tabs JS-->
                        <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
                        <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
                        <!--Internal  Clipboard js-->
                        <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
                        <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
                        <!-- Internal Prism js-->
                        <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
                    @endsection
