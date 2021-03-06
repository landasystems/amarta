<?php

/**
 * This is the model class for table "{{product}}".
 *
 * The followings are the available columns in table '{{product}}':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $product_brand_id
 * @property integer $product_category_id
 * @property integer $product_measure_id
 * @property string $departement_id
 * @property string $type
 * @property string $description
 * @property integer $price
 * @property integer $discount
 * @property integer $stock
 * @property integer $product_photo_id
 * @property double $weight
 * @property double $width
 * @property double $height
 * @property double $length
 */
class Product extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Product the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{product}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('product_brand_id, product_category_id, product_measure_id, product_photo_id', 'numerical', 'integerOnly' => true),
            array('weight, width, height, length, price_sell, discount', 'numerical'),
            array('code', 'length', 'max' => 45),
            array('name,price_sell', 'required'),
            
            array('stock, name', 'length', 'max' => 255),
            array('type', 'length', 'max' => 10),
            array('description, assembly_product_id', 'safe'),
            // The following rule is used by search().
// Please remove those attributes that should not be searched.
            array('id, code, name, product_brand_id, product_category_id, product_measure_id, type, description, discount, stock, product_photo_id, weight, width, height, length', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'ProductBrand' => array(self::BELONGS_TO, 'ProductBrand', 'product_brand_id'),
            'ProductMeasure' => array(self::BELONGS_TO, 'ProductMeasure', 'product_measure_id'),
            'ProductCategory' => array(self::BELONGS_TO, 'ProductCategory', 'product_category_id'),
            'ProductPhoto' => array(self::BELONGS_TO, 'ProductPhoto', 'product_photo_id'),
            'InDet' => array(self::HAS_MANY, 'InDet', 'id'),
            'OpnameDetail' => array(self::HAS_MANY, 'OpnameDetail', 'id'),            
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Kode Produk',
            'name' => 'Nama',
            'product_brand_id' => 'Produk Merek',
            'product_category_id' => 'Produk Kategori',
            'product_measure_id' => 'Produk Satuan',
            'type' => 'Type',
            'description' => 'Keterangan',
            'discount' => 'Diskon',
            'stock' => 'Stock',
            'product_photo_id' => 'Product Photo',
            'weight' => 'Weight',
            'width' => 'Width',
            'height' => 'Height',
            'length' => 'Length',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($cat) {
// Warning: Please modify the following code to remove attributes that
// should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = array('ProductCategory');
        $criteria->with = array('ProductBrand');
        $criteria->together = true;

        $criteria->compare('id', $this->id);
        $criteria->compare('code', $this->code, true);
        $criteria->compare($this->getTableAlias(false, false) . '.name', $this->name, true);
        $criteria->compare('ProductBrand.name', $this->product_brand_id, true);
        $criteria->compare('product_category_id', $cat);
        $criteria->compare('product_measure_id', $this->product_measure_id);
        $criteria->compare('type', $this->type);



        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => $this->getTableAlias(false, false) . '.type Desc, '.$this->getTableAlias(false, false) . '.id Desc')
        ));
    }

    public function getImgUrl() {
        if (empty($this->product_photo_id) || empty($this->ProductPhoto->img)) {
            return landa()->urlImg('product/', '', '');
        } else {
            return landa()->urlImg('product/', $this->ProductPhoto->img, $this->ProductPhoto->id);
        }
    }

    public function getTagImg() {
        return '<img src="' . $this->imgUrl['small'] . '" class="img-polaroid" width="50" height="50"/><br>';
    }
    public function getImgVeriSmall() {
        return '<img src="' . $this->imgUrl['small'] . '" class="img-polaroid" width="50px" height="50px"/><br>';
    }

    public function getMediumImg() {
        return '<img src="' . $this->imgUrl['medium'] . '" class="img-polaroid"/><br>';
    }

    public function getUrl() {
        if (empty($this->ProductCategory->alias)) {
            return '#';
        } else {
            return url('detail/' . $this->ProductCategory->alias . '/' . $this->alias);
        }
    }

    public function getTagPublic() {
        if ($this->type == "inv") {
            $type = "Inventory";
        } else if ($this->type == "srv") {
            $type = "Services";
        } else {
            $type = "Assembly";
        }
                 
        $display ='<div class="row-fluid" align="left">
                    <div class="span3" align="left">
                        <b>Kode Produk</b>
                    </div>
                    <div class="span1" align="left">:</div>
                    <div class="span8" style="text-align:left">
                        ' . $this->code . '
                    </div>
                </div>';
        $display .='<div class="row-fluid" align="left">
                    <div class="span3" align="left">
                        <b>Nama</b>
                    </div>
                    <div class="span1" align="left">:</div>
                    <div class="span8" style="text-align:left">
                        ' . $this->name . '
                    </div>
                </div>';
        return $display;
    }

    public function getTagProduct() {
        $listProduct = Product::model()->listProduct();
        if ($this->type == 'inv') {
            $brandName = (isset($this->ProductBrand->name)) ? $this->ProductBrand->name : "";
            $categoryName = (isset($this->ProductCategory->name)) ? $this->ProductCategory->name : "";
            $measure = (!empty($this->product_measure_id))? $this->ProductMeasure->name:'';
            return '               
                <div class="row-fluid" align="left">
                    <div class="span3" align="left">
                        <b>Kategori</b>
                    </div>
                    <div class="span1" align="left">:</div>
                    <div class="span8" style="text-align:left">
                        ' . $categoryName . '
                    </div>
                </div>
                <div class="row-fluid" align="left">
                    <div class="span3" align="left">
                        <b>Satuan</b>
                    </div>
                    <div class="span1" align="left">:</div>
                    <div class="span8" style="text-align:left">
                        '.$measure.'
                    </div>
                </div>
                ';
        } else if ($this->type == 'assembly' && !empty($this->assembly_product_id)) {
            $assembly_product_id = json_decode($this->assembly_product_id);
            $product_id = $assembly_product_id->product_id;
            $qty = $assembly_product_id->qty;
//            $display = '<div class="label label-info" style="width:98%;">Product Assembly</div>';
            $display = '<div class="row-fluid" align="left">
                    <div class="span4" align="left">
                        <b>List Product</b>
                    </div>
                    <div class="span1" align="left">:</div>
                    
                </div>';
//            foreach ($product_id as $no => $data) {
//                $display.='<div class="row-fluid" align="left">
//                    <div class="span12" align="left">
//                       ~ ' . $qty[$no] . 'x '.$listProduct[$product_id[$no]]['name'] . '
//                    </div>
//     
//                </div>';
//            }
            foreach ($product_id as $no => $data) {
                $display.='<div class="1" style="text-align:left;padding-left:20px">
                        ~ ' . $qty[$no] . ' '.$listProduct[$product_id[$no]]['name'] . '
                    </div>';
            }
            return $display;
        }
    }

    public function getTagDimension() {
        if ($this->type == 'inv') {
            return '<div class="row-fluid" align="left">
                    <div class="span6" align="left">
                        <b>Weight</b>
                    </div>
                    <div class="span1" align="left">:</div>
                    <div class="span4" style="text-align:left">
                        ' . $this->weight . ' Kg
                    </div>
                </div>
                <div class="row-fluid" align="left">
                    <div class="span6" align="left">
                        <b>Width</b>
                    </div>
                    <div class="span1" align="left">:</div>
                    <div class="span4" style="text-align:left">
                        ' . $this->width . ' Cm
                    </div>
                </div>
                <div class="row-fluid" align="left">
                    <div class="span6" align="left">
                        <b>Height</b>
                    </div>
                    <div class="span1" align="left">:</div>
                    <div class="span4" style="text-align:left">
                        ' . $this->height . ' Cm
                    </div>
                </div>
                <div class="row-fluid" align="left">
                    <div class="span6" align="left">
                        <b>Lenght</b>
                    </div>
                    <div class="span1" align="left">:</div>
                    <div class="span4" style="text-align:left">
                        ' . $this->length . ' Cm
                    </div>
                </div>
                ';
        }
    }

    public function getTagDimens() {
        return '<div class="row-fluid">
                    <div class="span4">
                        <b>Price</b>
                    </div>
                    <div class="span1">:</div>
                    <div class="span4" style="text-align:left">
                        ' . $this->price_sell . '
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <b>Discont</b>
                    </div>
                    <div class="span1">:</div>
                    <div class="span4" style="text-align:left">
                        ' . $this->width . '
                    </div>
                </div>
                
                ';
    }

    public function getCodename() {
        return $this->code . ' - ' . $this->name;
    }
    

    public function behaviors() {
        return array(
            'timestamps' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'modified',
                'setUpdateOnCreate' => true,
            ),
        );
    }

    protected function beforeValidate() {
        if (empty($this->created_user_id))
            $this->created_user_id = Yii::app()->user->id;
        return parent::beforeValidate();
    }

    public function listProduct() {
        if (!app()->session['listProduct']) {
            $result = array();
            $products = $this->findAll();
            foreach ($products as $product) {
                $measure = (!empty($product->product_measure_id))? $product->ProductMeasure->name:'';
                $result[$product->id] = array('name' => $product->name, 'code' => $product->code,'measure'=>$measure,'price_buy'=>$product->price_buy,'price_sell'=>$product->price_sell);
            }
            app()->session['listProduct'] = $result;
        }
        return app()->session['listProduct'];
    }
    

}
