<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        try {
            $sessionId = session()->getId();
            $userMsg = trim($request->message);

            // Save user message
            ChatMessage::create([
                'session_id' => $sessionId,
                'message' => $userMsg,
                'sender' => 'user'
            ]);

            // Get fake bot reply
            $reply = $this->getFakeBotReply($userMsg);

            // Save bot reply
            ChatMessage::create([
                'session_id' => $sessionId,
                'message' => $reply,
                'sender' => 'bot'
            ]);

            return response()->json([
                'reply' => $reply
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'reply' => 'Server error. Please try again.'
            ]);
        }
    }

    private function getFakeBotReply($message)
    {
        $msg = strtolower($message);
        $lastQuery = session('last_query', []);

        // Greetings
        if (str_contains($msg, 'hi') || str_contains($msg, 'hello')) {
            $responses = [
                "Hello 👋 Welcome to Tochy Travels! How can I assist you today?",
                "Hi there! I'm your visa assistant 🤖. How can I help?",
                "Hey! Looking for visa guidance? I'm here to help!"
            ];
            return $responses[array_rand($responses)];
        }

        // Countries and visa types
        $countries = [
            'canada' => [
                'tourist' => [
                    "Canada tourist visa usually takes 2–6 weeks. I can guide you through requirements.",
                    "Planning a Canada trip? We can help with the tourist visa paperwork."
                ],
                'student' => [
                    "Canada student visa requires proof of acceptance and funds. I can explain the steps.",
                    "Thinking of studying in Canada? I can guide you on student visa documents."
                ],
                'work' => [
                    "Canada work visa needs job offer and LMIA documents. I can walk you through it.",
                    "For a Canada work visa, we provide guidance on all paperwork and forms."
                ]
            ],
            'usa' => [
                'tourist' => [
                    "US tourist visa requires DS-160 form and interview scheduling. I can help you prepare.",
                    "Visiting the USA? I can guide you step by step for the tourist visa."
                ],
                'student' => [
                    "US student visa (F-1) needs I-20 and SEVIS fee. I can explain all steps.",
                    "Planning to study in the USA? I can guide you with your student visa."
                ],
                'work' => [
                    "US work visas (H-1B, L-1) require employer sponsorship. I can outline the process.",
                    "Need a US work visa? I can help explain the requirements."
                ]
            ],
            'uk' => [
                'tourist' => [
                    "UK tourist visa usually takes 3–4 weeks. We can help with forms and documentation.",
                    "Visiting the UK? I can guide you through the tourist visa process."
                ],
                'student' => [
                    "UK student visa requires CAS from school and funds proof. I can explain the process.",
                    "Studying in the UK? I can guide you on student visa documents."
                ],
                'work' => [
                    "UK work visa requires sponsorship from an employer. I can explain the paperwork.",
                    "For UK work visas, I can walk you through all requirements."
                ]
            ]
        ];

        // Check for country and visa type
        foreach ($countries as $country => $visas) {
            if (str_contains($msg, $country)) {

                $type = 'tourist'; // default
                foreach (['tourist', 'student', 'work'] as $visaType) {
                    if (str_contains($msg, $visaType)) {
                        $type = $visaType;
                        break;
                    }
                }

                // Avoid repeating same reply for same query
                if (isset($lastQuery['country']) && $lastQuery['country'] === $country && $lastQuery['type'] === $type) {
                    $alternative = [
                        "You've already asked about $type visa for $country. Do you want details on documents or processing times?",
                        "For $country $type visa, I can guide you with requirements or tips.",
                        "Do you need more info on $type visa for $country?"
                    ];
                    session(['last_query' => ['country' => $country, 'type' => $type]]);
                    return $alternative[array_rand($alternative)];
                }

                session(['last_query' => ['country' => $country, 'type' => $type]]);
                return $visas[$type][array_rand($visas[$type])];
            }
        }

        // Default fallback
        $default = [
            "I'm here to help 😊 Please tell me the country and type of visa you need.",
            "Can you specify your destination and visa type? I can give better guidance.",
            "Tell me the country and whether it's tourist, student, or work visa, and I’ll explain the steps."
        ];

        return $default[array_rand($default)];
    }
}