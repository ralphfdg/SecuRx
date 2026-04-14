document.addEventListener('DOMContentLoaded', function() {
    
    const doctorSelect = document.getElementById("doctor_select");
    const dateInput = document.getElementById("appointment_datetime");
    
    let fpInstance = null;

    if (dateInput) {
        fpInstance = flatpickr(dateInput, {
            inline: true,
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            minuteIncrement: 30,
            theme: "airbnb",
            disable: [
                function(date) { return true; } // Lock initially
            ]
        });
    }

    if (doctorSelect) {
        const tsInstance = new TomSelect(doctorSelect, {
            create: false,
            sortField: { field: "text", direction: "asc" },
            placeholder: "Type to search for a doctor...",
            controlInput: '<input type="text" class="text-sm">',
        });

        function updateCalendarForDoctor(doctorId) {
            fpInstance.clear(); 

            if (!doctorId || !fpInstance) {
                fpInstance.set('disable', [function(date) { return true; }]); 
                return;
            }
            
            const schedules = window.doctorSchedules ? (window.doctorSchedules[doctorId] || []) : [];

            if (schedules.length === 0) {
                fpInstance.set('disable', [function(date) { return true; }]); 
                return;
            }

            const dayMap = { 'sunday':0, 'monday':1, 'tuesday':2, 'wednesday':3, 'thursday':4, 'friday':5, 'saturday':6 };
            
            const disableFunction = function(date) {
                const dayOfWeek = date.getDay();
                
                const availableSchedulesForDay = schedules.filter(s => {
                    const dbDay = (s.day_of_week || '').toLowerCase();
                    
                    // FIX: Use loose equality to catch String "1", Integer 1, or Boolean true
                    const isAvailable = (s.is_available == 1 || s.is_available === true);
                    
                    return isAvailable && dayMap[dbDay] === dayOfWeek;
                });

                // Disable if the doctor has no available schedule on this day
                return availableSchedulesForDay.length === 0; 
            };

            fpInstance.set('disable', [disableFunction]);
        }

        tsInstance.on('change', updateCalendarForDoctor);

        const initialDoctorId = tsInstance.getValue();
        if (initialDoctorId) {
            updateCalendarForDoctor(initialDoctorId);
        }
    }
});