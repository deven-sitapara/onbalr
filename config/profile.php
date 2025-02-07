<?php

return [
    'fields' => [
        'logo' => [
            'label' => 'Logo',
            'type' => 'FileUpload',
            'rules' => 'required'
        ],
        'organization' => [
            'label' => 'Organization',
            'type' => 'TextInput',
            'rules' => 'required'
        ],
        'sport' => [
            'label' => 'Sport',
            'type' => 'TextInput',
            'rules' => 'required'
        ],
        'primary_color' => [
            'label' => 'Primary Color',
            'type' => 'ColorPicker',
            'rules' => 'required'
        ],
        'country' => [
            'label' => 'County',
            'type' => 'Select',
            'rules' => 'required',
            'options' => [
                // us ,canada, other
                'us' => 'United States',
                'ca' => 'Canada',
                'other' => 'Other'


            ]
        ],
        'about' => [
            'label' => 'About',
            'type' => 'Textarea',
            'rules' => 'required'
        ],
        'occupation' => [
            'label' => 'What do you do for a living?',
            'type' => 'TextInput',
            'rules' => ''
        ]
    ],
];
