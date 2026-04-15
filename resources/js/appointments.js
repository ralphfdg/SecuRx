document.addEventListener('DOMContentLoaded', function() {
    
    const dayMap = { 'sunday':0, 'monday':1, 'tuesday':2, 'wednesday':3, 'thursday':4, 'friday':5, 'saturday':6 };

    // =======================================================
    // 1. DYNAMIC SCHEDULE INJECTOR 
    // =======================================================
    function applyDoctorScheduleToFlatpickr(fpInstance, doctorId, uiElements = null) {
        if (!doctorId || !window.doctorSchedules || !window.doctorSchedules[doctorId]) {
            fpInstance.set('disable', [function(date) { return true; }]); 
            return;
        }

        const schedules = window.doctorSchedules[doctorId];
        if (schedules.length === 0) {
            fpInstance.set('disable', [function(date) { return true; }]);
            return;
        }

        function getCurrentTimeString() {
            const now = new Date();
            return String(now.getHours()).padStart(2, '0') + ':' + 
                   String(now.getMinutes()).padStart(2, '0') + ':00';
        }

        // STEP A: Block unavailable days
        fpInstance.set('disable', [
            function(date) {
                const dayOfWeek = date.getDay();
                const availableSchedules = schedules.filter(s => {
                    const dbDay = (s.day_of_week || '').toLowerCase();
                    const isAvailable = (s.is_available == 1 || s.is_available === true);
                    return isAvailable && dayMap[dbDay] === dayOfWeek;
                });

                if (availableSchedules.length === 0) return true;

                const now = new Date();
                const isToday = date.getDate() === now.getDate() &&
                                date.getMonth() === now.getMonth() &&
                                date.getFullYear() === now.getFullYear();

                if (isToday) {
                    const schedule = availableSchedules[0]; 
                    if (getCurrentTimeString() > schedule.end_time) {
                        return true; 
                    }
                }
                return false; 
            }
        ]);

        // STEP B: Check Time Limits & Double Booking whenever Time is changed
        fpInstance.config.onChange.push(function(selectedDates, dateStr, instance) {
            if (selectedDates.length > 0) {
                const date = selectedDates[0];
                const dayOfWeek = date.getDay();

                const scheduleForDay = schedules.find(s => {
                    const dbDay = (s.day_of_week || '').toLowerCase();
                    const isAvailable = (s.is_available == 1 || s.is_available === true);
                    return isAvailable && dayMap[dbDay] === dayOfWeek;
                });

                if (scheduleForDay) {
                    let dynamicMinTime = scheduleForDay.start_time;

                    const now = new Date();
                    const isToday = date.getDate() === now.getDate() &&
                                    date.getMonth() === now.getMonth() &&
                                    date.getFullYear() === now.getFullYear();

                    if (isToday) {
                        const currentTimeString = getCurrentTimeString();
                        if (currentTimeString > dynamicMinTime) {
                            dynamicMinTime = currentTimeString;
                        }
                    }

                    instance.set('minTime', dynamicMinTime);
                    instance.set('maxTime', scheduleForDay.end_time);
                }

                // ==========================================
                // DOUBLE BOOKING UI LOGIC
                // ==========================================
                const yyyy = date.getFullYear();
                const mm = String(date.getMonth() + 1).padStart(2, '0');
                const dd = String(date.getDate()).padStart(2, '0');
                const dateString = `${yyyy}-${mm}-${dd}`;

                const hh = String(date.getHours()).padStart(2, '0');
                const mins = String(date.getMinutes()).padStart(2, '0');
                const selectedToMinute = `${dateString} ${hh}:${mins}`;

                // Determine which UI elements to target based on whether we passed an ID object
                const conflictWarning = uiElements ? document.getElementById(uiElements.warningId) : document.getElementById('booking-conflict-warning');
                const submitBtn = uiElements ? document.getElementById(uiElements.btnId) : document.getElementById('btn-confirm-booking');
                const takenContainer = uiElements ? document.getElementById(uiElements.containerId) : document.getElementById('taken-slots-container');
                const takenList = uiElements ? document.getElementById(uiElements.listId) : document.getElementById('taken-slots-list');
                const takenDateSpan = uiElements ? document.getElementById(uiElements.dateId) : document.getElementById('taken-slots-date');

                if (window.bookedAppointments && window.bookedAppointments[doctorId]) {
                    const bookedForDoctor = window.bookedAppointments[doctorId];
                    
                    if (takenContainer && takenList && takenDateSpan) {
                        const takenForDay = bookedForDoctor.filter(dt => dt.startsWith(dateString)).sort();
                        
                        if (takenForDay.length > 0) {
                            takenContainer.classList.remove('hidden');
                            takenDateSpan.textContent = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                            takenList.innerHTML = '';
                            
                            takenForDay.forEach(dt => {
                                const timePart = dt.split(' ')[1];
                                const t = new Date(`1970-01-01T${timePart}Z`);
                                const formattedTime = t.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', timeZone: 'UTC' });

                                const badge = document.createElement('span');
                                badge.className = 'px-2 py-0.5 bg-red-100 text-red-700 border border-red-200 rounded text-[10px] font-bold shadow-sm inline-block';
                                badge.textContent = formattedTime;
                                takenList.appendChild(badge);
                            });
                        } else {
                            takenContainer.classList.add('hidden');
                        }
                    }

                    const isConflict = bookedForDoctor.some(dt => dt.startsWith(selectedToMinute));
                    
                    if (conflictWarning && submitBtn) {
                        if (isConflict) {
                            conflictWarning.classList.remove('hidden');
                            submitBtn.disabled = true;
                        } else {
                            conflictWarning.classList.add('hidden');
                            submitBtn.disabled = false;
                        }
                    }
                }
            }
        });
    }

    // =======================================================
    // 2. NEW BOOKING PAGE LOGIC
    // =======================================================
    const doctorSelect = document.getElementById("doctor_select");
    const dateInput = document.getElementById("appointment_datetime");

    if (dateInput) {
        let fpBooking = flatpickr(dateInput, {
            inline: true,
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            minuteIncrement: 30,
            theme: "airbnb",
            disable: [ function(date) { return true; } ] 
        });

        if (doctorSelect) {
            const tsInstance = new TomSelect(doctorSelect, {
                create: false,
                sortField: { field: "text", direction: "asc" },
                placeholder: "Type to search for a doctor...",
                controlInput: '<input type="text" class="text-sm">',
            });

            tsInstance.on('change', function(doctorId) {
                fpBooking.clear();
                applyDoctorScheduleToFlatpickr(fpBooking, doctorId);
                
                const warning = document.getElementById('booking-conflict-warning');
                const container = document.getElementById('taken-slots-container');
                if(warning) warning.classList.add('hidden');
                if(container) container.classList.add('hidden');
            });

            if (tsInstance.getValue()) {
                applyDoctorScheduleToFlatpickr(fpBooking, tsInstance.getValue());
            }
        }
    }

    // =======================================================
    // 3. RESCHEDULE LOGIC (My Appointments Page)
    // =======================================================
    const rescheduleInputs = document.querySelectorAll('.flatpickr-reschedule');
    rescheduleInputs.forEach(input => {
        const doctorId = input.getAttribute('data-doctor-id');
        const apptId = input.getAttribute('data-appt-id');
        
        let fpReschedule = flatpickr(input, {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            minuteIncrement: 30,
        });

        // NEW: Pass the specific IDs so the Javascript targets the correct row's UI!
        const uiElements = {
            warningId: `conflict-warning-${apptId}`,
            btnId: `btn-reschedule-${apptId}`,
            containerId: `taken-container-${apptId}`,
            listId: `taken-list-${apptId}`,
            dateId: `taken-date-${apptId}`
        };

        applyDoctorScheduleToFlatpickr(fpReschedule, doctorId, uiElements);
    });

    // =======================================================
    // 4. TAB UI LOGIC
    // =======================================================
    window.switchApptTab = function(tabId) {
        const contentUpcoming = document.getElementById('content-upcoming');
        const contentHistory = document.getElementById('content-history');
        const tabUpcoming = document.getElementById('tab-upcoming');
        const tabHistory = document.getElementById('tab-history');

        if (!contentUpcoming || !contentHistory) return;

        contentUpcoming.classList.add('hidden');
        contentHistory.classList.add('hidden');
        
        tabUpcoming.classList.replace('border-securx-cyan', 'border-transparent');
        tabUpcoming.classList.replace('text-securx-cyan', 'text-gray-500');
        tabHistory.classList.replace('border-securx-cyan', 'border-transparent');
        tabHistory.classList.replace('text-securx-cyan', 'text-gray-500');

        document.getElementById('content-' + tabId).classList.remove('hidden');
        const activeTab = document.getElementById('tab-' + tabId);
        activeTab.classList.replace('border-transparent', 'border-securx-cyan');
        activeTab.classList.replace('text-gray-500', 'text-securx-cyan');

        sessionStorage.setItem('activeApptTab', tabId);
    };

    const tabUpcoming = document.getElementById('tab-upcoming');
    if (tabUpcoming) {
        const savedTab = sessionStorage.getItem('activeApptTab') || 'upcoming';
        window.switchApptTab(savedTab);
    }
});