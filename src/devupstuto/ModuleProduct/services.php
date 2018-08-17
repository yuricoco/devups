<?php
            //ModuleProduct
		
        require '../../../admin/header.php';
        
        use Genesis as g;
        use Request as R;
        
        header("Access-Control-Allow-Origin: *");
                

		$categoryCtrl = new CategoryController();
		$imageCtrl = new ImageController();
		$productCtrl = new ProductController();
		$subcategoryCtrl = new SubcategoryController();
		
     (new Request('hello'));

     switch (Request::get('path')) {
                
        case 'category._new':
                g::json_encode(CategoryController::renderForm());
                break;

        case 'category._edit':
                g::json_encode(CategoryController::renderForm(R::get("id")));
                break;

        case 'category._show':
                g::json_encode(CategoryController::renderDetail(R::get("id")));
                break;

        case 'category._delete':
                g::json_encode($categoryCtrl->deleteAction(R::get("id")));
                break;

        case 'category._deletegroup':
                g::json_encode($categoryCtrl->deletegroupAction(R::get("ids")));
                break;

        case 'category.datatable':
                g::json_encode($categoryCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

        case 'image._new':
                g::json_encode(ImageController::renderForm());
                break;

        case 'image._edit':
                g::json_encode(ImageController::renderForm(R::get("id")));
                break;

        case 'image._show':
                g::json_encode(ImageController::renderDetail(R::get("id")));
                break;

        case 'image._delete':
                g::json_encode($imageCtrl->deleteAction(R::get("id")));
                break;

        case 'image._deletegroup':
                g::json_encode($imageCtrl->deletegroupAction(R::get("ids")));
                break;

        case 'image.datatable':
                g::json_encode($imageCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

        case 'penaltytype._new':
                g::json_encode(PenaltytypeController::renderForm());
                break;

        case 'penaltytype._edit':
                g::json_encode(PenaltytypeController::renderForm(R::get("id")));
                break;

        case 'penaltytype._show':
                g::json_encode(PenaltytypeController::renderDetail(R::get("id")));
                break;

        case 'penaltytype._delete':
                g::json_encode($penaltytypeCtrl->deleteAction(R::get("id")));
                break;

        case 'penaltytype._deletegroup':
                g::json_encode($penaltytypeCtrl->deletegroupAction(R::get("ids")));
                break;

        case 'penaltytype.datatable':
                g::json_encode($penaltytypeCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

        case 'product._new':
                g::json_encode(ProductController::renderForm());
                break;

        case 'product._edit':
                g::json_encode(ProductController::renderForm(R::get("id")));
                break;

        case 'product._show':
                g::json_encode(ProductController::renderDetail(R::get("id")));
                break;

        case 'product._delete':
                g::json_encode($productCtrl->deleteAction(R::get("id")));
                break;

        case 'product._deletegroup':
                g::json_encode($productCtrl->deletegroupAction(R::get("ids")));
                break;

        case 'product.datatable':
                g::json_encode($productCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

        case 'subcategory._new':
                g::json_encode(SubcategoryController::renderForm());
                break;

        case 'subcategory._edit':
                g::json_encode(SubcategoryController::renderForm(R::get("id")));
                break;

        case 'subcategory._show':
                g::json_encode(SubcategoryController::renderDetail(R::get("id")));
                break;

        case 'subcategory._delete':
                g::json_encode($subcategoryCtrl->deleteAction(R::get("id")));
                break;

        case 'subcategory._deletegroup':
                g::json_encode($subcategoryCtrl->deletegroupAction(R::get("ids")));
                break;

        case 'subcategory.datatable':
                g::json_encode($subcategoryCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

	
        default:
            echo json_encode("404 : page note found");
            break;
     }

