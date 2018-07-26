package nkap.mobile.nkap;
        
    import retrofit2.Call;
    import retrofit2.http.Body;
    import retrofit2.http.GET;
    import retrofit2.http.HTTP;
    import retrofit2.http.HeaderMap;
    import retrofit2.http.POST;
    import retrofit2.http.Path;

	public interface ProductWebServiceClientInterface extends DBAL{
			
		
        @POST("/Api/Product")
        Call<WebServiceDataResponse<List<Product>>> getProducts(@HeaderMap Map<String, String> headers, @Body WebServiceDataRequest<ProductDataRequest> dataRequest);

        @GET("/Api/Product/{id}")
        Call<WebServiceDataResponse<List<Product>>> getProduct(@HeaderMap Map<String, String> headers, @Path("id") long id);

        @POST("/Api/Product")
        Call<WebServiceDataResponse<List<Product>>> createProduct(@HeaderMap Map<String, String> headers, @Body WebServiceDataRequest dataRequest);

        @POST("/Api/Product/{id}")
        Call<WebServiceDataResponse<List<Product>>> updateProduct(@HeaderMap Map<String, String> headers, @Path("id") long id, @Body WebServiceDataRequest dataRequest);

        @POST("/Api/Product/{id}/Statut")
        Call<WebServiceDataResponse<List<Product>>> updateProductStatus(@HeaderMap Map<String, String> headers, @Path("id") long id, @Body WebServiceDataRequest<UpdateStatusDataRequest> dataRequest);

        @HTTP(method = "DELETE", path = "/Api/Product", hasBody = true)
        Call<WebServiceDataResponse<DeleteResponse>> deleteProduct(@HeaderMap Map<String, String> headers, @Body WebServiceDataRequest<DeleteProductDataRequest> dataRequest);
		
		
	}