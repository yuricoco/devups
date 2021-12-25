<?php

/**
 * @Entity @Table(name="country")
 * */
class Country extends \Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="name", type="string" , length=255 )
     * @var string
     **/
    protected $name;
    /**
     * @Column(name="iso", type="string" , length=255 )
     * @var string
     **/
    protected $iso;
    /**
     * @Column(name="iso3", type="string" , length=255 )
     * @var string
     **/
    protected $iso3;
    /**
     * @Column(name="numcode", type="string" , length=255 )
     * @var string
     **/
    protected $numcode;
    /**
     * @Column(name="phonecode", type="integer"  )
     * @var integer
     **/
    protected $phonecode;
    /**
     * @Column(name="status", type="integer"  )
     * @var integer
     **/
    protected $status;

    /**
     * @ManyToOne(targetEntity="\Continent")
     * , inversedBy="reporter"
     * @var \Continent
     */
    public $continent;

    public function __construct($id = null)
    {
        $this->dvtranslate = true;
        $this->dvtranslated_columns = ["nicename"];
        if ($id) {
            $this->id = $id;
        }
        $this->continent = new Continent();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Continent
     */
    public function getContinent()
    {
        return $this->continent;
    }

    /**
     * @param Continent $continent
     */
    public function setContinent(Continent $continent)
    {
        $this->continent = $continent;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPhonecode()
    {
        return $this->phonecode;
    }

    public function setPhonecode($phonecode)
    {
        $this->phonecode = $phonecode;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * @param string $iso
     */
    public function setIso($iso)
    {
        $this->iso = $iso;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phonecode' => $this->phonecode,
            'status' => $this->status,
        ];
    }

    public function tvas()
    {
        return $this->__hasmany(Tva::class);
    }

    public function showFlag()
    {
        return '<img alt="' . $this->name . '" src="' . __front . ("image/flags/" . strtolower($this->iso)) . '.png"/>';
    }

    public static function currentCountry()
    {
        return Country::where("iso", self::current())->__getOne();
    }

    public static function current()
    {
        $ip = \DClass\lib\Util::getIp();
        if (!isset($_SESSION["client_ip"])) {
            $_SESSION["client_ip"] = $ip;
        }
        if (isset($_SESSION["client_country"]) && $ip == $_SESSION["client_ip"]) {
            return $_SESSION["client_country"];
        }
        //$reader = new Reader('GeoLite2-Country.mmdb');
        //$record = $reader->country($_SERVER['REMOTE_ADDR']);
        //$record = geoip_country_code_by_name($_SERVER['REMOTE_ADDR']);
        $_SESSION["client_ip"] = $ip;
        if ($code = self::ip_info($ip, 'countrycode'))
            $_SESSION["client_country"] = $code;
        else
            $_SESSION["client_country"] = "CM";

        return $_SESSION["client_country"];

    }

    static function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE)
    {
        $output = NULL;

        if (!$ip)
            $ip = \DClass\lib\Util::getIp($ip, $deep_detect);

        $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city" => @$ipdat->geoplugin_city,
                            "state" => @$ipdat->geoplugin_regionName,
                            "country" => @$ipdat->geoplugin_countryName,
                            "country_code" => @$ipdat->geoplugin_countryCode,
                            "continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }

}
