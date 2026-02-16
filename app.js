/* ===== DATA ===== */
const hospitals = [
  { id: 'central', name: 'Asiri Central Hospital', phone: '011 4665500', address: 'No. 114, Norris Canal Road, Colombo 10', city: 'Colombo' },
  { id: 'medical', name: 'Asiri Medical Hospital', phone: '011 4523300', address: 'No. 181, Kirula Road, Colombo 05', city: 'Colombo' },
  { id: 'surgical', name: 'Asiri Surgical Hospital', phone: '011 4524400', address: 'No. 21, Kirimandala Mawatha, Colombo 05', city: 'Colombo' },
  { id: 'kandy', name: 'Asiri Hospital Kandy', phone: '081 4528800', address: 'No. 90, Aluthanthel Mawatha, Kandy', city: 'Kandy' },
  { id: 'galle', name: 'Asiri Hospital Galle', phone: '091 4527700', address: 'No. 10, Wakwella Road, Galle', city: 'Galle' },
  { id: 'matara', name: 'Asiri Hospital Matara', phone: '041 4526600', address: 'No. 26, Esplanade Road, Matara', city: 'Matara' },
];
const centresOfExcellence = [
  { id: 'heart-centre', title: 'Asiri Heart Centre', description: 'World-class cardiac care with state-of-the-art diagnostic and surgical facilities.', image: 'https://images.unsplash.com/photo-1628348068343-c6a848d2b6dd?q=80&w=800&auto=format&fit=crop', icon: 'heart' },
  { id: 'cancer-centre', title: 'Asiri AOI Cancer Centre', description: 'Comprehensive oncology services ranging from prevention to advanced treatment.', image: 'https://images.unsplash.com/photo-1579152276532-83a0adeeecf5?q=80&w=800&auto=format&fit=crop', icon: 'activity' },
  { id: 'neuro-science', title: 'Brain & Spine Centre', description: 'Specialized care for neurological disorders with advanced robotic assistance.', image: 'https://images.unsplash.com/photo-1559757175-5700dde675bc?q=80&w=800&auto=format&fit=crop', icon: 'brain' },
  { id: 'mother-baby', title: 'Mother & Baby Care', description: 'Expert maternity and neonatal care ensuring a safe start for your little ones.', image: 'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?q=80&w=800&auto=format&fit=crop', icon: 'baby' },
  { id: 'kidney-centre', title: 'Kidney & Transplant Centre', description: 'Leading edge nephrology and transplant services with compassionate care.', image: 'https://images.unsplash.com/photo-1530026186672-2cd00ffc50fe?q=80&w=800&auto=format&fit=crop', icon: 'stethoscope' },
  { id: 'stroke-centre', title: 'Stroke & Rehabilitation', description: 'Immediate intervention and long-term recovery support for stroke patients.', image: 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=800&auto=format&fit=crop', icon: 'refresh' },
];
const services = [
  { id: 'laboratory', title: 'Laboratory Services', category: 'Diagnostics', shortDesc: 'Accurate and timely diagnostic tests with 24/7 accessibility.', icon: 'flask' },
  { id: 'radiology', title: 'Radiology & Imaging', category: 'Diagnostics', shortDesc: 'Advanced MRI, CT, and X-ray services for precise visualization.', icon: 'dna' },
  { id: 'emergency', title: '24/7 Emergency', category: 'Critical Care', shortDesc: 'Rapid response trauma care and emergency medical services.', icon: 'ambulance' },
  { id: 'wellness', title: 'Health Checkups', category: 'Preventive', shortDesc: 'Comprehensive wellness packages tailored for all age groups.', icon: 'clipboard' },
  { id: 'pharmacy', title: 'In-house Pharmacy', category: 'Patient Care', shortDesc: 'Accessible medication and specialist pharmaceutical advice.', icon: 'pill' },
  { id: 'physiotherapy', title: 'Physiotherapy', category: 'Rehabilitation', shortDesc: 'Expert physical therapy for recovery and functional improvement.', icon: 'user' },
];
const news = [
  { id: '1', title: 'Asiri Health Launches Robotic Surgery Center', date: '2026-02-01', excerpt: 'The new center features the latest Da Vinci surgical system for minimally invasive procedures.', image: 'https://images.unsplash.com/photo-1551075504-129699668bd8?q=80&w=800&auto=format&fit=crop' },
  { id: '2', title: 'Breakthrough in Cardiac Rehabilitation', date: '2026-01-25', excerpt: 'Our specialists have developed a new protocol that reduces recovery time by 30%.', image: 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?q=80&w=800&auto=format&fit=crop' },
  { id: '3', title: 'Community Outreach program in Matara', date: '2026-01-15', excerpt: 'Over 500 residents received free health screenings and primary care advice.', image: 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=800&auto=format&fit=crop' },
];
const slides = [
  { id: 1, title: 'World Class Healthcare', subtitle: 'Advanced medical technology at your fingertips.', description: 'Experience the pinnacle of medical excellence with our state-of-the-art facilities and world-renowned specialists.', cta: 'Book Appointment', image: 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?q=80&w=1920&auto=format&fit=crop' },
  { id: 2, title: 'Compassionate Care', subtitle: 'Healing with a touch of humanity.', description: 'Our dedicated team of professionals ensures that every patient receives personalized care and attention.', cta: 'Find a Service', image: 'https://images.unsplash.com/photo-1516549655169-df83a0774514?q=80&w=1920&auto=format&fit=crop' },
  { id: 3, title: 'Expert Specialists', subtitle: 'Trust your health with the best minds.', description: 'Access the most extensive network of medical specialists in Sri Lanka, covering over 50 specialties.', cta: 'Find a Doctor', image: 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?q=80&w=1920&auto=format&fit=crop' },
];
/* doctorsData is loaded from the MySQL database via the API */
let doctorsData = [];
let doctorsLoaded = false;
const API_BASE = 'http://localhost:3000/api';

async function fetchDoctors() {
  try {
    const res = await fetch(`${API_BASE}/doctors`);
    if (!res.ok) throw new Error('API error');
    const data = await res.json();
    // Map DB columns to frontend-friendly names
    doctorsData = data.map(d => ({
      id: d.did,
      name: d.dname,
      specialty: d.specialization,
      fee: d.fee,
      presentDays: d.present_days,
      hospital: 'Asiri Health',
      image: `https://ui-avatars.com/api/?name=${encodeURIComponent(d.dname)}&size=400&background=8E0E2F&color=fff&bold=true`
    }));
    doctorsLoaded = true;
    return doctorsData;
  } catch (err) {
    console.error('Failed to load doctors:', err);
    doctorsLoaded = false;
    return [];
  }
}
let specialties = ['Cardiology', 'Oncology', 'Neurology', 'Orthopedics', 'Pediatrics', 'Nephrology', 'Dermatology', 'General Surgery'];

// Also fetch specializations from DB to keep the filter dropdown up-to-date
async function fetchSpecializations() {
  try {
    const res = await fetch(`${API_BASE}/specializations`);
    if (res.ok) {
      const data = await res.json();
      if (data.length > 0) specialties = data;
    }
  } catch (e) { /* use defaults */ }
}
const categories = ['All', 'Diagnostics', 'Critical Care', 'Preventive', 'Patient Care', 'Rehabilitation'];
const faqs = [
  { q: 'How do I book an appointment for this service?', a: 'You can book an appointment online via our "Book Appointment" page or by calling our hotline at 1313.' },
  { q: 'Is this service available 24/7?', a: 'Most of our diagnostic and emergency services are available 24/7. Specialist consultations are available during scheduled hours.' },
  { q: 'What documents should I bring?', a: 'Please bring your identification, previous medical records, and any referral letters from your primary physician.' }
];

/* ===== SVG ICONS ===== */
const ICONS = {
  phone: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>`,
  clock: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>`,
  mapPin: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>`,
  arrowRight: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>`,
  chevronRight: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>`,
  chevronLeft: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>`,
  chevronRightLg: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>`,
  fileText: `<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>`,
  calendar: `<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>`,
  calendarSm: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>`,
  calendarMd: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>`,
  heart: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>`,
  activity: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36-3.18-19.64A2 2 0 0 0 10.12 1h-.38a2 2 0 0 0-1.93 1.46L5.46 12H2"/></svg>`,
  brain: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5a3 3 0 1 0-5.997.125 4 4 0 0 0-2.526 5.77 4 4 0 0 0 .556 6.588A4 4 0 1 0 12 18Z"/><path d="M12 5a3 3 0 1 1 5.997.125 4 4 0 0 1 2.526 5.77 4 4 0 0 1-.556 6.588A4 4 0 1 1 12 18Z"/><path d="M15 13a4.5 4.5 0 0 1-3-4 4.5 4.5 0 0 1-3 4"/><path d="M12 18v-5"/></svg>`,
  baby: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12h.01"/><path d="M15 12h.01"/><path d="M10 16c.5.3 1.2.5 2 .5s1.5-.2 2-.5"/><path d="M19 6.3a9 9 0 0 1 1.8 3.9 2 2 0 0 1 0 3.6 9 9 0 0 1-17.6 0 2 2 0 0 1 0-3.6A9 9 0 0 1 12 3c2 0 3.5 1.1 3.5 2.5s-.9 2.5-2 2.5c-.8 0-1.5-.4-1.5-1"/></svg>`,
  stethoscope: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.2.2 0 1 0 .3.3"/><path d="M8 15v1a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6v-4"/><circle cx="20" cy="10" r="2"/></svg>`,
  refresh: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>`,
  flask: `<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2"/><path d="M8.5 2h7"/><path d="M7 16h10"/></svg>`,
  dna: `<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 15c6.667-6 13.333 0 20-6"/><path d="M9 22c1.798-1.998 2.518-3.995 2.807-5.993"/><path d="M15 2c-1.798 1.998-2.518 3.995-2.807 5.993"/><path d="m17 6-2.5-2.5"/><path d="m14 8-1-1"/><path d="m7 18 2.5 2.5"/><path d="m3.5 14.5.5.5"/><path d="m20 9 .5.5"/><path d="m6.5 12.5 1 1"/><path d="m16.5 10.5 1 1"/><path d="m10 16 1.5 1.5"/></svg>`,
  ambulance: `<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 10H6"/><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.28a1 1 0 0 0-.684-.948l-1.923-.641a1 1 0 0 1-.578-.502l-1.539-3.076A1 1 0 0 0 16.382 8H14"/><path d="M8 8v4"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>`,
  clipboard: `<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>`,
  pill: `<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/><path d="m8.5 8.5 7 7"/></svg>`,
  user: `<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>`,
  search: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>`,
  filter: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>`,
  check: `<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>`,
  checkCircle: `<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>`,
  checkCircleSm: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>`,
  checkCircleLg: `<svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>`,
  helpCircle: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>`,
  alertTriangle: `<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>`,
  alertCircle: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>`,
  send: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="m22 2-11 11"/></svg>`,
  mail: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>`,
  messageSquare: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>`,
  lock: `<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>`,
  download: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>`,
  fileTextSm: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>`,
  mapPinSm: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>`,
  mapPinXs: `<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>`,
  phoneSm: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>`,
  phoneXs: `<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>`,
  searchLg: `<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>`,
};
const iconForService = s => ICONS[s.icon] || ICONS.stethoscope;

/* ===== HELPERS ===== */
function formatDate(d) { return new Date(d).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }); }
function $(sel) { return document.querySelector(sel); }
function $$(sel) { return document.querySelectorAll(sel); }

/* ===== PAGE RENDERERS ===== */
function renderHomePage() {
  return `
    ${renderHeroCarousel()}
    ${renderQuickContacts()}
    ${renderCentresOfExcellence()}
    ${renderCTASections()}
    ${renderFeaturedServices()}
    ${renderNewsGrid()}
    ${renderHelpSection()}
  `;
}

function renderHeroCarousel() {
  return `<div class="hero" id="hero-carousel">
    ${slides.map((s, i) => `
      <div class="hero-slide ${i === 0 ? 'active' : ''}" data-slide="${i}">
        <div class="hero-bg" style="background-image:url(${s.image})"></div>
        <div class="hero-gradient"></div>
        <div class="hero-content"><div class="inner"><div class="hero-text">
          <span class="subtitle">${s.subtitle}</span>
          <h1>${s.title}</h1>
          <p class="desc">${s.description}</p>
          <div class="btns">
            <a href="#/doctor-appointment" class="btn-primary">${s.cta}</a>
            <a href="#/services" class="btn-outline">Our Services</a>
          </div>
        </div></div></div>
      </div>
    `).join('')}
    <button class="hero-arrow prev" onclick="heroNav(-1)">${ICONS.chevronLeft}</button>
    <button class="hero-arrow next" onclick="heroNav(1)">${ICONS.chevronRightLg}</button>
    <div class="hero-bottom">
      <div class="hero-progress"><div class="hero-progress-bar" id="hero-progress-bar"></div></div>
      <div class="hero-dots">
        ${slides.map((_, i) => `<button class="hero-dot ${i === 0 ? 'active' : ''}" onclick="heroGoTo(${i})" aria-label="Slide ${i + 1}"></button>`).join('')}
      </div>
    </div>
  </div>`;
}

function renderQuickContacts() {
  return `<div class="quick-contacts">
    <div class="container">
      <div class="grid grid-1 md-grid-3 gap-8" style="text-align:center">
        <div class="contact-item animate-on-scroll" style="flex-direction:column;align-items:center">
          <div class="contact-icon">${ICONS.phone}</div>
          <div><p class="contact-label">Emergency Hotline</p><p class="contact-value">1313 <span>/ 011 4665500</span></p></div>
        </div>
        <div class="contact-item contact-divider animate-on-scroll anim-delay-1" style="flex-direction:column;align-items:center">
          <div class="contact-icon">${ICONS.clock}</div>
          <div><p class="contact-label">Operating Hours</p><p class="contact-value">24 Hours <span>/ Open 365 Days</span></p></div>
        </div>
        <div class="contact-item contact-divider animate-on-scroll anim-delay-2" style="flex-direction:column;align-items:center">
          <div class="contact-icon">${ICONS.mapPin}</div>
          <div><p class="contact-label">Hospital Address</p><p class="contact-value" style="font-size:1.125rem">Norris Canal Rd, Colombo 10</p></div>
        </div>
      </div>
    </div>
  </div>`;
}

function renderCentresOfExcellence() {
  return `<section class="section-container" style="background:#fff">
    <div class="section-header text-center">
      <span class="section-tag animate-on-scroll">Specialized Care</span>
      <h2 class="section-title animate-on-scroll anim-delay-1">Centres of Excellence</h2>
      <div class="section-line animate-on-scroll anim-delay-2"></div>
    </div>
    <div class="grid grid-1 md-grid-2 lg-grid-3 gap-8">
      ${centresOfExcellence.map((c, i) => `
        <div class="centre-card animate-on-scroll anim-delay-${i % 3 + 1}">
          <div class="card-bg" style="background-image:url(${c.image})"></div>
          <div class="card-overlay"></div>
          <div class="card-content">
            <div class="icon-box">${ICONS[c.icon] || ICONS.activity}</div>
            <h3 style="font-size:1.5rem;font-weight:700;margin-bottom:.5rem">${c.title}</h3>
            <p class="card-desc">${c.description}</p>
            <div class="card-link"><span>Explore Center</span>${ICONS.arrowRight}</div>
          </div>
        </div>
      `).join('')}
    </div>
  </section>`;
}

function renderCTASections() {
  return `<section style="background:#fff;padding:3rem 0">
    <div class="container">
      <div class="grid grid-1 lg-grid-2 gap-8">
        <div class="cta-card primary animate-on-scroll from-left">
          <div class="cta-inner">
            <div class="cta-icon">${ICONS.fileText}</div>
            <div style="flex:1">
              <h3>Download Lab Reports</h3>
              <p>Access your medical records and laboratory results securely from the comfort of your home.</p>
              <a href="#/download-lab-reports" class="btn-outline" style="margin-top:1rem">Get Started ${ICONS.arrowRight}</a>
            </div>
          </div>
          <div class="cta-blob" style="top:0;right:0;width:16rem;height:16rem;background:rgba(255,255,255,.05);transform:translate(25%,-50%)"></div>
          <div class="cta-blob" style="bottom:-2rem;left:-2rem;width:12rem;height:12rem;background:rgba(255,255,255,.05)"></div>
          <div class="cta-shimmer"></div>
        </div>
        <div class="cta-card dark animate-on-scroll from-right">
          <div class="cta-inner">
            <div class="cta-icon">${ICONS.calendar}</div>
            <div style="flex:1">
              <h3>Book an Appointment</h3>
              <p>Schedule a consultation with our world-class specialists quickly and easily online.</p>
              <a href="#/doctor-appointment" class="btn-primary" style="margin-top:1rem;box-shadow:0 4px 15px rgba(142,14,47,.3)">Schedule Now ${ICONS.arrowRight}</a>
            </div>
          </div>
          <div class="cta-blob" style="top:0;right:0;width:16rem;height:16rem;background:rgba(142,14,47,.1);transform:translate(25%,-50%)"></div>
          <div class="cta-blob" style="bottom:-2rem;right:-2rem;width:12rem;height:12rem;background:rgba(142,14,47,.1)"></div>
          <div class="cta-shimmer"></div>
        </div>
      </div>
    </div>
  </section>`;
}

function renderFeaturedServices() {
  return `<section class="section-container" style="background:var(--brand-light)">
    <div class="flex flex-col gap-6" style="margin-bottom:3rem">
      <div style="max-width:42rem">
        <span class="section-tag animate-on-scroll from-left">Comprehensive Care</span>
        <h2 class="section-title animate-on-scroll from-left anim-delay-1">Healthcare Services</h2>
      </div>
      <a href="#/services" style="color:var(--brand-primary);font-weight:700;display:flex;align-items:center;gap:.5rem" class="animate-on-scroll from-right">
        <span>View All Services</span>${ICONS.arrowRight}
      </a>
    </div>
    <div class="grid grid-1 md-grid-2 lg-grid-3 gap-6">
      ${services.map((s, i) => `
        <a href="#/services/${s.id}" class="card-premium animate-on-scroll scale anim-delay-${(i % 3) + 1}">
          <div class="service-icon-box">${iconForService(s)}</div>
          <h3 style="font-size:1.25rem;font-weight:700;margin-bottom:.75rem">${s.title}</h3>
          <p style="color:var(--gray-600);font-size:.875rem;line-height:1.75;margin-bottom:1.5rem">${s.shortDesc}</p>
          <div class="service-link"><span>Read More</span>${ICONS.chevronRight}</div>
        </a>
      `).join('')}
    </div>
  </section>`;
}

function renderNewsGrid() {
  return `<section class="section-container" style="background:#fff">
    <div class="flex flex-col gap-6" style="margin-bottom:3rem">
      <div style="max-width:42rem">
        <span class="section-tag animate-on-scroll from-left">Stay Informed</span>
        <h2 class="section-title animate-on-scroll from-left anim-delay-1">News & Updates</h2>
      </div>
      <a href="#" style="color:var(--brand-primary);font-weight:700;display:flex;align-items:center;gap:.5rem" class="animate-on-scroll from-right">
        <span>View All News</span>${ICONS.arrowRight}
      </a>
    </div>
    <div class="grid grid-1 md-grid-2 lg-grid-3 gap-8">
      ${news.map((n, i) => `
        <div class="news-card animate-on-scroll anim-delay-${i + 1}">
          <div class="news-image">
            <div class="img-bg" style="background-image:url(${n.image})"></div>
            <span class="news-badge">News</span>
          </div>
          <div class="news-date">${ICONS.calendarSm}<span>${formatDate(n.date)}</span></div>
          <h3>${n.title}</h3>
          <p class="news-excerpt line-clamp-2">${n.excerpt}</p>
          <a href="#" class="news-link"><span>Read Full Article</span>${ICONS.arrowRight}</a>
        </div>
      `).join('')}
    </div>
  </section>`;
}

function renderHelpSection() {
  return `<div class="help-section">
    <div class="container" style="max-width:56rem">
      <h3>Need Help Finding a Service?</h3>
      <p>Our support team is available 24/7 to assist you with any medical inquiries or hospital-related information.</p>
      <a href="#/contact-us" class="btn-outline">Contact Information</a>
    </div>
  </div>`;
}

/* ===== SERVICES PAGE ===== */
function renderServicesPage() {
  return `
    <div class="page-banner dark">
      <div class="container relative" style="z-index:2">
        <span class="section-tag" style="color:rgba(255,255,255,.7)">Comprehensive Healthcare</span>
        <h1>Our Services</h1>
        <p>Explore our wide range of medical services, from advanced diagnostics to specialized treatments.</p>
      </div>
      <div class="skew"></div>
    </div>
    <div class="section-container">
      <div class="flex flex-col gap-6" style="margin-bottom:2rem">
        <div class="search-bar" style="max-width:28rem">
          ${ICONS.search}
          <input id="services-search" type="text" placeholder="Search services..." oninput="filterServices()">
        </div>
        <div class="filter-strip scrollbar-hide" id="filter-strip">
          ${categories.map(c => `<button class="filter-btn ${c === 'All' ? 'active' : ''}" onclick="setCategory('${c}')">${c}</button>`).join('')}
        </div>
      </div>
      <div class="grid grid-1 md-grid-2 lg-grid-3 gap-6" id="services-grid"></div>
      <div id="services-empty" style="display:none" class="empty-state">
        <div class="empty-icon">${ICONS.searchLg}</div>
        <h3 style="font-size:1.5rem;font-weight:700;color:var(--gray-700);margin-bottom:.5rem">No services found</h3>
        <p style="color:var(--gray-500)">Try adjusting your search or filter criteria.</p>
      </div>
    </div>
  `;
}

let currentCategory = 'All';
function setCategory(cat) {
  currentCategory = cat;
  $$('.filter-btn').forEach(b => b.classList.toggle('active', b.textContent === cat));
  filterServices();
}
function filterServices() {
  const query = ($('#services-search')?.value || '').toLowerCase();
  const filtered = services.filter(s => {
    const matchCat = currentCategory === 'All' || s.category === currentCategory;
    const matchQ = s.title.toLowerCase().includes(query) || s.shortDesc.toLowerCase().includes(query);
    return matchCat && matchQ;
  });
  const grid = $('#services-grid');
  const empty = $('#services-empty');
  if (!grid) return;
  if (filtered.length === 0) {
    grid.innerHTML = '';
    empty.style.display = 'block';
  } else {
    empty.style.display = 'none';
    grid.innerHTML = filtered.map((s, i) => `
      <a href="#/services/${s.id}" class="card-premium animate-on-scroll scale anim-delay-${(i % 3) + 1}">
        <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem">
          <div class="service-icon-box" style="margin-bottom:0">${iconForService(s)}</div>
          <span class="category-badge">${s.category}</span>
        </div>
        <h3 style="font-size:1.25rem;font-weight:700;margin-bottom:.75rem">${s.title}</h3>
        <p style="color:var(--gray-600);font-size:.875rem;line-height:1.75;margin-bottom:1.5rem">${s.shortDesc}</p>
        <div class="service-link"><span>Learn More</span>${ICONS.chevronRight}</div>
      </a>
    `).join('');
    observeAnimations();
  }
}

/* ===== SERVICE DETAIL PAGE ===== */
function renderServiceDetail(id) {
  const svc = services.find(s => s.id === id) || centresOfExcellence.find(c => c.id === id);
  if (!svc) return `<div class="section-container text-center"><h2>Service not found</h2><a href="#/services" class="btn-primary" style="margin-top:2rem">Back to Services</a></div>`;
  const benefits = ['Expert medical professionals', 'State-of-the-art technology', '24/7 availability', 'Affordable pricing', 'Comprehensive follow-up care', 'Quick turnaround times'];
  return `
    <div class="service-header">
      <div class="container">
        <div class="flex flex-col gap-8 items-start" style="max-width:56rem">
          <div class="icon-lg" style="display:inline-flex">${iconForService(svc)}</div>
          <div>
            <span class="category-badge" style="margin-bottom:1rem;display:inline-block">${svc.category || 'Specialized'}</span>
            <h1 style="font-size:2.5rem;font-weight:800;margin-bottom:1rem">${svc.title}</h1>
            <p style="color:var(--gray-600);font-size:1.125rem;line-height:1.75">${svc.shortDesc || svc.description}</p>
          </div>
        </div>
      </div>
    </div>
    <div class="section-container">
      <div class="grid grid-1 lg-grid-2-1 gap-12">
        <div>
          <div style="margin-bottom:3rem">
            <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:1.5rem">Overview</h2>
            <p style="color:var(--gray-600);line-height:1.75;margin-bottom:1rem">At Asiri Health, our ${svc.title} department combines cutting-edge technology with the expertise of highly trained medical professionals. We are committed to delivering precise and timely results that empower informed medical decisions.</p>
            <p style="color:var(--gray-600);line-height:1.75">Our team works around the clock to ensure that patients receive the highest standard of care, with a focus on accuracy, comfort, and convenience.</p>
          </div>
          <div style="margin-bottom:3rem">
            <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:1.5rem">Key Benefits</h2>
            <div class="flex flex-col gap-4">
              ${benefits.map(b => `<div class="benefit-item"><div class="benefit-check">${ICONS.check}</div><span style="color:var(--gray-700)">${b}</span></div>`).join('')}
            </div>
          </div>
          <div>
            <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:1.5rem">Frequently Asked Questions</h2>
            <div class="flex flex-col gap-6">
              ${faqs.map(f => `<div class="faq-item"><h4>${f.q}</h4><p>${f.a}</p></div>`).join('')}
            </div>
          </div>
        </div>
        <div>
          <div class="sidebar-cta">
            <h3 style="font-size:1.5rem;font-weight:700;margin-bottom:.5rem">Get Started</h3>
            <p style="color:rgba(255,255,255,.7);margin-bottom:1.5rem;font-size:.875rem">Book your appointment today or contact our team for more information.</p>
            <a href="#/doctor-appointment" class="sidebar-cta .book-btn" style="display:flex;align-items:center;justify-content:space-between;background:#fff;color:var(--brand-primary);padding:1rem;border-radius:var(--radius-xl);font-weight:700;transition:background .2s;width:100%;text-decoration:none;margin-bottom:1rem">
              <span>Book Appointment</span>${ICONS.chevronRight}
            </a>
            <div class="sidebar-cta .call-box" style="display:flex;align-items:center;gap:1rem;padding:1rem;background:rgba(255,255,255,.1);border-radius:var(--radius-xl)">
              ${ICONS.phone}<div><p style="font-size:.75rem;color:rgba(255,255,255,.7)">Call Us</p><p style="font-weight:700">1313</p></div>
            </div>
            <div style="padding-top:2rem;border-top:1px solid rgba(255,255,255,.2);margin-top:2rem">
              <h4 style="font-weight:700;text-transform:uppercase;letter-spacing:.1em;font-size:.75rem;margin-bottom:1rem">Available At</h4>
              <ul style="font-size:.875rem;color:rgba(255,255,255,.7)">${hospitals.slice(0, 4).map(h => `<li style="margin-bottom:.5rem;font-weight:500">${h.name}</li>`).join('')}</ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  `;
}

/* ===== CONTACT US PAGE ===== */
function renderContactPage() {
  return `
    <div class="page-banner dark">
      <div class="container relative" style="z-index:2">
        <span class="section-tag" style="color:rgba(255,255,255,.7)">Get in Touch</span>
        <h1>Contact Us</h1>
        <p>We're here to help. Reach out through any of the channels below or visit us at one of our locations.</p>
      </div>
      <div class="skew"></div>
    </div>
    <div class="section-container">
      <div class="grid grid-1 lg-grid-3 gap-8" style="margin-bottom:4rem">
        <div class="contact-info-card animate-on-scroll">
          <div class="contact-row" style="margin-bottom:1.5rem">
            <div class="icon">${ICONS.phone}</div>
            <div><h4 style="font-weight:700;margin-bottom:.25rem">General Inquiries</h4><p style="font-size:.875rem;color:var(--gray-500)">Mon-Fri, 8:00 AM – 6:00 PM</p></div>
          </div>
          <p style="font-size:1.5rem;font-weight:700;color:var(--brand-primary)">011 4665500</p>
        </div>
        <div class="contact-info-card animate-on-scroll anim-delay-1">
          <div class="contact-row" style="margin-bottom:1.5rem">
            <div class="icon">${ICONS.mail}</div>
            <div><h4 style="font-weight:700;margin-bottom:.25rem">Email Support</h4><p style="font-size:.875rem;color:var(--gray-500)">Response within 24 hours</p></div>
          </div>
          <p style="font-size:1.125rem;font-weight:700;color:var(--brand-primary)">info@asirihealth.com</p>
        </div>
        <div class="emergency-card animate-on-scroll anim-delay-2">
          <div class="flex items-center gap-3" style="margin-bottom:1rem">
            <div class="animate-pulse" style="width:.75rem;height:.75rem;background:#f87171;border-radius:50%"></div>
            <span style="font-size:.875rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em">Emergency Hotline</span>
          </div>
          <p style="font-size:3rem;font-weight:800;margin-bottom:.5rem">1313</p>
          <p style="color:var(--gray-400);font-size:.875rem">Available 24 hours, 7 days a week</p>
        </div>
      </div>

      <div class="grid grid-1 lg-grid-2 gap-12" style="margin-bottom:4rem">
        <div class="inquiry-form animate-on-scroll from-left" id="contact-form-card">
          <h3 style="font-size:1.5rem;font-weight:700;margin-bottom:.5rem">Send Us a Message</h3>
          <p style="color:var(--gray-500);margin-bottom:2rem;font-size:.875rem">Fill out the form and our team will respond promptly.</p>
          <form id="contact-form" onsubmit="submitContactForm(event)">
            <div class="grid grid-1 md-grid-2 gap-4" style="margin-bottom:1rem">
              <div><label class="form-label">Full Name</label><input class="form-input" required placeholder="Your name"></div>
              <div><label class="form-label">Email Address</label><input class="form-input" type="email" required placeholder="you@example.com"></div>
            </div>
            <div style="margin-bottom:1rem"><label class="form-label">Subject</label><input class="form-input" required placeholder="How can we help?"></div>
            <div style="margin-bottom:1.5rem"><label class="form-label">Message</label><textarea class="form-input" rows="4" required placeholder="Tell us more..." style="resize:vertical"></textarea></div>
            <button type="submit" class="btn-primary w-full" style="padding:.875rem">Send Message ${ICONS.arrowRight}</button>
          </form>
        </div>
        <div class="animate-on-scroll from-right">
          <h3 style="font-size:1.5rem;font-weight:700;margin-bottom:2rem">Our Hospital Network</h3>
          <div class="grid grid-1 md-grid-2 gap-4">
            ${hospitals.map(h => `
              <div class="hospital-network-card">
                <h5 style="font-weight:600;margin-bottom:.5rem">${h.name}</h5>
                <div class="flex items-start gap-2" style="font-size:.75rem;color:var(--gray-500);margin-bottom:.25rem">${ICONS.mapPinXs}<span>${h.address}</span></div>
                <div class="flex items-center gap-2" style="font-size:.75rem;color:var(--brand-primary);font-weight:500">${ICONS.phoneXs}<span>${h.phone}</span></div>
              </div>
            `).join('')}
          </div>
        </div>
      </div>
    </div>
  `;
}

function submitContactForm(e) {
  e.preventDefault();
  const card = $('#contact-form-card');
  card.innerHTML = `<div class="success-state"><div class="success-icon">${ICONS.checkCircle}</div><h3 style="font-size:1.5rem;font-weight:700;margin-bottom:.5rem">Message Sent!</h3><p style="color:var(--gray-500);margin-bottom:2rem">Thank you for reaching out. Our team will respond within 24 hours.</p><a href="#/" class="btn-primary">Back to Home</a></div>`;
}

/* ===== DOCTOR APPOINTMENT PAGE ===== */
let appointmentStep = 1, selectedDoctor = null;
function renderDoctorAppointmentPage() {
  return `
    <div class="page-banner primary">
      <div class="container relative" style="z-index:2">
        <span class="section-tag" style="color:rgba(255,255,255,.7)">Healthcare Access</span>
        <h1>Book an Appointment</h1>
        <p>Find the right specialist and schedule your consultation in minutes.</p>
      </div>
      <div class="skew" style="background:var(--brand-dark)"></div>
    </div>
    <div class="section-container" id="appointment-container">
      ${renderAppointmentStep()}
    </div>
  `;
}
function renderAppointmentStep() {
  if (appointmentStep === 1) return renderDoctorSearch();
  if (appointmentStep === 2) return renderBookingForm();
  return renderConfirmation();
}
function renderDoctorSearch() {
  return `
    <div style="max-width:56rem;margin:0 auto">
      <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:.5rem">Find a Doctor</h2>
      <p style="color:var(--gray-500);margin-bottom:2rem">Search by name, specialty, or hospital to find the right specialist.</p>
      <div class="grid grid-1 md-grid-2 gap-4" style="margin-bottom:2rem">
        <div class="search-bar"><input id="doctor-search" type="text" placeholder="Search by name..." oninput="filterDoctors()" style="width:100%"></div>
        <select class="form-select" id="specialty-filter" onchange="filterDoctors()">
          <option value="">All Specialties</option>
          ${specialties.map(s => `<option value="${s}">${s}</option>`).join('')}
        </select>
      </div>
      <div class="flex flex-col gap-4" id="doctor-list">
        <div style="text-align:center;padding:3rem;color:var(--gray-500)">Loading doctors...</div>
      </div>
    </div>
  `;
}

/* Load doctors from the API after the page renders */
async function loadDoctorsPage() {
  await Promise.all([fetchDoctors(), fetchSpecializations()]);
  const list = $('#doctor-list');
  if (!list) return;
  if (!doctorsLoaded || doctorsData.length === 0) {
    list.innerHTML = `<div class="empty-state"><div class="empty-icon">${ICONS.alertTriangle}</div><h3 style="font-size:1.25rem;font-weight:700;color:var(--gray-700)">Could not load doctors</h3><p style="color:var(--gray-500);margin-top:.5rem">Make sure the API server is running on port 3000.</p></div>`;
    return;
  }
  list.innerHTML = doctorsData.map(d => renderDoctorCard(d)).join('');
  // Update specialty dropdown with DB values
  const select = $('#specialty-filter');
  if (select) {
    select.innerHTML = `<option value="">All Specialties</option>` + specialties.map(s => `<option value="${s}">${s}</option>`).join('');
  }
}
function renderDoctorCard(d) {
  const feeText = d.fee ? `<span style="color:var(--green-600);font-weight:600;font-size:.8125rem">Rs. ${Number(d.fee).toLocaleString()}</span>` : '';
  const daysText = d.presentDays ? `<p style="color:var(--gray-400);font-size:.75rem;margin-top:.25rem">${d.presentDays}</p>` : '';
  return `<div class="doctor-card" onclick="selectDoctor(${d.id})" style="cursor:pointer">
    <div class="doctor-avatar"><img src="${d.image}" alt="${d.name}"></div>
    <div style="flex:1">
      <h3>${d.name}</h3>
      <p style="color:var(--brand-primary);font-weight:600;font-size:.875rem;margin-bottom:.25rem">${d.specialty}</p>
      ${feeText}
      ${daysText}
    </div>
    <div class="btn-outline" style="padding:.5rem 1rem;font-size:.75rem">Select</div>
  </div>`;
}
function filterDoctors() {
  const q = ($('#doctor-search')?.value || '').toLowerCase();
  const spec = $('#specialty-filter')?.value || '';
  const filtered = doctorsData.filter(d => {
    return d.name.toLowerCase().includes(q) && (!spec || d.specialty === spec);
  });
  const list = $('#doctor-list');
  if (list) list.innerHTML = filtered.length ? filtered.map(d => renderDoctorCard(d)).join('') : `<div class="empty-state"><div class="empty-icon">${ICONS.searchLg}</div><h3 style="font-size:1.25rem;font-weight:700;color:var(--gray-700)">No doctors found</h3></div>`;
}
function selectDoctor(id) {
  selectedDoctor = doctorsData.find(d => d.id === id);
  appointmentStep = 2;
  const c = $('#appointment-container');
  if (c) { c.innerHTML = renderAppointmentStep(); observeAnimations(); }
}
function renderBookingForm() {
  const d = selectedDoctor;
  return `<div style="max-width:42rem;margin:0 auto">
    <div class="booking-form-card">
      <div class="booking-header">
        <div class="avatar"><img src="${d.image}" alt="${d.name}"></div>
        <div><h3 style="font-weight:700;font-size:1.25rem">${d.name}</h3><p style="color:rgba(255,255,255,.7);font-size:.875rem">${d.specialty} • ${d.hospital}</p></div>
      </div>
      <div style="padding:2rem">
        <form id="booking-form" onsubmit="confirmAppointment(event)">
          <div class="grid grid-1 md-grid-2 gap-4" style="margin-bottom:1rem">
            <div><label class="form-label">Full Name *</label><input id="book-name" class="form-input" required placeholder="Your full name"></div>
            <div><label class="form-label">Phone *</label><input id="book-phone" class="form-input" type="tel" required placeholder="+94 XX XXX XXXX"></div>
          </div>
          <div class="grid grid-1 md-grid-2 gap-4" style="margin-bottom:1rem">
            <div><label class="form-label">Email *</label><input id="book-email" class="form-input" type="email" required placeholder="you@example.com"></div>
            <div><label class="form-label">NIC / Passport *</label><input id="book-nic" class="form-input" required placeholder="National ID or Passport"></div>
          </div>
          <div style="margin-bottom:1rem">
            <label class="form-label">Preferred Date *</label>
            <div class="date-box">${ICONS.calendarMd}<input id="book-date" type="date" class="form-input" required style="border:none;padding:.5rem;box-shadow:none" min="${new Date().toISOString().split('T')[0]}"></div>
          </div>
          <div style="margin-bottom:1.5rem"><label class="form-label">Notes (Optional)</label><textarea id="book-notes" class="form-input" rows="3" placeholder="Any special requirements..." style="resize:vertical"></textarea></div>
          <div id="booking-error" style="display:none;color:#e53e3e;background:#fff5f5;padding:.75rem 1rem;border-radius:var(--radius-xl);margin-bottom:1rem;font-size:.875rem"></div>
          <div class="flex gap-4">
            <button type="button" class="btn-outline" onclick="appointmentStep=1;$('#appointment-container').innerHTML=renderAppointmentStep();setTimeout(loadDoctorsPage,50)">Back</button>
            <button type="submit" id="book-submit-btn" class="btn-primary" style="flex:1">Confirm Booking ${ICONS.arrowRight}</button>
          </div>
        </form>
      </div>
    </div>
  </div>`;
}
let lastBookingRef = '';
async function confirmAppointment(e) {
  e.preventDefault();
  const errBox = $('#booking-error');
  const submitBtn = $('#book-submit-btn');

  // Collect form values
  const patientName = $('#book-name').value.trim();
  const phone = $('#book-phone').value.trim();
  const email = $('#book-email').value.trim();
  const appointDate = $('#book-date').value;
  const doctorId = selectedDoctor.id;

  // Show loading state
  submitBtn.disabled = true;
  submitBtn.innerHTML = 'Booking...';
  if (errBox) errBox.style.display = 'none';

  try {
    const res = await fetch(`${API_BASE}/appointments`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ patientName, email, phone, doctorId, appointDate })
    });
    const data = await res.json();

    if (!res.ok) {
      throw new Error(data.error || 'Failed to book appointment');
    }

    // Success — go to confirmation page
    lastBookingRef = data.reference;
    appointmentStep = 3;
    const c = $('#appointment-container');
    if (c) { c.innerHTML = renderAppointmentStep(); }
  } catch (err) {
    // Show error
    if (errBox) {
      errBox.textContent = err.message;
      errBox.style.display = 'block';
    }
    submitBtn.disabled = false;
    submitBtn.innerHTML = `Confirm Booking ${ICONS.arrowRight}`;
  }
}
function renderConfirmation() {
  const d = selectedDoctor;
  const ref = lastBookingRef || `APT-${Math.random().toString(36).substring(2, 8).toUpperCase()}`;
  return `<div style="max-width:36rem;margin:0 auto">
    <div class="confirm-card">
      <div style="color:var(--green-600);margin-bottom:1.5rem">${ICONS.checkCircleLg}</div>
      <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:.5rem">Appointment Confirmed!</h2>
      <p style="color:var(--gray-500);margin-bottom:2rem">Your appointment has been successfully saved to the database.</p>
      <div style="background:var(--gray-50);padding:1.5rem;border-radius:var(--radius-2xl);text-align:left;margin-bottom:2rem">
        <div class="confirm-detail"><span style="color:var(--gray-500)">Doctor</span><span style="font-weight:600">${d.name}</span></div>
        <div class="confirm-detail"><span style="color:var(--gray-500)">Specialty</span><span style="font-weight:600">${d.specialty}</span></div>
        <div class="confirm-detail"><span style="color:var(--gray-500)">Hospital</span><span style="font-weight:600">${d.hospital}</span></div>
        <div class="confirm-detail" style="border-bottom:none"><span style="color:var(--gray-500)">Reference</span><span style="font-weight:600;color:var(--brand-primary)">#${ref}</span></div>
      </div>
      <div class="flex gap-4 justify-center">
        <a href="#/" class="btn-outline">Back to Home</a>
        <a href="#/doctor-appointment" class="btn-primary" onclick="appointmentStep=1;selectedDoctor=null">New Booking</a>
      </div>
    </div>
  </div>`;
}

