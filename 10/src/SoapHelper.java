import java.util.HashMap;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

public class SoapHelper
{
   private HashMap<String, Double> productList;
   
   public SoapHelper(){
      productList = new HashMap<String, Double>();
      productList.put("dove",6.49);
      productList.put("irish spring",4.39);
      productList.put("dial",2.97);
      productList.put("lever",6.19);
      productList.put("zest",3.00);
   }
   
   public Double getPrice(String product){
      if (productList.containsKey(product)){
         return productList.get(product);
      } else {
         return -1.0;
      }
   }
   
   
   public String[] getProducts(){
   List<String> allProducts = new ArrayList<>(productList.keySet());
   return allProducts.toArray(new String[allProducts.size()]);
   }
   
   
   public String getCheapest(){
   String minprod = "";
   Double minprice = Double.MAX_VALUE;
   for (Map.Entry<String, Double> entry : productList.entrySet()){
      double val = entry.getValue();
      if (val < minprice){
         minprice = val;
         minprod = entry.getKey();
      }
      
   }
   
   return minprod;
   }
   
   
   public String getCostliest(){
      String maxprod = "";
      Double maxprice = Double.MIN_VALUE;
      for (Map.Entry<String, Double> entry : productList.entrySet()){
         double val = entry.getValue();
         if (val > maxprice){
            maxprice = val;
            maxprod = entry.getKey();
         }
         
      }
      
      return maxprod;
   }
    
}