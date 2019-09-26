package UPC;
import javax.ws.rs.*;

@Path("/Products")
public class UPCService {

    private UPCBusiness business = new UPCBusiness();

    @Path("/CountProducts")
    @GET
    @Produces("application/json")
    @Consumes("test/plain")
    public String getCount(){
        return business.getCount();
    }

    @Path("/Product/{upc}")
    @GET
    @Produces("application/json")
    @Consumes("test/plain")
    public String getDescription(@PathParam("upc") String upc){
        return business.getDescription(upc);
    }


    @Path("/Product")
    @GET
    @Produces("application/json")
    @Consumes("test/plain")
    public String getUpcs(@QueryParam("descrip") String descrip){
        return business.getUpcs(descrip);
    }


}
