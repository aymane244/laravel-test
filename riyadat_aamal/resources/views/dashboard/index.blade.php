@extends('dashboard.layout')
@section('title') Dashboard @endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/recommandation.css') }}">
@endsection

@section('content')

<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content wow fadeIn" data-wow-duration="1.5s">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Project Dashboard </h2>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard Template</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card" style="height: 208px">
                        <div class="card-body">
                            <div class="">
                                <h5 class="text-muted">Total Entreprises</h5>
                                <h2 class="mb-0"> {{ $count_entreprise }}</h2>
                            </div>
                            <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                <i class="fa fa-users text-info" style="font-size: 33px" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card" style="height: 208px">
                        <div class="card-body">
                            <div class="">
                                <h5 class="text-muted">Total Contact</h5>
                                <h2 class="mb-0"> {{ $count_contact }} </h2>
                            </div>
                            <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                                <i class="fa fa-envelope-open text-primary" style="font-size: 33px" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card" style="height: 208px">
                        <div class="card-body">
                            <div class="">
                                <h5 class="text-muted">Total Recommandation</h5>
                                <h2 class="mb-0">{{ $count_recommandation }}</h2>
                            </div>
                            <div class="float-right icon-circle-medium  icon-box-lg  bg-secondary-light mt-1">
                                <i class="fa fa-star text-secondary" style="font-size: 33px" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card" style="height: 208px">
                        <div class="card-body">
                            <div class="">
                                <h5 class="text-muted">Total Rendez-vous</h5>
                                <h2 class="mb-0"> {{ $count_rendez_vous }}</h2>
                            </div>
                            <div class="float-right icon-circle-medium  icon-box-lg  bg-brand-light mt-1">
                                <i class="fa fa-calendar-o text-brand" style="font-size: 33px" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Type d'entreprise</h5>
                        <div id="piechart"></div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12" style="margin: 0 auto;line-height: normal">
                    <div class="card" style="height: 450px;">
                        <h5 class="card-header">Contact</h5>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr class="border-0">
                                            <th class="border-0">Nom Complet</th>
                                            <th class="border-0">Email</th>
                                            <th class="border-0">Objet</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contacts as $contact)
                                            <tr>
                                                <td>{{ $contact->nom_complet }}</td>
                                                <td>{{ $contact->email }} </td>
                                                <td>{{ $contact->objet }} </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="9"><a href="{{ route('dashboard.contacts') }}" class="btn btn-outline-light float-right">View Details</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Les Entreprises</h5>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr class="border-0">
                                            <th class="border-0">Logo</th>
                                            <th class="border-0">Entreprise Name</th>
                                            <th class="border-0">Telephone</th>
                                            <th class="border-0">Email</th>
                                            <th class="border-0">Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($entreprises_active as $entreprise)
                                            <tr>
                                                <td>
                                                    @if ($entreprise->logo==NULL)
                                                        @php
                                                            $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                                            $color = $colors[array_rand($colors)];
                                                        @endphp
                                                        <div class="logo_rendez_vous" style="background-color: @php echo $color; @endphp;height:40px;width:40px">
                                                            <h5 class="text-center text-white" style="padding-top: 8px">@php echo substr($entreprise->name, 0, 1); @endphp </h5>
                                                        </div>
                                                    @else
                                                        <img src="{{ asset('img/logos/'.$entreprise->logo.'') }}" class="logo_rendez_vous" width="40px" height="40px" alt="{{ $entreprise->name }}">
                                                    @endif
                                                </td>
                                                <td>{{ $entreprise->name }} </td>
                                                <td>{{ $entreprise->tele }} </td>
                                                <td>{{ $entreprise->email }}</td>
                                                <td>
                                                    <div class="rating-row">
                                                        <ul>
                                                            <li class=""><i class="@if($entreprise->rating >= 1 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                                            <li class=""><i class="@if($entreprise->rating >= 2 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                                            <li class=""><i class="@if($entreprise->rating >= 3 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                                            <li class=""><i class="@if($entreprise->rating >= 4 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                                            <li class=""><i class="@if($entreprise->rating >= 5 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="9"><a href="{{ route('dashboard.show','List') }}" class="btn btn-outline-light float-right">View Details</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12" style="margin: 0 auto;line-height: normal">
                    <div class="card">
                        <h5 class="card-header">Les entreprise en attente</h5>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table no-wrap p-table">
                                    <thead class="bg-light">
                                        <tr class="border-0">
                                            <th class="border-0">Nom d'entreprise</th>
                                            <th class="border-0">Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($entreprises_desactive as $entreprise)
                                            <tr>
                                                <td>{{ $entreprise->name }}</td>
                                                <td>{{ $entreprise->email }}</td>
                                                <td><td><span class="badge-dot badge-success mr-1" style="background-color: red"></span>Desactiver </td></td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3">
                                                <a href="{{ route('dashboard.create') }}" class="btn btn-outline-light float-right">Details</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection

@section('script')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        // Load google charts
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        // Draw the chart and set the chart values
        function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['Auto entrepreneur', {{ $count_entrepreneur }}],
        ['Sarl', {{ $count_sarl }}],
        ['Société anonyme', {{ $count_anonyme }}],
        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'', 'width':700, 'height':400};

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
        }
    </script>
@endsection