/* ===== DOWNLOAD LAB REPORTS PAGE ===== */
let labStep = 1;
function renderLabReportsPage() {
  return `
    <div class="page-banner dark">
      <div class="container relative" style="z-index:2">
        <span class="section-tag" style="color:rgba(255,255,255,.7)">Secure Access</span>
        <h1>Download Lab Reports</h1>
        <p>Access your laboratory results securely using your reference number and passcode.</p>
      </div>
      <div class="skew"></div>
    </div>
    <div class="section-container" id="lab-container">
      ${labStep === 1 ? renderLabSearch() : renderLabResults()}
    </div>
  `;
}
function renderLabSearch() {
  return `<div class="lab-portal">
    <div class="lab-icon">${ICONS.lock}</div>
    <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:.5rem">Secure Report Portal</h2>
    <p style="color:var(--gray-500);margin-bottom:2rem">Enter the details provided by the hospital to access your reports.</p>
    <div class="lab-form-card">
      <form onsubmit="searchLabReports(event)">
        <div style="margin-bottom:1rem"><label class="form-label">Reference Number *</label><input class="form-input" id="lab-ref" required placeholder="e.g. LAB-2026-001234"></div>
        <div style="margin-bottom:1rem"><label class="form-label">Passcode *</label><input class="form-input" id="lab-pass" type="password" required placeholder="Enter your passcode"></div>
        <div class="lab-notice" style="margin-bottom:1.5rem">${ICONS.alertCircle}<span>Your data is encrypted and secure. We never share your information.</span></div>
        <button type="submit" class="btn-primary w-full" style="padding:.875rem">Access Reports ${ICONS.arrowRight}</button>
      </form>
    </div>
  </div>`;
}
function searchLabReports(e) {
  e.preventDefault();
  labStep = 2;
  const c = $('#lab-container');
  if (c) { c.innerHTML = renderLabResults(); observeAnimations(); }
}
function renderLabResults() {
  const reports = [
    { name: 'Complete Blood Count (CBC)', date: '2026-02-10', status: 'Ready' },
    { name: 'Lipid Panel', date: '2026-02-10', status: 'Ready' },
    { name: 'Liver Function Test', date: '2026-02-09', status: 'Ready' },
  ];
  return `<div class="lab-results">
    <div class="lab-results-card">
      <div class="lab-header">
        <div><h3 style="font-weight:700;font-size:1.25rem">Lab Reports</h3><p style="color:var(--gray-400);font-size:.875rem">Reference: LAB-2026-001234</p></div>
        <div style="background:var(--green-400);color:var(--gray-900);font-size:.75rem;font-weight:700;padding:.25rem .75rem;border-radius:var(--radius-full)">All Ready</div>
      </div>
      <div class="lab-patient-info">
        <div class="grid grid-1 md-grid-3 gap-4" style="font-size:.875rem">
          <div><span style="color:var(--gray-500)">Patient:</span> <strong>John Doe</strong></div>
          <div><span style="color:var(--gray-500)">Date:</span> <strong>February 10, 2026</strong></div>
          <div><span style="color:var(--gray-500)">Ordered By:</span> <strong>Dr. Rohan Perera</strong></div>
        </div>
      </div>
      <div style="padding:2rem">
        <div class="flex flex-col gap-4">
          ${reports.map(r => `
            <div class="report-item">
              <div class="flex items-center gap-4" style="flex:1">
                <div class="report-icon">${ICONS.fileTextSm}</div>
                <div><h4 style="font-weight:700">${r.name}</h4><p style="font-size:.75rem;color:var(--gray-500)">${formatDate(r.date)}</p></div>
              </div>
              <div class="flex items-center gap-3">
                <span style="font-size:.75rem;font-weight:700;color:var(--green-600);background:var(--green-100);padding:.25rem .75rem;border-radius:var(--radius-full)">${r.status}</span>
                <button class="download-btn">${ICONS.download} Download PDF</button>
              </div>
            </div>
          `).join('')}
        </div>
      </div>
      <div class="lab-disclaimer"><p>These results are for informational purposes only. Please consult your physician for interpretation. Results are confidential and protected under applicable privacy laws.</p></div>
    </div>
    <div style="text-align:center;margin-top:2rem">
      <button class="btn-outline" onclick="labStep=1;$('#lab-container').innerHTML=renderLabSearch()">Search Another Report</button>
    </div>
  </div>`;
}

