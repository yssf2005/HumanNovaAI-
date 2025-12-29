<?php

namespace App\Controllers;

use App\Core\Controller;

class ChatController extends Controller {
    private $groqApiKey = null;
    private $groqApiUrl = 'https://api.groq.com/openai/v1/chat/completions';
    
    public function __construct() {
        parent::__construct();
        // initialize from environment variable (set GROQ_API_KEY in your environment)
        $this->groqApiKey = getenv('GROQ_API_KEY');
        if (empty($this->groqApiKey)) {
            // fallback to other common places PHP may have env vars
            if (!empty($_ENV['GROQ_API_KEY'])) $this->groqApiKey = $_ENV['GROQ_API_KEY'];
            elseif (!empty($_SERVER['GROQ_API_KEY'])) $this->groqApiKey = $_SERVER['GROQ_API_KEY'];
        }
    }
    
    public function chat() {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['error' => 'Unauthorized', 'message' => 'Please login first']);
            return;
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
        $message = $input['message'] ?? '';
        
        if (empty($message)) {
            echo json_encode(['error' => 'Message is required', 'message' => 'Please enter a message']);
            return;
        }
        
        // Ensure the API key is configured
        if (empty($this->groqApiKey)) {
            echo json_encode(['error' => 'API key missing', 'message' => 'Chat service not configured. Please set GROQ_API_KEY in your environment.']);
            return;
        }

        // Call Groq API
        $response = $this->callGroqAPI($message);

        echo json_encode($response);
    }
    
    private function callGroqAPI($userMessage) {
        $data = [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a helpful assistant for an innovation platform. Help users with ideas, investments, job opportunities, and events. Be concise and friendly.'
                ],
                [
                    'role' => 'user',
                    'content' => $userMessage
                ]
            ],
            'temperature' => 0.7,
            'max_tokens' => 500
        ];
        
        $ch = curl_init($this->groqApiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->groqApiKey
        ]);

        $response = curl_exec($ch);
        $curlErr = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false) {
            return [
                'error' => 'API Error',
                'message' => 'Could not contact chat service: ' . ($curlErr ?: 'unknown error')
            ];
        }

        $result = json_decode($response, true);

        if ($httpCode !== 200) {
            $providerMsg = $result['error']['message'] ?? $result['message'] ?? null;
            return [
                'error' => 'API Error',
                'message' => 'Chat service returned an error. ' . ($providerMsg ? $providerMsg : 'Please try again later.')
            ];
        }

        if (isset($result['choices'][0]['message']['content'])) {
            return [
                'success' => true,
                'message' => $result['choices'][0]['message']['content']
            ];
        }

        return [
            'error' => 'Invalid response',
            'message' => 'Sorry, I could not process your request.'
        ];
    }
}
?>