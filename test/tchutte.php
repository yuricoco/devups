<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../header.php';

// basique request

//$storage = new Storage();
//$storage->town = "edea";
//$storage->__insert();// __save()

//$storages = Storage::all();
//$storages = Storage::all("name");
//$storages = Storage::all("name", "desc");

//$storagerows = Storage::allrows();
//$storagerows = Storage::allrows("town");
//$storagerows = Storage::allrows("town", "desc");

//->__getAll(); this method allow default join with the entity set as attribut of the one you use.
// so you need to specifie entity.attr
//      Product::select("product.name, product.description")->where("product.name", "tew")->__getAll(); 
//->__getAllRow(); this method doesn't allow default join so need to manually enable it.
//
//->__getOne(); you need to specifie entity.attr
//      Product::select("product.name, product.description")->where("product.name", "tew")->__getOne(); 
//->__getOneRow();

//Product::select();

// this formula will automatically take product as entity owner of category
//Product::select()->leftjoin("category");

// this formula takes subcategory as owner of category
//Product::select()->leftjoin("subcategory", "category");

//Product::select("name, description")->where("name", "tew");
//Product::select()->where("name", "=", "tew"); 
//Product::select()->where("name", "=", "tew")->orderby("name desc"); 
//Product::select()->where("name", "tew")->andwhere("description", "the");
//Product::select()->where("name", "tew")->orwhere("description", "the");

//Product::select()->where(["product.name", "category.id"], ["tew", 1]);
//Sql: ' select * from product where product.name = ? and category.id = ? '

//Product::select()->where(Category::find(1));
//Product::select()->where("id")->in([1, 2, 3]);
//Product::select()->where("id")->in("1, 2, 3");
//Product::select()->where("id")->in(
////        (new QueryBuilder(new Product_storage()))
//        Product_storage::select("product_id")->where("storage_id", 1)->getSqlQuery()
//        );

//$products = Storage::find(1)->__hasmany('product');
//$storages = Product::find(1)->__hasmany('storage');

//$category = Product::find(1)->__belongto('category');
//$products = Category::find(1)->__hasmany('product');

//$storage = Storage::find(1);
$storage = Storage::findrow(1);


//$storage = Storage::first();
//$storage = Storage::last();
//$storage = Storage::get(3);


//$product = Product::findrow(1);
//$product->getCategory();
//$category = $product->__belongto("category");

//$nb = Storage::count();

//$storage = Storage::find(3);
//$storage->town = "bamenda centre";
//$storage->__update(); // __save()
//$sql  = Storage::update("town", "bamenda", 3)->getSqlQuery();
//Storage::update(["statu"], ["1"], [1])->exec(); // update storage set statu = ? where id in ()
//Storage::update(["town"], ["buéa"], 1)->exec();
//Storage::update(["town" => "buéa"], 1)->exec();
//Storage::update()->set(["town" => "buéa"], 1)->exec();
//Storage::update()->set(["town" => "buéa"])->where('id', 1)->exec();

//$storage = Storage::get(3);

$produits = Product::allrows();

echo "<pre>";
dd($produits);