/* ===== SPA ROUTER ===== */
function getRoute() {
  const hash = location.hash.replace('#', '') || '/';
  return hash;
}
function route() {
  const path = getRoute();
  const app = $('#app');
  // Reset steps on navigation
  appointmentStep = 1; selectedDoctor = null; labStep = 1; currentCategory = 'All';
  window.scrollTo({ top: 0 });

  if (path === '/' || path === '/central-home') {
    app.innerHTML = renderHomePage();
    setTimeout(initCarousel, 50);
  } else if (path === '/services') {
    app.innerHTML = renderServicesPage();
    setTimeout(filterServices, 50);
  } else if (path.startsWith('/services/')) {
    const id = path.split('/services/')[1];
    app.innerHTML = renderServiceDetail(id);
  } else if (path === '/contact-us') {
    app.innerHTML = renderContactPage();
  } else if (path === '/doctor-appointment') {
    app.innerHTML = renderDoctorAppointmentPage();
    setTimeout(loadDoctorsPage, 50);
  } else if (path === '/download-lab-reports') {
    app.innerHTML = renderLabReportsPage();
  } else {
    app.innerHTML = renderHomePage();
    setTimeout(initCarousel, 50);
  }
  observeAnimations();
}

window.addEventListener('hashchange', route);

/* ===== HERO CAROUSEL ===== */
let currentSlide = 0, carouselInterval = null, progressInterval = null, progressValue = 0;
const SLIDE_DURATION = 6000;

