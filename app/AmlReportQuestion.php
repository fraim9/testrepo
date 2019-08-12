<?php

namespace App;


class AmlReportQuestion extends AppModelList {
    
    
    protected function _init() 
    {
        $this->_add(
                'q_1', 
                'Фамилия, имя, отчество (при наличии)',
                [
                        'num' => '1',
                        'descr' => '',
                        'type' => 'name',
                        'default' => '',
                ]);
        $this->_add(
                'q_2', 
                'Дата рождения',
                [
                        'num' => '2',
                        'descr' => '',
                        'type' => 'birth_date',
                        'default' => '',
                ]);
        $this->_add(
                'q_3', 
                'Гражданство',
                [
                        'num' => '3',
                        'descr' => '',
                        'type' => 'citizenhip',
                        'default' => '',
                ]);
        $this->_add(
                'q_4', 
                'Реквизиты документа, удостоверяющего личность',
                [
                        'num' => '4',
                        'descr' => 'серия (при наличии) и номер документа, дата выдачи документа, 
                                    наименование органа, выдавшего документ, и код подразделения 
                                    (при наличии)',
                        'type' => 'passport',
                        'default' => '',
                ]);
        $this->_add(
                'q_5', 
                'Данные миграционной карты: номер карты, дата начала срока пребывания и дата 
                 окончания срока пребывания в Российской Федерации',
                [
                        'num' => '5',
                        'descr' => 'Сведения, указанные в настоящем пункте, устанавливаются в отношении 
                                    иностранных граждан и лиц без гражданства, находящихся на территории Российской 
                                    Федерации, в случае если необходимость наличия у них миграционной карты предусмотрена 
                                    законодательством Российской Федерации',
                        'type' => 'migration',
                        'default' => '',
                ]);
        $this->_add(
                'q_6', 
                'Данные документа, подтверждающего право иностранного гражданина или лица 
                 без гражданства на пребывание (проживание) в Российской Федерации',
                [
                        'num' => '6',
                        'descr' => 'серия (если имеется) и номер документа, дата начала срока действия 
                                    права пребывания (проживания), дата окончания срока действия права 
                                    пребывания (проживания). Сведения, указанные в настоящем пункте,
                                    устанавливаются в отношении иностранных граждан и лиц без гражданства, 
                                    находящихся на территории Российской Федерации, в случае если 
                                    необходимость наличия у них документа, подтверждающего право 
                                    иностранного гражданина или лица без гражданства на пребывание 
                                    (проживание) в Российской Федерации, предусмотрена законодательством 
                                    Российской Федерации',
                        'type' => 'permission',
                        'default' => '',
                ]);
        $this->_add(
                'q_7', 
                'Адрес места жительства (регистрации) или места пребывания',
                [
                        'num' => '7',
                        'descr' => '',
                        'type' => 'address',
                        'default' => '',
                ]);
        $this->_add(
                'q_8', 
                'Идентификационный номер налогоплательщика (при наличии)',
                [
                        'num' => '8',
                        'descr' => '',
                        'type' => 'inn',
                        'default' => 'Отсутствует',
                ]);
        $this->_add(
                'q_8_1', 
                'Информация о страховом номере индивидуального лицевого счета застрахованного 
                 лица в системе обязательного пенсионного страхования (при наличии)',
                [
                        'num' => '8.1',
                        'descr' => '',
                        'type' => 'text',
                        'default' => 'Отсутствует',
                ]);
        $this->_add(
                'q_9', 
                'Контактная информация (например, номер телефона, факса, адрес электронной почты, 
                 почтовый адрес (при наличии)',
                [
                        'num' => '9',
                        'descr' => '',
                        'type' => 'contacts',
                        'default' => 'Отсутствует',
                ]);
        $this->_add(
                'q_10', 
                'Должность клиента, являющегося лицом, указанным в подпункте 1 пункта 1 
                 статьи 7.3 Федерального закона',
                [
                        'num' => '10',
                        'descr' => '',
                        'type' => 'text',
                        'default' => 'К указанным лицам не принадлежит',
                ]);
        $this->_add(
                'q_11', 
                'Степень родства либо статус клиента по отношению к лицу, указанному в подпункте 
                 1 пункта 1 статьи 7.3 Федерального закона',
                [
                        'num' => '11',
                        'descr' => '',
                        'type' => 'text',
                        'default' => 'Родственником указанных лиц не является',
                ]);
        $this->_add(
                'q_12', 
                'Сведения о целях установления и предполагаемом характере деловых отношений',
                [
                        'num' => '12',
                        'descr' => '',
                        'type' => 'text',
                        'default' => 'Сведения не устанавливаются в связи с присвоением клиенту низкой степени уровня риска',
                ]);
        $this->_add(
                'q_13', 
                'Сведения о финансовом положении',
                [
                        'num' => '13',
                        'descr' => '',
                        'type' => 'text',
                        'default' => 'Сведения не устанавливаются в связи с присвоением клиенту низкой степени уровня риска',
                ]);
        $this->_add(
                'q_14', 
                'Сведения об источниках происхождения денежных средств и (или) иного имущества клиента',
                [
                        'num' => '14',
                        'descr' => '',
                        'type' => 'text',
                        'default' => 'сведения не устанавливались, т.к. ООО не реализовало указанное право',
                ]);
        $this->_add(
                'q_15', 
                'Сведения, подтверждающие наличие у лица полномочий представителя клиента, - наименование, 
                 дата выдачи, срок действия, номер документа, на котором основаны полномочия представителя клиента',
                [
                        'num' => '15',
                        'descr' => '',
                        'type' => 'text',
                        'default' => 'Представитель отсутствует',
                ]);
        $this->_add(
                'q_16', 
                'Сведения о бенефициарном владельце (бенефициарных владельцах) клиента, сведения о 
                 принятых ООО мерах по идентификации физического лица в качестве бенефициарного 
                 владельца клиента и их результатах, а также сведения о бенефициарном владельце, 
                 представленные клиентом, и сведения о бенефициарном владельце клиента, установленные ООО',
                [
                        'num' => '16',
                        'descr' => '',
                        'type' => 'text',
                        'default' => 'Проведен устный опрос клиента. Бенефициарным владельцем клиента является это лицо, т.к. отсутствуют основания полагать, что бенефициарным владельцем является иное физическое лицо',
                ]);
        $this->_add(
                'q_17', 
                'Результаты проверки наличия или отсутствия в отношении клиента, представителя клиента, 
                 выгодоприобретателя и бенефициарного владельца сведений об их причастности к экстремистской 
                 деятельности или терроризму, распространению оружия массового уничтожения',
                [
                        'num' => '17',
                        'descr' => 'полученных в соответствии с пунктом 2 статьи 6, пунктом 2 статьи 7.4 и абзацем вторым пункта 1 статьи 7.5 Федерального закона',
                        'type' => 'text',
                        'default' => 'На %DATE% к экстремистской деятельности или терроризму не причастен; к распространению оружия массового уничтожения не причастен; решения о замораживании/блокировании денежных средств или иного имущества отсутствуют',
                ]);
        $this->_add(
                'q_18', 
                'Сведения о принадлежности клиента (регистрация, место жительства, место нахождения, наличие счета в банке) к государству (территории), которое (которая) не выполняет рекомендации Группы разработки финансовых мер борьбы с отмыванием денег (ФАТФ)',
                [
                        'num' => '18',
                        'descr' => '',
                        'type' => 'text',
                        'default' => 'Не принадлежит к указанным государствам (территориям)',
                ]);
        $this->_add(
                'q_19', 
                'Сведения о принадлежности клиента к:
<br>а) юридическим лицам, прямо или косвенно находящимся в собственности или под контролем организации или физического лица, в отношении которых подлежат применению меры по замораживанию (блокированию) денежных средств или иного имущества в соответствии с подпунктом 6 пункта 1 статьи 7 и пунктом 5 статьи 7.5 Федерального закона;
<br>б) физическим или юридическим лицам, действующим от имени или по указанию организации или физического лица, в отношении которых подлежат применению меры по замораживанию (блокированию) денежных средств или иного имущества в соответствии с подпунктом 6 пункта 1 статьи 7 и пунктом 5 статьи 7.5 Федерального закона;
<br>в) физическим или юридическим лицам, чьи операции с денежными средствами или иным имуществом приостановлены по решению суда в соответствии с частью четвертой статьи 8 Федерального закона.',
                [
                        'num' => '19',
                        'descr' => '',
                        'type' => 'text',
                        'default' => 'Не принадлежит к указанным лицам',
                ]);
        $this->_add(
                'q_20', 
                'Сведения о степени (уровне) риска совершения клиентом операций в целях легализации (отмывания) доходов, полученных преступным путем, или финансирования терроризма, включая обоснование оценки',
                [
                        'num' => '20',
                        'descr' => '',
                        'type' => 'text',
                        'default' => 'Присвоен низкий уровень риска, повышенный риск отсутствует, т.к. у клиента нет факторов, влияющих на отнесение риска к повышенному уровню, приведенных в ПВК по ПОД/ФТ/ФРОМУ',
                ]);
        $this->_add(
                'q_21', 
                'Дата начала отношений с клиентом, а также дата прекращения отношений с клиентом',
                [
                        'num' => '21',
                        'descr' => '',
                        'type' => 'text',
                        'default' => "Дата начала отношений %DATE% \nДата прекращения %DATE%",
                ]);
        $this->_add(
                'q_22', 
                'Дата оформления анкеты, даты обновлений анкеты (досье) клиента',
                [
                        'num' => '22',
                        'descr' => '',
                        'type' => 'text',
                        'default' => 'Дата оформления анкеты %DATE%',
                ]);
        $this->_add(
                'q_23', 
                'Фамилия, имя, отчество (при наличии), должность работника, принявшего решение о приеме клиента на обслуживание, а также работника, заполнившего (обновившего) анкету клиента',
                [
                        'num' => '23',
                        'descr' => '',
                        'type' => 'employee',
                        'default' => '',
                ]);
        $this->_add(
                'q_24', 
                'Подпись уполномоченного работника в случае ведения анкеты на бумажном носителе',
                [
                        'num' => '24',
                        'descr' => '',
                        'type' => 'empty',
                        'default' => '',
                ]);
        $this->_add(
                'q_25', 
                'Иные сведения, необходимые для реализации требований к идентификации клиентов, представителей клиента, выгодоприобретателей и бенефициарных владельцев, в том числе с учетом степени (уровня) риска совершения операций в целях легализации (отмывания) доходов, полученных преступным путем, и финансирования терроризма',
                [
                        'num' => '25',
                        'descr' => '',
                        'type' => 'text',
                        'default' => 'Отсутствуют',
                ]);
        
    }
    
    public function setAmlMini($amlMini)
    {
        // проверка на публичное лицо или гражданство рисковой страны 
        if ($amlMini->questionnaire['PublicOfficial']) {
            $this->_items['q_20']->default = 'Повышенный. Клиент и/или выгодоприобретателями и/или бенефициарными владельцами клиента являются иностранные публичные должностные лица, их супруги, близкие родственники';
        } else if ($amlMini->citizenship->aml_risk) {
            $this->_items['q_20']->default = 'Повышенный. Гражданство страны, входящей в перечень стран с высоким риском';
        }
    }
    
}

