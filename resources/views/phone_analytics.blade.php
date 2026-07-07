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
                            <h5 class="mb-0">MHM və LKŞ arasıda telefon xidmətləri arasında hesablanma fərqləri</h5>

                            <a href="{{ route('phone.analytics.export') }}" class="btn rounded-pill btn-outline-primary">
                                Excel Yüklə
                            </a>
                        </div>


                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Telefon</th>
                                        <th>MHM</th>
                                        <th>LKŞ</th>
                                        <th>Fərq</th>
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
                                            <td>{{ $item->mhm_summa }}</td>
                                            <td>{{ $item->lks_summa }}</td>
                                            <td>{{ $item->ferq }}</td>
                                            <td>{{ $item->abonent }}</td>

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
