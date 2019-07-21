
        <div class="col-lg-12 col-md-12">
                
                    <?= \DClass\devups\Datatable::renderentitydata($product, [
['label' => 'Name', 'value' => 'name'], 
['label' => 'Price', 'value' => 'price'], 
['label' => 'Description', 'value' => 'description'], 
['label' => 'Category', 'value' => 'Category.id']
]); ?>

        </div>
			