function initCarousel() {
  stopCarousel();
  currentSlide = 0;
  updateSlide();
  startCarousel();
  const hero = $('#hero-carousel');
  if (hero) {
    hero.addEventListener('mouseenter', stopCarousel);
    hero.addEventListener('mouseleave', startCarousel);
  }
}
function startCarousel() {
  stopCarousel();
  progressValue = 0;
  progressInterval = setInterval(() => {
    progressValue += 50 / SLIDE_DURATION * 100;
    const bar = $('#hero-progress-bar');
    if (bar) bar.style.width = progressValue + '%';
    if (progressValue >= 100) heroNav(1);
  }, 50);
}
function stopCarousel() {
  clearInterval(carouselInterval);
  clearInterval(progressInterval);
  carouselInterval = null;
  progressInterval = null;
}
function heroNav(dir) {
  currentSlide = (currentSlide + dir + slides.length) % slides.length;
  updateSlide();
  progressValue = 0;
  const bar = $('#hero-progress-bar');
  if (bar) bar.style.width = '0%';
}
function heroGoTo(i) {
  currentSlide = i;
  updateSlide();
  progressValue = 0;
  const bar = $('#hero-progress-bar');
  if (bar) bar.style.width = '0%';
}
function updateSlide() {
  $$('.hero-slide').forEach((s, i) => s.classList.toggle('active', i === currentSlide));
  $$('.hero-dot').forEach((d, i) => d.classList.toggle('active', i === currentSlide));
}

