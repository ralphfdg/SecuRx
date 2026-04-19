document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");

    if (calendarEl) {
        var apiUrl = calendarEl.dataset.url;

        var calendar = new FullCalendar.Calendar(calendarEl, {
            // Default to a wide month view for better data visualization
            initialView: "dayGridMonth",

            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
            },

            // Clinic Operating Hours
            slotMinTime: "08:00:00",
            slotMaxTime: "18:00:00",
            allDaySlot: false,

            // THE CRITICAL VISUALIZATION RULE:
            // Only show 3 events per day box. If more, group them into a "+X more" popup link.
            dayMaxEvents: 3,

            eventTimeFormat: {
                hour: "numeric",
                minute: "2-digit",
                meridiem: "short",
            },

            // Fetch Data
            events: apiUrl,

            // Event styling for better UX
            eventDisplay: "block",
            eventClassNames:
                "cursor-pointer shadow-sm rounded-md px-1 py-0.5 text-xs font-medium border-0",

            eventClick: function (info) {
                // Displays the newly fetched extended properties and fixed DateTime
                alert(
                    "Context: " + (info.event.extendedProps.type || 'Standard') + "\n" +
                    "Status: " + (info.event.extendedProps.status || 'Pending') + "\n" +
                    "Patient: " + (info.event.extendedProps.patientName || 'Unknown') + "\n" +
                    "Doctor: " + (info.event.extendedProps.doctorName || 'Unknown') + "\n" +
                    "Time: " + info.event.start.toLocaleString([], {
                        weekday: 'short', 
                        month: 'short', 
                        day: 'numeric', 
                        hour: '2-digit', 
                        minute: '2-digit'
                    })
                );
            },
        });

        calendar.render();
    }
});