@extends('layouts.app')
@section('title') Notifications @endsection

@section('content')

{{-- Contenu --}}
    <div class="mt-5" style="text-align: center;margin-bottom: 45px">
        <h1 style="font-weight: 900">Notifications</h1>
        <div class="h-divider-title">
            <div class="shadow"></div>
        </div>
    </div>

    <div class="container mb-5 wow fadeIn" data-wow-duration="1.5s">
        <div class="row">

            @foreach ($notifys as $notification)
                <div class="col-8 mx-auto">
                            <div class="card-body mb-3" style="box-shadow: 5px 6px 13px 0px #0000003d;@if($notification->is_read==false) background-color: #deffb2ba; @endif " >
                                <i class="@if($notification->etat=='rendez_vous') fa fa-clock-o @endif @if($notification->etat=='chat_group') fa fa-envelope @endif @if($notification->etat=='recommendation') fa fa-star @endif  icon_notification" aria-hidden="true"></i>
                                <div class="notify_message">
                                    {!! html_entity_decode($notification->message) !!}
                                    <span class="date_notify">{{ $notification->date }}</span>
                                </div>
                            </div>
                </div>
            @endforeach
        </div>
        <div style="margin: 0 auto;width:20%">{{ $notifys->links() }}</div>
    </div>

@endsection
