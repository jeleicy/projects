<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | El following language lines contain El default error messages used by
    | El validator class. Some of Else rules have multiple versions such
    | as El size rules. Feel free to tweak each of Else messages here.
    |
    */

    'accepted'             => 'El :attribute debe ser aceptado.',
    'active_url'           => 'El :attribute no es una direccion URL valida.',
    'after'                => 'La :attribute fecha debe ser anterior :date.',
    'alpha'                => 'El :attribute solo permite caracteres.',
    'alpha_dash'           => 'El :attribute solo permite letras, numeros, y guiones.',
    'alpha_num'            => 'El :attribute solo permite letras y numeros.',
    'array'                => 'El :attribute debe ser un arreglo.',
    'before'               => 'La :attribute fecha debe ser despues de :date.',
    'between'              => [
        'numeric' => 'El :attribute debe estar entre :min y :max.',
        'file'    => 'El :attribute debe estar entre :min y :max kilobytes.',
        'string'  => 'El :attribute debe estar entre :min y :max caracteres.',
        'array'   => 'El :attribute arreglo debe estar entre :min y :max items.',
    ],
    'boolean'              => 'El :attribute campo debe ser verdadero o falso.',
    'confirmed'            => 'La :attribute confirmacion no coincide.',
    'date'                 => 'El :attribute no es una fecha valida.',
    'date_format'          => 'El :attribute formato no coincide :format.',
    'different'            => 'El :attribute y :other debe ser diferente.',
    'digits'               => 'El :attribute debe ser digitos :digits .',
    'digits_between'       => 'El :attribute debe estar entre :min y :max digitos.',
    'email'                => 'La direcion email :attribute debe ser una direccion valida.',
    'filled'               => 'El campo es requerido :attribute .',
    'exists'               => 'La seleccion :attribute es invalida.',
    'image'                => ':attribute debe ser una imagen.',
    'in'                   => 'La seleccion :attribute es invalida.',
    'integer'              => ':attribute debe ser un entero.',
    'ip'                   => 'La direccion IP :attribute debe una direccion IP valida.',
    'max'                  => [
        'numeric' => 'El :attribute no debe ser mayor que :max.',
        'file'    => 'El :attribute no debe ser mayor que :max kilobytes.',
        'string'  => 'El :attribute no debe ser mayor que :max caracteres.',
        'array'   => 'El :attribute no debe ser mayor que :max items.',
    ],
    'mimes'                => 'El :attribute debe a file of type: :values.',
    'min'                  => [
        'numeric' => 'El :attribute debe at least :min.',
        'file'    => 'El :attribute debe at least :min kilobytes.',
        'string'  => 'El :attribute debe at least :min characters.',
        'array'   => 'El :attribute must have at least :min items.',
    ],
    'not_in'               => 'La seleccion :attribute es invalida.',
    'numeric'              => 'El :attribute debe ser un numero.',
    'regex'                => 'El :attribute formato es invalido.',
    'required'             => 'El :attribute campo es requerido.',
    'required_if'          => 'El :attribute campo es requerido cuando :other es :value.',
    'required_with'        => 'El :attribute campo es requerido cuando :values esta presente.',
    'required_with_all'    => 'El :attribute campo es requerido cuando :values esta presente.',
    'required_without'     => 'El :attribute campo es requerido cuando :values no este presente.',
    'required_without_all' => 'El :attribute campo es requerido cuando ninguno de los valores :values este presente.',
    'same'                 => 'El :attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'El :attribute debe :size.',
        'file'    => 'El :attribute debe :size kilobytes.',
        'string'  => 'El :attribute debe :size caracteres.',
        'array'   => 'El :attribute debe contener :size items.',
    ],
    'string'               => 'El :attribute debe ser una cadena de caracteres.',
    'timezone'             => 'El :attribute debe ser una zona valida.',
    'unique'               => 'El :attribute valor esta tomado.',
    'url'                  => 'El :attribute formato es invalido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using El
    | convention "attribute.rule" to name El lines. This makes it quick to
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
    | El following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