/* ===== SCROLL ANIMATIONS ===== */
function observeAnimations() {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
  }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
  $$('.animate-on-scroll:not(.visible)').forEach(el => observer.observe(el));
}

/* ===== NAVBAR SCROLL ===== */
function initNavbar() {
  const navbar = $('#navbar');
  window.addEventListener('scroll', () => {
    if (navbar) navbar.classList.toggle('scrolled', window.scrollY > 20);
  });
}

/* ===== MOBILE MENU ===== */
function initMobileMenu() {
  const toggle = $('#mobile-toggle');
  const menu = $('#mobile-menu');
  const menuIcon = $('#menu-icon');
  const closeIcon = $('#close-icon');
  if (toggle && menu) {
    toggle.addEventListener('click', () => {
      const isOpen = menu.classList.toggle('open');
      menuIcon.style.display = isOpen ? 'none' : 'block';
      closeIcon.style.display = isOpen ? 'block' : 'none';
    });
  }
}
function closeMobileMenu() {
  const menu = $('#mobile-menu');
  const menuIcon = $('#menu-icon');
  const closeIcon = $('#close-icon');
  if (menu) { menu.classList.remove('open'); menuIcon.style.display = 'block'; closeIcon.style.display = 'none'; }
}

/* ===== BACK TO TOP ===== */
function initBackToTop() {
  const btn = $('#back-to-top');
  window.addEventListener('scroll', () => { if (btn) btn.classList.toggle('visible', window.scrollY > 300); });
  if (btn) btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
}

