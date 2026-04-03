document.addEventListener('DOMContentLoaded', function() {
    
    const doctorSelect = document.getElementById("doctor_select");
    const dateInput = document.getElementById("appointment_datetime");
    
    let fpInstance = null;

    // 1. Initialize Flatpickr in a "Locked" default state
    if (dateInput) {
        fpInstance = flatpickr(dateInput, {
            inline: true,
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today", 
            minuteIncrement: 30,
            theme: "airbnb",
            // By default, disable EVERYTHING until a doctor is selected
            disable: [
                function(date) { return true; }
            ]
        });
    }

    // 2. Initialize Tom Select and listen for changes
    if (doctorSelect) {
        const tsInstance = new TomSelect(doctorSelect, {
            create: false,
            sortField: { field: "text", direction: "asc" },
            placeholder: "Type to search for a doctor...",
            controlInput: '<input type="text" class="text-sm">',
        });

        // 3. The Dynamic Engine: Triggered when a doctor is selected
        tsInstance.on('change', function(doctorId) {
            if (!doctorId || !fpInstance) return;
            
            // Fetch the schedules we injected from Laravel Blade
            const schedules = window.doctorSchedules[doctorId];
            
            // If the doctor has no schedule, lock the calendar
            if (!schedules || schedules.length === 0) {
                fpInstance.set('disable', [function(date) { return true; }]);
                // Optional: You could show an alert here using Toastify!
                return;
            }

            // Map standard day names to JavaScript getDay() integers (Sunday = 0)
            const dayMap = { 'Sunday':0, 'Monday':1, 'Tuesday':2, 'Wednesday':3, 'Thursday':4, 'Friday':5, 'Saturday':6 };
            
            // Extract the days this specific doctor is available
            const availableDays = schedules.filter(s => s.is_available).map(s => dayMap[s.day_of_week]);

            // Find the earliest start time and latest end time for this doctor
            let earliestStart = "23:59:59";
            let latestEnd = "00:00:00";
            
            schedules.forEach(s => {
                if (s.start_time < earliestStart) earliestStart = s.start_time;
                if (s.end_time > latestEnd) latestEnd = s.end_time;
            });

            // Format times to HH:MM for Flatpickr
            earliestStart = earliestStart.substring(0, 5);
            latestEnd = latestEnd.substring(0, 5);

            // Update Flatpickr dynamically!
            fpInstance.set('disable', [
                function(date) {
                    // Disable the date if its day of the week is NOT in the availableDays array
                    return !availableDays.includes(date.getDay());
                }
            ]);
            
            fpInstance.set('minTime', earliestStart);
            fpInstance.set('maxTime', latestEnd);
            
            // Clear any previously selected date to force them to pick a valid one
            fpInstance.clear(); 
        });
    }
});