<?php
namespace lukisongroup\purchasing\models;

use Yii;
use yii\base\Model;
use lukisongroup\purchasing\models\Rodetail;
use lukisongroup\master\models\Barangumum;

	/*
	 * DESCRIPTION FORM AddItem -> Model Additem validation
	 * Form Add Items Hanya ada pada Form Edit | ACTION addItem
	 * Items Barang tidak bisa di input Duplicated. | Unix by KD_RO dan KD_BARANG
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	
	/*
	 * FIELD RECOMENDED FROM Model | Rodetail
		CREATED_AT  value  date('Y-m-d H:i:s');
		KD_RO 
		KD_BARANG
		NM_BARANG 
		UNIT 		
		RQTY
		NOTE 
		STATUS 
	* @author ptrnov  <piter@lukison.com>
	* @since 1.1
	*/
	
class AdditemValidation extends Model
{
    public $kD_RO;
	public $kD_KATEGORI;
	public $kD_BARANG;	
	//public $nmBarang;
	public $uNIT;
	public $rQTY;
	//public $submitQty; //Kondisi Approved
	public $nOTE;
	public $sTATUS;
	public $cREATED_AT;
	  
    public function rules()
    {
        return [			
			[['kD_BARANG'], 'findcheck'],		
			[['kD_RO','kD_BARANG','uNIT','rQTY'], 'required'],				
			//[['nmBarang','nOTE'], 'string'],			
        	[['nOTE'], 'string'],			
        	['sTATUS','integer'],			
        	[['rQTY','cREATED_AT','kD_KATEGORI'], 'safe'],			
		];
    }
	
	/**
     * Check KD_RO dan KD_BARANG
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function findcheck($attribute, $params)
    {        
		if (!$this->hasErrors()) {
			 //$kondisiTrue = Rodetail::find()->where(['KD_RO' => $this->kD_RO, 'KD_BARANG' => $this->kD_BARANG ])->one();
			 $kondisiTrue = Rodetail::find()->where("KD_RO='".$this->kD_RO. "' AND KD_BARANG='".$this->kD_BARANG."' AND STATUS<>3")->one();
			if ($kondisiTrue) {
                $this->addError($attribute, 'Duplicated Items Barang !, Better (-/+) Request.Qty ');				
            } 
       }
    }
	
	/**
     * Saved Data Rodetail
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function additem_saved()
    {
		if ($this->validate()) {
			$rodetail = new Rodetail();
			$rodetail->CREATED_AT = date('Y-m-d H:i:s');
			$rodetail->KD_RO = $this->kD_RO;
			$rodetail->KD_BARANG = $this->kD_BARANG;
			$rodetail->NM_BARANG = $this->namaBarang($this->kD_BARANG);
			$rodetail->UNIT = $this->uNIT;
			$rodetail->RQTY = $this->rQTY;
			$rodetail->NOTE = $this->nOTE;
			$rodetail->STATUS = 0;
			if ($rodetail->save()) {
                return $rodetail;
            }
			return $rodetail;
		}		
		return null;	
	}
	
	public function attributeLabels()
    {
        return [
            'uNIT' => 'Satuan Barang',
            'kD_RO' => 'Kode Request Order',
            'kD_BARANG' => 'Nama  Barang',
			'kD_KATEGORI' => 'Kategori Barang',
			// 'NM_BARANG' => 'Nm  Barang',
            'rQTY' => 'Request Quantity',
         //   'SQTY' => 'Submit Quantity',
           // 'NO_URUT' => 'No  Urut',
            'nOTE' => 'Notes',
            'sTATUS' => 'Status',
            'cREATED_AT' => 'Created  At',
            //'UPDATED_AT' => 'Updated  At',
        ];
    }
	
	protected function namaBarang($kdBarang){
		$nmBarang = Barangumum::findOne(['KD_BARANG' => $kdBarang]);
		return $nmBarang->NM_BARANG;
	}
}
