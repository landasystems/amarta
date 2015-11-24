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
            array('name, roles_id', 'required'),
            array('created_user_id', 'numerical', 'integerOnly' => true),
            array('username, phone', 'length', 'max' => 20),
            array('', 'length', 'max' => 100),
            array('password, name,description, address', 'length', 'max' => 255),
            array('code', 'length', 'max' => 25),
            array('modified, enabled', 'safe'),
            array('username, email', 'unique', 'message' => '{attribute} : {value} already exists!', 'on' => 'allow'),
            array('email', 'email', 'on' => 'allow'),
            array('username, email', 'required', 'on' => 'allow'),
            array('username, email', 'safe', 'message' => '{attribute} : {value} already exists!', 'on' => 'notAllow'),
            array('id, username, email, password, code, name, address, phone, created, created_user_id, modified,description', 'safe', 'on' => 'search'),
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
        $criteria->compare('code', $this->code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('phone', $this->phone, true);
        if ($type == 'user') {
            $criteria->compare('roles_id', -1);
        } elseif ($type == 'customer') {
            $criteria->compare('roles_id', 1);
        }else{ // lainnya penjahit
            $criteria->compare('roles_id', 3);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function listUser() {
        return $this->findAll(array('index' => 'id'));
    }

    public function listPegawai() {
        $pegawai = $this->model()->findAll(array('condition' => 'roles_id=3 OR roles_id=7 OR roles_id=13'));
        return $pegawai;
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
            $sResult = User::model()->with('Roles')->findAll(array('condition' => 'Roles.is_allow_login=1'));
        } elseif ($type == 'customer') {
            $sResult = User::model()->with('Roles')->findAll(array('condition' => 'roles_id=1'));
        } elseif ($type == 'employment') {
            $sResult = User::model()->with('Roles')->findAll(array('condition' => 'roles_id<>1 AND Roles.is_allow_login=0'));
        }
        return $sResult;
    }

    public function typeRoles($sType = 'user') {
        $sResult = $this->listUsers($sType);
        $result = Chtml::listdata($sResult, 'id', 'name');
        return $result;
    }

    public function relations() {
        return array(
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

    public function getImgUrl() {
        return landa()->urlImg('avatar/', $this->avatar_img, $this->id);
    }

    public function getUrl() {
        return url('user/' . $this->id);
    }

    public function getTagImg() {
        return '<img src="' . $this->imgUrl['small'] . '" class="img-polaroid" style="width:30px"/><br>';
    }

    public function getMediumImage() {
        return '<img src="' . $this->imgUrl['medium'] . '" class="img-polaroid"/><br>';
    }

    public function getTagBiodata() {
        $code = (isset($this->code)) ? $this->code : '';

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
