package server;

import useless.*;
import javax.jws.*;

@WebService(serviceName="OurServiceName")
public class Area {

   @WebMethod(operationName = "ClassicHello")
   public String helloWorld() {
      return "Hello World";
     }
     
   @WebMethod(operationName = "ETHello")
   public String etHello() {
      Helper h = new Helper();
      return h.etHelloWorld();
      }
      
   public double calcRectangle(double x, double y){
   
      return x * y;
   }

   @WebMethod(exclude=true)
   public double calcCircle(double r){
   
      return 3.14 * r * r;
   }
}