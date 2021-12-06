<?php


class Dvups_config_item extends Model implements JsonSerializable, DvupsTranslation
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="name", type="string" , length=50 )
     * @var string
     **/
    protected $name;
    /**
     * @Column(name="label", type="string" , length=50, nullable=true )
     * @var string
     **/
    protected $label;


    /**
     * @Column(name="url", type="string" , length=25, nullable=true  )
     * @var string
     * */
    protected $url;

    /**
     * @return string
     */
    public function getUrl()
    {
        if (!$this->url)
            return strtolower(str_replace('_', '-', $this->name));

        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        if (!$url)
            $url = $this->name;

        $nameseo = str_replace('_', '-', $url); // supprime les autres caractères

        $this->url = strtolower($nameseo);

    }

    /**
     * @return string
     */
    public function getLabel()
    {
        if (!$this->label)
            return $this->name;

        return $this->label;

    }

    function getLabelform()
    {

        $view = '<div style="width: 100%;"><span> ' . $this->label . ' </span>
<span  class="btn btn-default"  onclick="editlabel(this)" data-id="' . $this->id . ' ">edit</span></div>
<div hidden ><input id="input-' . $this->id . '" style="width: 100px;" name="label" value="' . $this->label . '" />
<span class="btn btn-default" onclick="updatelabel(' . $this->id . ')">update</span>
<!--span class="btn" onclick="cancelupdate()">cancel</span-->
</div>';
        return $view;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
        ];
    }

    public function dvupsTranslate()
    {
        // we can iterate on howmuch lang the system may have to initiate all the lang of the new entry
//        self::inittranslate($this,"label", $this->label, "en");
//        self::inittranslate($this,"label", $this->label, "fr");
    }

}