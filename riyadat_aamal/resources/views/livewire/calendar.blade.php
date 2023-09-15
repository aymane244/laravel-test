
<div class="mt-5 mb-5">
    <div>
        <input type="hidden" value="{{ Auth::user()->id }}" id="id_entreprise">
        <div id='calendar-container' wire:ignore>
            <div id='calendar'></div>
        </div>
    </div>
</div>

    @push('scripts')

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.js'></script>
    <script>

        create_UUID = () => {
            let dt = new Date().getTime();
            const uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, c => {
                let r = (dt + Math.random() * 16) % 16 | 0;
                dt = Math.floor(dt / 16);
                return (c == 'x' ? r :(r&0x3|0x8)).toString(16);
            });
            return uuid;
        }

        document.addEventListener('livewire:load', function () {
            const Calendar = FullCalendar.Calendar;
            const calendarEl = document.getElementById('calendar');
            var id_entreprise = document.getElementById('id_entreprise').value;
            const calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                locale: '{{ config('app.locale') }}',
                events: JSON.parse(@this.events),
                editable: true,
                eventResize: info => @this.eventChange(info.event),
                eventDrop: info => @this.eventChange(info.event),

                // Ajouter 1
                selectable: true,
                select: arg => {
                    const title = prompt('Titre :');
                    const id = create_UUID();

                    if (title) {
                        calendar.addEvent({
                            id: id,
                            title: title,
                            start: arg.start,
                            end: arg.end,
                            id_entreprise:id_entreprise,
                            allDay: arg.allDay
                        });
                        @this.eventAdd(calendar.getEventById(id),id_entreprise);
                    };
                    calendar.unselect();
                },

                // Delete
                eventClick: info => {
                    if (confirm("Voulez-vous vraiment supprimer cet événement ?")) {
                        info.event.remove();
                        @this.eventRemove(info.event.id);
                    }
                }

            });
            calendar.render();
    });

    </script>

    @endpush



