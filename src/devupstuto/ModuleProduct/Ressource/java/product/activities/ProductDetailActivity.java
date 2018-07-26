package nkap.mobile.nkap;
        
    import nkap.mobile.nkap.R;
    import nkap.mobile.nkap.core.activities.BaseActivity;

    public class ProductDetailActivity extends BaseActivity{

        private Product product;
    
        @Override
        protected void onCreate(Bundle savedInstanceState) {
            super.onCreate(savedInstanceState);
            setContentView(R.layout.activity_product_detail);
        
        }
    }
    