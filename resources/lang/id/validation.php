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

    'accepted' => 'Isian :attribute harus diterima.',
    'active_url' => 'Isian :attribute bukan URL yang valid.',
    'after' => 'Isian :attribute harus tanggal setelah :date.',
    'after_or_equal' => 'Isian :attribute harus berupa tanggal setelah atau sama dengan tanggal :date.',
    'alpha' => 'Isian :attribute hanya boleh berisi huruf.',
    'alpha_dash' => 'Isian :attribute hanya boleh berisi huruf, angka, dan strip.',
    'alpha_num' => 'Isian :attribute hanya boleh berisi huruf dan angka.',
    'array' => 'Isian :attribute harus berupa sebuah array.',
    'before' => 'Isian :attribute harus tanggal sebelum tanggal :date.',
    'before_or_equal' => 'Isian :attribute harus berupa tanggal sebelum atau sama dengan tanggal :date.',
    'between' => [
        'numeric' => 'Isian :attribute harus di antara :min dan :max.',
        'file' => 'Isian :attribute harus di antara :min dan :max kilobytes.',
        'string' => 'Isian :attribute harus di antara :min dan :max karakter.',
        'array' => 'Isian :attribute harus ada di antara :min dan :max item.',
    ],
    'boolean' => 'Isian :attribute field harus bernilai true or false.',
    'confirmed' => 'Isian :attribute konfirmasi tidak cocok.',
    'date' => 'Isian :attribute bukan tanggal yang valid.',
    'date_equals' => 'Isian :attribute harus sama dengan tanggal :date.',
    'date_format' => 'Isian :attribute tidak cocok dengan format :format.',
    'different' => 'Isian :attribute dan :other harus berbeda.',
    'digits' => 'Isian :attribute harus berupa angka :digits.',
    'digits_between' => 'Isian :attribute harus di antara angka :min dan angka :max.',
    'dimensions' => 'Isian :attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => 'Isian :attribute field memiliki nilai duplikat.',
    'email' => 'Isian :attribute harus alamat e-mail yang valid.',
    'ends_with' => 'Isian :attribute harus diakhiri dengan salah satu dari yang berikut: :values',
    'exists' => 'Isian :attribute yang dipilih tidak valid.',
    'file' => 'Isian :attribute harus berupa file.',
    'filled' => 'Isian :attribute field harus memiliki nilai.',
    'gt' => [
        'numeric' => 'Isian :attribute harus lebih besar dari :value.',
        'file' => 'Isian :attribute harus lebih besar dari :value kilobytes.',
        'string' => 'Isian :attribute harus lebih besar dari :value karakter.',
        'array' => 'Isian :attribute harus memiliki lebih dari :value item.',
    ],
    'gte' => [
        'numeric' => 'Isian :attribute harus lebih besar atau sama dengan :value.',
        'file' => 'Isian :attribute harus lebih besar atau sama dengan :value kilobytes.',
        'string' => 'Isian :attribute harus lebih besar atau sama dengan :value karakter.',
        'array' => 'Isian :attribute harus punya :value item atau lebih.',
    ],
    'image' => 'Isian :attribute harus berupa gambar.',
    'in' => 'Isian :attribute yang dipilih tidak valid.',
    'in_array' => 'Isian :attribute field tidak ada di :other.',
    'integer' => 'Isian :attribute harus berupa integer.',
    'ip' => 'Isian :attribute harus valid dengan IP address.',
    'ipv4' => 'Isian :attribute harus valid dengan IPv4 address.',
    'ipv6' => 'Isian :attribute harus valid dengan IPv6 address.',
    'json' => 'Isian :attribute harus valid dengan JSON string.',
    'lt' => [
        'numeric' => 'Isian :attribute harus kurang dari :value.',
        'file' => 'Isian :attribute harus kurang dari :value kilobytes.',
        'string' => 'Isian :attribute harus kurang dari :value karakter.',
        'array' => 'Isian :attribute harus kurang dari :value item.',
    ],
    'lte' => [
        'numeric' => 'Isian :attribute harus kurang dari atau sama dengan :value.',
        'file' => 'Isian :attribute harus kurang dari atau sama dengan :value kilobytes.',
        'string' => 'Isian :attribute harus kurang dari atau sama dengan :value karakter.',
        'array' => 'Isian :attribute seharusnya tidak boleh lebih dari :value item.',
    ],
    'max' => [
        'numeric' => 'Isian :attribute seharusnya tidak lebih besar dari :max.',
        'file' => 'Isian :attribute seharusnya lebih besar dari :max kilobytes.',
        'string' => 'Isian :attribute seharusnya lebih besar dari :max karakter.',
        'array' => 'Isian :attribute seharusnya memiliki lebih dari :max item.',
    ],
    'mimes' => 'Isian :attribute harus berupa file bertipe: :values.',
    'mimetypes' => 'Isian :attribute harus berupa file bertipe: :values.',
    'min' => [
        'numeric' => 'Isian :attribute harus minimal :min.',
        'file' => 'Isian :attribute harus minimal :min kilobytes.',
        'string' => 'Isian :attribute harus minimal :min karakter.',
        'array' => 'Isian :attribute minimal harus :min item.',
    ],
    'not_in' => 'Isian :attribute yang dipilih tidak valid.',
    'not_regex' => 'Isian :attribute format tidak valid.',
    'numeric' => 'Isian :attribute berupa angka.',
    'password' => 'Isian password salah.',
    'present' => 'Isian :attribute field harus ada.',
    'regex' => 'Isian :attribute format tidak valid.',
    'required' => 'Isian :attribute field wajib diisi.',
    'required_if' => 'Isian :attribute field wajib diisi bila :other adalah :value.',
    'required_unless' => 'Isian :attribute field wajib diisi kecuali :other ada di :values.',
    'required_with' => 'Isian :attribute field wajib diisi bila terdapat :values.',
    'required_with_all' => 'Isian :attribute field wajib diisi bila terdapat :values.',
    'required_without' => 'Isian :attribute field wajib diisi bila tidak terdapat :values.',
    'required_without_all' => 'Isian :attribute field wajib diisi bila tidak terdapat :values yang ada.',
    'same' => 'Isian :attribute dan :other harus cocok.',
    'size' => [
        'numeric' => 'Isian :attribute harus berukuran :size.',
        'file' => 'Isian :attribute harus berukuran :size kilobytes.',
        'string' => 'Isian :attribute harus berukuran :size karakter.',
        'array' => 'Isian :attribute harus mengandung :size item.',
    ],
    'starts_with' => 'Isian :attribute harus dimulai dengan salah satu dari yang berikut: :values',
    'string' => 'Isian :attribute harus berupa string.',
    'timezone' => 'Isian :attribute harus berupa zona waktu yang valid.',
    'unique' => 'Isian :attribute sudah ada sebelumnya.',
    'uploaded' => 'Isian :attribute gagal diunggah.',
    'url' => 'Isian :attribute format tidak valid.',
    'uuid' => 'Isian :attribute harus berupa UUID yang valid.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
