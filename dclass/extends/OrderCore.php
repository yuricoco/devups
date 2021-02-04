<?php


class OrderCore extends \Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="totalweight", type="float" )
     * @var integer
     **/
    protected $totalweight = 0;
    /**
     * @Column(name="tariff", type="float" )
     * @var integer
     **/
    protected $tariff = 0;
    /**
     * @Column(name="totalamount", type="float"  )
     * @var integer
     **/
    protected $totalamount = 0;
    /**
     * @Column(name="commission", type="float", nullable=true  )
     * @var integer
     **/
    protected $commission = 0;
    /**
     * @Column(name="discountprice", type="float"  )
     * @var integer
     **/
    protected $discountprice = 0;
    /**
     * @Column(name="nettopay", type="float"  )
     * @var integer
     **/
    protected $nettopay = 0;

    /**
     * @Column(name="paymentmethod", type="string" , length=150 , nullable=true)
     * @var string
     **/
    protected $paymentmethod;
    /**
     * @Column(name="address_delivery_id", type="integer" , nullable=true)
     * @var string
     **/
    protected $address_delivery_id;

    /**
     * @ManyToOne(targetEntity="\User")
     * , inversedBy="reporter"
     * @var \User
     */
    public $user;

    /**
     * @ManyToOne(targetEntity="\Address")
     * , inversedBy="reporter"
     * @var \Address
     */
    public $address;

    /**
     * @Column(name="status", type="string" , length=150 , nullable=true)
     * @var string
     **/
    protected $status;

    /**
     * @ManyToOne(targetEntity="\Currency")
     * @var \Currency
     */
    public $currency;

    /**
     * @return int
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * @param int $commission
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;
    }
    /**
     * @param int $commission
     */
    public function m($amount)
    {
        return m($amount, $this->currency);
    }

    /**
     * convert the shop currency to the cart currenty (the cart currency is always the one of the marketplace.)
     * @param $amount
     * @param $currency
     * @return float|int|we
     */
    public function convert($amount, $currency)
    {
        // $currency = getcurrency();
        return $this->currency->convert($amount, $currency);
    }

}