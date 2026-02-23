<?php
session_start();
include 'database.php';
// doctors
$doctors = $db->doctors->find([], ['projection' => ['did' => 1, 'dname' => 1, 'specialisation' => 1, 'fee' => 1]]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment | NSBM Healthcare</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        
        .booking-page {
            min-height: calc(100vh - 80px);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px 60px;
        }
        .booking-logo { margin-bottom: 8px; }
        .booking-logo img { height: 90px; width: auto; object-fit: contain; display: block; }

        .booking-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 600px;
            padding: 36px 32px 32px;
        }
        .booking-card-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
        .booking-card-icon {
            width: 48px; height: 48px; border-radius: 14px;
            background: linear-gradient(135deg, var(--green), var(--green-dark));
            display: grid; place-items: center; color: #fff; flex-shrink: 0;
        }
        .booking-card-title { font-size: 22px; font-weight: 800; margin: 0; letter-spacing: -0.01em; }
        .booking-card-subtitle { margin: 2px 0 0; color: var(--muted); font-size: 14px; }

        .booking-section-label {
            display: flex; align-items: center; gap: 10px;
            font-weight: 700; font-size: 14px; color: var(--text);
            margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.04em;
        }
        .booking-section-number {
            width: 26px; height: 26px; border-radius: 8px;
            background: var(--green); color: #fff;
            display: grid; place-items: center; font-size: 13px; font-weight: 800;
        }
        .booking-fields-grid { display: grid; gap: 14px; }
        .booking-field label { display: block; font-weight: 600; font-size: 13px; color: var(--muted); margin-bottom: 6px; }
        .booking-field input, .booking-field select {
            width: 100%; padding: 11px 14px; border-radius: 12px;
            border: 1px solid var(--border); outline: none; font-size: 14px;
            background: var(--bg); color: var(--text); font-family: inherit; transition: .2s;
        }
        .booking-field input:focus, .booking-field select:focus {
            border-color: rgba(34, 197, 94, .5);
            box-shadow: 0 0 0 4px rgba(34, 197, 94, .1);
            background: #fff;
        }
        .booking-field input::placeholder { color: #a1a1aa; }
        .booking-divider { border: none; height: 1px; background: var(--border); margin: 24px 0; }

        .booking-submit-btn {
            width: 100%; display: flex; align-items: center; justify-content: center;
            gap: 8px; padding: 13px 24px; margin-top: 24px;
            background: linear-gradient(135deg, var(--green), var(--green-dark));
            color: #fff; border: none; border-radius: 14px;
            font-size: 15px; font-weight: 800; font-family: inherit;
            cursor: pointer; transition: .25s ease;
            box-shadow: 0 8px 24px rgba(34, 197, 94, .25);
        }
        .booking-submit-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(34, 197, 94, .35); }
        .booking-submit-btn:active { transform: translateY(0); }

        
        .modal-overlay {
            position: fixed; inset: 0; z-index: 9999;
            background: rgba(15, 23, 42, .55);
            backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none; transition: opacity .3s ease;
        }
        .modal-overlay.active { opacity: 1; pointer-events: auto; }

        .modal-panel {
            background: var(--card); border-radius: 20px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, .2);
            width: 100%; max-width: 520px; max-height: 85vh;
            overflow-y: auto; padding: 28px; margin: 16px;
            transform: translateY(20px) scale(.97); transition: transform .3s ease;
        }
        .modal-overlay.active .modal-panel { transform: translateY(0) scale(1); }

        .modal-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px; }
        .modal-title { font-size: 20px; font-weight: 800; margin: 0; letter-spacing: -0.01em; }
        .modal-subtitle { margin: 4px 0 0; font-size: 13px; color: var(--muted); line-height: 1.4; }

        .modal-close-btn {
            width: 36px; height: 36px; border: 1px solid var(--border); border-radius: 10px;
            background: var(--bg); cursor: pointer; display: grid; place-items: center;
            color: var(--muted); transition: .2s; flex-shrink: 0;
        }
        .modal-close-btn:hover { background: #fee2e2; color: #ef4444; border-color: #fecaca; }

        .modal-loading {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: 12px; padding: 40px 0; color: var(--muted); font-size: 14px;
        }
        .modal-spinner {
            width: 36px; height: 36px; border: 3px solid var(--border);
            border-top-color: var(--green); border-radius: 50%;
            animation: spin .7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .time-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
        .time-slot-btn {
            padding: 10px 6px; border-radius: 10px; border: 1px solid var(--border);
            background: var(--bg); font-size: 13px; font-weight: 600; font-family: inherit;
            cursor: pointer; transition: .2s ease; color: var(--text);
        }
        .time-slot-btn.available:hover { border-color: var(--green); background: rgba(34, 197, 94, .08); }
        .time-slot-btn.selected {
            background: var(--green); color: #fff; border-color: var(--green);
            box-shadow: 0 4px 14px rgba(34, 197, 94, .3);
        }
        .time-slot-btn.booked {
            background: #f1f5f9; color: #94a3b8; cursor: not-allowed;
            text-decoration: line-through; opacity: .6;
        }

        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px; padding-top: 18px; border-top: 1px solid var(--border); }
        .modal-cancel-btn {
            padding: 10px 20px; border: 1px solid var(--border); border-radius: 10px;
            background: var(--bg); color: var(--text); font-weight: 600; font-size: 14px;
            font-family: inherit; cursor: pointer; transition: .2s;
        }
        .modal-cancel-btn:hover { background: #e2e8f0; }
        .modal-confirm-btn {
            padding: 10px 24px; border: none; border-radius: 10px;
            background: linear-gradient(135deg, var(--green), var(--green-dark));
            color: #fff; font-weight: 700; font-size: 14px; font-family: inherit;
            cursor: pointer; transition: .2s;
            box-shadow: 0 4px 14px rgba(34, 197, 94, .2);
        }
        .modal-confirm-btn:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(34, 197, 94, .3); }
        .modal-confirm-btn:disabled { opacity: .5; cursor: not-allowed; }

        @media (max-width: 520px) {
            .booking-card { padding: 24px 18px 22px; }
            .time-grid { grid-template-columns: repeat(2, 1fr); }
            .modal-panel { padding: 20px; }
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="booking-page">

        <div class="booking-logo">
            <img src="Assets/logo.png" alt="NSBM Healthcare">
        </div>

        
        <div class="booking-card">
            <div class="booking-card-header">
                <div class="booking-card-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <div>
                    <h1 class="booking-card-title">Book an Appointment</h1>
                    <p class="booking-card-subtitle">Fill in your details to schedule a visit</p>
                </div>
            </div>

            <form id="bookingForm" action="process_quick_booking.php" method="POST">
                
                <div class="booking-section-label">
                    <span class="booking-section-number">1</span>
                    Your Information
                </div>

                <div class="booking-fields-grid">
                    <div class="booking-field">
                        <label for="pname">Full Name</label>
                        <input type="text" id="pname" name="pname" placeholder="Enter your full name" required>
                    </div>
                    <div class="booking-field">
                        <label for="pemail">Email Address</label>
                        <input type="email" id="pemail" name="pemail" placeholder="your@email.com" required>
                    </div>
                    <div class="booking-field">
                        <label for="pcontact">Contact Number</label>
                        <input type="text" id="pcontact" name="pcontact" placeholder="+94 7X XXX XXXX" required>
                    </div>
                </div>

                <div class="booking-divider"></div>

                <div class="booking-section-label">
                    <span class="booking-section-number">2</span>
                    Appointment Details
                </div>

                <div class="booking-fields-grid">
                    <div class="booking-field">
                        <label for="did">Select Doctor</label>
                        <select id="did" name="did" required>
                            <option value="">-- Choose a Specialist --</option>
                            <?php foreach($doctors as $doc): ?>
                                <option value="<?php echo $doc['did']; ?>">
                                    Dr. <?php echo $doc['dname']; ?> (<?php echo $doc['specialisation']; ?>) - LKR <?php echo $doc['fee']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="booking-field">
                        <label for="appoint_date">Preferred Date</label>
                        <input type="date" id="appoint_date" name="appoint_date" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>

                <input type="hidden" id="appoint_time" name="appoint_time" value="">

                <button type="submit" class="booking-submit-btn" id="submitBtn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"/><path d="M12 5l7 7-7 7"/>
                    </svg>
                    Confirm Booking
                </button>
            </form>
        </div>
    </div>

 
    <div class="modal-overlay" id="timeModal">
        <div class="modal-panel">
            <div class="modal-header">
                <div>
                    <h2 class="modal-title">Select a Time Slot</h2>
                    <p class="modal-subtitle" id="modalSubtitle">Choose an available time for your appointment</p>
                </div>
                <button class="modal-close-btn" id="modalCloseBtn" title="Close">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            <div class="modal-loading" id="modalLoading">
                <div class="modal-spinner"></div>
                <p>Checking availability...</p>
            </div>

            <div class="time-grid" id="timeGrid"></div>

            <div class="modal-footer">
                <button class="modal-cancel-btn" id="modalCancelBtn">Cancel</button>
                <button class="modal-confirm-btn" id="modalConfirmBtn" disabled>Confirm & Book</button>
            </div>
        </div>
    </div>

    <script>
    (function() {
        const form = document.getElementById('bookingForm');
        const modal = document.getElementById('timeModal');
        const timeGrid = document.getElementById('timeGrid');
        const loading = document.getElementById('modalLoading');
        const subtitle = document.getElementById('modalSubtitle');
        const confirmBtn = document.getElementById('modalConfirmBtn');
        const cancelBtn = document.getElementById('modalCancelBtn');
        const closeBtn = document.getElementById('modalCloseBtn');
        const hiddenTime = document.getElementById('appoint_time');

        let selectedTime = null;
        let isSubmitting = false;

        // Generate 20-minute time slots from 08:00 to 17:00
        function generateSlots() {
            const slots = [];
            let hour = 8, min = 0;
            while (hour < 17 || (hour === 17 && min === 0)) {
                const h12 = hour > 12 ? hour - 12 : (hour === 0 ? 12 : hour);
                const ampm = hour >= 12 ? 'PM' : 'AM';
                const label = String(h12).padStart(2, '0') + ':' + String(min).padStart(2, '0') + ' ' + ampm;
                slots.push(label);
                min += 20;
                if (min >= 60) { hour++; min -= 60; }
            }
            return slots;
        }

        // Intercept form submit
        form.addEventListener('submit', function(e) {
            // If time already selected, allow the form to submit normally
            if (isSubmitting) return;
            e.preventDefault();

            // Validate required fields
            if (!form.checkValidity()) { form.reportValidity(); return; }

            const did = document.getElementById('did').value;
            const date = document.getElementById('appoint_date').value;
            const doctorSelect = document.getElementById('did');
            const doctorText = doctorSelect.options[doctorSelect.selectedIndex].text;

            selectedTime = null;
            confirmBtn.disabled = true;
            subtitle.textContent = doctorText + ' — ' + new Date(date + 'T00:00:00').toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric', year: 'numeric' });

            // Show modal
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            loading.style.display = 'flex';
            timeGrid.style.display = 'none';

            // Fetch availability
            fetch('check_availability.php?did=' + did + '&date=' + encodeURIComponent(date))
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    loading.style.display = 'none';
                    timeGrid.style.display = 'grid';

                    const bookedSet = new Set(data.booked_times || []);
                    const allSlots = generateSlots();

                    timeGrid.innerHTML = '';
                    allSlots.forEach(function(slot) {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'time-slot-btn';
                        btn.textContent = slot;

                        if (bookedSet.has(slot)) {
                            btn.classList.add('booked');
                            btn.disabled = true;
                            btn.title = 'Already booked';
                        } else {
                            btn.classList.add('available');
                            btn.addEventListener('click', function() {
                                document.querySelectorAll('.time-slot-btn.selected').forEach(function(b) { b.classList.remove('selected'); });
                                btn.classList.add('selected');
                                selectedTime = slot;
                                confirmBtn.disabled = false;
                            });
                        }
                        timeGrid.appendChild(btn);
                    });
                })
                .catch(function() {
                    loading.innerHTML = '<p style="color:#ef4444;">Failed to load availability. Please try again.</p>';
                });
        });

        // Confirm booking — set flag and re-submit the form
        confirmBtn.addEventListener('click', function() {
            if (!selectedTime) return;
            hiddenTime.value = selectedTime;
            closeModal();
            isSubmitting = true;
            form.submit();
        });

        function closeModal() {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }

        cancelBtn.addEventListener('click', closeModal);
        closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
        });
    })();
    </script>

    <?php renderFooter(); ?>
</body>
</html>