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

    "accepted" => "Вы должны принять :attribute.",
    "accepted_if" => "Вы должны принять :attribute, когда :other соответствует :value.",
    "active_url" => "Значение поля :attribute не является действительным URL.",
    "after" => "Значение поля :attribute должно быть датой после :date.",
    "after_or_equal" => "Значение поля :attribute должно быть датой после или равной :date.",
    "alpha" => "Значение поля :attribute может содержать только буквы.",
    "alpha_dash" => "Значение поля :attribute может содержать только буквы, цифры, дефис и нижнее подчеркивание.",
    "alpha_num" => "Значение поля :attribute может содержать только буквы и цифры.",
    "are_you_sure_you_want_to_delete_member" => "Вы уверены что хотите исключить участника команды?",
    "are_you_sure_you_want_to_delete_team" => "Вы уверены что хотите удалить команду?",
    "are_you_sure_you_want_to_leave_team" => "Вы уверены что хотите покинуть команду?",
    "array" => "Значение поля :attribute должно быть массивом.",
    "ascii" => "Значение поля :attribute должно содержать только однобайтовые цифро-буквенные символы.",
    "attached" => "Значение поля :attribute уже прикреплено.",
    "attributes.team" => "команда",
    "before" => "Значение поля :attribute должно быть датой до :date.",
    "before_or_equal" => "Значение поля :attribute должно быть датой до или равной :date.",
    "between" => [
        "array" => "Количество элементов в поле :attribute должно быть между :min и :max.",
        "file" => "Размер файла в поле :attribute должен быть между :min и :max Кб.",
        "numeric" => "Значение поля :attribute должно быть между :min и :max.",
        "string" => "Количество символов в поле :attribute должно быть между :min и :max.",
    ],    
    "boolean" => "Значение поля :attribute должно быть логического типа.",
    "confirmed" => "Значение поля :attribute не совпадает с подтверждаемым.",
    "country" => "Значение поля :attribute должно содержать название настоящей страны.",
    "create_team" => "Создание команды",
    "current_password" => "Неверный пароль.",
    "current_teams" => "Текущие команды",
    "date" => "Значение поля :attribute не является датой.",
    "date_equals" => "Значение поля :attribute должно быть датой равной :date.",
    "date_format" => "Значение поля :attribute не соответствует формату даты :format.",
    "decimal" => "Значение поля :attribute должно содержать :decimal цифр десятичных разрядов.",
    "declined" => "Поле :attribute должно быть отклонено.",
    "declined_if" => "Поле :attribute должно быть отклонено, когда :other равно :value.",
    "delete_team" => "Удалить команду",
    "different" => "Значения полей :attribute и :other должны различаться.",
    "digits" => "Количество символов в поле :attribute должно быть равным :digits.",
    "digits_between" => "Количество символов в поле :attribute должно быть между :min и :max.",
    "dimensions" => "Изображение, указанное в поле :attribute, имеет недопустимые размеры.",
    "distinct" => "Значения поля :attribute не должны повторяться.",
    "doesnt_end_with" => "Значение поля :attribute не может заканчиваться одним из следующих: :values.",
    "doesnt_start_with" => "Значение поля :attribute не может начинаться с одного из следующих: :values.",
    "edit_team_member" => "Редактировать участника команды",
    "email" => "Значение поля :attribute должно быть действительным электронным адресом.",
    "ends_with" => "Значение поля :attribute должно заканчиваться одним из следующих: :values",
    "enum" => "Значение поля :attribute некорректно.",
    "exists" => "Значение поля :attribute не существует.",
    "failed" => "Неверное имя пользователя или пароль.",
    "file" => "В поле :attribute должен быть указан файл.",
    "filled" => "Значение поля :attribute обязательно для заполнения.",
    "gt" => [
        "gt.array" => "Количество элементов в поле :attribute должно быть больше :value.",
        "gt.file" => "Размер файла, указанный в поле :attribute, должен быть больше :value Кб.",
        "gt.numeric" => "Значение поля :attribute должно быть больше :value.",
        "gt.string" => "Количество символов в поле :attribute должно быть больше :value.",
    ],
    "gte" => [
        "gte.array" => "Количество элементов в поле :attribute должно быть :value или больше.",
        "gte.file" => "Размер файла, указанный в поле :attribute, должен быть :value Кб или больше.",
        "gte.numeric" => "Значение поля :attribute должно быть :value или больше.",
        "gte.string" => "Количество символов в поле :attribute должно быть :value или больше.",
    ],
    "if_you_delete_team_all_data_will_be_deleted" => "Если Вы решите удалить команду, все данные будут безвозвратно удалены.",
    "image" => "Файл, указанный в поле :attribute, должен быть изображением.",
    "in" => "Значение поля :attribute некорректно.",
    "in_array" => "Значение поля :attribute не существует в :other.",
    "integer" => "Значение поля :attribute должно быть целым числом.",
    "ip" => "Значение поля :attribute должно быть действительным IP-адресом.",
    "ipv4" => "Значение поля :attribute должно быть действительным IPv4-адресом.",
    "ipv6" => "Значение поля :attribute должно быть действительным IPv6-адресом.",
    "json" => "Значение поля :attribute должно быть JSON строкой.",
    "leave_team" => "Покинуть команду",
    "looks_like_you_are_not_part_of_team" => "Похоже, вы не являетесь частью какой-либо команды!",
    "lowercase" => "Значение поля :attribute должно быть в нижнем регистре.",
    "lt" => [
        "lt.array" => "Количество элементов в поле :attribute должно быть меньше :value.",
        "lt.file" => "Размер файла, указанный в поле :attribute, должен быть меньше :value Кб.",
        "lt.numeric" => "Значение поля :attribute должно быть меньше :value.",
        "lt.string" => "Количество символов в поле :attribute должно быть меньше :value.",
    ],
    "lte" => [
        "lte.array" => "Количество элементов в поле :attribute должно быть :value или меньше.",
        "lte.file" => "Размер файла, указанный в поле :attribute, должен быть :value Кб или меньше.",
        "lte.numeric" => "Значение поля :attribute должно быть равным или меньше :value.",
        "lte.string" => "Количество символов в поле :attribute должно быть :value или меньше.",
    ],
    "mac_address" => "Значение поля :attribute должно быть корректным MAC-адресом.",
    "max" => [
        "max.array" => "Количество элементов в поле :attribute не может превышать :max.",
        "max.file" => "Размер файла в поле :attribute не может быть больше :max Кб.",
        "max.numeric" => "Значение поля :attribute не может быть больше :max.",
        "max.string" => "Количество символов в значении поля :attribute не может превышать :max.",
    ],
    "max_digits" => "Значение поля :attribute не должно содержать больше :max цифр.",
    "member" => " Участник",
    "mimes" => "Файл, указанный в поле :attribute, должен быть одного из следующих типов: :values.",
    "mimetypes" => "Файл, указанный в поле :attribute, должен быть одного из следующих типов: :values.",
    "min" => [

    ],
    "min" => [
        "array" => "Количество элементов в поле :attribute должно быть не меньше :min.",
        "file" => "Размер файла, указанный в поле :attribute, должен быть не меньше :min Кб.",
        "numeric" => "Значение поля :attribute должно быть не меньше :min.",
        "string" => "Количество символов в поле :attribute должно быть не меньше :min.",
    ],
    "min_digits" => "Значение поля :attribute должно содержать не меньше :min цифр.",
    "multiple_of" => "Значение поля :attribute должно быть кратным :value",
    "next" => "Вперёд &raquo;",
    "not_eligible_based_on_current_members_teams" => "Вы не имеете права на этот план из-за Вашего текущего количества команд либо участников команды.",
    "not_in" => "Значение поля :attribute некорректно.",
    "not_regex" => "Значение поля :attribute имеет некорректный формат.",
    "numeric" => "Значение поля :attribute должно быть числом.",
    "password" => "Некорректный пароль.",
    "password" => [
        "letters" => "Значение поля :attribute должно содержать хотя бы одну букву.",
        "mixed" => "Значение поля :attribute должно содержать хотя бы одну прописную и одну строчную буквы.",
        "numbers" => "Значение поля :attribute должно содержать хотя бы одну цифру.",
        "symbols" => "Значение поля :attribute должно содержать хотя бы один символ.",
        "uncompromised" => "Значение поля :attribute обнаружено в утёкших данных. Пожалуйста, выберите другое значение для :attribute.",
    ],
    "plan_allows_no_more_teams" => "Ваш текущий план не позволяет Вам создавать больше команд.",
    "please_upgrade_to_add_more_members" => "Обновите подписку, чтобы добавить больше участников в команду.",
    "please_upgrade_to_create_more_teams" => "Обновите подписку, чтобы создать больше команд.",
    "present" => "Значение поля :attribute должно быть.",
    "previous" => "&laquo; Назад",
    "prohibited" => "Значение поля :attribute запрещено.",
    "prohibited_if" => "Значение поля :attribute запрещено, когда :other равно :value.",
    "prohibited_unless" => "Значение поля :attribute запрещено, если :other не состоит в :values.",
    "prohibits" => "Значение поля :attribute запрещает присутствие :other.",
    "regex" => "Значение поля :attribute имеет некорректный формат.",
    "relatable" => "Значение поля :attribute не может быть связано с этим ресурсом.",
    "remove_team_member" => "Удаление участника команды",
    "required" => "Поле :attribute обязательно.",
    "required_array_keys" => "Массив в поле :attribute обязательно должен иметь ключи: :values",
    "required_if" => "Поле :attribute обязательно для заполнения, когда :other равно :value.",
    "required_if_accepted" => "Поле :attribute обязательно, когда :other принято.",
    "required_unless" => "Поле :attribute обязательно для заполнения, когда :other не равно :values.",
    "required_with" => "Поле :attribute обязательно для заполнения, когда :values указано.",
    "required_with_all" => "Поле :attribute обязательно для заполнения, когда :values указано.",
    "required_without" => "Поле :attribute обязательно для заполнения, когда :values не указано.",
    "required_without_all" => "Поле :attribute обязательно для заполнения, когда ни одно из :values не указано.",
    "reset" => "Ваш пароль был сброшен!",
    "same" => "Значения полей :attribute и :other должны совпадать.",
    "sent" => "Ссылка на сброс пароля была отправлена!",
    "size" => [
        "array" => "Количество элементов в поле :attribute должно быть равным :size.",
        "file" => "Размер файла, указанный в поле :attribute, должен быть равен :size Кб.",
        "numeric" => "Значение поля :attribute должно быть равным :size.",
        "string" => "Количество символов в поле :attribute должно быть равным :size.",
    ],
    "slug_input_explanation" => "Этот ЧПУ используется для идентификации Вашей команды в URL-адресах.",
    "starts_with" => "Поле :attribute должно начинаться с одного из следующих значений: :values",
    "state" => "Это состояние недействительно для указанной страны.",
    "string" => "Значение поля :attribute должно быть строкой.",
    "team" => "Команда",
    "team_billing" => "Счета команды",
    "team_members" => "Состав команды",
    "team_name" => "Имя команды",
    "team_name_was_updated" => "Имя команды успешно обновлено!",
    "team_photo" => "Фото команды",
    "team_profile" => "Профиль команды",
    "team_settings" => "Настройки команды",
    "team_slug" => "ЧПУ команды",
    "team_trial" => "Пробный период команды",
    "team_trial_will_expire_on" => "Пробный период команды истекает :date.",
    "teams" => "Команды",
    "teams_currently_trialing" => "Испытания команд в настоящее время",
    "throttle" => "Слишком много попыток входа. Пожалуйста, попробуйте ещё раз через :seconds секунд.",
    "throttled" => "Пожалуйста, подождите перед повторной попыткой.",
    "timezone" => "Значение поля :attribute должно быть действительным часовым поясом.",
    "token" => "Ошибочный код сброса пароля.",
    "ulid" => "Значение поля :attribute должно быть корректным ULID.",
    "unique" => "Такое значение поля :attribute уже существует.",
    "update_team_name" => "Обновление имени команды",
    "uploaded" => "Загрузка файла из поля :attribute не удалась.",
    "uppercase" => "Значение поля :attribute должно быть в верхнем регистре.",
    "url" => "Значение поля :attribute имеет ошибочный формат URL.",
    "user" => "Не удалось найти пользователя с указанным электронным адресом.",
    "user_already_invited_to_team" => "Этот пользователь уже приглашён в состав команды.",
    "user_already_on_team" => "Этот пользователь уже находится в составе команды.",
    "user_doesnt_belong_to_team" => "Пользователь не принадлежит к этой команде.",
    "user_invited_to_join_team" => ":UserName пригласил Вас присоединиться к команде!",
    "uuid" => "Значение поля :attribute должно быть корректным UUID.",
    "vat_id" => "Идентификатор плательщика НДС указан неверно.",
    "view_all_teams" => "Показать все команды",
    "we_found_invitation_to_team" => "Мы нашли Ваше приглашение в команду :teamName!",
    "wheres_your_team" => "Где Ваша команда?",
    "you_have_been_invited_to_join_team" => "Вас пригласили присоединиться к команде :teamName!",
    "you_have_x_invitations_remaining" => "В настоящее время у Вас осталось :count приглашений(я).",
    "you_have_x_teams_remaining" => "В настоящее время у Вас :teamCount команд(ы).",

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

    'attributes' => [
        "name" => "'Имя'",
        "last_name" => "'Фамилия'",
        "phone_number" => "'Номер телефона'",
        "password" => "'Пароль'",
        "coffeePot_id" => "'Кофейня'",
        "agreement" => "'Согласие на обработку персональных данных'",
        "value" => "'Параметр'",
        "address" => "'Адрес'",
        "text" => "'Текст'",
        "site" => "'Внутри сайта'",
        "telegram" => "'Телеграм'",
        "email" => "'Адрес электронной почты'"
    ],

];
