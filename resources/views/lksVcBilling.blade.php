@extends('layouts.master')
@section('title', 'Blank')
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <!-- Hoverable Table rows -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            İnternet xidmətləri üzrə LKŞ və Billing analizi 
                        </h5>
                        <div>
                            Tapılan nömrələrin sayı: <strong style="color: red;">{{ $total }}</strong>
                        </div>


                        <a href="{{ route('lksVcBillingExport') }}" class="btn rounded-pill btn-outline-primary">
                            Excel Yüklə
                        </a>
                    </div>


                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Telefon</th>
                                    <th>LKŞ</th>
                                    <th>Billing</th>
                                    <th>Lkş Billing fərqi</th>
                                    <th>Kateqoriya</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @forelse ($data as $item)
                                <tr>
                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                        <strong>{{ $item->telefon }}
                                        </strong>
                                    </td>
                                    <td>{{ $item->lks_summa }}</td>
                                    <td>{{ $item->bill_summa }}</td>
                                    <td>{{ $item->lks_bill_ferq }}</td>
                                    <td>{{ $item->kateqoriya }}</td>

                                </tr>
                                @empty
                                <tr>
                                    <td>
                                        <strong>
                                            <h1>Məlumat yoxdur</h1>
                                        </strong>
                                    </td>
                                </tr>
                                @endforelse


                            </tbody>
                        </table>
                    </div>
                </div>
                <!--/ Hoverable Table rows -->





            </div>





        </div>

    </div>
</div>
<!-- / Content -->




@endsection