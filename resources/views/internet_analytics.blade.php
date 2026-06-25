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
                        <h5 class="card-header">Hoverable rows</h5>
                        <a href="{{ route('internet.analytics.export') }}" class="btn btn-success mb-3">Excel Yüklə</a>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Telefon</th>
                                        <th>Billing</th>
                                        <th>MHM</th>
                                        <th>LKŞ</th>
                                        <th>Bill_Mhm fərqi</th>
                                        <th>Bill_LKŞ fərqi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @forelse ($data as $item)
                                        <tr>
                                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$item->telefon}}
                                                    </strong></td>
                                            <td>{{$item->bill_summa}}</td>
                                            <td>{{$item->mhm_summa}}</td>
                                            <td>{{$item->lks_summa}}</td>
                                            <td>{{$item->bill_mhm_ferq}}</td>
                                            <td>{{$item->bill_lks_ferq}}</td>

                                        </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            <strong><h1>Məlumat yoxdur</h1></strong>    
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
