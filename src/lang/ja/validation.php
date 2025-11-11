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

    'accepted' => ':attribute を承認してください。',
    'accepted_if' => ':other が :value の場合、:attribute を承認してください。',
    'active_url' => ':attribute は有効なURLでなければなりません。',
    'after' => ':attribute は :date より後の日付でなければなりません。',
    'after_or_equal' => ':attribute は :date 以降の日付でなければなりません。',
    'alpha' => ':attribute には文字のみを含めることができます。',
    'alpha_dash' => ':attribute には文字、数字、ハイフン、アンダースコアのみを含めることができます。',
    'alpha_num' => ':attribute には文字と数字のみを含めることができます。',
    'any_of' => ':attribute の値は無効です。',
    'array' => ':attribute は配列でなければなりません。',
    'ascii' => ':attribute には半角英数字と記号のみを含めることができます。',
    'before' => ':attribute は :date より前の日付でなければなりません。',
    'before_or_equal' => ':attribute は :date 以前の日付でなければなりません。',
    'between' => [
        'array' => ':attribute の項目数は :min から :max の間でなければなりません。',
        'file' => ':attribute のファイルサイズは :min KBから :max KB の間でなければなりません。',
        'numeric' => ':attribute の値は :min から :max の間でなければなりません。',
        'string' => ':attribute の文字数は :min 文字から :max 文字の間でなければなりません。',
    ],
    'boolean' => ':attribute は true か false でなければなりません。',
    'can' => ':attribute に許可されていない値が含まれています。',
    'confirmed' => ':attribute の確認が一致しません。',
    'contains' => ':attribute に必須の値が含まれていません。',
    'current_password' => 'パスワードが正しくありません。',
    'date' => ':attribute は有効な日付でなければなりません。',
    'date_equals' => ':attribute は :date と同じ日付でなければなりません。',
    'date_format' => ':attribute は :format の形式と一致しなければなりません。',
    'decimal' => ':attribute は :decimal 桁の小数を含める必要があります。',
    'declined' => ':attribute は拒否されなければなりません。',
    'declined_if' => ':other が :value の場合、:attribute は拒否されなければなりません。',
    'different' => ':attribute と :other は異なる値でなければなりません。',
    'digits' => ':attribute は :digits 桁でなければなりません。',
    'digits_between' => ':attribute は :min 桁から :max 桁の間でなければなりません。',
    'dimensions' => ':attribute の画像サイズが無効です。',
    'distinct' => ':attribute に重複した値があります。',
    'doesnt_contain' => ':attribute に以下の値を含めてはいけません: :values。',
    'doesnt_end_with' => ':attribute は以下の値で終わってはいけません: :values。',
    'doesnt_start_with' => ':attribute は以下の値で始まってはいけません: :values。',
    'email' => ':attribute は有効なメールアドレスでなければなりません。',
    'ends_with' => ':attribute は以下の値のいずれかで終わる必要があります: :values。',
    'enum' => '選択された :attribute は無効です。',
    'exists' => '選択された :attribute は無効です。',
    'extensions' => ':attribute は以下の拡張子のいずれかでなければなりません: :values。',
    'file' => ':attribute はファイルでなければなりません。',
    'filled' => ':attribute は値を持たなければなりません。',
    'gt' => [
        'array' => ':attribute の項目数は :value より多くなければなりません。',
        'file' => ':attribute のファイルサイズは :value KB より大きくなければなりません。',
        'numeric' => ':attribute の値は :value より大きくなければなりません。',
        'string' => ':attribute の文字数は :value 文字より多くなければなりません。',
    ],
    'gte' => [
        'array' => ':attribute の項目数は :value 以上でなければなりません。',
        'file' => ':attribute のファイルサイズは :value KB 以上でなければなりません。',
        'numeric' => ':attribute の値は :value 以上でなければなりません。',
        'string' => ':attribute の文字数は :value 文字以上でなければなりません。',
    ],
    'hex_color' => ':attribute は有効な16進カラーでなければなりません。',
    'image' => ':attribute は画像でなければなりません。',
    'in' => '選択された :attribute は無効です。',
    'in_array' => ':attribute の値は :other に存在する必要があります。',
    'in_array_keys' => ':attribute は次のキーのいずれかを含む必要があります: :values。',
    'integer' => ':attribute は整数でなければなりません。',
    'ip' => ':attribute は有効なIPアドレスでなければなりません。',
    'ipv4' => ':attribute は有効なIPv4アドレスでなければなりません。',
    'ipv6' => ':attribute は有効なIPv6アドレスでなければなりません。',
    'json' => ':attribute は有効なJSON文字列でなければなりません。',
    'list' => ':attribute はリストでなければなりません。',
    'lowercase' => ':attribute は小文字でなければなりません。',
    'lt' => [
        'array' => ':attribute の項目数は :value 未満でなければなりません。',
        'file' => ':attribute のファイルサイズは :value KB 未満でなければなりません。',
        'numeric' => ':attribute の値は :value 未満でなければなりません。',
        'string' => ':attribute の文字数は :value 文字未満でなければなりません。',
    ],
    'lte' => [
        'array' => ':attribute の項目数は :value 以下でなければなりません。',
        'file' => ':attribute のファイルサイズは :value KB 以下でなければなりません。',
        'numeric' => ':attribute の値は :value 以下でなければなりません。',
        'string' => ':attribute の文字数は :value 文字以下でなければなりません。',
    ],
    'mac_address' => ':attribute は有効なMACアドレスでなければなりません。',
    'max' => [
        'array' => ':attribute の項目数は :max 以下でなければなりません。',
        'file' => ':attribute のファイルサイズは :max KB 以下でなければなりません。',
        'numeric' => ':attribute の値は :max 以下でなければなりません。',
        'string' => ':attribute の文字数は :max 文字以下でなければなりません。',
    ],
    'max_digits' => ':attribute は :max 桁以下でなければなりません。',
    'mimes' => ':attribute は次のファイルタイプでなければなりません: :values。',
    'mimetypes' => ':attribute は次のファイルタイプでなければなりません: :values。',
    'min' => [
        'array' => ':attribute の項目数は最低 :min 以上でなければなりません。',
        'file' => ':attribute のファイルサイズは最低 :min KB 以上でなければなりません。',
        'numeric' => ':attribute の値は最低 :min 以上でなければなりません。',
        'string' => ':attribute の文字数は最低 :min 文字以上でなければなりません。',
    ],
    'min_digits' => ':attribute は最低 :min 桁以上でなければなりません。',
    'missing' => ':attribute は存在してはいけません。',
    'missing_if' => ':other が :value の場合、:attribute は存在してはいけません。',
    'missing_unless' => ':other が :value でない限り、:attribute は存在してはいけません。',
    'missing_with' => ':values が存在する場合、:attribute は存在してはいけません。',
    'missing_with_all' => ':values がすべて存在する場合、:attribute は存在してはいけません。',
    'multiple_of' => ':attribute は :value の倍数でなければなりません。',
    'not_in' => '選択された :attribute は無効です。',
    'not_regex' => ':attribute の形式が無効です。',
    'numeric' => ':attribute は数字でなければなりません。',
    'password' => [
        'letters' => ':attribute には少なくとも1文字を含める必要があります。',
        'mixed' => ':attribute には少なくとも1つの大文字と1つの小文字を含める必要があります。',
        'numbers' => ':attribute には少なくとも1つの数字を含める必要があります。',
        'symbols' => ':attribute には少なくとも1つの記号を含める必要があります。',
        'uncompromised' => '指定された :attribute はデータ漏洩に含まれていました。別の :attribute を選んでください。',
    ],
    'present' => ':attribute は存在している必要があります。',
    'present_if' => ':other が :value の場合、:attribute は存在している必要があります。',
    'present_unless' => ':other が :value でない限り、:attribute は存在している必要があります。',
    'present_with' => ':values が存在する場合、:attribute は存在している必要があります。',
    'present_with_all' => ':values がすべて存在する場合、:attribute は存在している必要があります。',
    'prohibited' => ':attribute は禁止されています。',
    'prohibited_if' => ':other が :value の場合、:attribute は禁止されています。',
    'prohibited_if_accepted' => ':other が承認されている場合、:attribute は禁止されています。',
    'prohibited_if_declined' => ':other が拒否されている場合、:attribute は禁止されています。',
    'prohibited_unless' => ':other が :values に含まれていない限り、:attribute は禁止されています。',
    'prohibits' => ':attribute が存在する場合、:other は存在できません。',
    'regex' => ':attribute の形式が無効です。',
    'required' => ':attributeは必須です。',
    'required_array_keys' => ':attribute には次の項目を含める必要があります: :values。',
    'required_if' => ':other が :value の場合、:attribute は必須です。',
    'required_if_accepted' => ':other が承認されている場合、:attribute は必須です。',
    'required_if_declined' => ':other が拒否されている場合、:attribute は必須です。',
    'required_unless' => ':other が :values に含まれていない場合、:attribute は必須です。',
    'required_with' => ':values が存在する場合、:attribute は必須です。',
    'required_with_all' => ':values がすべて存在する場合、:attribute は必須です。',
    'required_without' => ':values が存在しない場合、:attribute は必須です。',
    'required_without_all' => ':values がすべて存在しない場合、:attribute は必須です。',
    'same' => ':attribute は :other と一致する必要があります。',
    'size' => [
        'array' => ':attribute の項目数は :size でなければなりません。',
        'file' => ':attribute のファイルサイズは :size KB でなければなりません。',
        'numeric' => ':attribute の値は :size でなければなりません。',
        'string' => ':attribute の文字数は :size 文字でなければなりません。',
    ],
    'starts_with' => ':attribute は以下の値のいずれかで始まる必要があります: :values。',
    'string' => ':attribute は文字列でなければなりません。',
    'timezone' => ':attribute は有効なタイムゾーンでなければなりません。',
    'unique' => ':attribute は既に使用されています。',
    'uploaded' => ':attribute のアップロードに失敗しました。',
    'uppercase' => ':attribute は大文字でなければなりません。',
    'url' => ':attribute は有効なURLでなければなりません。',
    'ulid' => ':attribute は有効なULIDでなければなりません。',
    'uuid' => ':attribute は有効なUUIDでなければなりません。',

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
