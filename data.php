<?php

$hospitals = [
  ['id' => 'central', 'name' => 'Asiri Central Hospital', 'phone' => '011 4665500', 'address' => 'No. 114, Norris Canal Road, Colombo 10', 'city' => 'Colombo'],
  ['id' => 'medical', 'name' => 'Asiri Medical Hospital', 'phone' => '011 4523300', 'address' => 'No. 181, Kirula Road, Colombo 05', 'city' => 'Colombo'],
  ['id' => 'surgical', 'name' => 'Asiri Surgical Hospital', 'phone' => '011 4524400', 'address' => 'No. 21, Kirimandala Mawatha, Colombo 05', 'city' => 'Colombo'],
  ['id' => 'kandy', 'name' => 'Asiri Hospital Kandy', 'phone' => '081 4528800', 'address' => 'No. 90, Aluthanthel Mawatha, Kandy', 'city' => 'Kandy'],
  ['id' => 'galle', 'name' => 'Asiri Hospital Galle', 'phone' => '091 4527700', 'address' => 'No. 10, Wakwella Road, Galle', 'city' => 'Galle'],
  ['id' => 'matara', 'name' => 'Asiri Hospital Matara', 'phone' => '041 4526600', 'address' => 'No. 26, Esplanade Road, Matara', 'city' => 'Matara'],
];

