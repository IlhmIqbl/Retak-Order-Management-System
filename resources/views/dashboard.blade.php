<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <style>
            .modal-overlay {
                background: rgba(0,0,0,0.6);
            }
        </style>
    </x-slot>

    <div class="flex gap-8">

        <!-- LEFT SIDE -->
        <div class="w-1/2">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/waving-hand.png') }}" class="w-8 h-8">
                <h3 class="text-lg font-bold text-gray-900">
                    Welcome back, {{ Auth::user()->name }}!
                </h3>
            </div>

            <div class="flex items-center space-x-4 py-12">
                <img src="{{ asset('images/user.png')}}" class="w-16 h-16">
                <h3 class="text-lg text-gray-900 font-extrabold">
                    {{ Auth::user()->name }} <br>
                    <span class="text-base text-gray-500 font-normal">
                        {{ Auth::user()->email }}
                    </span>
                </h3>
            </div>

            <div class="px-6">
                <div class="flex justify-between border-b py-4">
                    <span class="font-medium text-gray-900">Name</span>
                    <span class="text-gray-600">{{ Auth::user()->name }}</span>
                </div>

                <div class="flex justify-between border-b py-4">
                    <span class="font-medium text-gray-900">Email</span>
                    <span class="text-gray-600">{{ Auth::user()->email }}</span>
                </div>

                <div class="flex justify-between border-b py-4">
                    <span class="font-medium text-gray-900">Mobile number</span>
                    <span class="text-gray-600">+6012345679</span>
                </div>

                <div class="flex justify-between py-4">
                    <span class="font-medium text-gray-900">Position</span>
                    <span class="text-gray-600">Customer Service Admin</span>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE: Calendar -->
        <div class="w-1/2 bg-white p-12 rounded-lg">
            <h3 class="text-xl font-semibold mb-4">Calendar</h3>
            <div id="calendar"></div>
        </div>

    </div>

    <!-- MODAL -->
    <div id="eventModal" class="fixed inset-0 hidden items-center justify-center modal-overlay z-50">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <button onclick="closeModal()" class="  text-gray-500 hover:text-gray-700">✕</button>
          

            <input type="hidden" id="event-id">
            <input type="hidden" id="event-date"> <!-- store selected date -->

            <label class="block font-semibold py-4">Title</label>
            <input type="text" id="event-title" class="w-full border rounded p-2 mb-3" placeholder="Add Event">

            <div class="flex justify-between py-4">
                <button onclick="saveEvent()" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                <button onclick="deleteEvent()" id="delete-btn" class="hidden bg-red-600 text-white px-4 py-2 rounded">Delete</button>
            </div>
        </div>
    </div>

    <!-- FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const modal = document.getElementById('eventModal');

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                editable: true,
                events: '/events',

                dateClick: function(info) {
                    openModal('add', { date: info.dateStr });
                },

                eventClick: function(info) {
                    openModal('edit', {
                        id: info.event.id,
                        title: info.event.title,
                        date: info.event.startStr
                    });
                }
            });

            calendar.render();

            // Modal
            window.openModal = function(type, data) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');

                document.getElementById('event-date').value = data.date;

                if(type === 'add') {
                    document.getElementById('modal-title').innerText = 'Add Event';
                    document.getElementById('event-title').value = '';
                    document.getElementById('event-id').value = '';
                    document.getElementById('delete-btn').classList.add('hidden');
                } else {
                    document.getElementById('modal-title').innerText = 'Edit Event';
                    document.getElementById('event-title').value = data.title;
                    document.getElementById('event-id').value = data.id;
                    document.getElementById('delete-btn').classList.remove('hidden');
                }
            };

            window.closeModal = function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            };

            // Save event (Add/Edit)
            window.saveEvent = function() {
                const id = document.getElementById('event-id').value;
                const title = document.getElementById('event-title').value;
                const date = document.getElementById('event-date').value;

                if(!title) return alert('Please enter a title');

                if(!id) {
                    fetch('/events', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ title, start: date })
                    })
                    .then(res => res.json())
                    .then(data => { calendar.addEvent(data); closeModal(); });
                } else {
                    fetch(`/events/${id}`, {
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ title, start: date })
                    })
                    .then(res => res.json())
                    .then(data => {
                        const existingEvent = calendar.getEventById(id);
                        existingEvent.setProp('title', data.title);
                        existingEvent.setStart(data.start);
                        closeModal();
                    });
                }
            };

            // Delete event
            window.deleteEvent = function() {
                const id = document.getElementById('event-id').value;
                fetch(`/events/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                }).then(() => {
                    const existingEvent = calendar.getEventById(id);
                    if(existingEvent) existingEvent.remove();
                    closeModal();
                });
            };
        });
    </script>

</x-admin-layout>
