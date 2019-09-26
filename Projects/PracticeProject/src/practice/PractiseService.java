package practice;

import javax.ws.rs.*;
import java.util.HashMap;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import com.google.gson.JsonObject;
import companydata.*;
import org.json.JSONObject;

@Path("/PractiseServices")
public class PractiseService {

    private HashMap<String, Double> mattresses;
    private Gson gson = new GsonBuilder().setDateFormat("yyyy-mm-dd").create();

    private void createMattresses(){
        mattresses = new HashMap<>();
        mattresses.put("tuft", 750.0);
        mattresses.put("avocado green", 1200.0);
        mattresses.put("allswell", 310.0);
        mattresses.put("saatva", 599.0);
    }

    @Path("/mattress")
    @GET
    @Produces("application/json")
    @Consumes("text/plain")
    public String getMattress(@QueryParam("mattressName") String mattresssName){
        DataLayer dl = null;
        JsonObject obj = null;
        try {
            dl = new DataLayer("development");
            obj = new JsonObject();
            if (mattresssName == null){
                obj.addProperty("error", "cant be null");
                return obj.toString();
            } else {
                return gson.toJson(dl.getAllDepartment(mattresssName));
            }

        } catch (Exception e) {
            obj = new JsonObject();
            obj.addProperty("error", e.getMessage());
            return gson.toJson(obj);
        }

    }

    @Path("/mattress")
    @DELETE
    @Produces("application/json")
    @Consumes("text/plain")
    public String deleteMattress(@QueryParam("mattressName") String mattressName,
                                 @QueryParam("id") Integer id){
        DataLayer dl = null;
        JsonObject obj = null;
        try {
            dl = new DataLayer("development");
            if (mattressName == null){
                obj = new JsonObject();
                obj.addProperty("error", "null value");
                return gson.toJson(obj);
            } else {
                obj = new JsonObject();
                int val = dl.deleteDepartment(mattressName, id);
                if (val >= 1){
                    obj.addProperty("success", "deleted");
                    return gson.toJson(obj);
                } else {
                    obj.addProperty("error", "not deleted");
                    return gson.toJson(obj);
                }

            }

        } catch (Exception e) {
            obj = new JsonObject();
            obj.addProperty("error", e.getMessage());
            return gson.toJson(obj);
        }
    }

    @Path("/mattress")
    @POST
    @Produces("application/json")
    @Consumes("application/json")
    public String addMattress(String mattress){
        DataLayer dl;
        JsonObject msg;
        try {
            dl = new DataLayer("development");
            msg = new JsonObject();
            JSONObject obj = new JSONObject(mattress);
            if (!obj.has("name")){
                return gson.toJson("yo");
            } else {
                return gson.toJson("yo");
            }


        } catch (Exception e) {
            msg = new JsonObject();
            msg.addProperty("error", e.getMessage());
            return gson.toJson(msg);
        }
    }
}
