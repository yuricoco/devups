package nkap.mobile.nkap;
        
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.CardView;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import java.util.List;
        
import nkap.mobile.nkap.R;
        
public class ProductAdapter extends RecyclerView.Adapter<ProductAdapter.MyRecyclerView> {
    private AppCompatActivity activity;
    private List<Product> products;

    public ProductAdapter(AppCompatActivity activity) {
        this.activity = activity;
    }

    @Override
    public MyRecyclerView onCreateViewHolder(ViewGroup parent, int viewType) {
        return new MyRecyclerView(activity.getLayoutInflater().inflate(R.layout.list_item_product, parent, false));
    }
    @Override
    public void onBindViewHolder(ProductAdapter.MyRecyclerView holder, int position) {
        final Product product = products.get(position);

        //holder.nkap_product_title.setText(product.getTitle());

        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                Intent intent = new Intent(activity, ProductDetailActivity.class);
                intent.putExtra(Intent.EXTRA_TEXT, Integer.parseInt(product.getId()));
                activity.startActivity(intent);

            }
        });

    }

    public void setProducts(List<Product> products) {
        this.products = products;
    }
    @Override
    public int getItemCount() {
        return products.size();
    }

    class MyRecyclerView extends RecyclerView.ViewHolder {
        //TextView nkap_product_title;

        MyRecyclerView(View itemView) {
            super(itemView);
            //nkap_product_title = itemView.findViewById(R.id.label_product);
        }
    }

}