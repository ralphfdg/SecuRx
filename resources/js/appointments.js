document.addEventListener('DOMContentLoaded', function() {
    
    const doctorSelect = document.getElementById("doctor_select");
    const dateInput = document.getElementById("appointment_datetime");
    
    let fpInstance = null;

    // Helper to convert 'HH:mm:ss' to a Date object for today to compare times
    const timeToDate = (timeStr) => {
        const [hours, minutes, seconds] = timeStr.split(':');
        const date = new Date();
        date.setHours(hours, minutes, seconds, 0);
        return date;
    };

    // 1. Initialize Flatpickr in a "Locked" default state
    if (dateInput) {
        fpInstance = flatpickr(dateInput, {
            inline: true,
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            minuteIncrement: 30,
            theme: "airbnb",
            disable: [
                function(date) { return true; } // Initially, disable everything
            ]
        });
    }

    // 2. Initialize Tom Select
    if (doctorSelect) {
        const tsInstance = new TomSelect(doctorSelect, {
            create: false,
            sortField: { field: "text", direction: "asc" },
            placeholder: "Type to search for a doctor...",
            controlInput: '<input type="text" class="text-sm">',
        });

        // 3. The Dynamic Engine: Triggered when a doctor is selected
        tsInstance.on('change', function(doctorId) {
            fpInstance.clear(); // Clear previous selection

            if (!doctorId || !fpInstance) {
                fpInstance.set('disable', [function(date) { return true; }]); // Lock if no doctor
                return;
            }
            
            // Fetch schedules and existing appointments for the selected doctor from the global window object
            const schedules = window.doctorSchedules ? (window.doctorSchedules[doctorId] || []) : [];
            const existingAppointments = window.upcomingAppointments ? (window.upcomingAppointments[doctorId] || []).map(d => new Date(d).getTime()) : [];

            if (schedules.length === 0) {
                fpInstance.set('disable', [function(date) { return true; }]); // Lock if no schedule
                return;
            }

            // Map standard day names to JavaScript getDay() integers (Sunday = 0)
            const dayMap = { 'Sunday':0, 'Monday':1, 'Tuesday':2, 'Wednesday':3, 'Thursday':4, 'Friday':5, 'Saturday':6 };
            
            // This is our new, powerful disable function
            const disableFunction = function(date) {
                const dayOfWeek = date.getDay();
                
                // Check for existing appointments at this exact time slot
                if (existingAppointments.includes(date.getTime())) {
                    return true;
                }

                // Find available schedules for this day of the week
                const availableSchedulesForDay = schedules.filter(s => s.is_available && dayMap[s.day_of_week] === dayOfWeek);

                if (availableSchedulesForDay.length === 0) {
                    return true; // Disable if doctor doesn't work on this day
                }

                // Check if the selected time falls within any of the time slots for that day
                let isTimeAvailable = false;
                for (const slot of availableSchedulesForDay) {
                    const startTime = timeToDate(slot.start_time);
                    const endTime = timeToDate(slot.end_time);
                    
                    const selectedTime = new Date(date);
                    selectedTime.setFullYear(startTime.getFullYear(), startTime.getMonth(), startTime.getDate());

                    if (selectedTime >= startTime && selectedTime < endTime) {
                        isTimeAvailable = true;
                        break;
                    }
                }

                return !isTimeAvailable; // Disable the slot if it's not in any available range
            };

            // Update Flatpickr with the new rules, removing the old global time limits
            fpInstance.set('disable', [disableFunction]);
            fpInstance.set('minTime', null);
            fpInstance.set('maxTime', null);
        });
    }
});