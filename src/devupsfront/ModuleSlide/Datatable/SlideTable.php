<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class SlideTable extends Datatable{
    

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Slide $slide = null){
    
        $dt = new SlideTable();
        $dt->entity = $slide;
        
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('slide.id', '#'), 'value' => 'id'],
            ['header' => t('slide.image', 'Image'), 'value' => 'src:image'],
            ['header' => t('slide.activated', 'Activated'), 'value' => 'activated'],
['header' => t('slide.width_size', 'Width_size'), 'value' => 'width_size'], 
['header' => t('slide.height_size', 'Height_size'), 'value' => 'height_size'], 
['header' => t('slide.title', 'Title'), 'value' => 'title'], 
['header' => t('slide.content', 'Content'), 'value' => 'content'],
['header' => t('slide.targeturl', 'Targeturl'), 'value' => 'targeturl']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('slide.activated'), 'value' => 'activated'], 
['label' => t('slide.width_size'), 'value' => 'width_size'], 
['label' => t('slide.height_size'), 'value' => 'height_size'], 
['label' => t('slide.title'), 'value' => 'title'], 
['label' => t('slide.content'), 'value' => 'content'], 
['label' => t('slide.image'), 'value' => 'src:image'], 
['label' => t('slide.image'), 'value' => 'src:image'], 
['label' => t('slide.image'), 'value' => 'image'], 
['label' => t('slide.path'), 'value' => 'path'], 
['label' => t('slide.targeturl'), 'value' => 'targeturl']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
