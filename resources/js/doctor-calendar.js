import { Calendar } from "@fullcalendar/core"; // Assuming you are pulling this via npm now
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";

let calendarLoaded = false;

window.initDoctorCalendar = function () {
    if (calendarLoaded) {
        if (window.doctorCal) window.doctorCal.updateSize();
        return;
    }

    const calendarEl = document.getElementById("doctorCalendar");

    if (calendarEl) {
        // Parse the events from the data attribute
        const dynamicEvents = JSON.parse(
            calendarEl.getAttribute("data-events"),
        );

        window.doctorCal = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, timeGridPlugin],
            initialView: "dayGridMonth",
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay",
            },
            themeSystem: "standard",
            height: 600,

            // This enables the "See More" link if a day gets too crowded
            dayMaxEvents: 3,

            eventDisplay: "block",

            // Formats the time cleanly (e.g., 2:30p)
            displayEventTime: false,
            eventTimeFormat: {
                hour: "numeric",
                minute: "2-digit",
                meridiem: "short",
            },

            eventClassNames:
                "rounded-md border-0 text-xs font-bold px-1 cursor-pointer",
            events: dynamicEvents,
        });

        window.doctorCal.render();
        calendarLoaded = true;
    }
};
