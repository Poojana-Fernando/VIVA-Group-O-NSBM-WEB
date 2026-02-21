<?php
require('fpdf.php');
include 'database.php';

if (isset($_GET['id'])) {
    $booking_id = (int)$_GET['id'];

    // Aggregation to join appointment with patient and doctor
    $pipeline = [
        ['$match' => ['id' => $booking_id]],
        ['$lookup' => [
            'from' => 'patients',
            'localField' => 'pid',
            'foreignField' => 'pid',
            'as' => 'patient'
        ]],
        ['$unwind' => '$patient'],
        ['$lookup' => [
            'from' => 'doctors',
            'localField' => 'did',
            'foreignField' => 'did',
            'as' => 'doctor'
        ]],
        ['$unwind' => '$doctor'],
        ['$project' => [
            'id' => 1,
            'pname' => '$patient.pname',
            'appoint_date' => 1,
            'dname' => '$doctor.dname',
            'specialisation' => '$doctor.specialisation',
            'start_time' => '$doctor.start_time',
            'fee' => '$doctor.fee',
            'did' => 1
        ]]
    ];

    $results = $db->appointments->aggregate($pipeline);
    $data = null;
    foreach ($results as $row) {
        $data = $row;
        break;
    }

    if (!$data) {
        die("Appointment not found.");
    }

    // Count appointments before this one for time calculation
    $position = $db->appointments->countDocuments([
        'did' => $data['did'],
        'appoint_date' => $data['appoint_date'],
        'id' => ['$lt' => $booking_id]
    ]);

    $slot_duration = 20;
    $minutes_to_add = $position * $slot_duration;
    $patient_time = date('h:i A', strtotime("+$minutes_to_add minutes", strtotime($data['start_time'])));

    // Generate PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->SetTextColor(0, 123, 255); 
    $pdf->Cell(0, 20, 'E-CHANNELING BOOKING TICKET', 0, 1, 'C');
    
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
    $fee_value = $data['fee'];
    if ($fee_value instanceof MongoDB\BSON\Decimal128) {
        $fee_value = (string)$fee_value;
    }
    $pdf->Cell(0, 10, 'LKR ' . number_format((float)$fee_value, 2), 0, 1);

    $pdf->Ln(10);
    $pdf->SetFillColor(232, 240, 254);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 15, 'SCHEDULED TIME: ' . $patient_time, 1, 1, 'C', true);
    
    $pdf->Ln(20);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->SetTextColor(128, 128, 128);
    $pdf->MultiCell(0, 5, "Please arrive at the hospital at least 15 minutes before your scheduled time slot. \nPresent this digital or printed ticket at the reception desk.\n\n NOTE: You'll receive a confirmation email within several hours once your booking is confirmed. Kindly reminder to check your mailbox", 0, 'C');

    $pdf->Output('D', 'Appointment_Ticket_' . $booking_id . '.pdf');
}
?>