$centresOfExcellence = [
  ['id' => 'heart-centre', 'title' => 'Asiri Heart Centre', 'description' => 'World-class cardiac care with state-of-the-art diagnostic and surgical facilities.', 'image' => 'https://images.unsplash.com/photo-1628348068343-c6a848d2b6dd?q=80&w=800&auto=format&fit=crop', 'icon' => 'heart'],
  ['id' => 'cancer-centre', 'title' => 'Asiri AOI Cancer Centre', 'description' => 'Comprehensive oncology services ranging from prevention to advanced treatment.', 'image' => 'https://images.unsplash.com/photo-1579152276532-83a0adeeecf5?q=80&w=800&auto=format&fit=crop', 'icon' => 'activity'],
  ['id' => 'neuro-science', 'title' => 'Brain & Spine Centre', 'description' => 'Specialized care for neurological disorders with advanced robotic assistance.', 'image' => 'https://images.unsplash.com/photo-1559757175-5700dde675bc?q=80&w=800&auto=format&fit=crop', 'icon' => 'brain'],
  ['id' => 'mother-baby', 'title' => 'Mother & Baby Care', 'description' => 'Expert maternity and neonatal care ensuring a safe start for your little ones.', 'image' => 'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?q=80&w=800&auto=format&fit=crop', 'icon' => 'baby'],
  ['id' => 'kidney-centre', 'title' => 'Kidney & Transplant Centre', 'description' => 'Leading edge nephrology and transplant services with compassionate care.', 'image' => 'https://images.unsplash.com/photo-1530026186672-2cd00ffc50fe?q=80&w=800&auto=format&fit=crop', 'icon' => 'stethoscope'],
  ['id' => 'stroke-centre', 'title' => 'Stroke & Rehabilitation', 'description' => 'Immediate intervention and long-term recovery support for stroke patients.', 'image' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=800&auto=format&fit=crop', 'icon' => 'refresh'],
];

$services = [
  ['id' => 'laboratory', 'title' => 'Laboratory Services', 'category' => 'Diagnostics', 'shortDesc' => 'Accurate and timely diagnostic tests with 24/7 accessibility.', 'icon' => 'flask'],
  ['id' => 'radiology', 'title' => 'Radiology & Imaging', 'category' => 'Diagnostics', 'shortDesc' => 'Advanced MRI, CT, and X-ray services for precise visualization.', 'icon' => 'dna'],
  ['id' => 'emergency', 'title' => '24/7 Emergency', 'category' => 'Critical Care', 'shortDesc' => 'Rapid response trauma care and emergency medical services.', 'icon' => 'ambulance'],
  ['id' => 'wellness', 'title' => 'Health Checkups', 'category' => 'Preventive', 'shortDesc' => 'Comprehensive wellness packages tailored for all age groups.', 'icon' => 'clipboard'],
  ['id' => 'pharmacy', 'title' => 'In-house Pharmacy', 'category' => 'Patient Care', 'shortDesc' => 'Accessible medication and specialist pharmaceutical advice.', 'icon' => 'pill'],
  ['id' => 'physiotherapy', 'title' => 'Physiotherapy', 'category' => 'Rehabilitation', 'shortDesc' => 'Expert physical therapy for recovery and functional improvement.', 'icon' => 'user'],
];

$news = [
  ['id' => '1', 'title' => 'Asiri Health Launches Robotic Surgery Center', 'date' => '2026-02-01', 'excerpt' => 'The new center features the latest Da Vinci surgical system for minimally invasive procedures.', 'image' => 'https://images.unsplash.com/photo-1551075504-129699668bd8?q=80&w=800&auto=format&fit=crop'],
  ['id' => '2', 'title' => 'Breakthrough in Cardiac Rehabilitation', 'date' => '2026-01-25', 'excerpt' => 'Our specialists have developed a new protocol that reduces recovery time by 30%.', 'image' => 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?q=80&w=800&auto=format&fit=crop'],
  ['id' => '3', 'title' => 'Community Outreach program in Matara', 'date' => '2026-01-15', 'excerpt' => 'Over 500 residents received free health screenings and primary care advice.', 'image' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=800&auto=format&fit=crop'],
];

$slides = [
  ['id' => 1, 'title' => 'World Class Healthcare', 'subtitle' => 'Advanced medical technology at your fingertips.', 'description' => 'Experience the pinnacle of medical excellence with our state-of-the-art facilities and world-renowned specialists.', 'cta' => 'Book Appointment', 'image' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?q=80&w=1920&auto=format&fit=crop'],
  ['id' => 2, 'title' => 'Compassionate Care', 'subtitle' => 'Healing with a touch of humanity.', 'description' => 'Our dedicated team of professionals ensures that every patient receives personalized care and attention.', 'cta' => 'Find a Service', 'image' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?q=80&w=1920&auto=format&fit=crop'],
  ['id' => 3, 'title' => 'Expert Specialists', 'subtitle' => 'Trust your health with the best minds.', 'description' => 'Access the most extensive network of medical specialists in Sri Lanka, covering over 50 specialties.', 'cta' => 'Find a Doctor', 'image' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?q=80&w=1920&auto=format&fit=crop'],
];

$initialSpecialties = ['Cardiology', 'Oncology', 'Neurology', 'Orthopedics', 'Pediatrics', 'Nephrology', 'Dermatology', 'General Surgery'];

$categories = ['All', 'Diagnostics', 'Critical Care', 'Preventive', 'Patient Care', 'Rehabilitation'];

$faqs = [
  ['q' => 'How do I book an appointment for this service?', 'a' => 'You can book an appointment online via our "Book Appointment" page or by calling our hotline at 1313.'],
  ['q' => 'Is this service available 24/7?', 'a' => 'Most of our diagnostic and emergency services are available 24/7. Specialist consultations are available during scheduled hours.'],
  ['q' => 'What documents should I bring?', 'a' => 'Please bring your identification, previous medical records, and any referral letters from your primary physician.'],
];

/* ===== SVG ICONS ===== */
$ICONS = [
  'phone' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
  'clock' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
  'mapPin' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>',
  'arrowRight' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>',
  'chevronRight' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>',
  'chevronLeft' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>',
  'chevronRightLg' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>',
  'fileText' => '<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>',
  'calendar' => '<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>',
  'calendarSm' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>',
  'calendarMd' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>',
  'heart' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>',
  'activity' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36-3.18-19.64A2 2 0 0 0 10.12 1h-.38a2 2 0 0 0-1.93 1.46L5.46 12H2"/></svg>',
  'brain' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5a3 3 0 1 0-5.997.125 4 4 0 0 0-2.526 5.77 4 4 0 0 0 .556 6.588A4 4 0 1 0 12 18Z"/><path d="M12 5a3 3 0 1 1 5.997.125 4 4 0 0 1 2.526 5.77 4 4 0 0 1-.556 6.588A4 4 0 1 1 12 18Z"/><path d="M15 13a4.5 4.5 0 0 1-3-4 4.5 4.5 0 0 1-3 4"/><path d="M12 18v-5"/></svg>',
  'baby' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12h.01"/><path d="M15 12h.01"/><path d="M10 16c.5.3 1.2.5 2 .5s1.5-.2 2-.5"/><path d="M19 6.3a9 9 0 0 1 1.8 3.9 2 2 0 0 1 0 3.6 9 9 0 0 1-17.6 0 2 2 0 0 1 0-3.6A9 9 0 0 1 12 3c2 0 3.5 1.1 3.5 2.5s-.9 2.5-2 2.5c-.8 0-1.5-.4-1.5-1"/></svg>',
  'stethoscope' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.2.2 0 1 0 .3.3"/><path d="M8 15v1a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6v-4"/><circle cx="20" cy="10" r="2"/></svg>',
  'refresh' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>',
  'flask' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2"/><path d="M8.5 2h7"/><path d="M7 16h10"/></svg>',
  'dna' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 15c6.667-6 13.333 0 20-6"/><path d="M9 22c1.798-1.998 2.518-3.995 2.807-5.993"/><path d="M15 2c-1.798 1.998-2.518 3.995-2.807 5.993"/><path d="m17 6-2.5-2.5"/><path d="m14 8-1-1"/><path d="m7 18 2.5 2.5"/><path d="m3.5 14.5.5.5"/><path d="m20 9 .5.5"/><path d="m6.5 12.5 1 1"/><path d="m16.5 10.5 1 1"/><path d="m10 16 1.5 1.5"/></svg>',
  'ambulance' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 10H6"/><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.28a1 1 0 0 0-.684-.948l-1.923-.641a1 1 0 0 1-.578-.502l-1.539-3.076A1 1 0 0 0 16.382 8H14"/><path d="M8 8v4"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>',
  'clipboard' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>',
  'pill' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/><path d="m8.5 8.5 7 7"/></svg>',
  'user' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>',
  'search' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>',
  'filter' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>',
  'check' => '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>',
  'checkCircle' => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>',
  'checkCircleSm' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>',
  'checkCircleLg' => '<svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>',
  'helpCircle' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>',
  'alertTriangle' => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>',
  'alertCircle' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>',
  'send' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="m22 2-11 11"/></svg>',
  'mail' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>',
  'messageSquare' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
  'lock' => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>',
  'download' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>',
  'fileTextSm' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>',
  'mapPinSm' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>',
  'mapPinXs' => '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>',
  'phoneSm' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
  'phoneXs' => '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
  'searchLg' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>',
];

function iconForService($s) {
    global $ICONS;
    return isset($ICONS[$s['icon']]) ? $ICONS[$s['icon']] : $ICONS['stethoscope'];
}

/* ===== HELPER FUNCTIONS ===== */
function formatDate($d) {
    return date('F j, Y', strtotime($d));
}
?>
