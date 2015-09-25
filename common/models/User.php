<?php

class User extends CActiveRecord {

    public $cache;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{user}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, city_id, roles_id', 'required'),
            array(' city_id, created_user_id', 'numerical', 'integerOnly' => true),
            array('username, phone', 'length', 'max' => 20),
            array('', 'length', 'max' => 100),
            array('password, name,description, address', 'length', 'max' => 255),
            array('code', 'length', 'max' => 25),
            array('modified, enabled', 'safe'),
            array('username, email', 'unique', 'message' => '{attribute} : {value} already exists!', 'on' => 'allow'),
            array('email', 'email', 'on' => 'allow'),
            array('username, email', 'required', 'on' => 'allow'),
            array('username, email', 'safe', 'message' => '{attribute} : {value} already exists!', 'on' => 'notAllow'),
            array('id, username, email, password, code, name, city_id, address, phone, created, created_user_id, modified,description', 'safe', 'on' => 'search'),
            array('avatar_img', 'unsafe'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'code' => 'Kode',
            'name' => 'Nama',
            'province_id' => 'Propinsi',
            'city_id' => 'Kota/ Kabupaten',
            'address' => 'Alamat',
            'phone' => 'No. Telephone',
            'created' => 'Created',
            'created_user_id' => 'Created Userid',
            'modified' => 'Modified',
        );
    }

    public function search($type = 'user') {
        $criteria = new CDbCriteria;
        $criteria->with = array('Roles');
        $criteria->together = true;

        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);
