<?php
require('fpdf.php');
include 'database.php';

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    
    $sql = "SELECT a.id, p.pname, a.appoint_date, d.dname, d.specialisation, d.start_time, d.fee, d.did 
            FROM appointments a 
            JOIN Patients p ON a.pid = p.pid 
            JOIN Doctors d ON a.did = d.did
            WHERE a.id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();

    if (!$data) {
        die("Appointment not found.");
    }

    
    $count_query = $conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE did = ? AND appoint_date = ? AND id < ?");
    $count_query->bind_param("isi", $data['did'], $data['appoint_date'], $booking_id);
    $count_query->execute();
    $position = $count_query->get_result()->fetch_assoc()['total'];

    
    $slot_duration = 20;
    $minutes_to_add = $position * $slot_duration;
    $patient_time = date('h:i A', strtotime("+$minutes_to_add minutes", strtotime($data['start_time'])));

    
    $pdf = new FPDF();
    $pdf->AddPage();
    
    
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->SetTextColor(0, 123, 255); 
    $pdf->Cell(0, 20, 'E-CHANNELING TICKET', 0, 1, 'C');
    
    
    $pdf->Line(10, 30, 200, 30);
    $pdf->Ln(10);

    
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(40, 10, 'Booking ID:', 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, '#' . $data['id'], 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Patient Name:', 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, $data['pname'], 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Appoint. Date:', 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, date('l, F d, Y', strtotime($data['appoint_date'])), 0, 1);

    $pdf->Ln(5);
    $pdf->Line(10, 75, 100, 75);
    $pdf->Ln(5);

    
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Doctor:', 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Dr. ' . $data['dname'], 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Specialisation:', 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, $data['specialisation'], 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Doctor Fee:', 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'LKR ' . number_format($data['fee'], 2), 0, 1);

    
    $pdf->Ln(10);
    $pdf->SetFillColor(232, 240, 254);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 15, 'SCHEDULED TIME: ' . $patient_time, 1, 1, 'C', true);
    
    
    $pdf->Ln(20);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->SetTextColor(128, 128, 128);
    $pdf->MultiCell(0, 5, "Please arrive at the hospital at least 15 minutes before your scheduled time slot. \nPresent this digital or printed ticket at the reception desk.", 0, 'C');

    
    $pdf->Output('D', 'Appointment_Ticket_' . $booking_id . '.pdf');
}
?>