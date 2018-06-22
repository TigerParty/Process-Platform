<?php

return [
    'activiti_url' => env('ACTIVITI_URL'),
    'activiti_username' => env('ACTIVITI_USERNAME'),
    'activiti_password' => env('ACTIVITI_PASSWORD'),

    'submit_report' => env('LINK_SUBMIT_REPORT'),
    'report_corruption' => env('APP_LINK_REPORT_CORRUPTION'),
    'process_name_field_id' => env('SUBMIT_PROCESS_NAME_FIELD_ID', 1),
    'step_name_field_id' => env('SUBMIT_STEP_NAME_FIELD_ID', 2),
    'ga_tracking_id' => env('GA_TRACKING_ID'),
    'process_perpage_count' => env('PROCESS_PERPAGE_COUNT', 8),
];
