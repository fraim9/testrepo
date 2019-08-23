<?php

namespace App;

class AclResources extends AppModelList {
    
    protected function _init()
    {
        $this->_add('backendAccess', 'Access to OmniPOS BackOffice', ['group' => AclResourceGroups::MAIN]);
        
        $this->_add('users', 'User management', ['group' => AclResourceGroups::USERS]);
        $this->_add('userGroups', 'Setting up user groups', ['group' => AclResourceGroups::USERS]);
        $this->_add('aclRoles', 'Setting up ACL Roles', ['group' => AclResourceGroups::USERS]);
        
        $this->_add('settings', 'Access to general settings', ['group' => AclResourceGroups::SETTINGS]);
        
        $this->_add('stores', 'Setting stores', ['group' => AclResourceGroups::STORES]);
        $this->_add('storeGroups', 'Setting up store groups', ['group' => AclResourceGroups::STORES]);
        $this->_add('prices', 'Setting price types', ['group' => AclResourceGroups::STORES]);

        $this->_add('employees', 'Access to company employees', ['group' => AclResourceGroups::COMPANY]);
        $this->_add('divisions', 'Access to company divisions', ['group' => AclResourceGroups::COMPANY]);
        $this->_add('companyInfo', 'Access to company information', ['group' => AclResourceGroups::COMPANY]);
        
        $this->_add('clients', 'Access to clients', ['group' => AclResourceGroups::CRM]);

        $this->_add('amlQuestionnaires', 'Questionnaires', ['group' => AclResourceGroups::AML]);

        
        $this->_add('apiReceiveClients', 'Receive Clients personal data', ['group' => AclResourceGroups::API]);
        $this->_add('apiReceiveSmallAML', 'Receive small AML questionnaires', ['group' => AclResourceGroups::API]);
        $this->_add('apiReceiveFiles', 'Receive files from OmniPOS', ['group' => AclResourceGroups::API]);

        
    }
    
}

