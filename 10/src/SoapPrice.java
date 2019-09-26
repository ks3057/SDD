import java.lang.reflect.*;
import javax.jws.*;
import helper.*;

@WebService(serviceName="SOAPSoapService")
public class SoapPrice
{
   private Class sp;
   private SoapHelper sh;
   
   public SoapPrice(){
      sp = SoapHelper.class;
      sh = new SoapHelper();
   }
   
   @WebMethod
   public Double getPrice(String product){
      return sh.getPrice(product.toLowerCase());
   }
   
   @WebMethod
   public String[] getProducts(){
      return sh.getProducts();
   }
   
   @WebMethod
   public String getCheapest(){
      return sh.getCheapest();
   }
   
   @WebMethod
   public String getCostliest(){
      return sh.getCostliest();
   }
   
   @WebMethod
   public String[] getMethods(){
      Method[] m = sp.getDeclaredMethods();
      String[] methodnames = new String[m.length];
      for (int i = 0; i < m.length; i++){
         methodnames[i] = m[i].toString();
      }
      
      return methodnames;
   }  
}