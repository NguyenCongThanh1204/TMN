<?php

return [
    'name' => env('SITE_NAME', 'Architecture & Construction'),
    'tagline' => env('SITE_TAGLINE', 'Building ideas. Engineering the future.'),
    'description' => env('SITE_DESCRIPTION', 'Architecture, engineering and construction for high-performance spaces.'),
    'phone' => env('SITE_PHONE', '+84 000 000 000'),
    'email' => env('SITE_EMAIL', 'hello@example.com'),
    'contact_email' => env('CONTACT_EMAIL', 'hello@example.com'),
    'address' => env('SITE_ADDRESS', '123 Architecture Avenue, Da Nang, Vietnam'),
    'maps_url' => env('SITE_MAPS_URL', 'https://www.google.com/maps'),
    'zalo' => env('SITE_ZALO', '#'),
    'whatsapp' => env('SITE_WHATSAPP', '#'),
    'social' => [
        'facebook' => env('SITE_FACEBOOK', '#'),
        'linkedin' => env('SITE_LINKEDIN', '#'),
    ],
    'metrics' => [
        ['value' => '15+', 'label' => 'Years Experience'],
        ['value' => '240+', 'label' => 'Completed Projects'],
        ['value' => '99.2%', 'label' => 'Safety Rating'],
        ['value' => '96%', 'label' => 'Client Satisfaction'],
    ],
    'services' => [
        ['number'=>'01','title'=>'Architectural Design','text'=>'Concept, master planning, BIM coordination and detailed design.','icon'=>'⌂'],
        ['number'=>'02','title'=>'General Construction','text'=>'End-to-end construction delivery with disciplined site execution.','icon'=>'▦'],
        ['number'=>'03','title'=>'Interior & Fit-Out','text'=>'Material-led interiors, fit-out systems and precise finishing.','icon'=>'◫'],
        ['number'=>'04','title'=>'Project Supervision','text'=>'Cost, quality, schedule and safety controls from design to handover.','icon'=>'✓'],
    ],
    'process' => [
        ['step'=>'01','title'=>'Consultation','text'=>'Understand brief, site constraints, budget and programme.'],
        ['step'=>'02','title'=>'3D Architectural Blueprint','text'=>'Turn requirements into coordinated concepts and visual direction.'],
        ['step'=>'03','title'=>'Engineering & Permitting','text'=>'Coordinate technical design, approvals and construction documents.'],
        ['step'=>'04','title'=>'Construction Execution','text'=>'Build with quality, safety and schedule discipline.'],
        ['step'=>'05','title'=>'Handover','text'=>'Commission, close out documentation and support the client.'],
    ],
    'partners' => ['BuildPro','Apex Materials','SteelForm','Lumen Lighting','TerraStone','Nordic Systems'],
];
