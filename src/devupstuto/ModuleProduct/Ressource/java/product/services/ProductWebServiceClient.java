package nkap.mobile.nkap;
        
    import java.util.List;
    import retrofit2.Call;
	
	public class ProductWebServiceClient extends WebServiceClient{
			private final static String TAG = ProductWebServiceClient.class.getName();

    private static ProductWebServiceClient instance;

    public static ProductWebServiceClient getInstance() {
        if (instance == null) {
            instance = new ProductWebServiceClient();
        }
        return instance;
    }

    public ProductWebServiceClientInterface webServiceClientInterface;

    public ProductWebServiceClient() {
        super();
        webServiceClientInterface = WebServiceClientFactory.build(ProductWebServiceClientInterface.class);
    }

    public Promise getProducts(WebServiceDataRequest<ProductDataRequest> dataRequest) {
        Call<WebServiceDataResponse<List<Product>>> call = webServiceClientInterface.getProducts(getHeaderMap(), dataRequest);
        return executeCall(call);
    }

    public Promise getProduct(long id) {
        Call<WebServiceDataResponse<Product>> call = webServiceClientInterface.getProduct(getHeaderMap(), id);
        return executeCall(call);
    }

    public Promise createProduct(Product operation) {
        WebServiceDataRequest<Product> dataRequest = new WebServiceDataRequest<>(SessionManager.getInstance().getToken(null), operation);
        Call<WebServiceDataResponse<Product>> call = webServiceClientInterface.createProduct(getHeaderMap(), dataRequest);
        return executeCall(call);
    }

    public Promise updateProduct(Product operation) {
        WebServiceDataRequest<Product> dataRequest = new WebServiceDataRequest<>(SessionManager.getInstance().getToken(null), operation);
        Call<WebServiceDataResponse<Product>> call = webServiceClientInterface.updateProduct(getHeaderMap(), operation.getId(), dataRequest);
        return executeCall(call);
    }

    public Promise deleteProduct(long operationId) {
        DeleteProductDataRequest deleteTransferDataRequest = new DeleteProductDataRequest(operationId);
        WebServiceDataRequest<DeleteProductDataRequest> dataRequest = new WebServiceDataRequest<>(SessionManager.getInstance().getToken(null), deleteTransferDataRequest);
        Call<WebServiceDataResponse<DeleteResponse>> call = webServiceClientInterface.deleteProduct(getHeaderMap(), dataRequest);
        return executeCall(call);
    }	
		
	}