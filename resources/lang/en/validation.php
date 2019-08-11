<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'   => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',
    'phone_number'         => 'It must be :attribute In this format 05XXXXXXXX',
    'national_id'          => 'Please enter a valid ID number',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
      'name' => 'Name',
      'name_en' => 'English Name',
      'resource_name' => 'Resource Name',
      'icon' => 'Icon',
      'sort' => 'Sort',
      'frontend_path' => 'Frontend Path',
      'li_color' => 'category color',

      'displayed_in_menu' => 'Display in menu ?',
      'menu_type' => 'Menu Type',
      'access_level' => 'Access Level',
      'key' => 'Unique Key',
      'user_id' => 'User',
      'rel_mob' => 'Mobile number',
      'daily_report' => 'Daily Report',
      'follow_daily_report' => 'Fllow Daily Reports',
      'report_date' => 'Report Date',
      'report_body' => 'Report Text',
      'report_degree' => 'Report Degree',
      'report_resource' => 'Report Resource',
      'action_from_transport_office' => 'Action From Transport Office',
      'status' => 'Status',
      'display' => 'Display',
      'New' => 'New',
      'repeated' => 'Repeated',
      'guidance_done' => 'Guidance Done',
      'add~_report' => 'Add Report',
      'person.rel_mob' => 'Mobile number' ,
      'person.job_contract' =>'Name of contract of employment',
      'person.authority' =>'Supervising the contract ',
      'person.domicile' =>'residence',
      'person.district' =>'District ',
      'person.street' =>'street',
      'person.relative' =>'Contact person',
      'person.rel_realation' => 'relative relation',
      'car.plate' => 'car plate',
      'car.provenance_other' => 'Country',
      'permit.getfrom'=>'get from',
      'phone_model_id' => 'Phone Model',
      // News Module
      'news_title'       => 'News title',
      'news_body'        => 'News content',
      'news_rej_comment' => 'recject reason',
      'vacation_code' => 'Vacation Type',
      'start_hijri_date' => 'Hijri Start Date',
      // MyServices/PermissionsController
      'permission_type_id'      => 'permission day',
      'permission_reason'       => 'reason',

      'husband_or_wife' => 'Husband / Wife',
      'husband_or_wife_work_status' => 'Husband / Wife',
      'husband_or_wife_name' => 'Husband / Wife Name',
      'sex' => 'Sex',
      'husband_or_wife_national_id' => 'Husband / Wife Nationa Id',
      'husband_or_wife_place_of_work' => 'Husband / Wife Place Of Work',

      //gduss
      'gduss_request_id'  => 'request number',
      'option' => 'Option',

      //transport

      'track_number' => 'Track Number',

      'today' => 'Today'


      
    ],

];
