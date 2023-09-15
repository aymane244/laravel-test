<div class="contact-profile">
    @php
        $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
        $color = $colors[array_rand($colors)];
    @endphp
    <div class="logo_virtual_chat" style="margin: 9px 12px 0 9px;;background-color: @php echo $color; @endphp">
        <h5 class="text-center" style="color: white;padding-top: 11px;text-transform: uppercase">@php echo substr($group->name, 0, 1); @endphp </h5>
    </div>
    <p>{{ $group->name }}</p>

    @if ($group->admin_id == auth()->user()->id)
        <div class="social-media" style="font-size: 20px">
            <a href="#" onclick="confirmer({{$group->id}},'delete_groupe')" ><i class="fa fa-trash" aria-hidden="true"></i></a>
            <a href="/group/edit/{{$group->id}}"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>
            <a href="/group/members_list/{{$group->id}}" style="margin-right: 20px"><i class="fa fa-users" aria-hidden="true"></i></a>
        </div>
    @else
    <!-- this is for unFollow -->
    <div class="social-media mr-3 mt-3" style="font-size: 20px">
        <a href="#" onclick="confirmer({{$group->id}},'quitter_groupe')" ><i class="fa fa-sign-out" aria-hidden="true"></i></a>
    </div>
    @endif
</div>
<div class="messages" id="messages" style="min-height: calc(100% - 138px);max-height: calc(100% - 124px);">
    {{-- Messages --}}
    <div class="message-wrapper">
        <ul class="messages_msg" style="">
            @foreach($messages as $message)

                    @if ($message->from==Auth::id())
                        <li class="received">
                            @if (Auth::user()->logo==null)
                                @php
                                    $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                    $color = $colors[array_rand($colors)];
                                @endphp
                                <div class="logo_virtual_message" style="margin: 6px 0 0 8px;float: right;;background-color: @php echo $color; @endphp">
                                    <div class="text-center" style="color: white;padding-top: 4px;font-weight: 700;">@php echo substr(auth()->user()->name, 0, 1); @endphp </div>
                                </div>
                            @else
                                <img src="{{ asset('img/logos/'.Auth::user()->logo.'') }}" alt="{{ Auth::user()->name }}">
                            @endif
                            <p>

                                @if( $message->message!='null'){{ $message->message }} <br> <br>  @endif
                                @if ($message->file_message!=null)
                                    <span class="div_file_message_replies">
                                        <a href="{{ asset('files/'.$message->file_message.'') }}" target="_blank">
                                            <i class="fa fa-file file_message_read" style="color: white"></i>
                                        </a>
                                    </span>
                                    <br>
                                @endif
                                <span class="date" style="font-weight: 100">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</span>
                            </p>
                        </li>
                    @else
                        <li class="sent">
                            @if ($message->user_from->logo==null)
                                @php
                                    $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                    $color = $colors[array_rand($colors)];
                                @endphp
                                <div class="logo_virtual_message" style="float:left;background-color: @php echo $color; @endphp">
                                    <div class="text-center" style="color: white;padding-top: 4px;font-weight: 700;">@php echo substr($message->user_from->name, 0, 1); @endphp </div>
                                </div>
                            @else
                                <img src="{{ asset('img/logos/'.$message->user_from->logo.'') }}" alt="{{ $message->user_from->name }}">
                            @endif
                            <p>
                                <span style="color: #59ff59;display: block;margin-bottom: 6px">{{ $message->user_from->name }}</span>
                                @if( $message->message!='null'){{ $message->message }} <br> <br>  @endif
                                @if ($message->file_message!=null)
                                    <span class="div_file_message_sent">
                                        <a href="{{ asset('files/'.$message->file_message.'') }}" target="_blank">
                                            <i class="fa fa-file file_message_read_sent" style="color: #443591"></i>
                                        </a>
                                    </span>
                                    <br>
                                @endif
                                <span class="date" style="font-weight: 100">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</span>
                            </p>
                        </li>
                    @endif


            @endforeach
        </ul>
    </div>
</div>
