package UPC;

import UpcBiz.Product;
import UpcBiz.Products;
import com.google.gson.JsonObject;
import com.google.gson.Gson;

import java.util.HashMap;


public class UPCBusiness {

    private Gson gson = new Gson();

    protected String getCount(){
        JsonObject json = new JsonObject();
        try {
            Products ps = new Products();
            Long count = ps.getCount();

            json.addProperty("NumberOfProducts", count);
            return json.toString();

        } catch (Exception e) {
            json.addProperty("error", e.getMessage());
            return json.toString();
        }
    }

    protected String getDescription(String product){
        JsonObject json = new JsonObject();
        try {
            Product p = new Product(product);
            String description = p.getDescription();

            return description;

        } catch (Exception e) {
            json.addProperty("error", e.getMessage());
            return json.toString();
        }

    }

    protected String getUpcs(String partialdescrip){
        JsonObject json = new JsonObject();
        try {
            HashMap<String, String> des = new HashMap<>();
            Products ps = new Products();
            String[] details = ps.getUpcs(partialdescrip);
            for (String detail:
                 details) {
                des.put(detail, getDescription(detail));
            }


            return gson.toJson(des);

        } catch (Exception e) {
            json.addProperty("error", e.getMessage());
            return json.toString();
        }
    }





}