/* ===== NEWSLETTER ===== */
function initNewsletter() {
  const form = $('#newsletter-form');
  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const btn = $('#newsletter-btn');
      const input = $('#newsletter-email');
      if (btn) { btn.innerHTML = `<span>Subscribed ✓</span>`; btn.style.background = '#16a34a'; }
      if (input) { input.value = ''; input.disabled = true; }
      setTimeout(() => { if (btn) { btn.innerHTML = `<span>Subscribe</span>${ICONS.send}`; btn.style.background = ''; } if (input) input.disabled = false; }, 3000);
    });
  }
}

/* ===== FOOTER HOSPITALS ===== */
function renderFooterHospitals() {
  const container = $('#footer-hospitals');
  if (container) {
    container.innerHTML = hospitals.slice(0, 4).map(h => `
      <div class="hospital-item">
        <h5>${h.name}</h5>
        <div class="info">${ICONS.phoneXs}<span class="phone">${h.phone}</span></div>
        <div class="info">${ICONS.mapPinXs}<span>${h.address}</span></div>
      </div>
    `).join('');
  }
}

/* ===== RESPONSIVE TOP BAR ===== */
function initResponsive() {
  function check() {
    const w = window.innerWidth;
    $$('.sm-show').forEach(el => el.style.display = w >= 640 ? 'inline' : 'none');
    $$('.md-flex').forEach(el => el.style.display = w >= 768 ? 'flex' : 'none');
    $$('.top-bar .divider').forEach(el => el.style.display = w >= 640 ? 'block' : 'none');
  }
  check();
  window.addEventListener('resize', check);
}

/* ===== INIT ===== */
document.addEventListener('DOMContentLoaded', () => {
  initNavbar();
  initMobileMenu();
  initBackToTop();
  initNewsletter();
  renderFooterHospitals();
  initResponsive();
  route();
});
