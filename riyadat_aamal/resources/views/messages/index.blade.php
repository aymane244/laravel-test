<div class="message-wrapper">
    <ul class="messages">
        @foreach($messages as $message)

                @if ($message->from==Auth::id())
                    <li class="replies">
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
