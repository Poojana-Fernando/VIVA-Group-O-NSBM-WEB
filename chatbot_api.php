<?php
header('Content-Type: application/json');

// Load .env
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$hf_api_key = $_ENV['HF_TOKEN'] ?? '';

if (empty($hf_api_key)) {
    echo json_encode(['error' => 'API key missing']);
    exit;
}

// Get the user's message
$data = json_decode(file_get_contents('php://input'), true);
$message = $data['message'] ?? '';

if (empty($message)) {
    echo json_encode(['error' => 'No message provided']);
    exit;
}

$system_prompt = "You are a helpful and friendly AI assistant for NSBM Healthcare.
Your goal is to help patients navigate the website, understand booking procedures, and provide contact details.

Here is the essential information about NSBM Healthcare:
- Location: Homagama, Sri Lanka (NSBM Green University)
- Contact Hospital: 011-2345678
- Emergency Help: 011-2345678
- Email: nsbm.healthcare@nsbm.ac.lk

Wait times / Operating Hours:
- Heart Specialised Center - 011-2345678
- Brain & Spine Specialist - 011-2345678
- Kidney Specialist - 011-2345678
- General Physician - 011-2345678

Doctors List:
1. Dr. Radin Renula (Cardiologist)
2. Dr. Vinuka Jayavihan (Neurologist)
3. Dr. Chamidu Rathnayake (Nephrologist)
4. Dr. Poojana Fernando (General Physician)

Booking Procedures:
- If a user wants to book an appointment, instruct them to visit the booking page using this link: <a href='/book_now.php'>Book Now</a> or by navigating to 'Book Appointment' on the navigation bar.

Please answer the user's query concisely and politely based on the information above. Do not invent details that are not provided.
If they ask something outside of your scope, advise them to contact the hospital directly at 011-2345678.";

// Use Hugging Face Router API (OpenAI compatible)
$model = "zai-org/GLM-4.5:novita"; // Correct model per user snippet
$apiUrl = "https://router.huggingface.co/v1/chat/completions";

$postData = [
    "model" => $model,
    "messages" => [
        [
            "role" => "system",
            "content" => $system_prompt
        ],
        [
            "role" => "user",
            "content" => $message
        ]
    ]
];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . '/cacert.pem');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $hf_api_key
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo json_encode(['error' => 'Curl error: ' . curl_error($ch)]);
} else {
    $responseData = json_decode($response, true);
    if ($httpCode === 200 && isset($responseData['choices'][0]['message']['content'])) {
        // Return the generated text
        echo json_encode(['response' => trim($responseData['choices'][0]['message']['content'])]);
    } else {
         // Handle Hugging Face errors
         echo json_encode([
             'error' => 'Hugging Face API Error', 
             'details' => $responseData, 
             'http_code' => $httpCode
         ]);
    }
}

curl_close($ch);
?>