//        $criteria->compare('password', $this->password, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('roles_id', $this->roles_id, true);
        if ($type == 'customer') {
//            $criteria->alias = "u";
            $siteConfig = SiteConfig::model()->listSiteConfig();
            $sCriteria = json_decode($siteConfig->roles_customer, true);
            $criteria->addInCondition('roles_id', $sCriteria);
        } elseif ($type == 'user') {
            $criteria->compare('Roles.is_allow_login', '1', true);
        } elseif ($type == 'supplier') {
//            $criteria->alias = "u";
            $siteConfig = SiteConfig::model()->listSiteConfig();
            $sCriteria = json_decode($siteConfig->roles_supplier, true);
            $criteria->addInCondition('roles_id', $sCriteria);
        } elseif ($type == 'employment') {
//            $criteria->alias = "u";
            $siteConfig = SiteConfig::model()->listSiteConfig();
            $sCriteria = json_decode($siteConfig->roles_employment, true);
            $criteria->addInCondition('roles_id', $sCriteria);
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    public function listUser() {
        if (!app()->session['listUser']) {
            $result = array();
            $users = $this->findAll(array('index' => 'id'));
            app()->session['listUser'] = $users;
        }

        return app()->session['listUser'];
    }
    
    public function listPegawai(){
        $pegawai = $this->model()->findAll(array('condition' => 'roles_id=3 OR roles_id=7 OR roles_id=13'));
        return $pegawai;
    }

    public function listUserPhone() {
        if (!app()->session['listUserPhone']) {
            $result = array();
            $users = $this->findAll(array('index' => 'phone'));
            app()->session['listUserPhone'] = $users;
        }

        return app()->session['listUserPhone'];
    }

    public function roles() {
        $result = Roles::model()->findAll();
        return $result;
    }

    public function role($user_id) {
        $role = User::model()->findByPk($user_id);

        if (isset($role->Roles->name)) {
            $result = $role->Roles->name;
        } else {
            $result = '';
        }

        return $result;
    }

    public function listUsers($type = '') {
        $siteConfig = SiteConfig::model()->listSiteConfig();
        if ($type == 'user') {
//             $criteria->with = array('Roles');
//            $criteria->together = true;
            $sResult = User::model()->with('Roles')->findAll(array('condition' => 'Roles.is_allow_login=1'));
        } elseif ($type == 'supplier') {
            $sCriteria = json_decode($siteConfig->roles_supplier, true);
            if(!empty($sCriteria)){
            $list = '';
            foreach ($sCriteria as $o) {
                $list .= '"' . $o . '",';
            }
            $list = substr($list, 0, strlen($list) - 1);
            $sResult = User::model()->findAll(array('condition' => 'roles_id in(' . $list . ')'));
            }else{
               $sResult=array(); 
            }
        } elseif ($type == 'customer') {
            $sCriteria = json_decode($siteConfig->roles_customer, true);
            if(!empty($sCriteria)){
            $list = '';
            foreach ($sCriteria as $o) {
                $list .= '"' . $o . '",';
            }
            $list = substr($list, 0, strlen($list) - 1);
            $sResult = User::model()->findAll(array('condition' => 'roles_id in(' . $list . ')'));
            }else{
                $sResult=array();
            }
        } elseif ($type == 'contact') {
            $sCriteria = json_decode($siteConfig->roles_contact, true);
            if(!empty($sCriteria)){
            $list = '';
            foreach ($sCriteria as $o) {
                $list .= '"' . $o . '",';
            }
            $list = substr($list, 0, strlen($list) - 1);
            $sResult = User::model()->findAll(array('condition' => 'roles_id in(' . $list . ')'));
            }else{
                $sResult=array();
            }
        } elseif ($type == 'client') {
            $sCriteria = json_decode($siteConfig->roles_client, true);
            if(!empty($sCriteria)){
            $list = '';
            foreach ($sCriteria as $o) {
                $list .= '"' . $o . '",';
            }
            $list = substr($list, 0, strlen($list) - 1);
            $sResult = User::model()->findAll(array('condition' => 'roles_id in(' . $list . ')'));
            }else{
                $sResult=array();
            }
        } elseif ($type == 'guest') {
            $sCriteria = json_decode($siteConfig->roles_guest, true);
            if(!empty($sCriteria)){
            $list = '';
            foreach ($sCriteria as $o) {
                $list .= '"' . $o . '",';
            }
            $list = substr($list, 0, strlen($list) - 1);
            $sResult = User::model()->findAll(array('condition' => 'roles_id in(' . $list . ')'));
            }else{
                $sResult=array();
            }
        } elseif ($type == 'employment') {
            $sCriteria = json_decode($siteConfig->roles_employment, true);
            if(!empty($sCriteria)){
            $list = '';
            foreach ($sCriteria as $o) {
                $list .= '"' . $o . '",';
            }
            $list = substr($list, 0, strlen($list) - 1);
            $sResult = User::model()->findAll(array('condition' => 'roles_id in(' . $list . ')'));
            }else{
                $sResult=array();
            }
        }
        return $sResult;
    }

    public function typeRoles($sType = 'user') {
        $siteConfig = SiteConfig::model()->listSiteConfig();
        $result = array();

        if ($sType == 'user') {
            if (Yii::app()->user->roles_id == -1) {
                $array = array(-1 => 'Super User');
            } else {
                $array = array();
            }

            $sResult = Roles::model()->findAll(array('condition' => 'is_allow_login=1'));
            $result = $array + Chtml::listdata($sResult, 'id', 'name');
        } elseif ($sType == 'customer') {
            $customers = json_decode($siteConfig->roles_customer, true);
            $list = '';
            foreach ($customers as $customer) {
                $list .= '"' . $customer . '",';
            }
            $list = substr($list, 0, strlen($list) - 1);
            $sResult = Roles::model()->findAll(array('condition' => 'id in(' . $list . ')'));
            $result = Chtml::listdata($sResult, 'id', 'name');
        } elseif ($sType == 'supplier') {
            $customers = json_decode($siteConfig->roles_supplier, true);
            $list = '';
            foreach ($customers as $customer) {
                $list .= '"' . $customer . '",';
            }
            $list = substr($list, 0, strlen($list) - 1);
            $sResult = Roles::model()->findAll(array('condition' => 'id in(' . $list . ')'));
            $result = Chtml::listdata($sResult, 'id', 'name');
        } elseif ($sType == 'employment') {
            $customers = json_decode($siteConfig->roles_employment, true);
            $list = '';
            foreach ($customers as $customer) {
                $list .= '"' . $customer . '",';
            }
            $list = substr($list, 0, strlen($list) - 1);
            $sResult = Roles::model()->findAll(array('condition' => 'id in(' . $list . ')'));
            $result = Chtml::listdata($sResult, 'id', 'name');
        }


        return $result;
    }

    public function relations() {
        return array(
            'City' => array(self::BELONGS_TO, 'City', 'city_id'),
            'Payment' => array(self::HAS_MANY, 'Payment', 'id'),
            'FormBuilder' => array(self::HAS_MANY, 'FormBuilder', 'id'),
            'Roles' => array(self::BELONGS_TO, 'Roles', 'roles_id'),
            'UserLog' => array(self::HAS_MANY, 'UserLog', 'id'),
        );
    }
    
    public function validatePassword($password) {
        return $this->hashPassword($password) === $this->password;
    }

    public function hashPassword($password) {
        return sha1($password);
    }

    public function getUrlFull() {
        return param('urlImg') . $this->DownloadCategory->path . $this->url;
    }

    public function getUrlDel() {
        return createUrl('download/' . $this->Download->id);
    }

    public function getImgUrl() {
        return landa()->urlImg('avatar/', $this->avatar_img, $this->id);
    }

    public function getUrl() {

        return url('user/' . $this->id);
    }

    public function getTagImg() {
        return '<img src="' . $this->imgUrl['small'] . '" class="img-polaroid" width="50"/><br>';
    }

    public function getMediumImage() {
        return '<img src="' . $this->imgUrl['medium'] . '" class="img-polaroid"/><br>';
    }

    public function getTagBiodata() {
        $code = (isset($this->code)) ? $this->code : '';
        $province = (isset($this->City->Province->name ))? $this->City->Province->name  : '';
        $city = (isset( $this->City->name)) ?  $this->City->name : '';
        
        return '<div class="row-fluid">
                    <div class="span3">
                        <b>Kode</b>
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        ' . $code . '
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span3">
                        <b>Nama</b>
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        ' . $this->name . '
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span3">
                        <b>Provinsi</b>
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        ' . $province. '
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span3">
                        <b>Kota/Kab</b>
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        ' . $city . '
                    </div>
                </div>
                     <div class="row-fluid">
                    <div class="span3">
                        <b>Telepon</b>
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        +62' . $this->phone . '
                    </div>
                </div>
                ';
    }

    public function getTagAccess() {
        $username = (!empty($this->username)) ? "
            <div class=\"row-fluid\">
                    <div class=\"span3\">
                        <b>Username</b>
                    </div>
                    <div class=\"span1\">:</div>
                    <div class=\"span8\" style=\"text-align:left\">
                         $this->username 
                    </div>
                </div>" : '';
        $email = (!empty($this->email)) ? "
            <div class=\"row-fluid\">
                    <div class=\"span3\">
                        <b>E-mail</b>
                    </div>
                    <div class=\"span1\">:</div>
                    <div class=\"span8\" style=\"text-align:left\">
                         $this->email 
                    </div>
                </div>" : "";
        $enabled = ($this->enabled == 0) ? "<span class=\"label label-important\">No</span>" :
                "<span class=\"label label-info\">Yes</span>";
        return '' . $username . '
                <div class="row-fluid">
                    <div class="span3">
                        <b>Permission</b>
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        ' . $this->Roles->name . '
                    </div>
                </div>
                ' . $email . '
                <div class="row-fluid">
                    <div class="span3">
                        <b>Enabled</b>
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        ' . $enabled . '
                    </div>
                </div>';
    }


}
